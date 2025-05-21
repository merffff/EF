<?php

declare(strict_types=1);

function formatValue(int|float|string $value): string
{
    return (string)$value;
}

var_dump(formatValue(100));
var_dump(formatValue(99.99));
var_dump(formatValue("hello"));
var_dump(formatValue(true));
