<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'Technology', 'description' => 'Articles related to technology'],
            ['name' => 'Health', 'description' => 'Articles related to health and wellness'],
            ['name' => 'Finance', 'description' => 'Articles related to finance and investments'],
            ['name' => 'Lifestyle', 'description' => 'Articles related to lifestyle and living'],
            ['name' => 'Travel', 'description' => 'Articles related to travel and tourism'],
        ]);
    }
}
    