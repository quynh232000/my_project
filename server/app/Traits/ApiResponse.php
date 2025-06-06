<?php

namespace App\Traits;

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
}
