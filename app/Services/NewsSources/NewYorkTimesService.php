<?php

namespace App\Services\NewsSources;

use App\Helpers\HttpClientHelper;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Services\APILogService;
use Exception;
use Illuminate\Support\Facades\Log;

class NewYorkTimesService
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

    // Fetch Articles New York Times API
    public function fetchNews()
    {
        $categories = $this->categoryRepository->getCategories();
        $apiKey = config('services.nyt.api_key');
        $url = 'https://api.nytimes.com/svc/topstories/v2/home.json';
        $queryParams = [
            'api-key' => $apiKey
        ];

        try {
            $response = $this->httpClient->get($url, $queryParams);

             //Log response
            $sanitizedQueryParams = $queryParams;
            unset($sanitizedQueryParams['api-key']);
            $this->apiLogService->logRequest(
                'New York Times API',
                $url,
                $sanitizedQueryParams,
                $response,
                isset($response['status']) && $response['status'] === 'OK'
            );
            
            if ($response && $response['status'] === 'OK') {
                $articles = [];

                foreach ($response['results'] as $article) {
                    // Check if the article's section matches any of the categories
                    $categoryNames = $categories->pluck('name')->map(fn($name) => strtolower($name))->toArray();

                    if (in_array(strtolower($article['section']), $categoryNames)) {
                        $articles[] = [
                            'source' => 'New York Times',
                            'title' => $article['title'],
                            'author' => isset($article['byline']) ? preg_replace('/^\S+\s/', '', $article['byline']) : null,
                            'content' => $article['abstract'],
                            'url' => $article['url'],
                            'category' => $article['section'],
                            'published_at' => $article['published_date'],
                        ];
                    }
                }

                $this->articleRepository->saveArticles($articles);
            }
        } catch (Exception $e) {
            Log::error('HTTP GET Request Failed', ['url' => $url, 'error' => $e->getMessage()]);
            if ($e->getCode() == 429) {
                Log::warning('Rate limit hit for NYT API.');
            }
        }

        return true;
    }
}
