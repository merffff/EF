<?php

function printNumbers(int $n)
{
    for ($i=1 ; $i <= $n; $i++) {
        echo $i."\n";
    }
}

printNumbers(5);
