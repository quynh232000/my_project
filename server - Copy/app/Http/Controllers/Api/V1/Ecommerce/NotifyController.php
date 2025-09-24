<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\NotificationHistoryModel;
use Exception;
use Illuminate\Http\Request;

class NotifyController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new NotificationHistoryModel();
        parent::__construct($request);
    }
    public function index(Request $request)
    {

        try {
            $result = $this->table->listItem($this->_params,['task' => 'list']);
            if(!$request) return $this->error('Thông tin không hợp lệ');
            return $this->successResponsePagination('Ok',$result->items(),$result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
    public function show(Request $request, $id)
    {
        try {
            $notify = NotificationHistoryModel::where(['id' => $id, 'user_id' => auth('ecommerce')->id()])
                    ->with('notification')->first();

            if (!$notify) {
                return $this->errorResponse('Thông báo không tồn tại');
            }
            $notify->update(['is_read' => 1]);
            return $this->successResponse('Đã đọc tin nhắn thông báo', $notify);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function readAll(Request $request, $id)
    {
        try {
            NotificationHistoryModel::where(['is_read' => 0, 'user_id' => auth('eccommerce')->user()->id])->update(['status' => 1]);
            return $this->successResponse('Đã đọc tất cả tin nhắn thông báo');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
