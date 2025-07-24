<?php

require_once __DIR__.'/bootstrap.php';

use App\Entity\User;
use App\Repository\UserRepository;

/** @var UserRepository $userRepository */
$userRepository = $entityManager->getRepository(User::class);

$testEmail = "ivan@example.com";

$userData = $userRepository->findByEmail($testEmail);

echo "\nДанные массива:\n";
if ($userData) {
    print_r($userData);
} else {
    echo "Данные пользователя не найдены\n";
}


if (!$userData) {
    echo "\nСоздаем тестового пользователя...\n";

    $newUser = new User();
    $newUser->setName("Иван Иванов");
    $newUser->setEmail($testEmail);
    $newUser->setPassword(password_hash("secure123", PASSWORD_DEFAULT));

    $entityManager->persist($newUser);
    $entityManager->flush();

    echo "Создан пользователь с ID: " . $newUser->getId() . "\n";
}