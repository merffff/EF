<?php
require __DIR__ . '/vendor/autoload.php';


$builder = new DI\ContainerBuilder();


$providers = [
    RouterServiceProvider::class,
    UserServiceProvider::class
];

foreach ($providers as $provider) {
    (new $provider())->register($builder);
}

$container = $builder->build();


$router = $container->get(Router::class);
$router->handleRequest();



$router->handleRequest();


