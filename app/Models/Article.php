<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $table = 'articles';
    protected $fillable = [
        'source_id',
        'title',
        'content',
        'author',
        'category',
        'published_at',
        'url',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
