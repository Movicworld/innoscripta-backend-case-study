<?php

namespace App\Repositories;

use App\Models\Article;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ArticleRepository
{
    public function saveArticle($data)
    {
        Article::create([
            'source' => $data['source'],
            'title' => $data['title'],
            'author' => $data['author'],
            'content' => $data['content'],
            'url' => $data['url'],
            'category' => $data['category'],
            'published_at' => Carbon::parse($data['published_at'])->toDateTimeString(),
        ]);

        return true;
    }

    public function saveArticles($articles)
    {
        $insertData = [];

        foreach ($articles as $article) {
            // Check if the article already exists based on the unique title (case-insensitive)
            $exists = Article::whereRaw('LOWER(title) = ?', [strtolower($article['title'])])->exists();

            if (!$exists) {
                $insertData[] = [
                    'source' => $article['source'],
                    'title' => $article['title'],
                    'author' => $article['author'] ?? 'Unknown',
                    'content' => $article['content'] ?? '',
                    'url' => $article['url'],
                    'category' => $article['category'],
                    'published_at' => Carbon::parse($article['published_at'])->toDateTimeString(),
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

}
