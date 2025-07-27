<?php
require_once './../models/User.php';
$users = User::getAll();
print_r($users);
