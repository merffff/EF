<?php
include_once 'database.php';

echo "Настройка базы данных...\n";

$database = new Database();
$database->createUsersTable();


$db = $database->getConnection();

$testUsers = [
    'Иван Петров',
    'Мария Сидорова',
    'Алексей Козлов'
];

foreach ($testUsers as $name) {
    $query = "INSERT INTO users (name) VALUES (?)";
    $stmt = $db->prepare($query);
    $stmt->execute([$name]);
    echo "Добавлен пользователь: " . $name . "\n";
}

echo "Настройка завершена!\n";
echo "Структура проекта:\n";
echo "├── database.php (подключение к БД)\n";
echo "├── User.php (модель пользователя)\n";
echo "├── api/users.php (REST API)\n";
echo "├── graphql/index.php (GraphQL сервер)\n";
echo "└── setup.php (этот файл)\n";
echo "\nAPI доступно по адресам:\n";
echo "REST API: http://localhost/api/users\n";
echo "GraphQL: http://localhost/graphql/\n";

