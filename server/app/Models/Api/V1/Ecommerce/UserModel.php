<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\Ecommerce\PostModel;
use App\Models\Ecommerce\UserBankModel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class UserModel  extends Authenticatable implements JWTSubject
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
    protected $appends      = ['avatar_url'];
    protected $guarded      = [];
    public function shop()
    {
        return $this->hasOne(ShopModel::class, 'user_id','id');
    }
    public function roles()
    {
        $role_ids = UserRoleModel::where('user_id', $this->id)->pluck('role_id');
        return RoleModel::whereIn('id', $role_ids)->pluck('name');
    }
    public function role(){
        return $this->belongsToMany(RoleModel::class, 'user_roles', 'user_id', 'role_id');
    }
    public function getAvatarUrlAttribute(){
        return $this->avatar;
    }
    public function vouchers()
    {
        return $this->hasMany(VoucherModel::class,'user_id','id');
    }
    // public function orders()
    // {
    //     return $this->hasMany(OrderShopModel::class,'');
    // }
    public function total_coin($user_id = null)
    {
        return CoinTransactionModel::where(['user_id' => $user_id ?? auth('ecommerce')->id()])
                                    ->orderBy('id', 'desc')
                                    ->value('balance_after') ?? 0;
    }
    public function coin_register($user_id)
    {
        $coin_rule          = CoinRuleModel::find(1);
        $transaction_coin   = CoinTransactionModel::create([
                                'user_id'           => $user_id,
                                'name'              => $coin_rule->rule_name,
                                'amount'            => $coin_rule->coin_amount,
                                'balance_before'    => 0,
                                'balance_after'     => $coin_rule->coin_amount,
                                'description'       => $coin_rule->description
                            ]);
        $this->send_notify_coin($coin_rule, $transaction_coin, $user_id);
    }

    public function coin_login_daily($user_id)
    {
        $coin_rule              = CoinRuleModel::find(2);
        $check_get_coin         = CoinTransactionModel::where('user_id', $user_id)
                                ->where('name', $coin_rule->rule_name)
                                ->whereDate('created_at', Carbon::today())
                                ->exists();
        if (!$check_get_coin) {
            $total_coin         = $this->total_coin($user_id);
            $transaction_coin   = CoinTransactionModel::create([
                                    'user_id'           => $user_id,
                                    'name'              => $coin_rule->rule_name,
                                    'amount'            => $coin_rule->coin_amount,
                                    'balance_before'    => $total_coin,
                                    'balance_after'     => $total_coin + $coin_rule->coin_amount,
                                    'description'       => $coin_rule->description
                                ]);
            $this->send_notify_coin($coin_rule, $transaction_coin, $user_id);
        }
    }
    public function send_notify_coin($coin_rule, $transaction_coin, $user_id)
    {
        $notify         = NotificationModel::create([
                            'title'         => $coin_rule->description,
                            'message'       => "Bạn đã nhận được " . $coin_rule->coin_amount . " khi " . $coin_rule->rule_name,
                            'from'          => 'COIN',
                            'to'            => 'WEB',
                            'sent_type'     => "IMMEDIATE",
                            'status'        => "SENT",
                            'type_target'   => "USER",
                            'data_id'       => $transaction_coin->id
                        ]);
        NotificationHistoryModel::create([
                                    'notification_id'   => $notify->id,
                                    'user_id'           => $user_id,
                                ]);
    }
}
