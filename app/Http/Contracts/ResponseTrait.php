<?php

namespace App\Http\Contracts;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator as LengthAwarePaginatorContract;

trait ResponseTrait
{
    public function success($data, int $status = 200): JsonResponse
    {
        $response = [];

        $response['results'] = $data;

        if ($data instanceof ResourceCollection && $data->resource instanceof LengthAwarePaginatorContract) {
            $paginated = $data->response()->getData(true);

            $response['links'] = $paginated['links'];
            $response['meta'] = $paginated['meta'];
        }

        $response['error_message'] = '';

        return response()->json([
            'data' => $response,
            'server_time' => Carbon::now()->toIso8601String(),
        ], $status);
    }

    public function error($message, int $status = 400): JsonResponse
    {
        $response = [
            'data' => [
                'results' => (object)[],
                'error_message' => $message,
            ],
            'server_time' => Carbon::now()->toIso8601String(),
        ];

        return response()->json($response, $status);
    }

}
