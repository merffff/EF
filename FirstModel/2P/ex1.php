<?php

declare(strict_types =1);

function multiply(int|float $a, int|float $b): int|float
{
    return $a*$b;
}

echo multiply(3, 2)."\n";
echo multiply(3.5, 2)."\n";
echo multiply('3', 2);


