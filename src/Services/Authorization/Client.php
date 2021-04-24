<?php

namespace App\Services\Authorization;

use GuzzleHttp\Client as GuzzleClient;

class Client extends GuzzleClient
{
    public function __construct(array $config = [])
    {
        $config = [
            'base_uri' => '',
            'timeout' => 2.0
        ];
        parent::__construct($config);
    }
}
