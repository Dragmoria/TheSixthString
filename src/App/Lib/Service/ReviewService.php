<?php

namespace Lib\Service;

use Models\ReviewModel;
use Lib\Database\Entity\Review;

class ReviewService extends BaseDatabaseService {
    public function getReviewTest(): ReviewModel {
        $result = new ReviewModel();
        $result->id = 1;
        $result->rating = 3;
        $result->title = "Testreview";
        return $result;
    }

    public function getAllReviewsForProduct(int $productId) {
        $query = "select * from reviews rev inner join orderitems items on items.Id = rev.OrderItemId where items.ProductId = " . $productId;
        $result = $this->db->query($query);

        //TODO: convert to array of entities
        //return $result->toArray();
    }

    public function getReviewModel(int $id) : ReviewModel {
        $entity = $this->getById($id);

        return ReviewModel::convertToModel($entity);
    }

    public function createReview(ReviewModel $input): bool {
        //TODO: check of de ingelogde user een orderitem voor dit product heeft, zo ja: review mag aangemaakt worden met als status ReviewStatus::ToBeReviewed (is default, hoeft niet te worden gezet)
    }

    public function editReview(ReviewModel $input): bool {
        //TODO: alleen toestaan als status == ToBeReviewed!

        $entity = $this->getById($input->id);
    }

    public function denyReview(int $id): bool {

    }

    public function acceptReview(int $id): bool {

    }

    #region common database methods
    private function getById(int $id): Review {
        $query = "select top 1 * from reviews where Id = " . $id;
        $result = $this->db->query($query);

        return $result->fetch_object(Review::class);
    }
    #endregion
}