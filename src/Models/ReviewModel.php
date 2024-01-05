<?php

namespace Models;

use Lib\Database\Entity\Review;
use Lib\Enums\ReviewStatus;

class ReviewModel {
    public function __construct() { }

    public int $id = 0;
    public int $rating = 0;
    public string $title = "";
    public string $content = "";
    public ?ProductModel $product = null;
    public ReviewStatus $status = ReviewStatus::ToBeReviewed;
    public string $createdOn = "";

    public static function convertToModel(?Review $entity): ?ReviewModel {
        if ($entity->isEmptyObject()) return null;

        $model = new ReviewModel();
        $model->id = $entity->id;
        $model->rating = $entity->rating;
        $model->title = $entity->title;
        $model->content = $entity->content;
        $model->status = ReviewStatus::from($entity->status);
        $model->createdOn = $entity->createdOn;

        return $model;
    }

    public function convertToEntity(): Review {
        $entity = new Review();
        $entity->rating = $this->rating;
        $entity->title = $this->title;
        $entity->content = $this->content;
        $entity->status = $this->status->value;
        $entity->createdOn = $entity->getCurrentDateAsString('Y-m-d H:i:s');

        return $entity;
    }
}