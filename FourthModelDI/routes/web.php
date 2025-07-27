<?php
/** @var Router $router */

$router->addRoute('GET', '/', 'HomeController', 'index');
$router->addRoute('GET', '/users', 'UserController', 'index');

