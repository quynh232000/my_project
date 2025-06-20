<?php

namespace App\Http\Controllers\Admin\Portfolio;

use App\Http\Controllers\AdminController;
use App\Models\Admin\UserModel;
use App\Models\Portfolio\CategoryModel;
use App\Models\Portfolio\DataInfoModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DataInfoController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new DataInfoModel();
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
        $avatar_url                 = $request->avatar_link ?? '';
        $fileService                = new FileService();
        if ($request->hasFile('avatar')) {
            $avatar_url             = $fileService->uploadFile($request->avatar, 'portfolio.data-info.avatar', auth()->id())['url'] ?? '';
        }

        $img_background_url         = $request->img_background_link ?? '';
        if ($request->hasFile('img_background')) {
            $img_background_url     = $fileService->uploadFile($request->img_background, 'portfolio.data-info.background', auth()->id())['url'] ?? '';
        }
        $cv_url                     = $request->cv_link ?? '';
        if ($request->hasFile('cv')) {
            $cv_url                 = $fileService->uploadFile($request->cv, 'portfolio.data-info.cv', auth()->id())['url'] ?? '';
        }



        unset($data['avatar_link'], $data['avatar_remove'], $data['avatar'], $data['img_background_link'], $data['cv_link']);

        $item->update([
            ...$data,
            'avatar'            => $avatar_url,
            'img_background'    => $img_background_url,
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

        if ($request->email ?? false) {
            $this->_params['categories'] = CategoryModel::where('email', $request->email)->orderByDesc('id')->get();
        }
        $this->_params['users'] = UserModel::orderByDesc('id')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(Request $request)
    {
        $data                       = $request->all();
        $avatar_url                 = $request->avatar_link ?? '';
        $fileService                = new FileService();
        if ($request->hasFile('avatar')) {
            $avatar_url             = $fileService->uploadFile($request->avatar, 'portfolio.data-info.avatar', auth()->id())['url'] ?? '';
        }

        $img_background_url         = $request->img_background_link ?? '';
        if ($request->hasFile('img_background')) {
            $img_background_url     = $fileService->uploadFile($request->img_background, 'portfolio.data-info.background', auth()->id())['url'] ?? '';
        }
        $cv_url         = $request->cv_link ?? '';
        if ($request->hasFile('cv')) {
            $cv_url     = $fileService->uploadFile($request->cv, 'portfolio.data-info.cv', auth()->id())['url'] ?? '';
        }




        unset($data['avatar_link'], $data['avatar_remove'], $data['avatar'], $data['img_background_link'], $data['cv_link']);

        $this->table->create([
            ...$data,
            'avatar'         => $avatar_url,
            'img_background' => $img_background_url,
            'cv'            => $cv_url,
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
