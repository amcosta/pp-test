<?php declare(strict_types=1);

namespace App\Services;

use App\Entity\User;
use App\Exceptions\AuthorizationException;
use App\Services\Authorization\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Authorization
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function checkUser(User $user): bool
    {
        try {
            $response = $this->client->request('GET', '/authorize/' . $user->getId());
        } catch (GuzzleException $exception) {
            throw new HttpException(504, 'Authorization service unavailable');
        }

        $data = json_decode($response->getBody(), true);
        if ($data['authorized'] === false) {
            throw new AuthorizationException('Payer isn\'t authorized');
        }

        return true;
    }
}