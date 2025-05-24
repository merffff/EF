<?php

abstract class Vehicle
{
    abstract public function move():void;
}

interface Fuelable
{
    public function refuel():void;
}

class Car extends Vehicle implements Fuelable
{
    public function move():void
    {
        echo "Машина едет \n";
    }

    public function refuel():void
    {
        echo "Машина заправлена \n";
    }

}

class Bike extends Vehicle
{
    public function move():void
    {
        echo "Велосипед едет \n";
    }
}


$car = new Car();
$car->move();

$car->refuel();

$bike = new Bike();
$bike->move();
