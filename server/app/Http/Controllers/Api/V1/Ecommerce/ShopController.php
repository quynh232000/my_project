<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\ShopModel;
use Illuminate\Http\Request;

class ShopController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new ShopModel();
        parent::__construct($request);
    }
    public function index(Request $request){
        try {
            $result = $this->table->listItem($this->_params,['task' => 'list']);
            if(!$result) return $this->error('Thông tin không hợp lệ');
            return $this->success('Lấy danh sách sản phẩm thành công!', $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
    public function show(Request $request,$slug){
        try {
            $result = $this->table->getItem([...$this->_params,'slug' => $slug],['task' => 'info']);
            if(!$result) return $this->error('Thông tin không hợp lệ');
            return $this->success('Ok!', $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
}
