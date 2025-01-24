<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class APIRequestLog extends Model
{
    protected $table = 'api_logs';
    protected $fillable = [
        'source',
        'endpoint',
        'request_data',
        'response_data',
        'success',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }
}
