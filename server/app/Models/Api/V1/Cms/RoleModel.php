<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;
use App\Models\General\UserModel;
use Illuminate\Support\Facades\Hash;


class RoleModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_CMS_ROLE;
        parent::__construct();
    }

    public $crudNotAccepted         = ['permission_ids'];
    protected $guarded              = [];
    protected $hidden = [];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {
            $results = self::with(['user_create:id,full_name', 'user_update:id,full_name','permissions:id,name'])
                ->orderBy('created_at', 'desc')
                ->paginate($params['limit'] ?? 20);
            return $results;
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'add-item') {

            $params['created_by']     = auth('cms')->id();
            $params['created_at']   = date('Y-m-d H:i:s');
            $params['organization']   =  'cms';
            $item    = self::create([
                ...$this->prepareParams($params)
            ]);

            // add permission
            if ($params['permission_ids'] ?? false) {
                $dataInsert         = [];
                foreach ($params['permission_ids'] ?? [] as $key => $value) {
                    $dataInsert[]   = [
                        'permission_id' => $value,
                        'role_id'       => $item->id
                    ];
                }
                if (count($dataInsert) > 0) {
                    RolePermissionModel::insert($dataInsert);
                }
            }
            return $item;
        }
        if ($options['task'] == 'edit-item') {

            $params['updated_by']   = auth('cms')->id();
            $params['updated_at']   = date('Y-m-d H:i:s');



            $item = self::where('id', $params['id'])->firstOrFail();
            $item->update($this->prepareParams($params));

            return $item;
        }
        if ($options['task'] == 'toggle-status') {

            $item                       = self::find($params['id']);
            $item->status               = $item->status == 'active' ? 'inactive' : 'active';
            $item->updated_at           = date('Y-m-d H:i:s');
            $item->updated_by           = auth('cms')->id();
            $item->save();
            $results                     = $item;
        }

        return $results;
    }

    public function deleteItem($params = null, $options = null)
    {
        $results        = null;

        if ($options['task'] == 'delete-item') {
            self::where(['id' => $params['id']])->delete();
        }

        return $results;
    }
    public function getItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'detail') {


            $results    = self::where('id', $params['id'])->with(['user_create:id,full_name', 'user_update:id,full_name'])
                ->first();
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
    public function permissions()
    {
        return $this->belongsToMany(PermissionModel::class, RolePermissionModel::class, 'role_id', 'permission_id');
    }
}
