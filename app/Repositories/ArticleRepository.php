<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ArticleRepository
{

    public function saveArticles($articles)
    {
        $insertData = [];

        foreach ($articles as $article) {
            // Check if the article already exists based on the unique title (case-insensitive)
            $exists = Article::whereRaw(
                'LOWER(title) = ?',
                [strtolower($article['title'])]
            )->exists();

            if (!$exists) {
                $insertData[] = [
                    'source' => $article['source'],
                    'title' => $article['title'],
                    'author' => $article['author'] ?? 'Unknown',
                    'content' => $article['content'] ?? '',
                    'url' => $article['url'],
                    'category' => $article['category'],
                    'published_at' => Carbon::parse($article['published_at'])->toDateTimeString(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            } else {
                Log::info("Skipped duplicate article with title: {$article['title']}");
            }
        }

        if (!empty($insertData)) {
            try {
                Article::insert($insertData);
            } catch (\Exception $e) {
                Log::error('Failed to insert articles: ' . $e->getMessage());
            }
        }

        return true;
    }

    public function searchArticles($filters)
    {
        $query = Article::query();

        if (!empty($filters['query'])) {
            $query->where(
                'title',
                'like',
                '%' . $filters['query'] . '%'
            );
        }

        if (!empty($filters['category'])) {
            $query->whereIn(
                'category',
                explode(',', $filters['category'])
            );
        }

        if (!empty($filters['source'])) {
            $query->whereIn(
                'source',
                explode(',', $filters['source'])
            );
        }

        if (!empty($filters['author'])) {
            $query->where(
                'author',
                'like',
                '%' . $filters['author'] . '%'
            );
        }
        if (!empty($filters['date_from'])) {
            $query->whereDate(
                'published_at',
                '>=',
                $filters['date_from']
            );
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate(
                'published_at',
                '<=',
                $filters['date_to']
            );
        }

        // Paginate results, 20 per page
        $page = isset($filters['page']) ? $filters['page'] : 1;
        return $query->paginate(
            20,
            ['*'],
            'page',
            $page
        );
    }

    public function getFilters()
    {
        $categories = Category::all(['id', 'name']);

        $sources = Article::select('source')->distinct()->get();

        $authors = Article::select('author')->distinct()->get();

        return [
            'categories' => $categories,
            'sources' => $sources,
            'authors' => $authors,
        ];
    }
}
