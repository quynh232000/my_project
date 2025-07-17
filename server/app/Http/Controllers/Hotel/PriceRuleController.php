<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Hotel\PriceRuleModel;
use Illuminate\Http\Request;

class PriceRuleController extends AdminController
{
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new PriceRuleModel();
    }
    public function update(Request $request)
    {
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    }
}
