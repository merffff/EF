<?php

require "vendor/autoload.php";

use App\Models\User;

$user = new User("Анна");
echo $user->getName();
