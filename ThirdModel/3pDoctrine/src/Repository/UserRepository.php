<?php


namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;


class UserRepository extends EntityRepository
{
    /**
     * @return User|null
     */
    public function findByEmail(string $email): ?array
    {
        $user = $this->findOneBy(['email' => $email]);
        if (!$user) {
            return null;
        }

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }
    public function findByUserDataByEmail(string $email): ?array
    {
        $user = $this->findByEmail($email);

        if (!$user) {
            return null;
        }

        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'createdAt' => $user->getCreatedAt()->format('Y-m-d H:i:s')
        ];
    }
}
