<?php

declare(strict_types=1);
function getNamesLength(array $names): array
{
    $lengths = [];

    foreach ($names as $name) {
        $lengths[] = strlen($name);
    }

    return $lengths;
}


print_r(getNamesLength(["Alice", "Bob", "Charlie"]));
print_r(getNamesLength([123, "Bob", "Charlie"]));

