<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use Illuminate\Http\Request;
use App\Services\NewsSources\NewYorkTimesService;
use App\Services\NewsSources\NewsAPIService;
use App\Services\NewsSources\TheGuardianService;
use App\Services\UserService;
use Exception;
use Illuminate\Support\Facades\Auth;

class ArticleController extends Controller
{
    protected $newYorkTimesService;
    protected $newsAPIService;
    protected $theGuardianService;
    protected $articleService;
    protected $userServices;
    public function __construct(
        NewYorkTimesService $newYorkTimesService,
        NewsAPIService $newsAPIService,
        TheGuardianService $theGuardianService,
        ArticleService $articleService,
        UserService $userServices,
    ) {
        $this->newYorkTimesService = $newYorkTimesService;
        $this->newsAPIService = $newsAPIService;
        $this->theGuardianService = $theGuardianService;
        $this->articleService = $articleService;
        $this->userServices = $userServices;
    }

    public function news()
    {
         $this->newYorkTimesService->fetchNews();
         $this->newsAPIService->fetchNews();
        $this->theGuardianService->fetchNews();

        return response()->json([
            'status' => true,
            'message' => 'Articles retrieved from Third party successfully',
        ], 200);

    }

    public function searchArticles(Request $request)
    {
        try {
            $filters = $request->all();
            $user = Auth::user();

    if ($user) {
        // Fetch user preferences
        $userPreferences = $this->userServices->getUserPreferences($user->id);

        // Merge user preferences with request filters
        $filters = array_merge([
            'category' => $userPreferences->preferred_categories ?? null,
            'source' => $userPreferences->preferred_sources ?? null,
            'author' => $userPreferences->preferred_authors ?? null,
        ], $filters);
    }
            $articles = $this->articleService->searchArticles($filters);

            return response()->json([
                'status' => true,
                'message' => 'Articles retrieved successfully',
                'data' => $articles
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve articles',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getFilterApparatus()
    {
        try {
            // Fetch the filter apparatus
            $filters = $this->articleService->getFilters();

            return response()->json([
                'status' => true,
                'message' => 'Filter apparatus retrieved successfully',
                'data' => $filters
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve filter apparatus',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
