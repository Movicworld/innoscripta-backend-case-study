<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleMetadata extends Model
{
    protected $table = 'article_metadata';

    protected $fillable = [
        'article_id',
        'views',
        'likes',
        'shares',
    ];

    /**
     * Get the article associated with the metadata.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
