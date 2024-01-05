<?php

namespace Lib\Database\Entity;

use Lib\Enums\ReviewStatus;

class Review extends SaveableObject
{
    function __construct() {
        parent::__construct("review");
    }

    public int $rating = 0;
    public string $title = "";
    public string $content = "";
    public int $orderItemId = 0;
    public int $status = ReviewStatus::ToBeReviewed->value;
    public string $createdOn = "";
}