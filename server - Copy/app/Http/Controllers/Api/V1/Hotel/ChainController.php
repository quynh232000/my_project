<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Models\Api\V1\Hotel\ChainModel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;

class ChainController extends ApiController
{
    use ApiResponse;
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new ChainModel();
    }
    public function index(Request $request) 
    {
         try {
            $result     = $this->model->listItem($this->_params,['task' => 'list']);
            return $this->success('Lấy thông tin thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
}
