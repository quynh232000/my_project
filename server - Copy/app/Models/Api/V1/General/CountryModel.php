<?php

namespace App\Models\Api\V1\General;

use App\Models\ApiModel;
use Illuminate\Support\Facades\DB;

class CountryModel extends ApiModel
{
    // protected $hidden = ['image_url'];
    public function __construct()
    {
        $this->table = TABLE_GENERAL_COUNTRY;
        parent::__construct();
    }
    public function listItem($params = null, $options = null)
    {
        $results = null;

        if ($options['task'] == 'list-items') {
            $items      = self::select('id', 'name')->orderBy('name', 'asc')->get()->makeHidden(['image_url'])->toArray();
            return [
                'status'        => true,
                'status_code'   => 200,
                'message'       => 'Lấy danh sách country thành công.',
                'data'          => $items ?? []
            ];
        }
        if ($options['task'] == 'address') {
            $dataModel = [
                'country_id'    => [
                    'model'         => ProvinceModel::class,
                    'controller'    => 'city',
                    'action'        => 'listItem',
                ],
                'province_id'   => [
                    'model'         => WardModel::class,
                    'controller'    => 'ward',
                    'action'        => 'listItem',
                ],
            ];

            $class = $dataModel[$params['type'] ?? '']['model'] ?? null;

            if ($class && !empty($params['id'])) {

                $model                     = new $class();
                $params['controller']      = $dataModel[$params['type'] ?? '']['controller'];
                $params[$params['type']]   = $params['id'];

                $results =  $model->listItem($params, ['task' => 'list-items']);
            } else {

                $results = $this->listItem($params, ['task' => 'list-items']);
            }
        }
        return $results;
    }
}
