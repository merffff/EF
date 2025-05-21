<?php

function getAgeCategory(int $age):string
{
    return match (true) {
        $age >=0 and $age <=12 => "Ребенок",
        $age >12 and $age <18 => "Подросток",
        $age >17 and $age <65 => "Взрослый",
        $age >64 and $age <131 => "Пожилой"
    };
}

echo getAgeCategory(8)."\n";
echo getAgeCategory(15)."\n";
echo getAgeCategory(30)."\n";
echo getAgeCategory(70)."\n";
