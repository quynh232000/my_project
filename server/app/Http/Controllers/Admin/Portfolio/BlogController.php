<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\AdminController;
use App\Models\Admin\UserModel;
use App\Models\Portfolio\BlogModel;
use App\Models\Portfolio\CategoryModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class BlogController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new BlogModel();
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
        // dd($data);
        $avatar_link                 = $request->avatar_link ?? '';
        $fileService                 = new FileService();
        if ($request->hasFile('image')) {
            $avatar_link             = $fileService->uploadFile($request->image, 'portfolio.blog', auth()->id())['url'] ?? '';
        }


         unset($data['image_link'],$data['avatar_remove']);

        $item->update([
            ...$data,
            'slug' => Str::slug($data['title']),
            'image'            => $avatar_link,
            'cv'                => $cv_url,
            'updated_at'        => now()

        ]);
        return redirect()->back()->with('success', ' Update successfully!');
    }
    public function edit(Request $request, $id)
    {
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        $this->_params['item']  = $this->table->find($id);
        if ($request->email ?? false) {
            $this->_params['categories'] = CategoryModel::where('email', $request->email)->orderByDesc('id')->get();
        } else {
            $this->_params['categories'] = CategoryModel::where('email', $this->_params['item']->email)->orderByDesc('id')->get();
        }
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function create(Request $request)
    {
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $data                       = $request->all();
        $image_link                 = $request->image_link ?? '';
        $fileService                = new FileService();
        if ($request->hasFile('image')) {
            $image_link             = $fileService->uploadFile($request->image, 'portfolio.blog', auth()->id())['url'] ?? '';
        }
        unset($data['image_link'],$data['avatar_remove']);

        $this->table->create([
            ...$data,
            'slug' => Str::slug($data['title']),
            'image'         => $image_link,
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
