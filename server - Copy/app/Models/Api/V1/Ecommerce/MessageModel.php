<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class MessageModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function conversation()
    {
        return $this->belongsTo(ConversationModel::class, 'conversation_id','id');
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'sender_id','id');
    }

    public function shop()
    {
        return $this->belongsTo(ShopModel::class, 'sender_id','id');
    }

    public function sender()
    {
        return $this->type == 'user' ? $this->user : $this->shop;
    }
}
