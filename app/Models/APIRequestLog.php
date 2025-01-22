<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIRequestLog extends Model
{
    protected $table = 'api_logs';
    protected $fillable = [
        'source_id',
        'endpoint',
        'status_code',
        'response_time',
        'response_body',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
