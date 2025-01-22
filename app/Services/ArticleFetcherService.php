<?php

namespace App\Services;

use GuzzleHttp\Client;

class ArticleFetcherService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function fetchArticlesFromSource($source)
    {
        $response = $this->client->get($source->api_url, [
            'headers' => [
                'Authorization' => "Bearer {$source->api_key}",
            ],
        ]);

        return json_decode($response->getBody(), true);
    }
}
