<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Models\Api\V1\Hms\BankBranchModel;
use Illuminate\Http\Request;


class BankBranchController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new BankBranchModel();
    }
    public function index(Request $request)
    {
        try {
            
            $result = $this->model->listItem($this->_params,['task' => 'list-item']);

            return $this->success('Lấy danh sách thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
