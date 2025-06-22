<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\AdminController;
use App\Models\Admin\UserModel;
use App\Models\Portfolio\CategoryModel;
use App\Models\Portfolio\IconModel;
use App\Models\Portfolio\ProjectModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProjectController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new ProjectModel();
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
        $image_url              = $request->image_link ?? '';
        if ($request->hasFile('image')) {
            $fileService        = new FileService();
            $image_url          = $fileService->uploadFile($request->image, 'portfolio.project', auth()->id())['url'] ?? '';
        }
        unset($data['image_link'], $data['avatar_remove'], $data['image']);

        $item->update([
            ...$data,
            'slug'          => Str::slug($request->title),
            'thumbnail'     => $image_url,
            'updated_at'    => now()

        ]);
        return redirect()->back()->with('success', ' Update successfully!');
    }
    public function edit(Request $request, $id)
    {
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        $this->_params['item']  = $this->table->find($id);
        $this->_params['categories'] = IconModel::orderByDesc('id')->get();

        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create(Request $request)
    {

        $this->_params['categories'] = IconModel::orderByDesc('id')->get();
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $data = $request->all();
        $image_url              = $request->image_link ?? '';
        if ($request->hasFile('image')) {
            $fileService        = new FileService();
            $image_url          = $fileService->uploadFile($request->image, 'portfolio.project', auth()->id())['url'] ?? '';
        }
        unset($data['image_link'], $data['avatar_remove'], $data['image']);

        $this->table->create([
            ...$data,
            'thumbnail'         => $image_url,
            'slug'          => Str::slug($request->title),
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
