<?php

namespace App\Models\Api\V1\Hms;

use App\Models\Customer;
use App\Models\HmsModel;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class PriceTypeModel extends HmsModel
{
    use SoftDeletes;
    protected $bucket  = 's3_hotel';

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_TYPE;
        parent::__construct();
        $this->bucket       = config('filesystems.disks.'.$this->bucket.'.driver').'_'.config('filesystems.disks.'.$this->bucket.'.bucket');
    }

    protected $guarded = [];
    public $crudNotAccepted = ["room_ids",'policy_children'];
    protected $hidden = [
        'created_by','updated_at','updated_by','pivot'
    ];
    public function getItem($params = null, $options = null)
    {
        $results = null;
        
        if ($options['task'] == 'detail') {

            $results = self::with('roomType:room_id,price_type_id','policy_children')
                        ->where(['id' => $params['id'], 'hotel_id' => auth('hms')->user()->current_hotel_id])
                        ->whereNull('deleted_at')
                        ->first();
        }
       
        return $results;
    }
    public function listItem($params = null, $options = null)
    {
        $results        = null;

        if ($options['task'] == 'list') {
            $query      = PriceTypeModel::select('id','name','rate_type','created_at','status','created_by')
                            ->whereNull('deleted_at')
                            ->where(['hotel_id'=>auth('hms')->user()->current_hotel_id])
                            ->with('user:id,full_name','roomType');
            if($params['status'] ?? false){
                $query->where(['status' => $params['status']]);
            }

            if($params['search'] ?? false){
                $query->where(function ($q) use ($params) {
                    $q->where('name', 'LIKE', '%' . $params['search'] . '%')
                      ->orWhere('rate_type', 'LIKE', '%' . $params['search'] . '%');
                });
            }
            
            $results    = $query->orderBy($params['column'] ?? 'created_at',$params['direction'] ?? 'desc')->paginate($params['limit'] ?? 20);
        }
        if($options['task'] == 'list-all'){
            return self::select('id','name','rate_type')->where(['hotel_id'=>auth('hms')->user()->current_hotel_id])
                        ->orderBy('created_at','desc')
                        ->get();
        }
        
        return $results;
    }
  
    public function saveItem($params = null, $options = null)
    {
        $results    = null;
        if ($options['task'] == 'add-item') {

            $hotel_id                   = auth('hms')->user()->current_hotel_id;

            $params['created_by']       = auth('hms')->id();
            $params['created_at']       = date('Y-m-d H:i:s');
            $params['status']           = $params['status'] ?? "active";

            $insert_id                  = self::insertGetId($this->prepareParams([...$params, 'hotel_id' => $hotel_id]));

            if(count($params['room_ids'] ?? []) > 0){
                $PriceTypeRoomModel = new PriceTypeRoomModel();
                $PriceTypeRoomModel->saveItem($params['room_ids'], [...$options,'price_type_id' => $insert_id]);
            }
            // add policy children
            $PolicyChildren = new PolicyChildrenModel();
            if(count($params['policy_children'] ?? []) > 0){
                $PolicyChildren->saveItem($params['policy_children'],['task'=>'edit-pricetype', 'insert_id'=>$insert_id]);
            }else{
                $PolicyChildren->deleteItem(null,['task'=>'delete-pricetype', 'insert_id'=>$insert_id]);
            }

            return $insert_id;
        }

        if ($options['task'] == 'edit-item') {

            $hotel_id                   = auth('hms')->user()->current_hotel_id;

            $params['status']           = $params['status'] ?? "active";
            $params['updated_at']       = date('Y-m-d H:i:s');
            $params['updated_by']       = auth('hms')->id();

            $PriceTypeRoomModel          = new PriceTypeRoomModel();

            if(count($params['room_ids'] ?? []) > 0){
                $PriceTypeRoomModel->saveItem($params['room_ids'], [...$options,'price_type_id' => $params['id']]);
            }else{
                $PriceTypeRoomModel->deleteItem($params,['task' => 'delete-all']);
            }

            // add policy children
            $PolicyChildren = new PolicyChildrenModel();
            if(count($params['policy_children'] ?? []) > 0){
                $PolicyChildren->saveItem($params['policy_children'],['task'=>'edit-pricetype', 'insert_id' => $params['id']]);
            }else{
                $PolicyChildren->deleteItem(null,['task'=>'delete-pricetype', 'insert_id' => $params['id']]);
            }

            self::where(['id' => $params['id']])->update($this->prepareParams($params));
            return $params['id'];
        }

         if ($options['task'] == 'update-policy-cancel') {
            self::where('policy_cancel_id',$options['policy_cancel_id'])->update(['policy_cancel_id' => null]);
         }

        if($options['task'] == 'toggle-status'){
            
            $item                       = self::find($params['id']);
            $item->status               = $item->status == 'active' ? 'inactive' : 'active';
            $item->updated_at           = date('Y-m-d H:i:s');
            $item->updated_by           = auth('hms')->id();
            $item->save();
            $results                     = ['id' => $params['id']];
        }
        
        return $results;
    }

    public function deleteItem($params = null, $options = null)
    {
        $results        = null;

        if ($options['task'] == 'delete-item') {
            $PriceTypeRoomModel          = new PriceTypeRoomModel();
            // $PriceTypeRoomModel->deleteItem($params,['task' => 'delete-all']);

           $item = PriceTypeModel::where(['id' => $params['id'], 'hotel_id' => auth('hms')->user()->current_hotel_id])->first();
           if($item){
               $item->delete();
           }
        }
        
        return $results;
    }

    public function roomType() {
        return $this->hasMany(PriceTypeRoomModel::class,'price_type_id','id');
   }
     public function user() {
        return $this->belongsTo(Customer::class,'created_by','id');
   }
     public function roomTypes(){
        return $this->belongsToMany(
            RoomTypeModel::class,
            TABLE_HOTEL_PRICE_TYPE_ROOM, // tên bảng trung gian (nếu không theo chuẩn Laravel)
            'price_type_id',        // khóa ngoại ở bảng trung gian trỏ đến model hiện tại
            'room_id'          // khóa ngoại ở bảng trung gian trỏ đến model liên kết
        );
    }
    public function policy_children() {
        return $this->hasMany(PolicyChildrenModel::class, 'price_type_id', 'id');
    }
}
