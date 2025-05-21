<?php

declare(strict_types =1);

function isAdult(int $age):bool
{
    return $age>=18;
}

var_dump(isAdult(20));  // ✅ true
var_dump(isAdult(17));  // ✅ false
var_dump(isAdult('20')); // ❌ Должна быть ошибка TypeError

