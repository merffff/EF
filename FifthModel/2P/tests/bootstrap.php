<?php

/**
 * Bootstrap файл для тестов PHPUnit
 */

// Подключаем autoloader Composer
require_once __DIR__ . '/../vendor/autoload.php';

// Устанавливаем timezone для тестов
date_default_timezone_set('UTC');

// Определяем константы для тестового окружения
if (!defined('TEST_ENV')) {
    define('TEST_ENV', true);
}

// Можно добавить дополнительную настройку тестового окружения здесь
// Например, настройку базы данных для тестов, моков и т.д.