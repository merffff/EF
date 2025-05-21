<?php

function filterEvenNumbers(array $arr)
{
    return array_filter($arr, fn($ar)=> $ar %2 ===0);
}
print_r(filterEvenNumbers([1, 2, 3, 4, 5, 6]));
print_r(filterEvenNumbers([11, 15, 21]));
