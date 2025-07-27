<?php
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/Container.php';

echo "=== Проверка задания 1: Базовая регистрация сервиса ===\n\n";

try {

    $container = AppContainer::getInstance();



    $userService = $container->get(UserService::class);


    $users = $userService->getAllUsers();


    echo "✅ Метод getAllUsers() вернул данные:\n";
    print_r($users);

    echo "\nЗадание 1 выполнено успешно!\n";
} catch (Exception $e) {
    echo "\n❌ Ошибка: " . $e->getMessage() . "\n";
    echo "Стек вызовов:\n" . $e->getTraceAsString() . "\n";
    echo "Задание 1 не выполнено\n";
}
