<?php


require_once __DIR__ . '/../vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

$isDevMode = true;
$paths = [__DIR__.'/../src/Entity'];

$config = ORMSetup::createAttributeMetadataConfiguration(
    $paths,
    $isDevMode
);

$conn = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'my_database',
    'user'     => 'app_user',
    'password' => 'strong_password',
    'charset'  => 'utf8mb4',
]);

$entityManager = new EntityManager($conn, $config);

return $entityManager;