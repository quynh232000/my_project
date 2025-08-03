<?php

namespace App\Http\Controllers\Api\V1\Hotel;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\Api\V1\Hotel\Hotel\FilterRequest;
use App\Http\Requests\Api\V1\Hotel\Hotel\ShowRequest;
use App\Models\Api\V1\Hms\LocationModel;
use App\Models\Api\V1\Hotel\HotelModel;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HotelController extends ApiController
{
    use ApiResponse;
    public $model;
    public function __construct(Request $request)
    {
        parent::__construct($request);
        $this->model             = new HotelModel();
    }
    public function index(Request $request)
    {
        $data = $this->model->listItem($this->_params, ['task' => 'list']);
        return $this->success('ok', $data);
    }
    public function search(Request $request)
    {
        try {
            $response = $this->model->listItem($this->_params, ['task' => 'search']);
            return $this->success('Ok from DB', $response);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function filter(FilterRequest $request)
    {
        try {

            $response           = $this->model->listItem($this->_params, ['task' => 'filter']);

            return $this->paginated('Lấy thông tin thành công!', $response->items(), 200, [
                'per_page'      => $response->perPage(),
                'current_page'  => $response->currentPage(),
                'total_page'    => $response->lastPage(),
                'total_item'    => $response->total(),
            ]);
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function show(Request $request, $hotel)
    {
        try {
            $response           = $this->model->getItem([...$this->_params, 'slug' => $hotel], ['task' => 'item-info']);

            return response(gzencode(json_encode([
                'status'    => true,
                'message'   => 'Lấy dữ liệu thành công',
                'data'      => $response
            ])))
                ->header('Content-Type', 'application/json')
                ->header('Content-Encoding', 'gzip');
        } catch (\Exception $e) {
            return $this->internalServerError('Đã xảy ra lỗi:' . $e->getMessage());
        }
    }
    public function clone(Request $req)
    {
        $payload = $req->all(); // kiểm tra xem là map hay có args bên trong

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->withBody(json_encode($payload), 'application/json')
            ->post('https://apiportal.ivivu.com/web_prot/ms01/api/SearchFilters/SearchHotelList');
        $list = $response->json()['data']['list'];

        // $response = Http::withHeaders([
        //     'User-Agent' => 'MyLaravelApp/1.0 (your-email@example.com)', // Bắt buộc!
        // ])->get('https://nominatim.openstreetmap.org/reverse', [
        //     'lat' => 11.9283941,
        //     'lon' => 108.4433296,
        //     'format' => 'json'
        //     // ,'accept-language' => 'vi'
        // ]);

        // $data = $response->json(); // đây mới là dữ liệu địa chỉ

        // $address = $data['address'] ?? [];
        // return $address;
        // // Lấy tỉnh, quận, phường
        // $province = $address['state'] ?? null;
        // $district = $address['county'] ?? $address['city'] ?? null;
        // $ward     = $address['suburb'] ?? $address['village'] ?? null;
        // return $province;
        foreach ($list as $item) {
            $hotel_id = HotelModel::insertGetId([
                'reviewMessage' => $item['reviewMessage'],
                'hotelId' => $item['hotelId'],
                'name' => $item['hotelName'],
                'slug' => $item['hotelCode'],
                'reviewCount' => $item['reviewCount'],
                'avg_price' => (int) preg_replace('/[^\d]/', '', $item['maxPrice'] ?? 0),
                'stars' => 5,
                'status' => 'active',
                'accommodation_id' => 62,
                'chain_id' => 3,
                'created_by' =>  5,
                'image' => isset($item['avatar']) && str_starts_with($item['avatar'], 'http')
                    ? $item['avatar']
                    : 'https:' . ($item['avatar'] ?? '')
            ]);

            LocationModel::insert([
                'hotel_id' => $hotel_id,
                'longitude' => $item['lon'],
                'latitude' => $item['lat'],
                'address' => $item['address'],
                'country_id' => 245,
                'country_slug' => 'viet-nam',
                'country_name' => 'Việt Nam',
                'province_id' => 28,
                'province_slug' => 'thanh-pho-ho-chi-minh',
                'province_name' => 'Thành phố Hồ Chí Minh',
                'ward_id' => 2738,
                'ward_slug' => 'phuong-an-lac',
                'ward_name' => 'Phường An Lạc',
            ]);
        }

        return $response->json(); // hoặc return $response->body();
    }
}
