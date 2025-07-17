<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Models\Api\V1\Hms\AttributeModel;
use Illuminate\Http\Request;


class AttributeController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new AttributeModel();
    }
    public function index(Request $request)
    {
        try {
           if(!$request->type){
            return $this->errorInvalidate('Vui lòng chọn type');
           }
            $result = $this->model->listItem($this->_params,['task' => 'list-items']);
            return $this->success('Thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
