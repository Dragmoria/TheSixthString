<?php

namespace Models;

class DailyMessageModel {
    private $message;

    public function __construct() {
        $this->message = 'Hello There! This is a message from the DailyMessageModel.';
    }

    public function getMessage() {
        return $this->message;
    }
}