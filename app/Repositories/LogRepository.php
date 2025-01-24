<?php

namespace App\Repositories;

use App\Models\APIRequestLog;

class LogRepository
{
    public function log($data)
    {
        return APIRequestLog::create($data);
    }
}
