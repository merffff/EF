<?php


namespace Tests\Unit;

use App\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = new User('Иван', 'Петров', 'ivan@example.com', 25);
    }

    /**
     * Задание 2
     */
    public function testUserCanBeCreated(): void
    {
        $user = new User('Анна', 'Сидорова', 'anna@example.com', 28);

        $this->assertInstanceOf(User::class, $user);
        $this->assertEquals('Анна', $user->getFirstName());
        $this->assertEquals('Сидорова', $user->getLastName());
        $this->assertEquals('anna@example.com', $user->getEmail());
        $this->assertEquals(28, $user->getAge());
    }

    /**
     * Задание 3
     */
    public function testUserFullName(): void
    {
        $fullName = $this->user->getFullName();

        $this->assertEquals('Иван Петров', $fullName);
        $this->assertIsString($fullName);
        $this->assertNotEmpty($fullName);
    }

    public function testUserGetters(): void
    {
        $this->assertEquals('Иван', $this->user->getFirstName());
        $this->assertEquals('Петров', $this->user->getLastName());
        $this->assertEquals('ivan@example.com', $this->user->getEmail());
        $this->assertEquals(25, $this->user->getAge());
    }

    public function testUserIsAdult(): void
    {
        $this->assertTrue($this->user->isAdult());

        $minorUser = new User('Дмитрий', 'Волков', 'dmitry@example.com', 16);
        $this->assertFalse($minorUser->isAdult());
    }

    public function testUserToArray(): void
    {
        $userData = $this->user->toArray();

        $this->assertIsArray($userData);
        $this->assertArrayHasKey('firstName', $userData);
        $this->assertArrayHasKey('lastName', $userData);
        $this->assertArrayHasKey('email', $userData);
        $this->assertArrayHasKey('age', $userData);
        $this->assertArrayHasKey('fullName', $userData);
        $this->assertArrayHasKey('isAdult', $userData);

        $this->assertEquals('Иван', $userData['firstName']);
        $this->assertEquals('Иван Петров', $userData['fullName']);
        $this->assertTrue($userData['isAdult']);
    }
}
