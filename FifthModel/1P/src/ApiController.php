<?php


namespace App;

class ApiController
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getUsers(): string
    {
        $users = $this->userRepository->getAllUsers();
        $usersData = [];

        foreach ($users as $user) {
            $usersData[] = $user->toArray();
        }

        return json_encode([
            'status' => 'success',
            'data' => $usersData,
            'count' => count($usersData)
        ]);
    }

    public function getUserByEmail(string $email): string
    {
        $user = $this->userRepository->findUserByEmail($email);

        if (!$user) {
            return json_encode([
                'status' => 'error',
                'message' => 'User not found'
            ]);
        }

        return json_encode([
            'status' => 'success',
            'data' => $user->toArray()
        ]);
    }
}
