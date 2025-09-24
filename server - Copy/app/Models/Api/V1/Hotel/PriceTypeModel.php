<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PriceTypeModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_TYPE;
        $this->hidden       = ['created_at','created_by','updated_at','updated_by','deleted_at','hotel_id'];
        $this->appends      = [];
    }
    public function policy_cancel()
    {
        return $this->belongsTo(PolicyCancellationModel::class, 'policy_cancel_id', 'id');
    }
    public function getPolicyCancelApplyAttribute()
    {
        if($this->policy_cancel_id){
            return $this->policy_cancel;
        }
        // Lấy chính sách hoàn hủy chung
        return PolicyCancellationModel::with('policy_cancel_rules')->where('hotel_id', $this->hotel_id)
                ->where('is_global', 1)
                ->first();
    }
    public function getPolicyChildrenApplyAttribute()
    {
        $hotel_id           = $this->hotel_id;
        $price_type_id      = $this->id;

        // Lấy chính sách trẻ em áp dụng cho loại giá này
        return PolicyChildrenModel::where('hotel_id', $hotel_id)
                ->where(function ($query) use ($price_type_id) {
                    $query->where('price_type_id', $price_type_id)
                        ->orWhereNull('price_type_id');
                })
                ->whereRaw("
                    type = (
                        SELECT
                            IF(COUNT(*) > 0, 'price_type', 'policy')
                        FROM ".TABLE_HOTEL_POLICY_CHILDREN."
                        WHERE hotel_id = ?
                        AND (price_type_id = ? OR price_type_id IS NULL)
                        AND type = 'price_type'
                        LIMIT 1
                    )
                ", [$hotel_id, $price_type_id])
                ->get()??null;
    }
}
