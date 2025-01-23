<?php

namespace App\Services\Admin;

use App\Repositories\ArticleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AdminServices
{
    protected $articleRepository;
    protected $userRepository;

    public function __construct(ArticleRepository $articleRepository, UserRepository $userRepository)
    {
        $this->articleRepository = $articleRepository;
        $this->userRepository = $userRepository;
    }


    public function getUsersWithPreferences($id)
    {
        return $this->userRepository->getUsersWithPreferences($id);
    }

    public function getAdminDetails($admin)
    {
        return $admin;
    }

    public function createCategories(Request $request)
    {
        return $this->userRepository->getUsersWithPreferences($id);
    }

}
