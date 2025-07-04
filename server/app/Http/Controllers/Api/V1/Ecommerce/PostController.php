<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\PostModel;
use Illuminate\Http\Request;

class PostController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new PostModel();
        parent::__construct($request);
    }
    public function index(Request $request)
    {
        try {
            $result = $this->table->listItem($this->_params, ['task' => 'list']);
            if (!$result) return $this->error('Thông tin không hợp lệ');
            return $this->successResponsePagination('Lấy danh sách sản phẩm thành công!', $result->items(), $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
}
