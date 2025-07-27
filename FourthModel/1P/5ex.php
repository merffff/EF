<?php

require_once './../services/UserService.php';
require_once './../repositories/UserRepository.php';
$service = new UserService(new UserRepository());
print_r($service->getAllUsers());
