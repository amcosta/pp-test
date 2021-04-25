<?php

namespace App\Services\Authorization;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public function __construct(array $config = [], string $authorizationUrl = '')
    {
        $config = [
            'base_uri' => $authorizationUrl,
            'timeout' => 2.0
        ];
        parent::__construct($config);
    }
}
