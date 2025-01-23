<?php

namespace App\Services\NewsSources;

use Illuminate\Support\Facades\Http;
use App\Helpers\HttpClientHelper;

class NewCredService
{
    protected $httpClient;
    public function fetchNews()
    {
        $apiKey = env('NEWCRED_API_KEY');
        $response = Http::get("https://newcred.com/api/news?api-key={$apiKey}");

        if ($response->successful()) {
            $data = $response->json();
            // Process and save the data
        }
    }
}
