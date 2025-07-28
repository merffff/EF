<?php


namespace Tests\Integration;

use App\ApiController;
use App\User;
use App\UserRepository;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    private ApiController $apiController;
    private UserRepository $userRepository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->userRepository = new UserRepository();
        $this->apiController = new ApiController($this->userRepository);
    }

    /**
     * Задание 5
     */
    public function testUserApiReturnsUsers(): void
    {
        $response = $this->apiController->getUsers();

        $this->assertIsString($response);

        $decodedResponse = json_decode($response, true);


        $this->assertIsArray($decodedResponse);
        $this->assertArrayHasKey('status', $decodedResponse);
        $this->assertArrayHasKey('data', $decodedResponse);
        $this->assertArrayHasKey('count', $decodedResponse);


        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertIsArray($decodedResponse['data']);
        $this->assertGreaterThan(0, $decodedResponse['count']);


        $firstUser = $decodedResponse['data'][0];
        $this->assertArrayHasKey('firstName', $firstUser);
        $this->assertArrayHasKey('lastName', $firstUser);
        $this->assertArrayHasKey('email', $firstUser);
        $this->assertArrayHasKey('age', $firstUser);
        $this->assertArrayHasKey('fullName', $firstUser);
        $this->assertArrayHasKey('isAdult', $firstUser);
    }

    public function testGetUserByEmailReturnsUser(): void
    {
        $response = $this->apiController->getUserByEmail('ivan@example.com');
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('success', $decodedResponse['status']);
        $this->assertArrayHasKey('data', $decodedResponse);
        $this->assertEquals('Иван', $decodedResponse['data']['firstName']);
        $this->assertEquals('ivan@example.com', $decodedResponse['data']['email']);
    }

    public function testGetUserByEmailReturnsErrorForNonExistentUser(): void
    {
        $response = $this->apiController->getUserByEmail('nonexistent@example.com');
        $decodedResponse = json_decode($response, true);

        $this->assertEquals('error', $decodedResponse['status']);
        $this->assertArrayHasKey('message', $decodedResponse);
        $this->assertEquals('User not found', $decodedResponse['message']);
    }

    public function testApiResponseIsValidJson(): void
    {
        $response = $this->apiController->getUsers();


        $this->assertJson($response);


        json_decode($response);
        $this->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    public function testApiReturnsCorrectUserCount(): void
    {
        $response = $this->apiController->getUsers();
        $decodedResponse = json_decode($response, true);

        $expectedCount = $this->userRepository->getUsersCount();
        $actualCount = $decodedResponse['count'];

        $this->assertEquals($expectedCount, $actualCount);
        $this->assertEquals(count($decodedResponse['data']), $actualCount);
    }
}