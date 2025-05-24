<?php

interface Movable
{
    public function move():void;
}

class Bicycle implements Movable
{
    public function move():void
    {
        echo "Велосипед едет"."\n";
    }
}

class Car implements Movable
{

    private string $brand;
    private string $model;
    private int $year;

    public function __construct (string $brand, string $model, int $year)
    {
        $this->brand = $brand;
        $this->model = $model;
        $this->year = $year;
    }

    public function setYear(int $year)
    {
        $this->year=$year;
    }

    public function getYear():int
    {
        return $this->year;
    }

    public function getCarInfo():void
    {
        echo $this->brand. " ". $this->model. ", ". $this->year;
    }

    public function move():void
    {
        echo "Машина едет"."\n";
    }
}

$car = new Car("Ford", "Focus", 2019);
echo $car->move();

$bike = new Bicycle();
echo $bike->move();
