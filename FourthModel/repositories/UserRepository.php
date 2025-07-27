<?php

require_once __DIR__ . '/../models/User.php';

class UserRepository {
    private $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function getAll() {
        return $this->userModel->getAllUsers();
    }

    public function findById($id) {
        return $this->userModel->findById($id);
    }

    public function create($userData) {

        if (empty($userData['name']) || empty($userData['email'])) {
            throw new InvalidArgumentException('Имя и email обязательны');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некорректный email');
        }

        return $this->userModel->create($userData);
    }

    public function update($id, $userData) {

        $user = $this->findById($id);
        if (!$user) {
            throw new Exception('Пользователь не найден');
        }

        return $this->userModel->update($id, $userData);
    }

    public function delete($id) {

        $user = $this->findById($id);
        if (!$user) {
            throw new Exception('Пользователь не найден');
        }

        return $this->userModel->delete($id);
    }
}
