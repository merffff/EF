<?php

namespace App;

/**
 * Простой калькулятор для демонстрации CI/CD
 */
class Calculator
{
    /**
     * Сложение двух чисел
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function add(float $a, float $b): float
    {
        return $a + $b;
    }

    /**
     * Вычитание двух чисел
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function subtract(float $a, float $b): float
    {
        return $a - $b;
    }

    /**
     * Умножение двух чисел
     *
     * @param float $a
     * @param float $b
     * @return float
     */
    public function multiply(float $a, float $b): float
    {
        return $a * $b;
    }

    /**
     * Деление двух чисел
     *
     * @param float $a
     * @param float $b
     * @return float
     * @throws \InvalidArgumentException
     */
    public function divide(float $a, float $b): float
    {
        if ($b === 0.0) {
            throw new \InvalidArgumentException('Division by zero is not allowed');
        }

        return $a / $b;
    }

    /**
     * Возведение в степень
     *
     * @param float $base
     * @param float $exponent
     * @return float
     */
    public function power(float $base, float $exponent): float
    {
        return pow($base, $exponent);
    }

    /**
     * Извлечение квадратного корня
     *
     * @param float $number
     * @return float
     * @throws \InvalidArgumentException
     */
    public function sqrt(float $number): float
    {
        if ($number < 0) {
            throw new \InvalidArgumentException('Cannot calculate square root of negative number');
        }

        return sqrt($number);
    }
}