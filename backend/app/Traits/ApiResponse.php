<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * This function is used to send a uniform success response.
     *
     * @param array $data
     * @param string $message
     * @param int $statusCode
     * @return JsonResponse
     */
    protected function successResponse(array $data, string $message, int $statusCode = 200): JsonResponse
    {
        return response()->json([
            'status' => $statusCode,
            'message' => $message,
            'data' => $data,
            'error' => null
        ]);
    }

    /**
     * This function is used to send a uniform error response.
     *
     * @param string $message
     * @param int $statusCode
     * @param string $errors
     * @return JsonResponse
     */
    protected function errorResponse(string $message, int $statusCode, string $errors): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'data' => null,
            'error' => $errors
        ], $statusCode);
    }
}

