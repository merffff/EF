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

    public function addUser($name, $email, $password)
    {
        try {

            if (empty($name) || empty($email) || empty($password)) {
                throw new InvalidArgumentException("Все поля обязательны для заполнения");
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new InvalidArgumentException("Некорректный email");
            }


            $passwordHash = password_hash($password, PASSWORD_DEFAULT);


            $stmt = $this->pdo->prepare("INSERT INTO users (name, email, password) VALUES (:name, :email, :password)");

            $stmt->execute([
                ':name' => $name,
                ':email' => $email,
                ':password' => $passwordHash
            ]);

            return $this->pdo->lastInsertId();
        } catch (PDOException $e) {
            error_log("Ошибка при добавлении пользователя: " . $e->getMessage());
            return false;
        }
    }

    public function deleteUser($id)
    {
        try {




            $id = (int)$id;


            $stmt = $this->pdo->prepare("DELETE FROM users WHERE id = :id");
            $stmt->execute([':id' => $id]);


            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            error_log("Ошибка при удалении пользователя: " . $e->getMessage());
            return false;
        }
    }
}


$db = new Database();


$result = $db->deleteUser("1 OR 1=1");
if ($result === false) {
    echo "Попытка SQL-инъекции предотвращена!";
}




print_r($db->getUsers());