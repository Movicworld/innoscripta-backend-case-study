<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Source extends Model
{
    protected $table = 'sources';
    protected $fillable = [
        'name',
        'api_url',
        'api_key',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
