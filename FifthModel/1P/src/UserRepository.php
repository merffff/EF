<?php


namespace App;

class UserRepository
{
    private array $users = [];

    public function __construct()
    {

        $this->users = [
            new User('Иван', 'Петров', 'ivan@example.com', 25),
            new User('Мария', 'Сидорова', 'maria@example.com', 30),
            new User('Алексей', 'Козлов', 'alex@example.com', 22)
        ];
    }

    public function findUserByEmail(string $email): ?User
    {
        foreach ($this->users as $user) {
            if ($user->getEmail() === $email) {
                return $user;
            }
        }
        return null;
    }

    public function getAllUsers(): array
    {
        return $this->users;
    }

    public function addUser(User $user): void
    {
        $this->users[] = $user;
    }

    public function getUsersCount(): int
    {
        return count($this->users);
    }
}