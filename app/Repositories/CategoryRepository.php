<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{
    public function getCategories()
    {
        return Category::all();
    }


    public function saveArticle($data)
    {
        Category::create([
            'name' => $data['name'],
            'description' => $data['description'],
        ]);

        return true;
    }

}
