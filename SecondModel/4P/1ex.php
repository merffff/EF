<?php

require_once 'src/Models/User.php';

use App\Models\User;

$user = new User("Иван");
echo $user->getName();