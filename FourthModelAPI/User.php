<?php
class User {
    private $conn;
    private $table_name = "users";

    public $id;
    public $name;
    public $created_at;
    public $updated_at;

    public function __construct($db) {
        $this->conn = $db;
    }


    public function getAll() {
        $query = "SELECT id, name, created_at, updated_at FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $users = array();
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $users[] = array(
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            );
        }

        return $users;
    }


    public function getById($id) {
        $query = "SELECT id, name, created_at, updated_at FROM " . $this->table_name . " WHERE id = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row) {
            return array(
                'id' => (int)$row['id'],
                'name' => $row['name'],
                'created_at' => $row['created_at'],
                'updated_at' => $row['updated_at']
            );
        }

        return null;
    }


    public function create($name) {
        $query = "INSERT INTO " . $this->table_name . " SET name=:name";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $name);

        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return $this->getById($this->id);
        }

        return false;
    }


    public function update($id, $name) {
        $query = "UPDATE " . $this->table_name . " SET name=:name WHERE id=:id";
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            return $this->getById($id);
        }

        return false;
    }


    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $id);

        return $stmt->execute();
    }
}

