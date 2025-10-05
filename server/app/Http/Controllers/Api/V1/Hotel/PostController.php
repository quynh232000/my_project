<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Models\Api\V1\Hotel\PostModel;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    public $model;
    public $newsCategorymodel;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new PostModel();
    }
    public function list(Request $request)
    {
        $items = $this->model->listItem($this->_params, ['task' => 'list']);
        return response()->json($items, $items['status_code']);
    }
    public function detail(Request $request)
    {
        $items = $this->model->getItem($this->_params, ['task' => 'detail']);
        return response()->json([...$items, 'data' => $items['data']], $items['status_code']);
    }
    public function listAirline(Request $request)
    {
        $items = $this->model->listItem($this->_params, ['task' => 'list-airline']);
        return response()->json($items, $items['status_code']);
    }
    public function meta(Request $request)
    {
        $items = $this->model->getItem($this->_params, ['task' => 'meta']);
        return response()->json($items, $items['status_code']);
    }
}
