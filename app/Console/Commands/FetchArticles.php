<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ArticleFetcherService;
use App\Models\Source;

class FetchArticles extends Command
{
    protected $signature = 'fetch:articles';
    protected $description = 'Fetch articles from configured sources';

    public function handle(ArticleFetcherService $fetcher)
    {
        $sources = Source::all();
        foreach ($sources as $source) {
            $articles = $fetcher->fetchArticlesFromSource($source);
            // Process and store articles in the database
        }

        $this->info('Articles fetched successfully.');
    }
}
