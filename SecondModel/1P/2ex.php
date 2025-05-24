<?php


class Car {

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
}


$car = new Car("Toyota", "Camry", 2020);
echo $car->getCarInfo()."\n";

$car->setYear(2022);
echo $car->getYear()."\n";


