<?php

namespace App\Services\NewsSources;

use App\Helpers\HttpClientHelper;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\APILogService;
use Exception;
use Illuminate\Support\Facades\Log;

class TheGuardianService
{
    protected $httpClient;
    protected $articleRepository;
    protected $categoryRepository;
    protected $apiLogService;
    public function __construct(
        HttpClientHelper $httpClient,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository,
        APILogService $apiLogService
    ) {
        $this->httpClient = $httpClient;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
        $this->apiLogService = $apiLogService;
    }

    // Fetch Articles from The Guardian API
    public function fetchNews()
    {
        $categories = $this->categoryRepository->getCategories();
        $apiKey = config('services.guardian.api_key');
        $url = 'https://content.guardianapis.com/search';
        $queryParams = [
            'api-key' => $apiKey,
            'page-size' => 100,
            'order-by' => 'newest',
        ];

        try {
            $response = $this->httpClient->get($url, $queryParams);

             //Log response
            $sanitizedQueryParams = $queryParams;
            unset($sanitizedQueryParams['api-key']);
            $this->apiLogService->logRequest(
                'The Guardian API',
                $url,
                $sanitizedQueryParams,
                $response,
                isset($response['response']['status']) && $response['response']['status'] === 'ok'
            );

            if ($response && $response['response']['status'] === 'ok') {
                $articles = [];
                $categoryNames = $categories->pluck('name')->map(fn($name) => strtolower($name))->toArray();

                foreach ($response['response']['results'] as $result) {
                    // Match the sectionName with categories in the database
                    if (in_array(strtolower($result['sectionId']), $categoryNames)) {
                        $articles[] = [
                            'source' => 'The Guardian',
                            'title' => $result['webTitle'],
                            'author' => null, // No author field in the response
                            'content' => null, // No content field in the response
                            'url' => $result['webUrl'],
                            'category' => $result['sectionId'],
                            'published_at' => $result['webPublicationDate'],
                        ];
                    }
                }

                // Save the articles using the repository
                $this->articleRepository->saveArticles($articles);
            }
        } catch (Exception $e) {
            Log::error('HTTP GET Request Failed', ['url' => $url, 'error' => $e->getMessage()]);
        }

        return true;
    }
}
