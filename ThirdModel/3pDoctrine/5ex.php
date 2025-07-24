<?php

require_once __DIR__.'/bootstrap.php';

use App\Entity\User;
use App\Entity\Post;


$userRepository = $entityManager->getRepository(User::class);
$user = $userRepository->findOneBy(['email' => 'anna@example.com']);

if (!$user) {
    $user = new User();
    $user->setName('Анна');
    $user->setEmail('anna@example.com');
    $user->setPassword(password_hash('password123', PASSWORD_DEFAULT));

    $entityManager->persist($user);
    $entityManager->flush();
}


$post = new Post();
$post->setTitle('Мой первый пост');
$post->setContent('Содержание поста...');
$post->setUser($user);

$entityManager->persist($post);
$entityManager->flush();


echo "Пост создан успешно!\n";
echo "Автор: " . $post->getUser()->getName() . "\n";
echo "Email автора: " . $post->getUser()->getEmail() . "\n";