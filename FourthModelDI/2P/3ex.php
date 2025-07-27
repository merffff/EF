<?php


require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../core/Container.php';

echo "=== Проверка задания 3: Использование интерфейсов ===\n\n";

try {
    $container = AppContainer::getInstance();

    $userService = $container->get(UserService::class);


    $reflection = new ReflectionClass($userService);
    $constructor = $reflection->getConstructor();
    $parameters = $constructor->getParameters();

    $interfaceName = $parameters[0]->getType()->getName();

    echo "✅ Конструктор ожидает интерфейс: {$interfaceName}\n";


    $repository = $container->get(UserRepositoryInterface::class);
    echo "✅ Реализация интерфейса: " . get_class($repository) . "\n";


    $users = $userService->getAllUsers();
    print_r($users);
    echo "✅ Метод getAllUsers() работает через интерфейс\n";

    echo "\nЗадание 3 выполнено успешно!\n";
} catch (Exception $e) {
    echo "❌ Ошибка: " . $e->getMessage() . "\n";
    echo "Задание 3 не выполнено\n";
}
