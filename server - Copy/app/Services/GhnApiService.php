<?php

namespace App\Services;

use App\Jobs\GetWardData;
use App\Models\District;
use App\Models\Province;
use App\Models\Ward;
use Illuminate\Support\Facades\Http;

class GhnApiService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.ghn.base_url');
        $this->token = config('services.ghn.token');
    }
    public function get_data($url, $params = [])
    {
        return Http::withHeaders([
            'token' => $this->token,
            'Content-Type' => 'application/json'
        ])->get($this->baseUrl . $url, $params);
    }
    public function post_data($url, $data)
    {
        return Http::withHeaders([
            'token' => $this->token,
            'Content-Type' => 'application/json'
        ])->post($this->baseUrl . $url, $data);
    }

    public function get_province()
    {
        $response = $this->get_data('/master-data/province');
        if ($response->successful()) {
            $data = $response->json()['data'];
            $data_arr = [];
            foreach ($data as $key => $value) {
                $data_arr[] = [
                    'id' => $value['ProvinceID'],
                    'name' => $value['ProvinceName'],
                    'code' => $value['Code'],
                    'name_extention' => json_encode($value['NameExtension']),
                ];
            }
            Province::insert($data_arr);
            return [
                'status' => true,
                'data' => $data_arr,
                'total' => count($data_arr),
            ];
        } else {
            return [
                'error' => 'Failed to fetch data',
                'status' => false,
                'message' => $response->body()
            ];
        }
    }
    public function get_district()
    {
        $response = $this->get_data('/master-data/district');
        if ($response->successful()) {
            $data = $response->json()['data'];
            $data_arr = [];
            foreach ($data as $key => $value) {
                $data_arr[] = [
                    'id' => $value['DistrictID'],
                    'name' => $value['DistrictName'],
                    'code' => $value['Code'] ?? '',
                    'name_extention' => isset($value['NameExtension']) ? json_encode($value['NameExtension']) : json_encode([]),
                    'province_id' => $value['ProvinceID'],
                ];
            }
            District::insert($data_arr);
            return [
                'status' => true,
                'data' => $data_arr,
                'total' => count($data_arr),
            ];
        } else {
            return [
                'error' => 'Failed to fetch data',
                'status' => false,
                'message' => $response->body()
            ];
        }
    }
    public function get_ward()
    {

        District::pluck('id')->each(function ($district_id) {
            GetWardData::dispatch($district_id);
        });
        return [
            'status' => true,
            'message' => 'Get data ward success',
        ];


    }


}
