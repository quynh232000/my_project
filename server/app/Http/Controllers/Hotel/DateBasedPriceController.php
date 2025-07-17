<?php

namespace App\Http\Controllers\Hotel;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Controller;
use App\Models\Hotel\DateBasedPriceModel;
use Illuminate\Http\Request;

class DateBasedPriceController extends AdminController
{
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model        = new DateBasedPriceModel();
        $this->_viewAction  = 'hotel.date-based-price.index';
       
    }
    public function dateBasedPrice($hotel_id)
    {
       
        $this->_params[$this->model->columnPrimaryKey()]  = $hotel_id;
        $this->_params['item']      = $this->model->getItem($this->_params, ['task' => "get-item-info"]);
        // echo '<pre>';
        // print_r($this->_params['item']->toArray());
        // echo '<pre>';
        // die();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit($id)
    {
        $this->_params['hotel'] = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        $this->_params[$this->model->columnPrimaryKey()] = $id;
        //$this->_params['item']              = $this->model->getItem($this->_params, ['task' => 'get-item-info']);
        // $this->_params['roomType']          = $this->model->getItem($this->_params, ['task' => 'get-room-type']);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    // public function update()
    // {
    //     if (isset($this->_params['_method']) && $this->_params['_method'] == 'PUT') {
    //         $this->model->saveItem($this->_params, ['task' => 'edit-item']);
    //     }
    //     return response()->json(array('success' => true, 'message' => 'Cập nhật thành công'));
    // }
}