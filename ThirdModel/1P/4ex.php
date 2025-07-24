<?php

class Database
{
    private $host = "localhost";
    private $dbname = "my_database";
    private $username = "app_user";
    private $password = "strong_password";
    private $pdo;

    public function __construct()
    {
        $this->connect();
    }

    public function connect()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbname;charset=utf8", $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return "Подключение успешно!";
        } catch (PDOException $e) {
            die("Ошибка подключения: " . $e->getMessage());
        }
    }

    public function getUsers()
    {
        try {
            $stmt = $this->pdo->query("SELECT * FROM users");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return ["error" => "Ошибка при получении пользователей: " . $e->getMessage()];
        }
    }

    public function addUser($name, $email)
    {
        try {
            $stmt = $this->pdo->prepare("INSERT INTO users (name, email) VALUES (:name, :email)");
            $stmt->execute([
                ':name' => $name,
                ':email' => $email
            ]);
            return true;
        } catch (PDOException $e) {
            error_log("Таблица не удалена: " . $e->getMessage());
            return false;
        }
    }
}


$db = new Database();
$db->addUser("Алексей', 'hacked@example.com'); DROP TABLE users; --", "hacker@example.com");
print_r($db->getUsers());




