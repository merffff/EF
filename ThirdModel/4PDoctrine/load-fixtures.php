<?php


require_once __DIR__ . '/vendor/autoload.php';

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use App\DataFixtures\UserFixtures;

$config = ORMSetup::createAttributeMetadataConfiguration([__DIR__ . '/src/Entity'], true);
$connection = DriverManager::getConnection([
    'driver'   => 'pdo_mysql',
    'host'     => 'localhost',
    'dbname'   => 'my_database',
    'user'     => 'app_user',
    'password' => 'strong_password'
], $config);

$entityManager = new EntityManager($connection, $config);


$loader = new Loader();
$loader->addFixture(new UserFixtures());

$executor = new ORMExecutor($entityManager, new ORMPurger());
$executor->execute($loader->getFixtures());
