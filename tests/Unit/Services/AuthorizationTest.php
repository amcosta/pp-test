<?php

namespace App\Tests\Unit\Services;

use App\Entity\User;
use App\Exceptions\AuthorizationException;
use App\Services\Authorization;
use App\Services\Authorization\Client;
use GuzzleHttp\Exception\TransferException;
use Mockery as m;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use Symfony\Component\HttpKernel\Exception\HttpException;

class AuthorizationTest extends TestCase
{
    private m\MockInterface|User|m\LegacyMockInterface $mockedPayer;

    protected function setUp(): void
    {
        $this->mockedPayer = m::mock(User::class);
        $this->mockedPayer->shouldReceive('getId')->withNoArgs()->andReturn(1);
    }

    private function mockClient(array $responseFromServer): m\MockInterface
    {
        $response = m::mock(ResponseInterface::class);
        $response->shouldReceive('getBody')->withNoArgs()->andReturn(json_encode($responseFromServer));

        $client = m::mock(Client::class);
        $client->shouldReceive('request')->with('GET', '/authorize/1')->andReturn($response);
        return $client;
    }

    public function testShouldAuthorizeTheUser()
    {
        $client = $this->mockClient(['authorized' => true]);

        $service = new Authorization($client);
        $isAuthorized = $service->checkUser($this->mockedPayer);

        self::assertTrue($isAuthorized);
    }

    public function testShouldNotAuthorizedTheUser()
    {
        self::expectException(AuthorizationException::class);

        $client = $this->mockClient(['authorized' => false]);

        $service = new Authorization($client);
        $service->checkUser($this->mockedPayer);
    }

    public function testShouldHandleErrorFromServer()
    {
        self::expectException(HttpException::class);

        $client = m::mock(Client::class);
        $client->shouldReceive('request')->with('GET', '/authorize/1')->andThrow(new TransferException());

        $service = new Authorization($client);
        $isAuthorized = $service->checkUser($this->mockedPayer);
    }
}
