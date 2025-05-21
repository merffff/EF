<?php

function factorial(int $n)
{
    $count=1;
    $f=1;
    while ($count <=$n) {
        $f = $f*$count;
        $count++;
    }
    return $f;
}

echo factorial(5)."\n";  // ✅ 120
echo factorial(3)."\n";  // ✅ 6
echo factorial(1)."\n";  // ✅ 1
echo factorial(0)."\n";  // ✅ 1
