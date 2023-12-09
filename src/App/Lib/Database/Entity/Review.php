<?php

namespace Lib\Database\Entity;

class Review extends SaveableObject
{
    function __construct() { }

    public int $rating = 0;
    public string $title = "";
    public string $content = "";
    public int $orderItemId = 0;
    public int $status = 0; //default is ReviewStatus::ToBeReviewed (= 0)
    public string $createdOn = "";
}