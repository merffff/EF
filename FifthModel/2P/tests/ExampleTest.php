<?php

namespace Tests;

use App\Calculator;
use PHPUnit\Framework\TestCase;

class ExampleTest extends TestCase
{
    private Calculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new Calculator();
    }

    public function testAddition(): void
    {
        $result = $this->calculator->add(2, 3);
        $this->assertEquals(5, $result);

        $result = $this->calculator->add(-1, 1);
        $this->assertEquals(0, $result);

        $result = $this->calculator->add(0.1, 0.2);
        $this->assertEqualsWithDelta(0.3, $result, 0.00001);
    }

    public function testSubtraction(): void
    {
        $result = $this->calculator->subtract(5, 3);
        $this->assertEquals(2, $result);

        $result = $this->calculator->subtract(1, 1);
        $this->assertEquals(0, $result);

        $result = $this->calculator->subtract(-1, -1);
        $this->assertEquals(0, $result);
    }

    public function testMultiplication(): void
    {
        $result = $this->calculator->multiply(3, 4);
        $this->assertEquals(12, $result);

        $result = $this->calculator->multiply(-2, 3);
        $this->assertEquals(-6, $result);

        $result = $this->calculator->multiply(0, 100);
        $this->assertEquals(0, $result);
    }

    public function testDivision(): void
    {
        $result = $this->calculator->divide(10, 2);
        $this->assertEquals(5, $result);

        $result = $this->calculator->divide(7, 2);
        $this->assertEquals(3.5, $result);
    }

    public function testDivisionByZero(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Division by zero is not allowed');

        $this->calculator->divide(10, 0);
    }

    public function testPower(): void
    {
        $result = $this->calculator->power(2, 3);
        $this->assertEquals(8, $result);

        $result = $this->calculator->power(5, 0);
        $this->assertEquals(1, $result);

        $result = $this->calculator->power(4, 0.5);
        $this->assertEquals(2, $result);
    }

    public function testSquareRoot(): void
    {
        $result = $this->calculator->sqrt(9);
        $this->assertEquals(3, $result);

        $result = $this->calculator->sqrt(16);
        $this->assertEquals(4, $result);

        $result = $this->calculator->sqrt(0);
        $this->assertEquals(0, $result);
    }

    public function testSquareRootNegativeNumber(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Cannot calculate square root of negative number');

        $this->calculator->sqrt(-1);
    }

    public function testBasicEnvironment(): void
    {
        // Тест для проверки, что тестовое окружение настроено правильно
        $this->assertTrue(defined('TEST_ENV'));
        $this->assertTrue(TEST_ENV);
    }
}