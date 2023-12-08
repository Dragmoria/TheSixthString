<?php

namespace Models;

use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;

class ReviewModel {
    function __construct() {
        $this->id = 0;
        $this->rating = 0;
        $this->title = "";
        $this->content = "";
        //$this->orderItemId = 0;
        $this->status = ReviewStatus::ToBeReviewed->value;
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