<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;
use App\Services\FileService;
use App\Traits\ApiResponse;
use Illuminate\Support\Str;


class RestaurantModel extends HmsModel
{
    use ApiResponse;
    public function __construct()
    {
        $this->table        = TABLE_CMS_RESTAURANT;
        parent::__construct();
    }

    public $crudNotAccepted         = [];
    protected $guarded              = [];
    protected $hidden = ['updated_at','updated_by'];
   protected $casts = [
        'features' => 'array'
    ];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'index') {
            $query = self::query()->with('owner:id,email,full_name','user_create:id,full_name');
            // lọc theo tên nhà hàng
            if (!empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }
            // lọc theo trạng thái
            if (!empty($params['status'])) {
                $query->where('status', $params['status']);
            }
            $results    = $query->orderBy('priority','asc')->orderBy('created_at', 'desc')
                        ->paginate($params['limit'] ?? 20);
            return $results;
        }
       if ($options['task'] == 'list') {
            $query = self::with('users:id,email,full_name')
            ->whereHas('users', function($q) {
                $q->where(TABLE_CMS_USER.'.id', auth('cms')->id());
            });
            // lọc theo tên nhà hàng
            if (!empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }
            // lọc theo trạng thái
            if (!empty($params['status'])) {
                $query->where('status', $params['status']);
            }
            $results    = $query->orderBy('priority','asc')->orderBy('created_at', 'desc')
                        ->paginate($params['limit'] ?? 20);
            return $results;
        }
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'add-item') {

            $params['created_by']   = auth('cms')->id();
            $params['owner_id']     = auth('cms')->id();
            $params['created_at']   = now();
            $params['status']       = 'active';
            $params['state']        = 'new';
            $params['priority']     = $params['priority'] ?? 9999;
            $params['uuid']       = Str::uuid()->toString();

            if(request()->hasFile(('logo'))){
                $params['logo'] = FileService::file_upload($params,$params['logo'],'restaurant.logo');
            }

            $item = self::create($this->prepareParams($params));
            return $item;
        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by']   = auth('cms')->id();
            $params['updated_at']   = now();



            $item = self::find($params['id'] ?? 0);
            if(request()->hasFile(('logo'))){
                $params['logo'] = FileService::file_upload($params,$params['logo'],'restaurant.logo');
            }

            if ($item) {
                if($params['state'] == 'active'){
                    $role = RoleModel::where('name','Owner')->first();
                    if(!$role) {
                        return $this->error('Chưa có vai trò Owner, vui lòng tạo vai trò Owner trước khi kích hoạt nhà hàng!');
                    }

                    UserRestaurantRoleModel::updateOrCreate(
                        [
                            'user_id'       => $item->owner_id,
                            'restaurant_id'=> $item->id,
                            'role_id'          => $role->id
                        ],
                        [
                            'assigned_by'   => auth('cms')->id(),
                            'assigned_at'   => now(),
                            'status'        => 'active',
                        ]
                    );
                }


                $item->update($this->prepareParams($params));
            }

            return $item;
        }
        if ($options['task'] == 'delete-item') {
            $item = self::find($params['id'] ?? 0);
            if ($item) {
                $item->delete();
            }
            return $item;
        }
        if($options['task'] == 'toggle-status'){
            $item = self::find($params['id'] ?? 0);
            if ($item) {
                $item->status = $item->status == 'active' ? 'inactive' : 'active';
                $item->updated_by = auth('cms')->id();
                $item->updated_at = now();
                $item->save();
            }
            return $item;
        }

        return $results;
    }
    public function getItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'detail') {
            $item = self::with('owner:id,email,full_name','user_create:id,full_name','plan')->find($params['id'] ?? 0);
            return $item;
        }

        return $results;
    }
   
    public function user_create()
    {
        return $this->belongsTo(UserModel::class, 'created_by', 'id');
    }
    public function user_update()
    {
        return $this->belongsTo(UserModel::class, 'updated_by', 'id');
    }
    public function owner()
    {
        return $this->belongsTo(UserModel::class, 'owner_id', 'id');
    }
    public function plan(){
        return $this->belongsTo(PlanModel::class,'plan_id','id');
    }
    public function users(){
        return $this->belongsToMany(UserModel::class, UserRestaurantRoleModel::class, 'restaurant_id', 'user_id')
;
    }
}
