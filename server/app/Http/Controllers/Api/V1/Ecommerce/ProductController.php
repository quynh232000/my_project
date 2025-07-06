<?php

namespace App\Http\Controllers\Api\V1\Ecommerce;

use App\Http\Controllers\ApiController;
use App\Models\Api\V1\Ecommerce\CategoryModel;
use App\Models\Api\V1\Ecommerce\ContactModel;
use App\Models\Api\V1\Ecommerce\ProductModel;
use App\Models\Api\V1\Ecommerce\ShopModel;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ProductController extends ApiController
{
    private $table;
    public function __construct(Request $request)
    {
        $this->table = new ProductModel();
        parent::__construct($request);
    }
    public function index(Request $request){
        try {
            $result = $this->table->listItem($this->_params,['task' => 'list']);
            return $this->successResponsePagination('Lấy danh sách sản phẩm thành công!', $result->items(), $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
    public function filter(Request $request){
        try {
            $result = $this->table->listItem($this->_params,['task' => 'filter']);
            if(!$result) return $this->error('Thông tin không hợp lệ');
            return $this->successResponsePagination('Lấy danh thành công!', $result[0], $result[1]);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
    public function show(Request $request,$slug){
        try {
            $result = $this->table->getItem([...$this->_params,'slug' => $slug],['task' => 'info']);
            if(!$result) return $this->error('Thông tin không hợp lệ');
            return $this->success('Ok', $result);
        } catch (\Exception $e) {
            return $this->errorInvalidate('Đã có lỗi xảy ra: ', $e->getMessage());
        }
    }
     public function search(Request $request){
        try {
            $limit_product      = $request->limit_product ?? 10;
            $limit_category     = $request->limit_category ?? 5;
            $limit_shop         = $request->limit_shop ?? 5;
            $key                = $request->q ?? '';
            if(!empty($key)){
                $products   = ProductModel::select('name','slug')->where('name','LIKE','%' . $key.'%')->limit($limit_product)->get()
                                ->makeHidden(['product_loves_count','product_reviews_count','shop_replies_count']);
                $categories = CategoryModel::select('name','slug')->where('name','LIKE','%' . $key.'%')->limit($limit_category)->get();
                $shops      = ShopModel::select('name','slug')->where('name','LIKE','%' . $key.'%')->limit($limit_shop)->get();
            }


            return $this->successResponse('ok',[
                'products'      => $products ??[],
                'categories'    => $categories??[],
                'shops'         => $shops??[],
            ]);

        } catch (Exception $e) {
            return $this->errorResponse('ĐÃ có lỗi xảy ra: ' . $e->getMessage(), 500);
        }
    }
    public function contact(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'name'    => 'required',
                'email'   => 'required|email',
                'phone'   => 'required|numeric',
                'title'   => 'required',
                'message' => 'required',
            ], [
                'name.required'     => 'Vui lòng nhập tên đầy đủ',
                'email.required'    => 'Vui lòng nhập email',
                'email.email'       => 'Email không đúng định dạng',
                'phone.required'    => 'Vui lòng nhập số điện thoại',
                'title.required'    => 'Vui lòng nhập tiêu đề',
                'message.required'  => 'Vui lòng nhập nội dung',
            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Thông tin không hợp lệ', $validate->errors(), 400);
            }
            // Send email here
            $contact = ContactModel::create($request->all());
            $contact['email_admin'] = config('app.info.email');

            Mail::send('email.contact', ['data' => $contact], function ($message) use ($contact) {
                $message->to($contact['email_admin'])->subject("[Liên hệ - ".(config('app.name'))."]: ".$contact['title']);
            });
            return $this->successResponse('Gửi liên hệ thành công');
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
