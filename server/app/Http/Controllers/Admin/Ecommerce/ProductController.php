<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\AdminController;
use App\Models\Ecommerce\ProductModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ProductController extends AdminController
{
    private $table  = null;
    protected $data = [];
    public $model;
     public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model = new ProductModel();
    }
    public function index()
    {
        $this->_params["item-per-page"]     = $this->getCookie('-item-per-page', 25);
        $this->_params['model']             = $this->model->listItem($this->_params, ['task' => "admin-index"]);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(Request $request, $id)
    {
        $item = $this->table->find($id);
        $data = $request->all();
        $icon_link                 = $request->icon_link ?? '';
        $fileService                = new FileService();
        if ($request->hasFile('icon')) {
            $icon_link             = $fileService->uploadFile($request->image, 'ecomerce.caregory', auth()->id())['url'] ?? '';
        }


         unset($data['icon_link'],$data['avatar_remove']);

        $item->update([
            ...$data,
            'slug'                  => Str::slug($data['name']),
            'icon_url'              => $icon_link,
            'updated_at'            => now()

        ]);
        return redirect()->back()->with('success', ' Update successfully!');
    }
    public function edit(Request $request, $id)
    {
        $this->_params['categories'] = $this->table->orderByDesc('id')->get();
        $this->_params['item']  = $this->table->find($id);

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create(Request $request)
    {
        $this->_params['categories'] = $this->table->orderByDesc('id')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $data                       = $request->all();
        $icon_link                 = $request->icon_link ?? '';
        $fileService                = new FileService();
        if ($request->hasFile('icon')) {
            $icon_link             = $fileService->uploadFile($request->icon, 'ecommerce.Product', auth()->id())['url'] ?? '';
        }
        unset($data['icon_link'],$data['avatar_remove']);

        $this->table->create([
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
