<?php

namespace App\Http\Controllers\Api\V1\Hms;

use App\Http\Controllers\Api\HmsController;
use App\Http\Requests\Api\V1\Hms\Room\ToggleStatusRequest;
use App\Models\Api\V1\Hms\RoomModel;
use Illuminate\Http\Request;

class RoomController extends HmsController
{
    protected $data = [];
    public $model;

    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new RoomModel();
    }
    public function index(Request $request)
    {
        try{
            if(isset($request->list) && $request->list == 'all'){
                $response = $this->model->listItem($this->_params, ['task' => 'list-all']);
                return $this->success('Thành công!',$response);
            }else{
                $response = $this->model->listItem($this->_params, ['task' => 'list-item']);
                return $this->paginated('Lấy thông tin thành công!',$response->items(),200,[
                    'per_page'      => $response->perPage(),
                    'current_page'  => $response->currentPage(),
                    'total_page'    => $response->lastPage(),
                    'total_item'    => $response->total(),
                ]);
            }
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    public function show($room)
    {
        $this->_params['id'] = $room;
        try{
            $response = $this->model->getItem($this->_params, ['task' => 'detail']);
            return $this->success('Thành công!',$response);
        }catch(\Exception $e){
            return $this->error($e->getMessage());
        }
    }
    public function store(Request $request)
    {
        $response = $this->model->saveItem($this->_params, ['task' => 'add-item']);
        return response()->json($response);
    }
    public function update(Request $request,$room)
    {
        $this->_params['id']    = $room;
        $response               = $this->model->saveItem($this->_params, ['task' => 'edit-item']);
        
        return response()->json($response);
    }
    public function list(){
        try {
            $result                 = $this->model->listItem($this->_params,['task' => 'list']);
            // return response(gzencode(json_encode($result)))
            // ->header('Content-Type', 'application/json')
            // ->header('Content-Encoding', 'gzip');
            return $this->success('Lấy danh sách thành công!',$result );
        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
    public function toggleStatus(ToggleStatusRequest $request){
        try {
            $result                 = $this->model->saveItem($this->_params,['task' => 'toggle-status']);
            return $this->success('Thực hiện yêu cầu thành công!',$result );
        } catch (\Exception $e) {
             return $this->internalServerError('Đã xảy ra lỗi:'. $e->getMessage());
        }
    }
}
