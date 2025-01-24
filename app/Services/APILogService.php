<?php

namespace App\Services;

use App\Repositories\LogRepository;

class APILogService
{
    protected $apiLogRepository;

    public function __construct(LogRepository $apiLogRepository)
    {
        $this->apiLogRepository = $apiLogRepository;
    }

    public function logRequest($source, $endpoint, $requestData, $responseData, $statusCode)
    {
        $logData = [
            'source' => $source,
            'endpoint' => $endpoint,
            'request_data' => json_encode($requestData),
            'response_data' => json_encode($responseData),
            'success' => $statusCode,
        ];

        $this->apiLogRepository->log($logData);
    }
}
