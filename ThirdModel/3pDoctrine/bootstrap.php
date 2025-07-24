<?php

require_once __DIR__.'/vendor/autoload.php';

use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\EntityManager;
use Doctrine\DBAL\DriverManager;


$paths = [__DIR__ . '/src/Entity'];
$isDevMode = true;


$config = ORMSetup::createAnnotationMetadataConfiguration(
    $paths,
    $isDevMode
);

$connection = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'my_database',
    'user'     => 'app_user',
    'password' => 'strong_password',
    'charset'  => 'utf8mb4',
], $config);


$entityManager = new EntityManager($connection, $config);