<?php

namespace Lib\Database\Entity;

class TryoutSchedule extends SaveableObject
{
    public function __construct()
    {
        parent::__construct("tryoutschedule");
    }

    public string $startDate = "";
    public string $endDate = "";
    public int $productId = 0;
}
