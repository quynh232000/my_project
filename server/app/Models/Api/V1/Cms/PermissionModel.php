<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;
use App\Models\General\UserModel;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class PermissionModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_CMS_PERMISSION;
        parent::__construct();
    }

    public $crudNotAccepted         = [];
    protected $guarded              = [];
     protected $hidden = ['pivot'];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {
            $results    = self::select('id', 'name', 'route_name')->orderBy('created_at', 'desc')
                ->paginate($params['limit'] ?? 20);
            return $results;
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'add-item') {

            $userId = auth('cms')->id();
            $now = now();

            $permissions = collect($params['data'])->map(function ($item) use ($userId, $now) {
                // Tạo hoặc lấy permission
                $permission = PermissionModel::firstOrCreate(
                    [
                        'name'          => $item['name'],
                        'route_name'    => $item['route_name'],
                        'resource_type' => 'api.v1.cms',
                        'uri'           => $item['uri'],
                        'method'        => $item['method'],
                    ],
                    [
                        'created_by'    => $userId,
                        'created_at'    => $now,
                    ]
                );

                return [
                    'route_name'      => $item['route_name'],
                    'permission_name' => $permission->name,
                    'created_at'      => $now,
                    'updated_at'      => $now,
                ];
            });

            // Bulk insert mapping
            PermissionMappingModel::insert($permissions->toArray());

            return $permissions;
        }
        if ($options['task'] == 'edit-item') {



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


            $results    = self::where('id', $params['id'])->with(['user_create:id,full_name'])
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
}
