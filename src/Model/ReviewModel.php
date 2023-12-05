<?php

namespace Model;

use Database\Entity\Review;

class ReviewModel {
    function __construct() {
        $this->id = 0;
        $this->rating = 0;
        $this->title = "";
        $this->content = "";
        //$this->orderItemId = 0;
        $this->status = ReviewStatus::ToBeReviewed;
    }

    public int $id;
    public int $rating;
    public string $title;
    public string $content;
    //public int $orderItemId;
    public int $status;

    public static function convertToModel(Review $entity): ?ReviewModel {
        if (is_null($entity)) {
            return null;
        }

        $result = new ReviewModel();

        $result->id = $entity->id;
        $result->rating = $entity->rating;
        $result->title = $entity->title;
        $result->content = $entity->content;
        //$result->orderItemId = $entity->orderItemId;

        return $result;
    }
}