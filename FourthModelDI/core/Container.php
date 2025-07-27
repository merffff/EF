<?php


use DI\Container;
use DI\ContainerBuilder;

class AppContainer
{
    private static ?Container $instance = null;

    public static function getInstance(): Container
    {
        if (self::$instance === null) {
            $builder = new ContainerBuilder();


            $containerConfig = require __DIR__ . '/../config/container.php';
            $containerConfig($builder);

            self::$instance = $builder->build();
        }
        return self::$instance;
    }
}
