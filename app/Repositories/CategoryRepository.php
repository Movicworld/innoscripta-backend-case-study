<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getCategories()
    {
        return Category::all();
    }

     public function create(array $data)
    {
        return Category::create($data);
    }

}
