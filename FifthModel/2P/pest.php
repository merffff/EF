<?php


use Pest\Expectation;


uses(Tests\TestCase::class)->in('tests');

expect()->extend('toBeCalculatorResult', function (float $expected) {
    /** @var Expectation $this */
    return $this->toEqual($expected);
});

function calculator(): App\Calculator
{
    return new App\Calculator();
}