<?php

namespace App\Http\Controllers\Api\V1\Cms;

use App\Http\Controllers\Api\CmsController;
use App\Http\Requests\Api\V1\Cms\Restaurant\CreateRequest;
use App\Http\Requests\Api\V1\Cms\Restaurant\DestroyRequest;
use App\Http\Requests\Api\V1\Cms\Restaurant\ShowRequest;
use App\Http\Requests\Api\V1\Cms\Restaurant\ToggleStatusRequest;
use App\Http\Requests\Api\V1\Cms\Restaurant\UpdateRequest;
use App\Models\Api\V1\Cms\RestaurantModel;
use DB;
use Illuminate\Http\Request;
use Str;

/**
 * @authenticated
 */
class RestaurantController extends CmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new RestaurantModel();
    }
    public function index(Request $request)
    {
        try {
            $result = $this->model->listItem($this->_params, ['task' => 'list']);
            return $this->paginated('Lấy thông tin thành công!', $result->items(), 200, [
                'per_page'      => $result->perPage(),
                'current_page'  => $result->currentPage(),
                'total_page'    => $result->lastPage(),
                'total_item'    => $result->total(),
            ]);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function store(CreateRequest $request)
    {
        try {
            $result = $this->model->saveItem($this->_params, ['task' => 'add-item']);

            return $this->success('Cập nhật thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function update(UpdateRequest $request, $restaurant)
    {
        try {
            $result = $this->model->saveItem([...$this->_params, 'id' => $restaurant], ['task' => 'edit-item']);

            return $this->success('Cập nhật thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function show(ShowRequest $request, $restaurant)
    {
        try {
            $result =  $this->model->getItem([...$this->_params, 'id' => $restaurant], ['task' => 'detail']);

            return $this->success('Lấy thông tin chi tiết thành công!', $result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function toggleStatus(ToggleStatusRequest $request)
    {
        try {
            $result =  $this->model->saveItem([...$this->_params], ['task' => 'toggle-status']);

            return $this->success('Thực hiện yêu cầu thành công!',$result);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
}
