<?php

namespace Lib\Database;

use Lib\EnvUtility\EnvHandler;
use Lib\MVCCore\Application;

class DatabaseContext
{
    private string $_servername;
    private string $_username;
    private string $_password;
    private string $_database;
    private int $_port;

    function __construct()
    {
        $envHandler = Application::getContainer()->resolve(EnvHandler::class);

        $this->_servername = $envHandler->getEnv('MYSQL_SERVERNAME');
        $this->_username = $envHandler->getEnv('MYSQL_USER');
        $this->_password = $envHandler->getEnv('MYSQL_PASSWORD');
        $this->_database = $envHandler->getEnv('MYSQL_DATABASE');
        $this->_port = $envHandler->getEnv('MYSQL_PORT');
    }

    public function connect(): \mysqli
    {
        return new \mysqli($this->_servername, $this->_username, $this->_password, $this->_database, $this->_port);
    }
}
