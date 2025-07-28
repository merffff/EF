<?php


use App\User;

/**
 * Задание 4
 */

it('can create a user', function () {
    $user = new User('Анна', 'Сидорова', 'anna@example.com', 28);

    expect($user)->toBeInstanceOf(User::class);
    expect($user->getFirstName())->toBe('Анна');
    expect($user->getLastName())->toBe('Сидорова');
    expect($user->getEmail())->toBe('anna@example.com');
    expect($user->getAge())->toBe(28);
});

it('returns correct full name', function () {
    $user = new User('Иван', 'Петров', 'ivan@example.com', 25);

    expect($user->getFullName())->toBe('Иван Петров');
});

it('determines if user is adult', function () {
    $adultUser = new User('Алексей', 'Смирнов', 'alex@example.com', 25);
    $minorUser = new User('Дмитрий', 'Волков', 'dmitry@example.com', 16);

    expect($adultUser->isAdult())->toBeTrue();
    expect($minorUser->isAdult())->toBeFalse();
});

it('converts user to array', function () {
    $user = new User('Мария', 'Петрова', 'maria@example.com', 30);
    $userData = $user->toArray();

    expect($userData)->toBeArray();
    expect($userData)->toHaveKeys([
        'firstName', 'lastName', 'email', 'age', 'fullName', 'isAdult'
    ]);
    expect($userData['firstName'])->toBe('Мария');
    expect($userData['fullName'])->toBe('Мария Петрова');
    expect($userData['isAdult'])->toBeTrue();
});

test('user properties are set correctly', function () {
    $user = new User('Елена', 'Козлова', 'elena@example.com', 22);

    expect($user->getFirstName())->toBe('Елена')
        ->and($user->getLastName())->toBe('Козлова')
        ->and($user->getEmail())->toBe('elena@example.com')
        ->and($user->getAge())->toBe(22);
});