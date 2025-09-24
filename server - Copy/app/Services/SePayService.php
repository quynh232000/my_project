<?php

namespace App\Services;
use Exception;
use Illuminate\Support\Facades\Http;

class SePayService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.sepay.url');
        $this->token = config('services.sepay.api_key');
    }
    public function get_data($url, $params = [])
    {
        return Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->token,
            'Content-Type' => 'application/json'
        ])->get($this->baseUrl . $url, $params);
    }
    public function fetch_transactions()
    {
        try {
            $response = $this->get_data('/transactions/list');
            if ($response->successful()) {
                $data = $response->json()['transactions'];
                return [
                    'status' => true,
                    'data' => $data,
                    'message' => 'Data fetched successfully',
                ];
            } else {
                return [
                    'status' => false,
                    'message' => $response->body()
                ];
            }
        } catch (Exception $e) {
            return [
                'status' => false,
                'message' => $e->getMessage(),
            ];
        }
    }


}
