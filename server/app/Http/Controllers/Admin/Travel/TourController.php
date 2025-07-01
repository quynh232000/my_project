<?php

namespace App\Http\Controllers\Admin\Travel;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\Ecommerce\ShopRequest;
use App\Models\Travel\TourModel;
use App\Services\FileService;
use App\Traits\ApiRes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
class TourController extends AdminController
{
    use ApiRes;
    private $model = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new TourModel();
    }
    public function index()
    {
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(ShopRequest $request, $id)
    {

        $this->_params['id'] = $id;
        $this->model->saveItem($this->_params, ['task' => "edit-item"]);
        return $this->success('Update successfully!');
    }
    public function show( $id)
    {
        $this->_params['categories'] = $this->model->orderByDesc('id')->get();
        $this->_params['item']  = $this->model->find($id);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function edit(Request $request, $id)
    {
        $this->_params['categories'] = $this->model->orderByDesc('id')->get();
        $this->_params['item']  = $this->model->find($id);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create(Request $request)
    {
        $this->_params['categories'] = $this->model->orderByDesc('id')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $data                       = $request->all();
        $icon_link                 = $request->icon_link ?? '';
        $fileService                = new FileService();
        if ($request->hasFile('icon')) {
            $icon_link             = $fileService->uploadFile($request->icon, 'ecommerce.category', auth()->id())['url'] ?? '';
        }
        unset($data['icon_link'],$data['avatar_remove']);

        $this->model->create([
            ...$data,
            'slug'              => Str::slug($data['name']),
            'icon_url'          => $icon_link,
            'created_at'        => now(),
            'created_by'        => auth()->id(),
            'is_show'           => 1,
            'commission_fee'    => 5
        ]);


        return redirect()->back()->with('success', 'Create successfully.');
    }
    public function destroy($id)
    {
        $this->model->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
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
