<?php

namespace Service;

use Lib\Database\Entity\Product;
use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;
use Lib\Enums\SortOrder;
use Lib\MVCCore\Application;
use Models\ProductModel;
use Models\ReviewModel;

class ReviewService extends BaseDatabaseService
{
    public function getReviewById(int $id): ReviewModel
    {
        $review = $this->getById($id);
        $product = $this->query('select prod.* from product prod inner join orderitem items on prod.id = items.productId where items.id = ' . $review->orderItemId . ' limit 1')->fetch_object(Product::class);

        $model = ReviewModel::convertToModel($review);
        $model->product = ProductModel::convertToModel($product);
        return $model;
    }

    public function getAllReviewsForProduct(int $productId)
    {
        $query = "select rev.* from review rev inner join orderitem items on items.Id = rev.orderItemId where items.productId = " . $productId;
        $entities = $this->query($query)->fetch_all(MYSQLI_ASSOC);

        $models = array();
        foreach ($entities as $entity) {
            array_push($models, ReviewModel::convertToModel(cast(Review::class, $entity)));
        }

        return $models;
    }

    public function createReview(int $productId, int $userId, ReviewModel $model): bool
    {
        $entity = $model->convertToEntity();
        $orderItemId = $this->executeQuery("select item.id from orderitem item inner join `order` ord on ord.id = item.orderId where ord.userId = ? and item.productId = ? limit 1", [$userId, $productId])[0]->id;

        return $this->executeQuery("insert into review (rating, title, content, orderItemId, status, createdOn) values (?,?,?,?,?,?)", [$entity->rating, $entity->title, $entity->content, $orderItemId, $entity->status, $entity->createdOn]);
    }

    public function amountToBeReviewed(): int
    {
        $query = 'select count(*) as amount from review where status = ?'; //. ReviewStatus::ToBeReviewed->value;

        $params = [ReviewStatus::ToBeReviewed->value];

        $result = $this->executeQuery($query, $params, Review::class);

        $c = count($result);

        return $c;
    }

    public function denyReview(int $id): bool
    {
        $review = $this->getById($id);
        if ($review->isEmptyObject())
            return false;

        $review->status = ReviewStatus::Denied->value;

        return $this->updateReviewStatus($review);
    }

    public function acceptReview(int $id): bool
    {
        $review = $this->getById($id);
        if ($review->isEmptyObject())
            return false;

        $review->status = ReviewStatus::Accepted->value;

        return $this->updateReviewStatus($review);
    }

    public function getWrittenReviewForProductAndUser(int $productId, int $userId): ?ReviewModel
    {
        $reviewEntity = $this->executeQuery("select rev.* from review rev inner join orderitem item on item.id = rev.orderItemId inner join `order` ord on ord.id = item.orderId where item.productId = ? and ord.userId = ? limit 1", [$productId, $userId], Review::class)[0] ?? null;
        if (is_null($reviewEntity))
            return null;

        return ReviewModel::convertToModel($reviewEntity);
    }

    #region common database methods
    private function getById(int $id): Review
    {
        $query = 'select * from review where id = ' . $id;
        $result = $this->query($query);

        return $result->fetch_object(Review::class);
    }

    private function updateReviewStatus(Review $review): bool
    {
        return $this->query('update review set status = ' . $review->status . ' where id = ' . $review->id);
    }
    #endregion

    public function getAllReviews(string $sortField, SortOrder $sortOrder): ?array
    {
        $query = 'SELECT review.id, review.rating, review.title, review.content, review.status, review.createdOn, orditem.productId FROM review INNER JOIN orderitem orditem ON review.orderItemId = orditem.id';

        $params = [];

        $validSortFields = ['id', 'rating', 'title', 'content', 'status', 'createdOn', 'orderItemId'];

        if (in_array($sortField, $validSortFields)) {
            $query .= ' ORDER BY review.' . $sortField . ' ' . $sortOrder->value;
        } else {
            $query .= ' ORDER BY review.status';
        }

        $result = $this->executeQuery($query, $params);

        $products = [];

        $productService = Application::resolve(ProductService::class);

        $models = [];
        foreach ($result as $entity) {
            $model = new ReviewModel();

            $model->id = $entity->id;
            $model->rating = $entity->rating;
            $model->title = $entity->title;
            $model->content = $entity->content;
            $model->status = ReviewStatus::from($entity->status);
            $model->createdOn = $entity->createdOn;

            if ($entity->productId != null) {
                if (array_key_exists($entity->productId, $products)) {
                    $model->product = $products[$entity->productId];
                } else {
                    $product = $productService->getProductDetails($entity->productId, true);
                    $model->product = $product;
                    $products[$entity->productId] = $product;
                }
            }

            $models[] = $model;
        }

        return $models;
    }
}
