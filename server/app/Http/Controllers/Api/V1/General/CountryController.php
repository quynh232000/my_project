<?php

namespace App\Http\Controllers\Api\V1\General;

use App\Http\Controllers\Api\ApiController;
use App\Models\Api\V1\General\CountryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CountryController extends ApiController
{
    public $model;
    public $category;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new CountryModel();
    }
    public function list(Request $request)
    {
        $this->_params['thumb_name'] = 'thumb1';
        $items = $this->model->listItem($this->_params, ['task' => 'list']);
        return response()->json($items, $items['status_code']);
    }
    public function listItems(Request $request)
    {
        $items = $this->model->listItem($this->_params, ['task' => 'list-items']);
        return response()->json($items, $items['status_code']);
    }
    public function address(Request $request)
    {
        $items = $this->model->listItem($this->_params, ['task' => 'address']);
        return response()->json($items, $items['status_code']);
    }
}
