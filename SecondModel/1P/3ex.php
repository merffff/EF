<?php

class Car
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
}

class ElectricCar extends Car
{
    private int $batteryCapacity;

    public function __construct(string $brand, string $model, int $year, int $batteryCapacity)
    {
        parent::__construct($brand,$model, $year);
        $this->batteryCapacity = $batteryCapacity;
    }

    public function getBatteryInfo(): string
    {
        return "Батарея: " . $this->batteryCapacity . " kWh";
    }


}


$tesla = new ElectricCar("Tesla", "Model S", 2021, 100);
echo $tesla->getBatteryInfo();


