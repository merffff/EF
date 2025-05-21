<?php

function calculatePrice(int $basePrice, int $discount, int $tax)
{
    $priceAfterDiscount = $basePrice - ($basePrice * $discount / 100);
    $finalPrice = $priceAfterDiscount + ($priceAfterDiscount * $tax / 100);

    return $finalPrice;
}

echo calculatePrice(basePrice: 1000, discount: 10, tax: 5)."\n";//  945

echo calculatePrice(tax: 5, discount: 10, basePrice: 2000); // 1890

