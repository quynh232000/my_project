<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Hotel\PartnerRegisterRequest;
use App\Models\Api\V1\Hotel\PartnerRegisterModel;
use Illuminate\Http\Request;

class PartnerRegisterController extends ApiController
{
    public $model;
    public $newsCategorymodel;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new PartnerRegisterModel();
    }
    public function store(PartnerRegisterRequest $request) 
    {
        try {
            $this->_params['ip'] = $request->ip();

            $items = $this->model->saveItem($this->_params, ['task' => 'add-item']);
            return response()->json($items, $items['status_code']);

        } catch (\Exception $e) {

            return response()->json([
                'status'    => false,
                'message'   => $e->getMessage()
            ],500);
        }
        
    }
}
