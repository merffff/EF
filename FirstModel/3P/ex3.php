<?php

function getUserEmails(array $users):array
{
    return array_map(
        function($user) {
             return $user['email'];
        }, $users
    );
}

$users = [
    ['id' => 1, 'name' => 'Alice', 'email' => 'alice@example.com'],
    ['id' => 2, 'name' => 'Bob', 'email' => 'bob@example.com'],
];

print_r(getUserEmails($users));
