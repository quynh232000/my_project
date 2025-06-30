<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\AdminController;
use App\Models\Ecommerce\PaymentMethodModel;
use App\Models\Ecommerce\SettingModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class SettingController extends AdminController
{
    private $model  = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new SettingModel();
    }
   public function index()
    {
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create(Request $request)
    {
        $this->_params['categories']                     = $this->model->all();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $result = $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return redirect()->back()->with($result['status'], $result['message']);
    }
    public function edit(Request $request, $id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        $this->_params['item']                           = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        $this->_params['categories']                     = $this->model->all();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(Request $request, $id)
    {
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
            $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        }
        return redirect()->back()->with('success', ' Update successfully!');
    }


    public function confirmDelete()
    {
        $this->_params['id'] = $this->_params['id'] ?? [];
        $this->model->deleteItem($this->_params, ['task' => 'delete-item']);
        return response()->json(array('status' => true, 'message' => 'Delete item successfully.'));
    }
    public function status($status, $id)
    {
        $this->_params['status']    = $status;
        $this->_params['id']        = $id;
        $this->model->saveItem($this->_params, ['task' => 'change-status']);
        return redirect()->route($this->_params['prefix'] . '.' . $this->_params['controller'] . '.index')->with('success', 'Update status successfully!');
    }
}
