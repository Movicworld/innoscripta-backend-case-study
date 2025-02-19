<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
        'source',
        'title',
        'content',
        'author',
        'category',
        'published_at',
        'url',
    ];

}
