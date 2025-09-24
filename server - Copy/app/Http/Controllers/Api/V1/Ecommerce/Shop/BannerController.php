<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\BannerModel;
use App\Services\FileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BannerController extends Controller
{
    public function banner_index(Request $req)
    {
        try {
            $page = $req->page ?? 1;

            $limit = $req->limit ?? 20;

            $query = BannerModel::where(['user_id' => auth('ecommerce')->id(), 'from'=>'shop']);

            if ($req->search) {
                $query->where('title', 'like', '%' . $req->search . '%');
            }

            if ($req->where) {
                $query->where('placement', 'like', '%' . $req->where . '%');
            }

            if ($req->type) {
                $query->where('placement', 'like', '%' . $req->type . '%');
            }

            if ($req->priority) {
                // return Carbon::now();
                switch (mb_strtolower($req->priority)) {
                    case 'desc':
                        $query->orderBy('priority', 'desc');
                        break;

                    case 'asc':
                        $query->orderBy('priority', 'asc');
                        break;
                }
            }
            if ($req->sort) {
                switch (mb_strtolower($req->sort)) {
                    case 'latest':
                        $query->orderBy('created_at', 'desc');
                        break;

                    case 'oldest':
                        $query->orderBy('created_at', 'asc');
                        break;
                }
            }
            $data = $query->paginate($limit, ['*'], 'page', $page);

            return $this->successResponsePagination('Lấy danh sách banners thành công', $data->items(), $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function banner_get($id)
    {
        try {

            $banner = BannerModel::where(['user_id' => auth('ecommerce')->id(), 'is_show' => true])->find($id);

            if (!$banner) {
                return $this->errorResponse( 'Banner không tồn tại');
            }

            return $this->successResponse('success', $banner);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function banner_create(Request $req)
    {
        try {

            $validator = Validator::make($req->all(), [
                'title' => 'required|min:10',
                'description' => 'required|min:10',
                'alt' => 'required|min:10',
                'placement' => 'required|string',
                'link_to' => 'required',
                'banner_url' => 'required|image',
                'type' => 'required|string',
                'expired_at' => 'required',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse('Vui lòng nhập đầy đủ thông tin!', $validator->errors());
            }

            // if (BannerModel::where('title', trim($req->title))->first()) {
            //     return $this->errorResponse( 'Banner với tên này đã tồn tại. Vui lòng sử dụng tên khác.');
            // }

            if (strtotime($req->expired_at) < time()) {
                return $this->errorResponse( 'Ngày hết hạn banner không hợp lệ');
            }

            // if (isset($req->link_to) && !empty($req->link_to)) {
            //     $domain_regex = "/(mr-quynh.com)/";

            //     if (!preg_match($domain_regex, $req->link_to)) {
            //         return $this->errorResponse( 'Vui lòng dẫn đến domain mr-quynh.com.');
            //     }
            // }

            $fileService = new FileService();

            $banner_url = $fileService->uploadFile($req->file('banner_url'), 'shop', auth('ecommerce')->id())['url'];

            $banner = BannerModel::create([
                'title' => trim($req->title),
                'description' => trim($req->description),
                'alt' => trim($req->alt),
                'from' => 'shop',
                'user_id' => auth('ecommerce')->id(),
                'placement' => $req->placement,
                'link_to' => $req->link_to,
                'banner_url' => $banner_url,
                'type' => $req->type,
                'expired_at' => $req->expired_at,
            ]);

            return $this->successResponse('Tạo banner thành công.', $banner);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function banner_update(Request $req, $id)
    {
        try {

            $banner = BannerModel::where(['user_id' => auth('ecommerce')->id(), 'is_show' => true])->find($id);

            if (!$banner) {
                return $this->errorResponse( 'Banner không tồn tại');
            }

            $validator = Validator::make($req->all(), [
                'title' => 'min:10',
                'description' => 'min:10',
                'alt' => 'min:10',
                'placement' => 'string',
                'banner_url' => 'image',
                'type' => 'string',
            ]);

            if ($validator->fails()) {
                return $this->errorResponse(false, $validator->errors());
            }

            if ($req->title && BannerModel::where('user_id', auth('ecommerce')->id())->where('title', trim($req->title))->first()) {
                return $this->errorResponse( 'Banner với tên này đã tồn tại. Vui lòng sử dụng tên khác.');
            } else {
                $banner->title = trim($req->title);
            }

            if ($req->expired_at && strtotime($req->expired_at) < time()) {
                return $this->errorResponse( 'Ngày hết hạn banner không hợp lệ');
            } else {
                $banner->expired_at = $req->expired_at;
            }

            if (isset($req->link_to) && !empty($req->link_to)) {
                $domain_regex = "/(mr-quynh.com)/";

                if (!preg_match($domain_regex, $req->link_to)) {
                    return $this->errorResponse( 'Vui lòng dẫn đến domain mr-quynh.com.');
                } else {
                    $banner->link_to = $req->link_to;
                }
            }

            if ($req->file('banner_url')) {

                $fileService = new FileService();

                $banner_url = $fileService->uploadFile($req->file('banner_url'), 'shop', auth('ecommerce')->id())['url'];

                $banner->banner_url = $banner_url;
            }
            if (isset($req->description) && !empty($req->description)) {
                $banner->description = trim($req->description);
            }

            if (isset($req->placement) && !empty($req->placement)) {
                $banner->placement = trim($req->placement);
            }

            if (isset($req->alt) && !empty($req->alt)) {
                $banner->alt = trim($req->alt);
            }

            $banner->updated_at = Carbon::now();


            $banner->save();

            return $this->successResponse('Cập nhật banner thành công.', $banner);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function banner_delete($id)
    {
        try {
            $banner = BannerModel::where(['user_id' => auth('ecommerce')->id()])->find($id);

            // return $banner;

            if (!$banner) {
                return $this->errorResponse( 'Banner không tồn tại');
            }

            $banner->is_show = false;

            $banner->save();

            return $this->successResponse('Xóa banner thành công.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }


    public function banner_restore($id)
    {
        try {

            $banner = BannerModel::where(['user_id' => auth('ecommerce')->id(), 'is_show' => true])->where('id', $id)->first();

            if ($banner) {
                return $this->errorResponse( 'Không thể khôi phục banner đang hoạt động.');
            }

            $banner_deleted = BannerModel::where(['user_id' => auth('ecommerce')->id(), 'is_show' => false])->where('id', $id)->first();

            if (!$banner_deleted) {
                return $this->errorResponse( 'Banner không tồn tại trong thùng rác.');
            }

            $banner_deleted->is_show = true;

            $banner_deleted->save();

            return $this->successResponse('Khôi phục banner thành công.');
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
