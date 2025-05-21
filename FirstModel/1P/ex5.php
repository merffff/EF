<?php

function getUserEmail(object $user): string {
    $email = $user->profile?->email;

    return $email ?? "Email не найден";
}


$user = (object)[
    'profile' => (object)[
        'email' => 'test@example.com'
    ]
];
echo getUserEmail($user)."\n";

$user = (object)[
    'profile' => null
];
echo getUserEmail($user)."\n";
