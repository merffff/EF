<?php

function printEvenNumbers(int $n)
{
    $i=1;
    while ($i <=$n) {
        if ( $i%2 ===0 ) {
            echo $i."\n";
        }
        $i++;
    }
}

printEvenNumbers(10);
