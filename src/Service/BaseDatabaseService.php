<?php

namespace Service;

use Lib\Database\DatabaseContext;

class BaseDatabaseService {
    private DatabaseContext $_dbContext;

    function __construct() {
        $this->_dbContext = new DatabaseContext();
    }

    public function query(string $query, int $result_mode = MYSQLI_STORE_RESULT): \mysqli_result|bool {
        $db = $this->_dbContext->connect();
        try {
            return $db->query($query, $result_mode);
        } catch(\Exception) {
            throw;
        } finally {
            $db->close();
        }
    }
}