<?php

namespace App\Tests\E2E\Controller;

use App\Repository\UserRepository;
use App\Tests\E2E\AuthTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class P2PControllerTest extends WebTestCase
{
    use AuthTrait;
    
    public function testShouldMakeAP2PTransaction(): void
    {
        $client = $this->createAuthenticatedClient();
        
        $crawler = $client->request(
            'POST',
            '/api/p2p-transfer',
            [],
            [],
            ['CONTENT_TYPE' => 'application/son'],
            json_encode(['payee_id' => 1, 'amount' => 6.78])
        );

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
