<?php

abstract class Shape
{
    abstract public function getArea():int|float;
}

class Rectangle extends Shape
{
    private int $a;
    private int $b;

    public function __construct(int $a, int $b)
    {
        $this->a = $a;
        $this->b = $b;
    }
    public function getArea():int|float
    {
        $s = $this->a*$this->b;
        return $s;
    }
}

class Circle extends Shape
{
    private int $a;

    public function __construct(int $a)
    {
        $this->a = $a;
    }

    public function getArea():int|float
    {
        $s = $this->a*$this->a*pi();
        return round($s,2);
    }
}

$rect = new Rectangle(10, 5);
echo $rect->getArea()."\n";

$circle = new Circle(7);
echo $circle->getArea();
