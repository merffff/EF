<?php

function printArrayItems(array $arr)
{
    foreach ($arr as $elem) {
        echo $elem."\n";
    }
}

printArrayItems(["apple", "banana", "cherry"]);
