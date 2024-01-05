<?php

namespace Service;

use Lib\Database\Entity\Product;
use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;
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
        if ($review->isEmptyObject()) return false;

        $review->status = ReviewStatus::Denied->value;

        return $this->updateReviewStatus($review);
    }

    public function acceptReview(int $id): bool
    {
        $review = $this->getById($id);
        if ($review->isEmptyObject()) return false;

        $review->status = ReviewStatus::Accepted->value;

        return $this->updateReviewStatus($review);
    }

    public function getWrittenReviewForProductAndUser(int $productId, int $userId): ?ReviewModel {
        $reviewEntity = $this->executeQuery("select rev.* from review rev inner join orderitem item on item.id = rev.orderItemId inner join `order` ord on ord.id = item.orderId where item.productId = ? and ord.userId = ? limit 1", [$productId, $userId], Review::class)[0] ?? null;
        if(is_null($reviewEntity)) return null;

        return ReviewModel::convertToModel($reviewEntity);
    }

    #region common database methods
    private function getById(int $id): Review
    {
        $query = 'select top 1 * from review where id = ' . $id;
        $result = $this->query($query);

        return $result->fetch_object(Review::class);
    }

    private function updateReviewStatus(Review $review): bool
    {
        return $this->query('update review set status = ' . $review->status . ' where id = ' . $review->id);
    }
    #endregion
}
