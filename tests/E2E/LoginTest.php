<?php

namespace App\Tests\E2E;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    public function testShouldReturn401ForInvalidCredencials(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => 'pumba', 'password' => 'invalid'])
        );

        self::assertEquals(401, $client->getResponse()->getStatusCode());
    }
    
    public function testShouldLoginSuccessfully(): void
    {
        $client = static::createClient();
        $crawler = $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => 'pumba', 'password' => 'hakunamatata'])
        );

        $payload = json_decode($client->getResponse()->getContent(), true);
        self::assertEquals(200, $client->getResponse()->getStatusCode());
        self::assertArrayHasKey('token', $payload);
    }
}
