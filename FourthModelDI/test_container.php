<?php


require __DIR__ . '/vendor/autoload.php';
$container = require __DIR__ . '/config/container.php';


$userService = $container->get(UserService::class);
print_r($userService->getAllUsers());
