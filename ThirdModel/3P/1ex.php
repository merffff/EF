<?php

require __DIR__ . '/database.php';

use App\Models\User;

try {

    $user = new User();
    $user->name = "Иван";
    $user->email = "ivan@example.com";
    $user->password = "secret";
    $user->save();


    echo "Пользователь создан успешно! ID: " . $user->id;
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}