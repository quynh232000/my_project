<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\AdminController;
use App\Models\Admin\UserModel;
use App\Models\Portfolio\CategoryModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new CategoryModel();
    }
    public function index()
    {
        $query = $this->table->with('creator');
        if(request()->search ?? false){
            $query->where('name','LIKE','%'.request()->search.'%');
        }
        $this->_params['items'] = $query->orderByDesc('id')->paginate(20);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function update(Request $request, $id)
    {
        $item = $this->table->find($id);
        $icon_url           = $request->icon_link ?? $item->icon;
        if($request->hasFile('icon')){
            $fileService    = new FileService();
            $icon_url       = $fileService->uploadFile($request->icon,'portfolio.category',auth()->id())['url'] ?? '';
        }

        $item->update([
                                'email'         => $request->email,
                                'name'          => $request->name,
                                'slug'          => Str::slug($request->name),
                                'icon'          => $icon_url,

                            ]);
        return redirect()->back()->with('success', ' Update successfully!');
    }
    public function edit($id)
    {
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        $this->_params['item']  = $this->table->find($id);
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create()
    {
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $icon_url           = $request->icon_link ?? '';
        if($request->hasFile('icon')){
            $fileService    = new FileService();
            $icon_url       = $fileService->uploadFile($request->icon,'portfolio.category',auth()->id())['url'] ?? '';
        }

        $this->table->create([
                                'email'         => $request->email,
                                'name'          => $request->name,
                                'slug'          => Str::slug($request->name),
                                'icon'          => $icon_url,
                                'created_at'    => now(),
                                'created_by'    => auth()->id(),
                                'status'        => 'active'
                            ]);


        return redirect()->back()->with('success', 'Create successfully.');
    }
    public function destroy($id)
    {
        $this->table->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
    }
}
