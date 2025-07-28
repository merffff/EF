<?php

require_once __DIR__ . '/../vendor/autoload.php';

date_default_timezone_set('UTC');

if (!defined('TEST_ENV')) {
    define('TEST_ENV', true);
}
