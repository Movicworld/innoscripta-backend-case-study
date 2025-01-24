<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsSources\NewYorkTimesService;
use App\Services\NewsSources\TheGuardianService;
use App\Services\NewsSources\NewsAPIService;

class FetchArticles extends Command
{
    protected $signature = 'news:update';
    protected $description = 'Update news data from various sources';

    protected $newYorkTimesService;
    protected $theGuardianService;
    protected $newsAPIService;

    public function __construct(
        NewYorkTimesService $newYorkTimesService,
        TheGuardianService $theGuardianService,
        NewsAPIService $newsAPIService,
    ) {
        parent::__construct();
        $this->newYorkTimesService = $newYorkTimesService;
        $this->theGuardianService = $theGuardianService;
        $this->newsAPIService = $newsAPIService;
    }

    public function handle()
    {
        $this->info('Starting news update...');
        $this->newYorkTimesService->fetchNews();
        $this->theGuardianService->fetchNews();
        $this->newsAPIService->fetchNews();
       // $this->newCredService->fetchNews();
        $this->info('Article update completed.');
    }
}
