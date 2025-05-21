<?php

function formatText(string $text, bool $uppercase = false):string
{
    return $uppercase ? strtoupper($text):$text;
}

echo formatText("hello")."\n";
echo formatText("hello", true)."\n";


