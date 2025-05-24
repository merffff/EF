<?php

require "vendor/autoload.php";

use App\Services\UserService;

$service = new UserService();

echo $service->getUserGreeting("Мария");
