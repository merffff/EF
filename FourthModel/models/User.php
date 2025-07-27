<?php

require_once __DIR__ . '/../core/Database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public static function getAll() {
        $instance = new self();
        return $instance->getAllUsers();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users ORDER BY id ASC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $sql = "SELECT * FROM users WHERE id = ?";
        $stmt = $this->db->query($sql, [$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $sql = "INSERT INTO users (name, email, created_at) VALUES (?, ?, NOW())";
        return $this->db->query($sql, [$data['name'], $data['email']]);
    }

    public function update($id, $data) {
        $sql = "UPDATE users SET name = ?, email = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->query($sql, [$data['name'], $data['email'], $id]);
    }

    public function delete($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->db->query($sql, [$id]);
    }
}
