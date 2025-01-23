<?php

namespace App\Helpers;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

class HttpClientHelper
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client([
            'timeout' => 130, // Set a default timeout
        ]);
    }

    /**
     * Make an HTTP GET request.
     *
     * @param string $url The API endpoint URL.
     * @param array $queryParams Query parameters for the request.
     * @param array $headers Headers for the request.
     * @return array|null Response data or null if an error occurs.
     */
    public function get(string $url, array $queryParams = [], array $headers = [])
    {
        try {
            $response = $this->client->get($url, [
                'query' => $queryParams,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Log or handle the exception
           $error = logger()->error('HTTP GET Request Failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            return $error;
        }
    }

    /**
     * Make an HTTP POST request.
     *
     * @param string $url The API endpoint URL.
     * @param array $data Payload for the request.
     * @param array $headers Headers for the request.
     * @return array|null Response data or null if an error occurs.
     */
    public function post(string $url, array $data = [], array $headers = [])
    {
        try {
            $response = $this->client->post($url, [
                'json' => $data,
                'headers' => $headers,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (RequestException $e) {
            // Log or handle the exception
            logger()->error('HTTP POST Request Failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }
}
