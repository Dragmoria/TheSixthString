<?php

namespace Lib\Database\Entity;

class TryoutSchedule extends SaveableObject {
    public function __construct() {
        $this->tableName = "tryoutschedule";
    }

    public string $date = "";
    public int $productId = 0;
}