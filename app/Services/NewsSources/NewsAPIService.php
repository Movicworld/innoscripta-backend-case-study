<?php

namespace App\Services\NewsSources;

use App\Helpers\HttpClientHelper;
use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Log;

class NewsAPIService
{
    protected $httpClient;
    protected $articleRepository;
    protected $categoryRepository;
    public function __construct(
        HttpClientHelper $httpClient,
        ArticleRepository $articleRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->httpClient = $httpClient;
        $this->articleRepository = $articleRepository;
        $this->categoryRepository = $categoryRepository;
    }

    // Fetch Articles from NewsAPI.org API
    public function fetchNews()
    {
        $categories = $this->categoryRepository->getCategories();

        foreach ($categories as $category) {
            $apiKey = config('services.newsapi.api_key');
            $url = 'https://newsapi.org/v2/everything';
            $queryParams = [
                'apiKey' => $apiKey,
                'language' => 'en',
                'q' => strtolower($category->name),
            ];

            $response = $this->httpClient->get($url, $queryParams);

            if ($response && $response['status'] === 'ok') {
                $articles = [];

                foreach ($response['articles'] as $article) {
                    if (!isset($article['title']) || !isset($article['url'])) {
                        // Skip articles missing essential fields
                        continue;
                    }

                    $articles[] = [
                        'source' => 'NewsAPI',
                        'title' => $article['title'],
                        'author' => $article['author'] ?? 'Unknown',
                        'content' => $article['content'] ?? '',
                        'url' => $article['url'],
                        'category' => $category->name,
                        'published_at' => $article['publishedAt'],
                    ];
                }

                if (!empty($articles)) {
                    try {
                        $this->articleRepository->saveArticles($articles);
                    } catch (\Exception $e) {
                        Log::error('Failed to save articles for category: ' . $category->name . ' - ' . $e->getMessage());
                    }
                }
            } else {
                Log::warning('Failed to fetch news for category: ' . $category->name);
            }
        }

        return true;
    }
}
