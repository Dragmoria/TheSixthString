<?php

namespace Service;

use Lib\Database\DatabaseContext;

class BaseDatabaseService
{
    private DatabaseContext $_dbContext;

    function __construct()
    {
        $this->_dbContext = new DatabaseContext();
    }

    public function executeQuery(string $query, array $params, string $className = null): array|bool|\mysqli_result
    {
        $db = $this->_dbContext->connect();

        try {
            $stmt = $db->prepare($query);
            if ($stmt === false) {
                // Handle error
                throw new \Exception('Failed to prepare the statement');
            }

            // Dynamically bind parameters
            $types = '';
            foreach ($params as &$param) {
                if (is_int($param)) {
                    $types .= 'i';
                } elseif (is_float($param)) {
                    $types .= 'd';
                } elseif (is_string($param)) {
                    $types .= 's';
                } elseif (is_bool($param)) {
                    $types .= 'i';
                    $param = (int) $param; // Convert boolean to integer
                } else if (is_null($param)) {
                    $types .= 's';
                } else {
                    throw new \Exception('Invalid parameter type: ' . gettype($param));
                }
            }

            if (!empty($params)) {
                $stmt->bind_param($types, ...$params);
            }

            if (!$stmt->execute()) {
                // Handle error
                throw new \Exception('Failed to execute the statement');
            }

            $result = $stmt->get_result();

            // If the query is a SELECT statement, fetch the result
            if (stripos($query, 'SELECT') === 0) {
                $data = [];
                while ($row = $className ? $result->fetch_object($className) : $result->fetch_object()) {
                    $data[] = $row;
                }
                return $data;
            }

            // If the query is not a SELECT statement, return the result of the execution
            return $stmt->affected_rows > 0;
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $db->close();
        }
    }

    public function query(string $query, int $result_mode = MYSQLI_STORE_RESULT): \mysqli_result|bool
    {
        $db = $this->_dbContext->connect();
        try {
            return $db->query($query, $result_mode);
        } catch (\Exception $ex) {
            throw $ex;
        } finally {
            $db->close();
        }
    }
}
