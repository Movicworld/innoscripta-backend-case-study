<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\NewsSources\NewYorkTimesService;
use App\Services\NewsSources\NewsAPIService;
use App\Services\NewsSources\TheGuardianService;

class ArticleController extends Controller
{
    protected $newYorkTimesService, $newsAPIService, $theGuardianService;

    public function __construct(NewYorkTimesService $newYorkTimesService,
    NewsAPIService $newsAPIService,
    TheGuardianService $theGuardianService)
    {
        $this->newYorkTimesService = $newYorkTimesService;
        $this->newsAPIService = $newsAPIService;
        $this->theGuardianService = $theGuardianService;
    }

    public function news(){
        //return $this->newYorkTimesService->fetchNews();
        //return $this->newsAPIService->fetchNews();
        return $this->theGuardianService->fetchNews();
    }
    //
}
