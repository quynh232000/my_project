<?php

namespace App\Services;
use Exception;
use Twilio\Rest\Client;
class SmsService
{
    protected $twilio;

    public function __construct()
    {
        $this->twilio = new Client(env('TWILIO_SID'), env('TWILIO_AUTH_TOKEN'));
    }
    function formatPhoneNumber($phoneNumber, $countryCode = '+84') {
        // Loại bỏ khoảng trắng, dấu gạch ngang, hoặc ký tự không phải số
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Nếu số bắt đầu bằng '0', thay thế bằng mã quốc gia
        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = $countryCode . substr($phoneNumber, 1);
        }

        return $phoneNumber;
    }
    public function sendOtp($phoneNumber, $otp)
    {
        try {
            $message = $this->twilio->messages->create(
                $this->formatPhoneNumber($phoneNumber),
                [
                    'from' => '',
                    'body' => "Your OTP code is: $otp"
                ]
            );
            return $message->sid;
        } catch (\Exception $e) {
            throw new \Exception("Failed to send SMS: " . $e->getMessage());
        }
    }
}
