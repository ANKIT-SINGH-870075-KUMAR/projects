<?php

namespace App\Config;

class Database{
    private string $host = "localhost";
    private string $username = "practice";
    private string $password = "1234";
    private string $database = "practice_code";

    private static ?Database $instance = null;
    private \mysqli $connection;

    private function __construct(){
        $this->connection = new \mysqli(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );

        if($this->connection->connect_error){
            throw new \Exception("Database connection Failed: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8mb4");
    }

    public static function getInstance(): Database{
        if(self::$instance === null){
            self::$instance = new Database();
        }
        return self::$instance;
    }

    public function getConnection(): \mysqli{
        return $this->connection;
    }
}

?>