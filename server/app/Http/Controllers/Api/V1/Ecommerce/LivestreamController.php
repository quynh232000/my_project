<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\LivestreamModel;
use Illuminate\Http\Request;

class LivestreamController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new LivestreamModel();
        parent::__construct($request);
    }
    public function index(Request $request){
        try {
            $result = $this->table->listItem($this->_params,['task' => 'list']);
            return $this->success('Ok',$result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
}
