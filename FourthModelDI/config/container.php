<?php

use DI\ContainerBuilder;
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../repositories/UserRepository.php';
require_once __DIR__ . '/../services/UserService.php';

return function (ContainerBuilder $builder) {

    $builder->addDefinitions([

        UserRepository::class => DI\create()
            ->constructor(new User()),


        UserService::class => DI\create()
            ->constructor(DI\get(UserRepository::class)),

        UserRepositoryInterface::class => DI\get(UserRepository::class),

    ]);


    $builder->useAutowiring(true);
};
