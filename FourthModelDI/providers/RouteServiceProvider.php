<?php


require_once __DIR__ . '/../core/ServiceProvider.php';
require_once __DIR__ . '/../core/Router.php';

class RouterServiceProvider extends ServiceProvider
{
    public function register(ContainerBuilder $builder): void
    {
        $builder->addDefinitions([
            Router::class => function (ContainerInterface $container) {
                $router = new Router($container);
                $this->bindRoutes($router);
                return $router;
            }
        ]);
    }
}
