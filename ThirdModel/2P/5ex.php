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

    public function getUserByEmail($email)
    {
        try {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("Неверный формат email");
            }

            $stmt = $this->pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->execute();

            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new RuntimeException("Пользователь с email $email не найден");
            }

            return $user;
        } catch (InvalidArgumentException $e) {

            error_log("Ошибка валидации: " . $e->getMessage());
            return ["error" => $e->getMessage()];
        } catch (PDOException $e) {
            error_log("Ошибка при поиске пользователя: " . $e->getMessage());
            return ["error" => "Произошла ошибка при поиске пользователя"];
        }
    }

    public function addUser($name, $email, $password)
    {
        try {

            if (empty($name) || empty($email) || empty($password)) {
                throw new InvalidArgumentException("Все поля обязательны");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("Некорректный email");
            }

            $passwordHash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");


            $stmt->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $passwordHash, PDO::PARAM_STR);

            $stmt->execute();
            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Ошибка при добавлении пользователя: " . $e->getMessage());
            return false;
        }
    }
}


$db = new Database();


$result = $db->getUserByEmail("неправильный_адрес");
if (isset($result['error'])) {
    echo $result['error'];
}


$user = $db->getUserByEmail("oleg@example.com");
if (isset($user['error'])) {
    echo $user['error'];
} else {
    print_r($user);
}
