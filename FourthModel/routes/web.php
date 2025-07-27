<?php
global $router;
route('GET', '/users', 'UserController', 'index');
route('GET', '/', 'UserController', 'index');
