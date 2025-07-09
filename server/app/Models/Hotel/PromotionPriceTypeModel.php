<?php

namespace App\Models\Hotel;

use App\Models\AdminModel;
use Illuminate\Database\Eloquent\Model;

class PromotionPriceTypeModel extends AdminModel
{

    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PROMOTION_PRICE_TYPE;

        parent::__construct();
    }
    public function saveItem($params = null, $options = null)
    {
        if ($options['task'] == 'add-item') { //thêm mới

            if ($params['all_price_types'] != 0) {
                $this->priceType            = new PriceTypeModel();
                $params['price_types']      = $this->priceType->getItem($params, ['task'=>'get-price-type'])->pluck('id')->toArray();
            }
            $data_price_types = array_map(fn($value) => ['promotion_id' => $params['inserted_id'], 'price_type_id' => $value], $params['price_types']);
            self::insert($this->prepareParams($data_price_types));

            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
        if ($options['task'] == 'edit-item') {
            if ($params['all_price_types'] != 0) {
                $this->priceType            = new PriceTypeModel();
                $params['price_types']      = $this->priceType->getItem($params, ['task'=>'get-price-type'])->pluck('id')->toArray();
            }
            $list_price_type    = self::where($this->table . '.promotion_id', $params['id'])->get()->pluck('price_type_id')->toArray();
            $toDelete           = array_diff($list_price_type, $params['price_types']);
            $toAdd              = array_diff($params['price_types'], $list_price_type);
            $data_price_types   = array_map(fn($value) => ['promotion_id' => $params['inserted_id'], 'price_type_id' => $value], $toAdd);
            $this->whereIn($this->table . '.price_type_id', $toDelete)->delete();
            $this->insert($this->prepareParams($data_price_types));
            return response()->json(array('success' => true, 'msg' => 'Tạo yêu cầu thành công!'));
        }
    }
    public function getItem($params = null, $options = null){

    }
    public function deleteItem($params = null, $options = null)
    {
        if ($options['task'] == 'delete-item') {
            if ($params['id'] === '0') {

            } else {
                self::whereIn($this->table . '.promotion_id', $params['id'])->delete();
            }
        }
    }
}
