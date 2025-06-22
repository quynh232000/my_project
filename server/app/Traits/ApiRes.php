<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiRes
{

    public function success( $message = 'Thành công.',$data = null, $statusCode = 200, $meta = null): JsonResponse
    {
        $response = [
            'status'    => true,
            'message'   => $message,
        ];

        if ($meta) {
            $response['meta'] = $meta;
        }
        if($data){
            $response['data'] = $data;
        }

        return response()->json($response, $statusCode);
    }


    public function error($message, $errorDetails = [],$statusCode = 400): JsonResponse
    {
        $response = [
            'status'    => false,
            'message'   => $message,
            'error'     => [
                    'code'      => $statusCode
            ]
        ];
        if($errorDetails){
            $response = [
                    ...$response,
                    'error'=> [
                        ...$response['error'],
                        'details'   => $errorDetails
                    ]
                ];
        }

        return response()->json($response, $statusCode);
    }
    public function errorInvalidate($message, $errorDetails = []){
        return $this->error($message, $errorDetails, 422);
    }

    public function internalServerError($message = 'Đã xảy ra lỗi hệ thống.', $statusCode = 500): JsonResponse
    {
        return $this->error($message, null, $statusCode);
    }


    public function paginated( $message = 'Lấy dữ liệu thành công.',$data, $statusCode = 200, $meta = []): JsonResponse
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
