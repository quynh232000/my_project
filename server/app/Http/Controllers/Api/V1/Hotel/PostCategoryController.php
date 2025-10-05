<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Models\Api\V1\Hotel\PostCategoryModel;
use Illuminate\Http\Request;

class PostCategoryController extends ApiController
{
    public $model;
    public $newsCategorymodel;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PostCategoryModel();
    }
    public function list(Request $request)
    {
        $items = $this->model->listItem($this->_params, ['task' => 'list']);
        return response()->json($items, $items['status_code'] ?? 200);
    }
    public function detail(Request $request)
    {
        $items = $this->model->getItem($this->_params, ['task' => 'get-item-detail']);
        return response()->json($items, $items['status_code'] ?? 200);
    }
    public function meta(Request $request)
    {
        $items = $this->model->getItem($this->_params, ['task' => 'meta']);
        return response()->json($items, $items['status_code']);
    }
}
