<?php
use DI\ContainerBuilder;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/ServiceProvider.php';
require __DIR__ . '/../providers/UserServiceProvider.php';

echo "=== Проверка задания 4: Сервис-провайдер ===\n\n";


$builder1 = new ContainerBuilder();
$container1 = $builder1->build();

try {
    $container1->get(UserService::class);
    echo "❌ Ошибка: Сервис доступен без провайдера\n";
} catch (Exception $e) {
    echo "✅ Без провайдера сервис недоступен (ожидаемо)\n";
}


$builder2 = new ContainerBuilder();
(new UserServiceProvider())->register($builder2);

try {
    $container2 = $builder2->build();
    $userService = $container2->get(UserService::class);
    $users = $userService->getAllUsers();

    echo "✅ С провайдером сервис работает\n";
    echo "✅ Получено пользователей: " . count($users) . "\n";



    echo "\nЗадание 4 выполнено успешно!\n";
} catch (Exception $e) {
    echo "\n❌ Ошибка: " . $e->getMessage() . "\n";
    echo "Стек вызовов:\n" . $e->getTraceAsString() . "\n";
    echo "Задание 4 не выполнено\n";
}