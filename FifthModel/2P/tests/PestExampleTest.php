<?php


use App\Calculator;

it('can add two numbers', function () {
    $calculator = new Calculator();

    expect($calculator->add(2, 3))->toBe(5.0);
    expect($calculator->add(-1, 1))->toBe(0.0);
    expect($calculator->add(0.1, 0.2))->toEqualWithDelta(0.3, 0.00001);
});

it('can subtract two numbers', function () {
    $calculator = new Calculator();

    expect($calculator->subtract(5, 3))->toBe(2.0);
    expect($calculator->subtract(1, 1))->toBe(0.0);
});

it('can multiply two numbers', function () {
    $calculator = new Calculator();

    expect($calculator->multiply(3, 4))->toBe(12.0);
    expect($calculator->multiply(-2, 3))->toBe(-6.0);
    expect($calculator->multiply(0, 100))->toBe(0.0);
});

it('can divide two numbers', function () {
    $calculator = new Calculator();

    expect($calculator->divide(10, 2))->toBe(5.0);
    expect($calculator->divide(7, 2))->toBe(3.5);
});

it('throws exception when dividing by zero', function () {
    $calculator = new Calculator();

    expect(fn() => $calculator->divide(10, 0))
        ->toThrow(InvalidArgumentException::class, 'Division by zero is not allowed');
});

it('can calculate power', function () {
    $calculator = new Calculator();

    expect($calculator->power(2, 3))->toBe(8.0);
    expect($calculator->power(5, 0))->toBe(1.0);
    expect($calculator->power(4, 0.5))->toBe(2.0);
});

it('can calculate square root', function () {
    $calculator = new Calculator();

    expect($calculator->sqrt(9))->toBe(3.0);
    expect($calculator->sqrt(16))->toBe(4.0);
    expect($calculator->sqrt(0))->toBe(0.0);
});

it('throws exception for negative square root', function () {
    $calculator = new Calculator();

    expect(fn() => $calculator->sqrt(-1))
        ->toThrow(InvalidArgumentException::class, 'Cannot calculate square root of negative number');
});

describe('Calculator basic operations', function () {
    beforeEach(function () {
        $this->calculator = new Calculator();
    });

    it('performs addition correctly', function () {
        expect($this->calculator->add(1, 2))->toBe(3.0);
    });

    it('performs subtraction correctly', function () {
        expect($this->calculator->subtract(5, 3))->toBe(2.0);
    });
});

it('calculates addition correctly for various inputs', function (float $a, float $b, float $expected) {
    $calculator = new Calculator();
    expect($calculator->add($a, $b))->toBe($expected);
})->with([
    [1, 2, 3],
    [0, 0, 0],
    [-1, 1, 0],
    [10.5, 5.5, 16.0],
]);

it('performs calculations quickly', function () {
    $calculator = new Calculator();

    $start = microtime(true);

    for ($i = 0; $i < 1000; $i++) {
        $calculator->add($i, $i + 1);
    }

    $end = microtime(true);
    $duration = $end - $start;

    expect($duration)->toBeLessThan(0.1);
});