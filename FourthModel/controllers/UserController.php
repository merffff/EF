<?php

require_once __DIR__ . '/../services/UserService.php';
require_once __DIR__ . '/../repositories/UserRepository.php';

class UserController {
    private $userService;

    public function __construct() {

        $userRepository = new UserRepository();
        $this->userService = new UserService($userRepository);
    }

    public function index() {
        try {

            $users = $this->userService->getAllUsers();


            $this->render('users/index', [
                'users' => $users,
                'title' => 'Список пользователей'
            ]);
        } catch (Exception $e) {
            $this->render('users/index', [
                'users' => [],
                'error' => 'Ошибка загрузки пользователей: ' . $e->getMessage(),
                'title' => 'Список пользователей'
            ]);
        }
    }

    public function show($id) {
        try {
            $user = $this->userService->getUserById($id);
            if (!$user) {
                throw new Exception('Пользователь не найден');
            }

            $this->render('users/show', [
                'user' => $user,
                'title' => 'Профиль пользователя'
            ]);
        } catch (Exception $e) {
            $this->render('users/show', [
                'user' => null,
                'error' => $e->getMessage(),
                'title' => 'Профиль пользователя'
            ]);
        }
    }

    private function render($view, $data = []) {

        extract($data);


        require_once "views/{$view}.php";
    }
}
