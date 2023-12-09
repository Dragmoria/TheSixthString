<?php

namespace Service;

use Lib\Enums\ReviewStatus;
use Models\ProductModel;
use Models\ReviewModel;
use Lib\Database\Entity\Review;
use Lib\Database\Entity\Product;

class ReviewService extends BaseDatabaseService {
    public function getReviewTest(): ReviewModel {
        $review = $this->db->query('select * from review limit 1')->fetch_object(Review::class);
        $product = $this->db->query('select prod.* from product prod inner join orderitem items on prod.id = items.productId where items.id = ' . $review->orderItemId . ' limit 1')->fetch_object(Product::class);

        $model = ReviewModel::convertToModel($review);
        $model->product = ProductModel::convertToModel($product);
        return $model;
    }

    public function getAllReviewsForProduct(int $productId) {
        $query = "select rev.* from review rev inner join orderitem items on items.Id = rev.orderItemId where items.productId = " . $productId;
        $entities = $this->db->query($query)->fetch_all(MYSQLI_ASSOC);

        $models = array();
        foreach($entities as $entity) {
            array_push($models, ReviewModel::convertToModel(cast(Review::class, $entity)));
        }

        return $models;
    }

    public function createReview(ReviewModel $input): bool {
        //TODO: check of de ingelogde user een orderitem voor dit product heeft, zo ja: review mag aangemaakt worden met als status ReviewStatus::ToBeReviewed (is default, hoeft niet te worden gezet)
    }

    public function editReview(ReviewModel $input): bool {
        //TODO: alleen toestaan als status == ToBeReviewed!

        $entity = $this->getById($input->id);
    }

    public function denyReview(int $id): bool {
        $review = $this->getById($id);
        if($review->isEmptyObject()) return false;

        return $this->updateReviewStatus($review, ReviewStatus::Denied);
    }

    public function acceptReview(int $id): bool {
        $review = $this->getById($id);
        if($review->isEmptyObject()) return false;

        return $this->updateReviewStatus($review, ReviewStatus::Accepted);
    }

    #region common database methods
    private function getById(int $id): Review {
        $query = 'select top 1 * from reviews where Id = ' . $id;
        $result = $this->db->query($query);

        return $result->fetch_object(Review::class);
    }

    private function updateReviewStatus(Review $review, ReviewStatus $status): bool {
        return $this->db->query('update review set status = ' . $status->value . ' where id = ' . $review->id);
    }
    #endregion
}