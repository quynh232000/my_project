<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Models\Api\V1\Hms\LanguageModel;
use Illuminate\Http\Request;


class LanguageController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new LanguageModel();
    }
    public function index(Request $request)
    {
        try {
            $result = $this->model->listItem($this->_params,['task' => 'list-items']);
            return $this->success('Lấy danh sách ngôn ngữ thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
   
}
