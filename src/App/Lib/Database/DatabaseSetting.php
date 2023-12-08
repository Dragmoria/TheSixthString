<?php

namespace Lib\Database;

class DatabaseSetting {
    function __construct($servername, $username, $password, $database, $port) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    public $servername;
    public $username;
    public $password;
    public $database;
    public $port;
}