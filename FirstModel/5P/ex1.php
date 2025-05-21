<?php

function greetUser(string $name, string $lang = "ru"):string
{
    if ($lang === "ru") {
        $res  = "Привет,". $name. "!";
    } elseif ($lang === "en") {
        $res =  "Hello,". $name. "!";
    }
    return $res;
}

echo greetUser("Иван")."\n";
echo greetUser("John", "en")."\n";