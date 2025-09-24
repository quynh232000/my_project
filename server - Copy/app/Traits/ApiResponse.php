<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

trait ApiResponse
{
    public function successResponse($message = 'Thành công!', $data = null, $statusCode = Response::HTTP_OK)
    {
        return response()->json(['status' => true, 'message' => $message, 'data' => $data], $statusCode);
    }
    public function errorResponse($message = 'Thất bại!', $data = null, $statusCode = Response::HTTP_BAD_REQUEST)
    {
        return response()->json(['status' => false, 'message' => $message, 'data' => $data, 'error_code' => $statusCode], $statusCode);
    }
    public function successResponsePagination($message = 'Thành công!', $data = null, $paginate = null, $statusCode = Response::HTTP_OK)
    {
        $resPagination = [];
        if ($paginate) {
            $resPagination = [
                'pagination' => [
                    'current_page' => $paginate->currentPage(),
                    'last_page' => $paginate->lastPage(),
                    'per_page' => $paginate->perPage(),
                    'total' => $paginate->total(),
                    'next_page_url' => $paginate->nextPageUrl(),
                    'prev_page_url' => $paginate->previousPageUrl(),
                ]
            ];
        }
        return response()->json(['status' => true, 'message' => $message, 'data' => $data, 'meta' => $resPagination], $statusCode);
    }
    public function success($message = 'Thành công.', $data = null, $statusCode = 200, $meta = null): JsonResponse
    {
        $response = [
            'status'    => true,
            'message'   => $message,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }
        if ($data) {
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }


    public function error($message, $errorDetails = [], $statusCode = 400): JsonResponse
    {
        $response = [
            'status'    => false,
            'message'   => $message,
            'error'     => [
                'code'      => $statusCode
            ]
        ];
        if ($errorDetails) {
            $response = [
                ...$response,
                'error' => [
                    ...$response['error'],
                    'details'   => $errorDetails
                ]
            ];
        }

        return response()->json($response, $statusCode);
    }
    public function errorInvalidate($message, $errorDetails = [])
    {
        return $this->error($message, $errorDetails, 422);
    }

    public function internalServerError($message = 'Đã xảy ra lỗi hệ thống.', $statusCode = 500): JsonResponse
    {
        return $this->error($message, null, $statusCode);
    }


    public function paginated($message = 'Lấy dữ liệu thành công.', $data, $statusCode = 200, $meta = []): JsonResponse
    {
        $response = [
            'status'    => true,
            'message'   => $message,
            'data'      => $data,
            'meta'      => $meta
        ];

        return response()->json($response, $statusCode);
    }
}
