<?php

function squareNumbers(array $arr)
{
    return array_map(fn($ar) => $ar ** 2, $arr);
}

print_r(squareNumbers([1, 2, 3, 4]));
print_r(squareNumbers([-2, 5, 10]));

