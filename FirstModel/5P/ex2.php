<?php

function calculateDiscount(int $price, int $discount =10):int
{
    $totalPrice = $price*(1-$discount/100);
    return $totalPrice;
}

echo calculateDiscount(price: 1000)."\n";
echo calculateDiscount(price: 2000, discount: 20)."\n";
