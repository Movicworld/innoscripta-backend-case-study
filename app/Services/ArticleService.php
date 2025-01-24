<?php

namespace App\Services;

use App\Repositories\ArticleRepository;

class ArticleService
{
    protected $articleRepository;
    public function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function searchArticles($filters)
{
    return $this->articleRepository->searchArticles($filters);
}


public function getFilters()
{
    return $this->articleRepository->getFilters();
}

}
