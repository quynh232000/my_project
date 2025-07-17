<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\PolicyOther\ShowRequest;
use App\Http\Requests\Api\V1\Hms\PolicyOther\UpdateRequest;
use App\Models\Api\V1\Hms\PolicyOtherModel;
use Illuminate\Http\Request;


class PolicyOtherController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PolicyOtherModel();
    }
    public function index(Request $request)
    {
        try {
            
            $result = $this->model->listItem($this->_params,['task' => 'list-item']);

            return $this->success('Lấy danh sách thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi: '. $e->getMessage());
        }
    }
    public function store(UpdateRequest $request)
    {
        try {
            $this->model->saveItem($this->_params,['task' => 'edit-item']);
            
            return $this->success('Cập nhật thành công!');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi: '. $e->getMessage());
        }
    }
    public function show(ShowRequest $request,$policy_other)
    {
        try {
           $result =  $this->model->getItem([...$this->_params, 'slug' => $policy_other],['task' => 'item-info']);
            
            return $this->success('Lấy thông tin chi tiết thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi: '. $e->getMessage());
        }
    }
}
