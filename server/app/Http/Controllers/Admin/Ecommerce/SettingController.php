<?php

namespace App\Http\Controllers\Admin\Ecommerce;

use App\Http\Controllers\AdminController;
use App\Models\Ecommerce\PaymentMethodModel;
use App\Models\Ecommerce\SettingModel;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
class SettingController extends AdminController
{
    private $table = null;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->table = new SettingModel();
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


        $item->update([
            ...$data,
            'updated_at'            => now()

        ]);
        return redirect()->back()->with('success', ' Update successfully!');
    }
    public function edit(Request $request, $id)
    {

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
        $this->table->create([
            ...$data,
            'created_at'        => now(),
            'created_by'        => auth()->id()
        ]);


        return redirect()->back()->with('success', 'Create successfully.');
    }
    public function destroy($id)
    {
        $this->table->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Delete route successfully.');
    }
}
