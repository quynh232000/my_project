<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\RoomQuantity\UpdateRequest;
use App\Models\Api\V1\Hms\RoomQuantityModel;
use Illuminate\Http\Request;


class RoomQuantityController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new RoomQuantityModel();
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
   
}
