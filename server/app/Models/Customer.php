<?php

namespace App\Models;

use App\Mail\Hms\V1\Auth\ForgotPasswordMail;
use App\Models\Api\V1\Hms\HotelCustomerModel;
use App\Models\Api\V1\Hms\HotelModel;
use DB;
use Hash;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Facades\Cache;
use Mail;
use Spatie\Permission\Traits\HasRoles;
use Str;
use Tymon\JWTAuth\Contracts\JWTSubject;


class Customer extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = 'hms_customers';
    protected $guard_name = 'hms';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $casts = [
        'reset_code_expires_at'     => 'datetime',
        'last_reset_code_sent_at'   => 'datetime',
    ];
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'hotel_ids' => $this->hotels()->pluck(TABLE_HOTEL_HOTEL.'.id')
        ];
    }
    protected $fillable = [
        'code',
        'full_name',
        'username',
        'email',
        'password',
        'phone',
        'image',
        'status',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'get-item') {
            $result               = self::select('id','username','full_name','email','phone','created_at','image')
                                    ->where('id',$params['id'])->first();
        }
        if ($options['task'] == 'get-item-by-email') {
            $result               = self::select('id','username','full_name','email','phone','created_at','image')
                                    ->where('email',$params['email'])->first();
        }
        return $result;
    }
    public function getImageAttribute()
    {
        return $this->attributes['image'] ? URL_DATA_IMAGE.config('filesystems.disks.s3_hotel.bucket')."/customer/". $this->attributes['image'] : null;
    }
    public function saveItem($params = null, $options = null){
        if($options['task'] == 'forgot-password'){

            $item                  = self::where('email',$params['email'])->first();

            if(!$item){
                return [
                    'status'        => false,
                    'message'       => 'Email không tồn tại.'
                ];
            }

            if ($item->last_reset_code_sent_at && $item->last_reset_code_sent_at->gt(now()->subSeconds(60))) {
                return [
                    'status'        => false,
                    'message'       => 'Vui lòng chờ 60 giây trước khi gửi lại mã.'
                ];
            }

            $key    = 'reset_code_count:' . $item->email;
            $count  = Cache::get($key, 0);

            if ($count >= 5) {
                return [
                    'status'        => false,
                    'message'       => 'Bạn đã vượt quá số lần gửi mã trong 1 giờ'
                ];
            }

            Cache::put($key, $count + 1, now()->addHour());


            // $code = rand(1000, 9999);
            $code = 1234;

            $item->reset_code               = $code;
            $item->reset_code_expires_at    = now()->addMinutes(10);
            $item->last_reset_code_sent_at  = now();
            $item->save();


            $data                   = $item;
            // $data['url']            = config('app.fe_url.190hms').'/forgot-password/'.$code;
            $data['code']           = $code;

            try {
                // $mail               = new ForgotPasswordMail($data);
                // Mail::to($item['email'])->send($mail);

                return [
                    'status'        => true,
                    'message'       => 'Đã gửi yêu cầu lấy lại mật khẩu! Vui lòng kiểm tra email để tiếp tục.'
                ];

            } catch (\Throwable $th) {
                return [
                    'status'        => false,
                    'message'       => $th->getMessage()
                ];
            }

        }

        if($options['task'] == 'reset-password'){

            if (!Cache::get('reset_verified:' . $params['email'])) {
                return [
                    'status'        => false,
                    'message'       => 'Bạn chưa xác minh mã OTP'
                ];
            }

            $cutomer = Customer::where('email', $params['email'])->first();

            $cutomer->password                 = Hash::make($params['password']);
            $cutomer->reset_code               = null;
            $cutomer->reset_code_expires_at    = null;
            $cutomer->last_reset_code_sent_at  = null;
            $cutomer->save();

            // Xoá cờ cache sau khi reset xong
            Cache::forget('reset_verified:' . $cutomer->email);

            return [
                'status'        => true,
                'message'       => 'Đặt lại mật khẩu thành công.'
            ];

        }
    }
    public function verifyResetCode($params) {
        $email          = strtolower($params['email']);
        $attemptsKey    = 'otp_attempts:' . $email;
        $lockoutKey     = 'otp_locked:' . $email;

        // Nếu đang bị khóa
        if (Cache::has($lockoutKey)) {
            return [
                'status'    => false,
                'message'   => 'Bạn đã nhập sai quá nhiều lần. Vui lòng thử lại sau 15 phút.'
            ];
        }


        $cutomer = Customer::where('email', $params['email'])
                ->where('reset_code', $params['code'])
                ->where('reset_code_expires_at', '>=', now())
                ->first();

        if (!$cutomer) {

            $attempts       = Cache::increment($attemptsKey);

            if ($attempts >= 5) {

                Cache::put($lockoutKey, true, now()->addMinutes(15));
                Cache::forget($attemptsKey);

                return [
                    'status'    => false,
                    'message'   => 'Bạn đã nhập sai quá nhiều lần. Tài khoản tạm khóa xác minh trong 15 phút.'
                ];
            } else {

                Cache::put($attemptsKey, $attempts, now()->addMinutes(15));

                return [
                    'status'    => false,
                    'message'   => 'Mã không đúng hoặc đã hết hạn'
                ];
            }
        }

        // Nếu đúng thì:
        Cache::forget($attemptsKey);
        Cache::put('reset_verified:' . $email, true, now()->addMinutes(10));

        return [
            'status'    => true,
            'message'   => 'Xác thực thành công!'
        ];
    }
    public function hotels()
    {
        return $this->belongsToMany(HotelModel::class, TABLE_HOTEL_HOTEL_CUSTOMER, 'customer_id', 'hotel_id');
    }
}
