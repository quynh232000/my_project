<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\FileUploadModel;
use App\Services\FileService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FileUploadController extends ApiController
{
    public function __construct(Request $request)
    {
        parent::__construct($request);
    }
     public function upload_file(Request $request)
    {
        try {
            $from       = $request->from ?? 'upload_file';
            $validate   = Validator::make($request->all(), [
                            'file' => 'required',
                        ]);
            if ($validate->fails()) {
                return $this->errorResponse('Vui lòng chọn file');
            }
            $fileService    = new FileService();
            if ($request->hasFile('file')) {
                $result     = $fileService->uploadFile($request->file, $from, auth('ecommerce')->id());
                if ($result['status']) {
                    return $this->successResponse('Thêm file thành công', $result['url']);
                } else {
                    return $this->errorResponse('Thêm file thất bại', $result['message']);
                }
            }
            return $this->errorResponse('Lỗi khong có file');
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
     public function upload_files(Request $request)
    {
        try {
            $from           = $request->from ?? 'upload_file';

            if (!$request->hasFile('files')) {
                return $this->errorResponse('Vui lòng chọn file nhiều');
            }
            $fileService    = new FileService();
            $filesUrls      = [];
            foreach ($request->file('files') as $key => $value) {
                $result     = $fileService->uploadFile($value, $from, auth('ecommerce')->id());
                if ($result['status'] && $result['url']) {
                    $filesUrls[] = $result['url'];
                }
            }
            return $this->successResponse('success', $filesUrls);
        } catch (Exception $e) {
            return $this->errorResponse('Lỗi: ' . $e->getMessage());
        }
    }
}
