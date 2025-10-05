<?php

namespace App\Models\Admin;

use App\Models\Ecommerce\PostModel;
use App\Models\Ecommerce\UserBankModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Cache;
use Laravel\Sanctum\HasApiTokens;

class UserModel  extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    protected $table = null;
    public function __construct()
    {
        $this->table        = config('constants.table.general.TABLE_USER');
    }
    protected $guarded       = [];
    public function roles()
    {
        return $this->belongsToMany(RoleModel::class, UserRoleModel::class, 'user_id', 'role_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, UserPermissionModel::class, 'user_id', 'permission_id');
    }
    public function hasPermission1($route_name, $method)
    {
        $method = strtoupper($method);
        $userId = $this->id;

        $cacheKey = "api.v1.cms.user_permission:{$userId}:{$route_name}:{$method}";

        return Cache::remember($cacheKey, now()->addMinutes(10), function () use ($route_name, $method) {
            // role ngoại lệ
            $excludedRoles = config('constants.api.v1.cms.route.role_excluded');

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
            $excludedPermissions = config('constants.api.v1.cms.route.permission_excluded');

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
     public function hasPermission($route_name, $method)
    {
        $method = strtoupper($method);
        $userId = $this->id;

         // role ngoại lệ
            $excludedRoles = config('constants.api.v1.cms.route.role_excluded');

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
            $excludedPermissions = config('constants.api.v1.cms.route.permission_excluded');

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
    }

    public function ecommerce_posts()
    {
        return $this->hasMany(PostModel::class, 'author_id', 'id');
    }
    public function ecommerce_banks()
    {
        return $this->hasMany(UserBankModel::class, 'user_id', 'id');
    }
}
