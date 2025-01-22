<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserActivityLog extends Model
{
    protected $table = 'user_activity_logs';
    protected $fillable = [
        'user_id',
        'article_id',
        'action',
        'action_at',
    ];

    /**
     * Get the user that owns the activity log.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the article associated with the activity log.
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
