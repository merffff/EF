<?php

enum OrderStatus: string
{
    case Pending = 'Заказ в ожидании';
    case Shipped = 'Заказ отправлен';
    case Delivered = 'Заказ доставлен';
}

function getDeliveryMessage(OrderStatus $status): string
{
    return $status->value;
}

echo getDeliveryMessage(OrderStatus::Pending)."\n";
echo getDeliveryMessage(OrderStatus::Shipped)."\n";
echo getDeliveryMessage(OrderStatus::Delivered)."\n";