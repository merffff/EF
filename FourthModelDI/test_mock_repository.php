<?php


require __DIR__ . '/vendor/autoload.php';

class MockUserRepository implements UserRepositoryInterface
{
    public function getAll(): array
    {
        return [['id' => 1, 'name' => 'Test User']];
    }
}

$builder = new DI\ContainerBuilder();
$builder->addDefinitions([
    UserRepositoryInterface::class => DI\autowire(MockUserRepository::class)
]);
$container = $builder->build();

$userService = $container->get(UserService::class);
print_r($userService->getAllUsers());
