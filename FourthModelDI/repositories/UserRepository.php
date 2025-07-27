<?php

require_once __DIR__ . '/../models/User.php';

require_once __DIR__ . '/interfaces/UserRepositoryInterface.php';

class UserRepository implements UserRepositoryInterface {
    private $userModel;

    public function __construct(User $userModel) {
        $this->userModel = $userModel;
    }


    public function getAll():array {
        return $this->userModel->getAllUsers();
    }

    public function findById($id):?array {
        return $this->userModel->findById($id);
    }

    public function create($userData):bool {

        if (empty($userData['name']) || empty($userData['email'])) {
            throw new InvalidArgumentException('Имя и email обязательны');
        }

        if (!filter_var($userData['email'], FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Некорректный email');
        }

        return $this->userModel->create($userData);
    }

    public function update($id, $userData):bool {

        $user = $this->findById($id);
        if (!$user) {
            throw new Exception('Пользователь не найден');
        }

        return $this->userModel->update($id, $userData);
    }

    public function delete($id):bool {

        $user = $this->findById($id);
        if (!$user) {
            throw new Exception('Пользователь не найден');
        }

        return $this->userModel->delete($id);
    }

    public function getModel(): User {
        return $this->userModel;
    }
}
