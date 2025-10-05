<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;


class PlanModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_CMS_PLAN;
        parent::__construct();
    }

    public $crudNotAccepted         = [];
    protected $guarded              = [];
    protected $hidden = ['updated_at','updated_by','priority'];
   protected $casts = [
        'features' => 'array'
    ];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {
            $query = self::with('user_create');
            // lọc theo tên gói
            if (!empty($params['name'])) {
                $query->where('name', 'like', '%' . $params['name'] . '%');
            }
            // lọc theo trạng thái
            if (!empty($params['status'])) {
                $query->where('status', $params['status']);
            }

            $results    = self::orderBy('priority','asc')->orderBy('created_at', 'desc')
                        ->paginate($params['limit'] ?? 20);
            return $results;
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'add-item') {

            $params['created_by']   = auth('cms')->id();
            $params['created_at']   = now();
            $params['status']       = 'active';
            $params['priority']     = $params['priority'] ?? 9999;

            $item = self::create($this->prepareParams($params));
            return $item;
        }
        if ($options['task'] == 'edit-item') {
            $item = self::find($params['id'] ?? 0);
            if ($item) {
                $params['updated_by'] = auth('cms')->id();
                $params['updated_at'] = now();

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
            $item = self::find($params['id'] ?? 0);
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
}
