<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class ConversationModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function recent_message(){
        $user_id = auth()->id();
        $message = MessageModel::where(['conversation_id'=>$this->id])->latest()->first();
        // if($user_id == $this->user1_id){
        // }else{
        //     $message = Message::where(['conversation_id'=>$this->id,'user_id'=>$this->user1_id])->first();
        // }
        return $message;
    }
    public function user(){
        return $this->belongsTo(UserModel::class,'user_id','id');
    }
    public function shop(){
        return $this->belongsTo(ShopModel::class,'shop_id','id');
    }
    public function messages(){
        return $this->hasMany(MessageModel::class,'conversation_id','id');
    }
}
