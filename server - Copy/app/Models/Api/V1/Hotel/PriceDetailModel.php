<?php

namespace App\Models\Api\V1\Hotel;
use App\Models\ApiModel;

class PriceDetailModel extends ApiModel
{
    public function __construct()
    {
        $this->table        = TABLE_HOTEL_PRICE_DETAIL;
        $this->hidden       = ['created_at', 'created_by'];
        $this->appends      = [];
    }
    public function price_detail_price_types(){
        return $this->hasMany(PriceDetailPriceTypeModel::class,'price_detail_id','id');
    }
    public function min_price_type()
    {
        return $this->hasOne(PriceDetailPriceTypeModel::class,'price_detail_id','id')
                    ->orderBy('price', 'asc');
    }
    // public function scopeAvailableDate($query, $params)
    // {
    //     return $query->where('status', 'NOT LIKE','close')
    //             ->whereDate('date', '>=', $params['date_start'])
    //             ->whereDate('date', '<=', $params['date_end'])
    //             ->whereRaw('quantity - room_booked >= ?', [$params['quantity'] ?? 1]);
    // }
    public function scopeAvailableForBooking($query, $params)
    {
        return $query
            ->join(TABLE_HOTEL_ROOM, TABLE_HOTEL_ROOM.'.id', '=', TABLE_HOTEL_PRICE_DETAIL.'.room_id')
            ->where(function ($query) use ($params) {
                $query->where(function ($sub) use ($params) {
                        $sub->whereNotNull(TABLE_HOTEL_PRICE_DETAIL.'.quantity')
                            ->whereRaw('('.TABLE_HOTEL_PRICE_DETAIL.'.quantity - '.TABLE_HOTEL_PRICE_DETAIL.'.room_booked) >= ?', [$params['quantity']]);
                    })
                    ->orWhere(function ($sub) use ($params) {
                        $sub->whereNull(TABLE_HOTEL_PRICE_DETAIL.'.quantity')
                            ->whereRaw('('.TABLE_HOTEL_ROOM.'.quantity - '.TABLE_HOTEL_PRICE_DETAIL.'.room_booked) >= ?', [$params['quantity']]);
                    });
            })
            ->where(function ($query) {
                $query->where(TABLE_HOTEL_PRICE_DETAIL.'.status', '!=', 'close')
                    ->orWhereNull(TABLE_HOTEL_PRICE_DETAIL.'.status');
            })
            ->whereBetween(TABLE_HOTEL_PRICE_DETAIL.'.date', [$params['date_start'], $params['end']]);
    }

}
