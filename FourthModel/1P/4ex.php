<?php
require_once './../services/UserService.php';
$users = UserService::getUsers();
print_r($users);
