<?php

declare(strict_types =1);

function calculateTax(float $price, float $tax): float
{
    $totalPrice = $price * (1 + $tax);

    return round($totalPrice, 2);
}

echo calculateTax(100, 0.2)."\n";  // 120.00
echo calculateTax(50, 0.15)."\n";  // 57.50
echo calculateTax(99.99, 0.05)."\n"; // 104.99

