<?php

namespace App\Http\Controllers\Admin\Travel;

use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\Ecommerce\ShopRequest;
use App\Http\Requests\Travel\TourRequest;
use App\Models\Admin\CountryModel;
use App\Models\Admin\ProvinceModel;
use App\Models\Api\V1\Travel\ProcessTour;
use App\Models\Travel\TourModel;
use App\Services\FileService;
use App\Traits\ApiRes;
use Exception;
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
    public function show($id)
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
        $this->_params['provinces'] = ProvinceModel::select('id', 'name')->where('status', 'active')->orderBy('name', 'asc')->get();
        $this->_params['countries'] = CountryModel::select('id', 'name')->where('status', 'active')->orderBy('name', 'asc')->get();
        return view($this->_viewAction, ['params' => $this->_params]);
    }
    public function store(TourRequest $request)
    {

        try {
            $images = [];
            if ($request->hasFile('images')) {

                foreach ($request->images as $image) {
                    $images[]   = FileService::file_upload($this->_params, $image, 'image');
                }
            }
            $thumnail           = "";
            if ($request->hasFile('thumnail')) {
                $thumnail       =  FileService::file_upload($this->_params, $request->thumnail, 'thumnail');
            }

            $tour = TourModel::create([
                'uuid' => Str::uuid(),
                'slug' => $request->title,
                'title' => $request->title,
                'thumnail' => $thumnail,
                'country_id' => $request->country_id ?? 232,
                'images' => json_encode($images),
                'type' => $request->type,
                'category' => $request->category,
                'price' => $request->price,
                'price_child' => $request->price_child,
                'price_baby' => $request->price_baby,
                'percent_sale' => $request->percent_sale,
                'additional_fee' => $request->additional_fee,
                "province_start_id" => $request->province_start_id,
                "province_end_id" => $request->province_end_id,
                'number_of_day' => $request->number_of_day,
                'tour_pakage' => $request->tour_pakage,
                'quantity' => $request->quantity,
                'date_start' => $request->date_start,
                'time_start' => $request->time_start,
                'transportation' => $request->transportation,
                'tourguide_id' => auth('hms')->user()->id,
            ]);
            $tour->slug = Str::slug($request->title) . '_' . $tour->id;
            $tour->save();
            // create process tour

            $processTours = [];
            if ($request->has(['date', 'title_process', 'content'])) {
                if (count($request->date) != count($request->title_process) || count($request->date) != count($request->content)) {
                    return $this->error('Missing parameters of precess detail');
                }
                foreach ($request->date as $key => $value) {
                    $processTours[] = ProcessTour::create([
                        'product_id' => $tour->id,
                        'date' => $value,
                        'title' => $request->title_process[$key],
                        'content' => $request->input('content')[$key]
                    ]);
                }
            }
            $tour['process_tour'] = $processTours;

            return response()->json(array('success' => true, 'message' => 'Thêm thành công'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
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
