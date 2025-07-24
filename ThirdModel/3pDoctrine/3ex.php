<?php

require_once __DIR__.'/bootstrap.php';

use App\Entities\User;

try {
    $user = new User();
    $user->setName("Тестовый пользователь");
    $user->setEmail("test@example.com");
    $user->setPassword("password123");

    $entityManager->persist($user);
    $entityManager->flush();

    echo "Пользователь создан с ID: " . $user->getId();
} catch (\Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}