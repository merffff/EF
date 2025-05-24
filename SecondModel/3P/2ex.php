<?php

interface Drawable
{
    public function draw():void;
}

abstract class Shape
{
    abstract public function getArea():int|float;
}

class Rectangle extends Shape implements Drawable
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

    public function draw():void
    {
        echo "Рисую прямоугольник шириной $this->a и высотой $this->b \n";
    }
}

class Circle extends Shape implements Drawable
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

    public function draw():void
    {
        echo "Рисую круг радиусом $this->a \n";
    }
}

$rect = new Rectangle(10, 5);
$circle = new Circle(7);

$rect->draw();
$circle->draw();



