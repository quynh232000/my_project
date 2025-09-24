<?php

namespace App\Http\Controllers\Api\V1\Ecommerce\Shop;

use App\Events\Api\V1\Ecommerce\LiveChat;
use App\Http\Controllers\Controller;
use App\Models\Api\V1\Ecommerce\LiveChatModel;
use App\Models\Api\V1\Ecommerce\LivestreamModel;
use App\Services\FileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator as FacadesValidator;
use Log;
use Str;

class LiveStreamController extends Controller
{
    public function index(Request $request)
    {
        try {
            $live = LivestreamModel::where(['user_id' => auth('ecommerce')->id(), 'status' => 'scheduled'])->first();


            $query = LivestreamModel::where(['user_id' => auth('ecommerce')->id()])
                ->where('status', '!=', 'scheduled');

            if ($request->search) {
                $query->where('name', 'LIKE', "%{$request->search}%");
            }
            if ($request->sort) {
                $query->orderBy('created_at', $request->sort == 'desc' ? 'desc' : 'asc');
            } else {
                $query->orderByDesc('created_at');
            }

            $data = $query->paginate(20);

            if ($live) {
                $live->key = $live->name . "?key=" . $live->key;
                $live->server = config('app.rmtp_server_url');
            }

            return $this->successResponsePagination('Thành công', ['live' => $live, 'items' => $data->items()], $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }

    }
    public function current(Request $request)
    {
        try {
            $data = LivestreamModel::where(['user_id' => auth('ecommerce')->id(), 'status' => 'scheduled'])->orderByDesc('created_at')->paginate(20);
            return $this->successResponsePagination('Thành công', $data->items(), $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }

    }
    public function create(Request $request)
    {
        try {
            $validate = FacadesValidator::make($request->all(), [
                'title' => "required",
                'thumbnail_url' => "required",
                'description' => "required",
            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Sai dữ liệu', $validate->errors());
            }
            //  check live not live
            $live = LivestreamModel::where(['user_id' => auth('ecommerce')->id(), 'status' => 'scheduled'])->exists();
            if ($live) {
                return $this->errorResponse('Bạn đã có live nhưng chưa live, Vui lòng live trước đã tạo');
            }
            $fileService = new FileService();
            $url = $fileService->uploadFile($request->file('thumbnail_url'), 'livestream_thumb', auth('ecommerce')->id())['url'];

            $data = LivestreamModel::create([
                'title' => $request->title,
                'description' => $request->title,
                'user_id' => auth('ecommerce')->id(),
                'status' => 'scheduled',
                'thumbnail_url' => $url,
                'key' => Str::uuid(),
                'name' => time()
            ]);

            return $this->successResponsePagination('Tạo yêu cầu thành công', $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }

    }
    public function verify(Request $request)
    {
        try {
            // Log::info(123,$request->all());
            $data = LivestreamModel::where(['name' => $request->name, 'key' => $request->key])->first();
            if (!$data) {
                return response()->json('Stream Key không tồn tại!', 403);
            }

            $call = $request->call;
            if ($call == 'publish' && $data->status == 'ended') {
                return response()->json('Stream Key đã kết thúc', 403);
            } else if ($call == 'done' && $data->status != 'live') {
                return response()->json('Stream Key chưa live hoặc đã kết thúc bạn không thể tắt', 403);
            }
            $data->status = $call == 'publish' ? 'live' : 'ended';
            event(new LiveChat($data->id, null, null, $data->status));

            $data->updated_at = Carbon::now();
            $data->save();
            return response()->json('Success', 200);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function detail($name)
    {
        try {
            if (!$name) {
                return $this->errorResponse('Chuyền name');
            }
            $data = LivestreamModel::where(['name' => $name, 'status' => 'live'])->with('user.shop')->first();
            if (!$data) {
                return $this->errorResponse('Đoạn live đã kết thúc');
            }
            $data->addView();
            if ($data->status == 'live') {
                event(new LiveChat($data->id, null, 1));
            }
            $data['video_url'] = config('app.video_server_url') . '/' . $data->name . '.m3u8';
            $data->user->shop->follow_count = $data->user->shop->follow_count();
            $data->messages = LiveChatModel::where(['livestream_id' => $data->id])->with('user')->orderBy('created_at', 'asc')->limit(50)->get();

            $data->currentProduct = $data->currentProduct();

            return $this->successResponse('Success', $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function sendChat(Request $request)
    {
        try {
            $validate = Validator($request->all(), [
                'message' => "required|string",
                'livestream_id' => "required",
            ]);
            if ($validate->fails()) {
                return $this->errorResponse('Lỗi ', $validate->errors());
            }
            $data = LiveChatModel::create([
                'user_id' => auth('ecommerce')->id(),
                'livestream_id' => $request->livestream_id,
                'message' => $request->message,
            ]);
            $data = $data->load('user');

            event(new LiveChat($request->livestream_id, $data));

            return $this->successResponse('Success', $data);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
    public function history($name)
    {
        try {
            if (!$name) {
                return $this->errorResponse('Chuyền name');
            }
            $live = LivestreamModel::where(['name' => $name, 'user_id' => auth('ecommerce')->id()])
                ->with([
                    'messages.user',
                    'products.product',
                    'products'=>function($q){
                        $q->withCount('cart_products');
                    }
                ])
                ->first();
            if (!$live) {
                return $this->errorResponse('Đoạn live không tồn tại');
            }
            $live->orders = $live->orders();

            return $this->successResponse('Success', $live);
        } catch (\Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }
}
