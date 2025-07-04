<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\Ecommerce\PostModel;
use App\Models\Ecommerce\UserBankModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
    public function shop()
    {
        return $this->hasOne(ShopModel::class, 'user_id','id');
    }
}
