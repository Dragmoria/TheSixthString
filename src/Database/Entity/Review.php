<?php

namespace Database\Entity;

use Shared\Enums\ReviewStatus;

class Review extends SaveableObject {
    function __construct() {
        $this->id = 0;
        $this->rating = 0;
        $this->title = "";
        $this->content = "";
        $this->orderItemId = 0;
        $this->status = ReviewStatus::ToBeReviewed;
        $this->createdOn = new \DateTime();
    }

    public int $rating;
    public string $title;
    public string $content;
    public int $orderItemId;
    public int $status;
    public \DateTime $createdOn;
}