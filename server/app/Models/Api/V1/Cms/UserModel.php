<?php

namespace App\Models\Api\V1\Cms;

use App\Services\FileService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Illuminate\Support\Str;
use Tymon\JWTAuth\Contracts\JWTSubject;
// use Hash;

class UserModel extends Authenticatable implements JWTSubject
{
    use Notifiable;

    protected $table = TABLE_CMS_USER;
    protected $guard_name = 'cms';
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
            // 'hotel_ids' => $this->hotels()->pluck(TABLE_HOTEL_HOTEL . '.id')
        ];
    }
    // protected $fillable = [
    //     'code',
    //     'full_name',
    //     'username',
    //     'email',
    //     'password',
    //     'phone',
    //     'image',
    //     'status',
    //     'created_at',
    //     'updated_at',
    //     'created_by',
    //     'updated_by'
    // ];
    protected $guarded  = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        "failed_attempts",
        'organization_id',
        "uuid"
    ];

    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'detail') {
            $result               = self::select('*')
            ->with('roles:id,name','permissions:id,name')
                ->where('id', $params['id'])->first();
        }
        if ($options['task'] == 'get-item-by-email') {
            $result               = self::select('id', 'username', 'full_name', 'email', 'phone', 'created_at', 'image')
                ->where('email', $params['email'])->first();
        }
        return $result;
    }

    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'forgot-password') {

            $item                  = self::where('email', $params['email'])->first();

            if (!$item) {
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

        if ($options['task'] == 'reset-password') {

            if (!Cache::get('reset_verified:' . $params['email'])) {
                return [
                    'status'        => false,
                    'message'       => 'Bạn chưa xác minh mã OTP'
                ];
            }

            $cutomer = self::where('email', $params['email'])->first();

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
        if($options['task'] == 'add-item'){
            $list_avatars       = [
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436188.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-bald-person-with-glasses_23-2149436184.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-glasses_23-2149436191.jpg',
                'https://img.freepik.com/free-psd/3d-illustration-person-with-sunglasses_23-2149436178.jpg'
            ];
            $avatar             = $list_avatars[rand(0, count($list_avatars) - 1)];
            if (request()->hasFile('avatar')) {
                $avatar         = FileService::file_upload($params,$params['avatar'],'avatar') ?? '';
            }
            $user = UserModel::create([
                'uuid'          => Str::uuid(),
                'full_name'     => $params['full_name'],
                'phone'         => $params['phone'] ?? '',
                'username'      => explode('@', $params['email'])[0],
                'email'         => $params['email'],
                'password'      => Hash::make($params['password']),
                'avatar'        => $avatar
            ]);

            if ($params['role_ids'] ?? false) {
                $dataRoleInsert         = [];
                foreach ($params['role_ids'] as $role_id) {
                    $dataRoleInsert[]   = [
                        'user_id'   => $user->id,
                        'role_id'   => $role_id
                    ];
                }
                UserRoleModel::insert($dataRoleInsert);
            }
            if ($params['permission_ids'] ?? false) {
                $dataPermissionInsert         = [];
                foreach ($params['permission_ids'] as $permission_id) {
                    $dataPermissionInsert[]   = [
                        'user_id'           => $user->id,
                        'permission_id'     => $permission_id
                    ];
                }
                UserPermissionModel::insert($dataPermissionInsert);
            }
            return $user;

        }

        if($options['task'] == 'edit-item'){
            $user = self::findOrFail((int)$params['id']);
            $avatar             = $user->avatar;
            if (request()->hasFile('avatar')) {
                $avatar         = FileService::file_upload($params,$params['avatar'],'avatar') ?? '';
            }
            // Cập nhật thông tin người dùng
            $user->update([
                'full_name' => $params['full_name'],
                'username'  => explode('@', $params['email'])[0],
                'email'     => $params['email'],
                'phone'     => $params['phone'] ?? '',
                'avatar'    => $avatar ?? $user->avatar, // giữ lại avatar nếu không thay đổi
            ]);

            if (!empty($params['password'])) {
                $user->update([
                    'password' => Hash::make($params['password']),
                ]);
            }

            // Cập nhật vai trò
            if ($params['role'] ?? false) {
                // Xoá role cũ
                UserRoleModel::where('user_id', $user->id)->delete();

                // Thêm role mới
                $dataRoleInsert = [];
                foreach ($params['role'] as $role_id) {
                    $dataRoleInsert[] = [
                        'user_id' => $user->id,
                        'role_id' => $role_id,
                    ];
                }
                UserRoleModel::insert($dataRoleInsert);
            }

            // Cập nhật quyền
            if ($request->permission ?? false) {
                // Xoá permission cũ
                UserPermissionModel::where('user_id', $user->id)->delete();

                // Thêm permission mới
                $dataPermissionInsert = [];
                foreach ($params['permission'] as $permission_id) {
                    $dataPermissionInsert[] = [
                        'user_id'       => $user->id,
                        'permission_id' => $permission_id,
                    ];
                }
                UserPermissionModel::insert($dataPermissionInsert);
            }
            return $user;
        }
    }
    public function verifyResetCode($params)
    {
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


        $cutomer = self::where('email', $params['email'])
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
    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {
            $results = self::select('*')->with('roles:id,name','permissions:id,name')
                ->orderBy('created_at', 'desc')
                ->paginate($params['limit'] ?? 20);
            return $results;
        }
        return $results;
    }
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, UserRoleModel::class, 'user_id', 'role_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, UserPermissionModel::class, 'user_id', 'permission_id');
    }
    public function hasPermission($route_name, $method)
    {
        // $method                 = strtoupper($method);
        // // role ngoại lệ============================================
        // $excludedRoles          = config('constants.index.role_excluded');

        // if (
        //     $this->roles()->where(function ($q) use ($excludedRoles) {
        //         foreach ($excludedRoles as $role) {
        //             $q->orWhereRaw('LOWER(name) = ?', [strtolower($role)]);
        //         }
        //     })->exists()
        // ) {
        //     return true;
        // }
        // // permission ngoại lệ======================================
        // $excludedPermissions    = config('constants.index.permission_excluded');

        // foreach ($excludedPermissions as $exception) {
        //     if (
        //         $exception['route_name'] === $route_name &&
        //         str_contains($exception['method'], $method)
        //     ) {
        //         return true;
        //     }
        // }

        // // 1. Kiểm tra quyền gán trực tiếp==========================
        // $direct     = $this->permissions()
        //     ->where('route_name', $route_name)
        //     ->where(function ($q) use ($method) {
        //         $q->where('method', 'LIKE', "%$method%");
        //     })
        //     ->exists();

        // // 2. Kiểm tra quyền thông qua role=========================
        // $viaRole    = $this->roles()->whereHas('permissions', function ($q) use ($route_name, $method) {
        //     $q->where('route_name', $route_name)
        //         ->where('method', 'LIKE', "%$method%");
        // })->exists();
        // return $direct || $viaRole;
        $method = strtoupper($method);
        $userId = $this->id;

        $cacheKey = "user_permission:{$userId}:{$route_name}:{$method}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($route_name, $method) {
            // role ngoại lệ
            $excludedRoles = config('constants.index.role_excluded');

            if (
                $this->roles()->where(function ($q) use ($excludedRoles) {
                    foreach ($excludedRoles as $role) {
                        $q->orWhereRaw('LOWER(name) = ?', [strtolower($role)]);
                    }
                })->exists()
            ) {
                return true;
            }

            // permission ngoại lệ
            $excludedPermissions = config('constants.index.permission_excluded');

            foreach ($excludedPermissions as $exception) {
                if (
                    $exception['route_name'] === $route_name &&
                    str_contains($exception['method'], $method)
                ) {
                    return true;
                }
            }

            // 1. Kiểm tra quyền gán trực tiếp
            $direct = $this->permissions()
                ->where('route_name', $route_name)
                ->where(function ($q) use ($method) {
                    $q->where('method', 'LIKE', "%$method%");
                })
                ->exists();

            // 2. Kiểm tra quyền thông qua role
            $viaRole = $this->roles()->whereHas('permissions', function ($q) use ($route_name, $method) {
                $q->where('route_name', $route_name)
                    ->where('method', 'LIKE', "%$method%");
            })->exists();

            return $direct || $viaRole;
        });
    }

}
