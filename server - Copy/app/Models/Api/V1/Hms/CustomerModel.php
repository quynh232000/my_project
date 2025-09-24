<?php

namespace App\Models\Api\V1\Hms;

use App\Models\HmsModel;
use App\Models\General\UserModel;
use Hash;

class CustomerModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_HMS_CUSTOMER;
        parent::__construct();
    }

    public $crudNotAccepted         = ['password_confirmation','role','hotel_id'];
    protected $guarded              = [];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {
            $hotel_id   = auth('hms')->user()->current_hotel_id;
            $limit      = $params['limit'] ?? 1000;

            $results    = self::select('id', 'email', 'full_name', 'status', 'created_by', 'added_by')
                        ->with([
                            'hotel_customers' => function ($q) use ($hotel_id) {
                                $q->where('hotel_id', $hotel_id)->select('id','hotel_id','customer_id','role');
                            },
                            'created_by:id,full_name',
                            'added_by:id,full_name',
                        ])
                        ->whereHas('hotel_customers', function ($q) use ($hotel_id) {
                            $q->where('hotel_id', $hotel_id);
                        })
                        ->orderBy('created_at','desc')
                        ->limit($limit)
                        ->get();
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'add-item') {

            $params['added_by']     = auth('hms')->id();
            $params['created_at']   = date('Y-m-d H:i:s');

            $item    = self::create([
                                                ...$this->prepareParams($params),
                                                'password' => Hash::make($params['password'])
                                            ]);
            $params['insert_id'] = $item->id;

            $HotelCustomerModel = new HotelCustomerModel();
            $HotelCustomerModel->saveItem($params,['task'=>'edit-item']);
        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by']   = auth('hms')->id();
            $params['updated_at']   = date('Y-m-d H:i:s');

            if($params['password'] ?? false){
                $params['password'] = Hash::make($params['password']);
            }

            $item = self::where('id',$params['id'])->firstOrFail();
            $item->update($this->prepareParams($params));

            $params['insert_id']    = $params['id'];
            $HotelCustomerModel = new HotelCustomerModel();
            $HotelCustomerModel->saveItem($params,['task'=>'edit-item']);
        }
        return ['id' =>  $params['insert_id']];
    }
    public function getItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'detail') {
            $hotel_id   = auth('hms')->user()->current_hotel_id;


            $results    = self::select('id', 'email', 'full_name', 'status', 'created_by', 'added_by')
                        ->with([
                            'hotel_customers' => function ($q) use ($hotel_id) {
                                $q->select('id','hotel_id','customer_id','role');
                            },
                            'created_by:id,full_name',
                            'added_by:id,full_name',
                        ])
                        ->where('id',$params['id'])
                        ->first();
        }
        return $results;
    }

    public function hotel_customers()
    {
        return $this->hasMany(HotelCustomerModel::class, 'customer_id', 'id');
    }
    public function created_by() {
        return $this->belongsTo(UserModel::class,'created_by','id');
    }
    public function added_by() {
        return $this->belongsTo(CustomerModel::class,'added_by','id');
    }
}
