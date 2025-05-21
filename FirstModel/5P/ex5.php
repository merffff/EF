<?php

function generatePassword(int $length = 8, bool $includeNumbers = true, bool $includeSpecialChars = false):string
{
    $characters = '';

    if($includeNumbers) {
        $characters.= '0123456789';
    }

    if ($includeSpecialChars){
        $characters .='!@#$%^&*()_-+={}[];:,.<>?';
    }
    if (empty($characters)) {
        return 'Нет символов для генерации пароля';
    }

    $password ='';
    $charactersLength = strlen($characters);
    for ($i=0; $i<$length; $i++) {
        $password.= $characters[rand(0, $charactersLength-1)];
    }

    return $password;
}

echo generatePassword()."\n";
echo generatePassword(length: 12, includeSpecialChars: true)."\n";

