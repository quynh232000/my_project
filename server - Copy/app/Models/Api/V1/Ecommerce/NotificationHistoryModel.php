<?php

namespace App\Models\Api\V1\Ecommerce;

use App\Models\ApiModel;

class NotificationHistoryModel  extends ApiModel
{
    protected $table        = null;
    public function __construct()
    {
        $this->table        = config('constants.table.ecommerce.' . self::getTable());
        parent::__construct();
    }
    protected $guarded       = [];
    public function listItem($params = null, $options = null)
    {
        if ($options['task'] == "list") {

            $page       = $params['page'] ?? 1;
            $limit      = $params['limit'] ?? 10;

            $query      = self::select($this->table.'.*')
                        ->where('user_id', auth('ecommerce')->id())
                        ->with('notification');

            $query->join('ecommerce_notifications as n', 'n.id', '=', 'notification_id');
            $query->select($this->table.'.*');

            if (!empty($params['position']) && $params['position'] == 'preview') {
                if ($params['type'] && !empty($params['type'])) {
                    $query->where('n.to', strtoupper($params['type']));
                }
                $query->where('is_read', 0);
            } else {

                if (isset($params['type']) && !empty($params['type'])) {
                    $query->where('n.to', strtoupper($params['type']));
                }
                if (isset($params['from']) && !empty($params['from'])) {
                    $query->where('n.from', strtoupper($params['from']));
                }
                if (isset($params['search']) && !empty($params['search'])) {
                    $query->where('n.title', 'LIKE', '%' . $params['search'] . '%')
                        ->orWhere('n.message', 'LIKE', '%' . $params['search'] . '%');
                }
                if (isset($params['created_at']) &&!empty($params['created_at'])) {
                    $query->orderBy($this->table.'.created_at', $params['created_at']);
                } else {
                    $query->orderBy($this->table.'.created_at', 'desc');
                }
            }
            if (isset($params['read']) && $params['read'] == 'all') {
            self::where(['is_read' => 0, 'user_id' => auth('ecommerce')->user()->id])
                ->update(['is_read' => 1]);
        }

            $result = $query->paginate($limit, ['*'], 'page', $page);
            return $result;
        }
    }
    public function user()
    {
        return $this->belongsTo(UserModel::class, 'user_id', 'id');
    }
    public function notification() {
        return $this->belongsTo(NotificationModel::class,'notification_id','id');
    }
}
