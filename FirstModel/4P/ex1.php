<?php

function checkNumber(int|float $a): string
{
    if ($a > 0) {
        $res = "Положительное";
    } elseif ($a < 0) {
        $res = "Отрицательное";
    } elseif ($a === 0) {
        $res = "Ноль";
    }

    return $res;
}

echo checkNumber(10)."\n";
echo checkNumber(-5)."\n";
echo checkNumber(0)."\n";



