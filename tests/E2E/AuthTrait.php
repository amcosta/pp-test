<?php

namespace App\Tests\E2E;

trait AuthTrait
{
    protected function createAuthenticatedClient($username = 'pumba', $password = 'hakunamatata')
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login_check',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['username' => $username, 'password' => $password])
        );

        $payload = json_decode($client->getResponse()->getContent(), true);
        $client->setServerParameter('HTTP_Authorization', sprintf('Bearer %s', $payload['token']));

        return $client;
    }
}