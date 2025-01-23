<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run()
    {
        DB::table('categories')->insert([
            ['name' => 'News', 'description' => 'General news articles and updates'],
            ['name' => 'Technology', 'description' => 'Articles related to advancements in technology'],
            ['name' => 'Health', 'description' => 'Articles focused on health and wellness topics'],
            ['name' => 'Travel', 'description' => 'Articles on travel and tourism insights'],
            ['name' => 'Movies', 'description' => 'Articles about the film industry and movies'],
            ['name' => 'General', 'description' => 'General articles on various topics'],
            ['name' => 'World', 'description' => 'News and articles about global events'],
            ['name' => 'Business', 'description' => 'Articles related to business and commerce'],
            ['name' => 'Environment', 'description' => 'Articles discussing environmental issues and sustainability'],
            ['name' => 'Finance', 'description' => 'Articles covering finance and investment strategies'],
            ['name' => 'Lifestyle', 'description' => 'Articles about lifestyle and daily living'],

        ]);
    }
}
