<?php
use DI\ContainerBuilder;

require_once __DIR__ . '/../core/ServiceProvider.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../repositories/interfaces/UserRepositoryInterface.php';
require_once __DIR__ . '/../services/UserService.php';

class UserServiceProvider extends ServiceProvider {
    public function register(ContainerBuilder $builder): void {
        $builder->addDefinitions([

            User::class => DI\create(),


            UserRepositoryInterface::class => DI\create(UserRepository::class)
                ->constructor(DI\get(User::class)),


            UserService::class => DI\create()
                ->constructor(DI\get(UserRepositoryInterface::class))
        ]);
    }
}
