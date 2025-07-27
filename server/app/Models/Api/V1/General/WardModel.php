<?php

namespace App\Models\Api\V1\General;

use App\Helpers\RedisHelper;
use App\Models\ApiModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class WardModel extends ApiModel
{
    // protected $hidden = ['image_url'];
    public function __construct()
    {
        $this->table = TABLE_GENERAL_WARD;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results = null;
        if ($options['task'] == 'list-items') {

            $items = self::select('id', 'name')
                ->where('province_id', $params['province_id'])
                ->orderBy('name', 'asc')
                ->get()
                ->makeHidden(['image_url'])
                ->toArray();

            return [
                'status'        => true,
                'status_code'   => 200,
                'message'       => 'Lấy danh sách city thành công.',
                'data'          => $items
            ];
        }
        return $results;
    }
}
