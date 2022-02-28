<?php

namespace Blog\Models;

use Blog\Config\Database;
use PDO;
use PDOException;

abstract class Model 
{
    protected $conn;

    private function connect()
    {
        // connect
        $host=Database::HOST_NAME;
        $dbname=Database::DB_NAME;

        $dsn="mysql:host=$host;dbname=$dbname";
        $this->conn = new PDO($dsn, Database::USERNAME, Database::PASSWORD);
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    protected function getConnection() {
        $this->connect();
        
        return $this->conn;
    }


}
