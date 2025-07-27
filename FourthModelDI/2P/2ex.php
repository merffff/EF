<?php

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/Container.php';

echo "=== Проверка задания 2: Внедрение зависимостей ===\n\n";

try {
    $container = AppContainer::getInstance();

    $userService = $container->get(UserService::class);




    $users = $userService->getAllUsers();
    print_r($userService->getAllUsers());

    echo "✅ Метод getAllUsers() работает корректно\n";

    echo "\nЗадание 2 выполнено успешно!\n";
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
    echo "Задание 2 не выполнено\n";
}
