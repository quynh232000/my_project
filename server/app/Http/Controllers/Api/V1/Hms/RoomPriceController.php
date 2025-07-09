<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\RoomPrice\UpdateRequest;
use App\Models\Api\V1\Hms\RoomPriceModel;
use Illuminate\Http\Request;


class RoomPriceController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new RoomPriceModel();
    }

    public function store(UpdateRequest $request)
    {
        try {
            $result = $this->model->saveItem($this->_params,['task' => 'update-item']);
            
            return $this->success('Cập nhật thành công!',$result);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function history(Request $request)
    {
        try {
            $result = $this->model->listItem($this->_params,['task' => 'list-history']);
            
            return $this->paginated('Lấy thông tin thành công!',$result->items(),200,[
                    'per_page'      => $result->perPage(),
                    'current_page'  => $result->currentPage(),
                    'total_page'    => $result->lastPage(),
                    'total_item'    => $result->total(),
                ]);

        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }

   
}
