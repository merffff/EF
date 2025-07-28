<?php


namespace Tests\Unit;

use App\ApiController;
use App\User;
use App\UserRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class MockTest extends TestCase
{
    /**
     * Задание 6
     */
    public function testFindUserByEmailUsingMock(): void
    {
        $userRepositoryMock = Mockery::mock(UserRepository::class);

        $testUser = new User('Тест', 'Пользователь', 'test@example.com', 25);

        $userRepositoryMock->shouldReceive('findUserByEmail')
            ->once()
            ->with('test@example.com')
            ->andReturn($testUser);


        $result = $userRepositoryMock->findUserByEmail('test@example.com');


        $this->assertInstanceOf(User::class, $result);
        $this->assertEquals('test@example.com', $result->getEmail());
        $this->assertEquals('Тест Пользователь', $result->getFullName());
    }

    public function testApiControllerWithMockedRepository(): void
    {

        $userRepositoryMock = Mockery::mock(UserRepository::class);

        $users = [
            new User('Анна', 'Петрова', 'anna@example.com', 28),
            new User('Игорь', 'Сидоров', 'igor@example.com', 32)
        ];

        $userRepositoryMock->shouldReceive('getAllUsers')
            ->once()
            ->andReturn($users);

        $apiController = new ApiController($userRepositoryMock);

        $response = $apiController->getUsers();
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertCount(2, $decodedResponse['data']);
        $this->assertEquals(2, $decodedResponse['count']);

        $firstUser = $decodedResponse['data'][0];
        $this->assertEquals('Анна', $firstUser['firstName']);
        $this->assertEquals('anna@example.com', $firstUser['email']);
    }

    public function testFindUserByEmailReturnsNull(): void
    {
        $userRepositoryMock = Mockery::mock(UserRepository::class);

        $userRepositoryMock->shouldReceive('findUserByEmail')
            ->once()
            ->with('nonexistent@example.com')
            ->andReturn(null);

        $result = $userRepositoryMock->findUserByEmail('nonexistent@example.com');

        $this->assertNull($result);
    }

    public function testApiControllerGetUserByEmailWithMock(): void
    {
        $userRepositoryMock = Mockery::mock(UserRepository::class);

        $testUser = new User('Елена', 'Козлова', 'elena@example.com', 26);

        $userRepositoryMock->shouldReceive('findUserByEmail')
            ->once()
            ->with('elena@example.com')
            ->andReturn($testUser);

        $apiController = new ApiController($userRepositoryMock);

        $response = $apiController->getUserByEmail('elena@example.com');
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertEquals('Елена', $decodedResponse['data']['firstName']);
        $this->assertEquals('elena@example.com', $decodedResponse['data']['email']);
    }

    public function testMultipleMethodCallsOnMock(): void
    {

        $userRepositoryMock = Mockery::mock(UserRepository::class);

        $userRepositoryMock->shouldReceive('getUsersCount')
            ->twice()
            ->andReturn(5, 6);

        $firstCall = $userRepositoryMock->getUsersCount();
        $secondCall = $userRepositoryMock->getUsersCount();

        $this->assertEquals(5, $firstCall);
        $this->assertEquals(6, $secondCall);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}