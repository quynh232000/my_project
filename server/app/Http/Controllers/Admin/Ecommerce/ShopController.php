<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\AdminController;
use App\Models\Ecommerce\ShopModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class ShopController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new ShopModel();
    }
    public function index()
    {
        $query = $this->table->with('creator');
        if (request()->search ?? false) {
            $query->where('name', 'LIKE', '%' . request()->search . '%');
        }
        $this->_params['items'] = $query->orderByDesc('id')->paginate(20);
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
            $icon_link             = $fileService->uploadFile($request->icon, 'ecommerce.category', auth()->id())['url'] ?? '';
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
    public function destroy($id)
    {
        $this->table->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
    }
}
