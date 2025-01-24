<?php

namespace App\Services\Admin;

use App\Repositories\ArticleRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminServices
{
    protected $articleRepository;
    protected $userRepository;
    protected $categoryRepository;

    public function __construct(
        ArticleRepository $articleRepository,
        UserRepository $userRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
        $this->categoryRepository = $categoryRepository;
    }

    public function getUsers($userId = null)
    {
        if ($userId) {
            return $this->userRepository->getUserDetails($userId);
        }


        return $this->userRepository->getPaginatedUsers();
    }

    public function getCategories()
    {
        return $this->categoryRepository->getCategories();
    }


    public function getAdminDetails($admin)
    {
        return $admin;
    }

    public function createCategory($data)
    {
        return $this->categoryRepository->create($data);
    }
}
