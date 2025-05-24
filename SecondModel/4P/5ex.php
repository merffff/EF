<?php

require "vendor/autoload.php";

use App\Models\Order;

$order = new Order();
$order->log("Заказ создан");