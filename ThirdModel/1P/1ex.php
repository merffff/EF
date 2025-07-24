<?php

class Database
{
    private $host = "localhost";
    private $dbname  = "my_database";
    private $username = "app_user";
    private $password = "strong_password";

    public function connect()
    {

        try {
            $pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Подключение успешно!";
        } catch (PDOException $e) {
            die("Ошибка подключения: " . $e->getMessage());
        }

    }

}

$db = new Database();
echo $db->connect();
