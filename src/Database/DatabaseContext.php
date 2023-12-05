<?php

namespace Database;

class DatabaseContext {
    private string $_servername;
    private string $_username;
    private string $_password;
    private string $_database;
    private int $_port;

    function __construct() {
        $settings = $this->readFromSettings();
        if (!isset($settings)) {
            throw new \Exception("Could not read database settings");
        }

        $this->_servername = $settings->servername;
        $this->_username = $settings->username;
        $this->_password = $settings->password;
        $this->_database = $settings->database;
        $this->_port = $settings->port;
    }

    public function connect(): \mysqli {
        $conn = new \mysqli($this->_servername, $this->_username, $this->_password, $this->_database, $this->_port);
        return $conn;
    }

    private function readFromSettings(): DatabaseSetting {
        //TODO: uit settings-file/.env halen?
        return new DatabaseSetting("localhost", "root", "FgDp96_<w1F4", "test", 3306);
    }
}