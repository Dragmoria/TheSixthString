<?php

namespace Lib\Database;

class DatabaseContext {
    private string $_servername;
    private string $_username;
    private string $_password;
    private string $_database;
    private int $_port;

    function __construct() {
//        $this->_servername = getenv('MYSQL_SERVER');
//        $this->_username = getenv('MYSQL_USER');
//        $this->_password = getenv('MYSQL_PASSWORD');
//        $this->_database = getenv('MYSQL_DATABASE');
//        $this->_port = getenv('MYSQL_PORT');

        $this->_servername = 'thesixthstring-db-1';
        $this->_username = 'root';
        $this->_password = '';
        $this->_database = 'thesixthstring';
        $this->_port = 3306;
    }

    public function connect(): \mysqli {
        try {
            return new \mysqli($this->_servername, $this->_username, $this->_password, $this->_database, $this->_port);
        } catch(\Exception $ex) {
            print('<pre>' . $ex . '</pre>');
        }
    }
}