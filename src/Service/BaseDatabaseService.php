<?php

namespace Service;

use Database\DatabaseContext;

class BaseDatabaseService {
    protected \mysqli $db;

    function __construct(){
        $databaseContext = new DatabaseContext();
        $this->db = $databaseContext->connect();
    }

    protected function sanitizeInput(string $value): string
    {
        return $this->db->real_escape_string($value);
    }
}