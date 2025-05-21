<?php

function orderPizza(string $size = "medium", string $crust = "thin", array $toppings = ["cheese"]):string
{
    if ($crust === "thin") {
        $res = "на тонком тесте ";
    }else {
        $res = "на толстом тесте";
    }

    $string = implode(', ', $toppings);

    return "Заказ ". $size. " пицца ". $res."c ". $string;
}

echo orderPizza()."\n";
echo orderPizza(size: "large", toppings: ["cheese", "pepperoni"])."\n";

