<?php

require_once __DIR__ . '/../repositories/UserRepository.php';

require_once __DIR__ . '/../repositories/interfaces/UserRepositoryInterface.php';

class UserService {
    private UserRepositoryInterface $repository;

    public function __construct(UserRepositoryInterface $repository) {
        $this->repository = $repository;
    }

    public function getAllUsers() {
        try {
            $users = $this->repository->getAll();

            // Дополнительная бизнес-логика
            foreach ($users as &$user) {
                $user['display_name'] = $this->formatUserName($user);
                $user['status'] = $this->getUserStatus($user);
            }

            return $users;
        } catch (Exception $e) {
            error_log("Ошибка при получении пользователей: " . $e->getMessage());
            return [];
        }
    }

    public function getUserById($id) {
        try {
            $user = $this->repository->findById($id);
            if ($user) {
                $user['display_name'] = $this->formatUserName($user);
                $user['status'] = $this->getUserStatus($user);
            }
            return $user;
        } catch (Exception $e) {
            error_log("Ошибка при получении пользователя: " . $e->getMessage());
            return null;
        }
    }

    public function createUser($userData) {
        try {

            $userData = $this->sanitizeUserData($userData);
            return $this->repository->create($userData);
        } catch (Exception $e) {
            throw new Exception("Ошибка создания пользователя: " . $e->getMessage());
        }
    }

    public function updateUser($id, $userData) {
        try {
            $userData = $this->sanitizeUserData($userData);
            return $this->repository->update($id, $userData);
        } catch (Exception $e) {
            throw new Exception("Ошибка обновления пользователя: " . $e->getMessage());
        }
    }

    public function deleteUser($id) {
        try {
            return $this->repository->delete($id);
        } catch (Exception $e) {
            throw new Exception("Ошибка удаления пользователя: " . $e->getMessage());
        }
    }


    private function formatUserName($user) {
        return ucfirst(strtolower($user['name']));
    }

    private function getUserStatus($user) {

        if (isset($user['created_at'])) {
            $created = new DateTime($user['created_at']);
            $now = new DateTime();
            $diff = $now->diff($created);

            if ($diff->days < 7) {
                return 'новый';
            } elseif ($diff->days < 30) {
                return 'активный';
            } else {
                return 'постоянный';
            }
        }
        return 'неизвестно';
    }

    private function sanitizeUserData($userData) {
        return [
            'name' => trim(htmlspecialchars($userData['name'] ?? '')),
            'email' => trim(strtolower($userData['email'] ?? ''))
        ];
    }

    public function getRepository(): UserRepositoryInterface {
        return $this->repository;
    }
}
