<?php

namespace App\Models\Api\V1\Hotel;

use App\Models\Api\V1\General\CityModel;
use App\Models\Api\V1\General\DistrictModel;
use App\Models\Api\V1\General\WardModel;
use Elastic\Elasticsearch\ClientBuilder;
use App\Helpers\RedisHelper;
use App\Models\Admin\ProvinceModel;
use App\Models\Api\V1\General\CountryModel;
use App\Models\ApiModel;
use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

class HotelModel extends ApiModel
{
    public function __construct()
    {
        $this->table         = TABLE_HOTEL_HOTEL;
        $this->hidden        = ['created_at', 'created_by', 'updated_at', 'updated_by', 'contract_file', 'status'];
        $this->appends       = [];
        parent::__construct();
    }

    protected $casts    =  [
        'faqs'      => 'array',
        'position'  => 'array',
        'language'  => 'array'
    ];
    protected $hidden   = [
        'pivot',
        'contract_file',
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];
    public function setJson(string $key, array $data, int $ttl = null): void
    {
        Redis::set($key, json_encode($data), 'EX', $ttl ?? $this->defaultTtl);
    }

    public function getJson(string $key): array|null
    {
        $raw = Redis::get($key);
        return $raw ? json_decode($raw, true) : null;
    }
    public function rememberCacheJson($key, $callback,  $ttl = 3600): array
    {
        return $callback();
        if (!RedisHelper::checkRedis()) {
            return $callback();
        }

        $cached = $this->getJson($key);
        if ($cached !== null) {
            return $cached;
        }
        $data   = $callback();
        $this->setJson($key, $data, $ttl);
        return $data;
    }
    public function getItem($params = null, $options = null)
    {
        if ($options['task'] == 'item-info') {
            $result             = null;

            $params['adt']      = (int)($params['adt'] ?? 1);
            $params['chd']      = (int)($params['chd'] ?? 0);
            $params['quantity'] = (int)($params['quantity'] ?? 1);
            $params['capacity'] = (int)ceil(($params['adt'] + $params['chd']) / $params['quantity']); //sức chứa trung bình mỗi phòng
            $params['end']      =  Carbon::parse($params['date_end'])->subDay()->format('Y-m-d'); // trừ đi 1 ngày

            $roomRelations              = [
                'rooms.amenities:id,name,image,parent_id',
                'rooms.amenities.parents:id,name',
                'rooms.images' => function ($q) {
                    $q->select('id', 'hotel_id', 'label_id', 'type', 'point_id', 'priority', 'image')->orderBy('priority', 'asc');
                },
                'rooms.images.label:id,name',
                'rooms.price_details' => fn($q) => $q->whereBetween('date', [$params['date_start'], $params['end']]),
                'rooms.price_details.price_detail_price_types',
                'rooms.price_details.price_detail_price_types.price_type',
                'rooms.price_settings',
                'rooms.promotions' => fn($q) => $q->where('status', 'active'),
                'rooms.promotions.price_types',
                'rooms.room_extra_beds',
                'rooms.bed_type:id,name',
                'rooms.sub_bed_type:id,name',
                'rooms.direction:id,name',
            ];

            $withRelations              = [
                'location',
                'chain:id,name,slug',
                'hotelImage:id,hotel_id,label_id,type,point_id,priority,image',
                'hotelImage.label:id,name',
                'accommodation:id,name,slug',
                'facilities:id,name,image,parent_id',
                'facilities.parents:id,name',
                'near_locations:id,hotel_id,name,address,longitude,latitude,distance',
                'policy_others.policy_name:id,name,slug',
                'policy_generals.policy_name:id,name,image',
                'policy_children',
                'policy_cancellations.policy_cancel_rules',
                'policy_cancellations.price_types:id,name,policy_cancel_id',
                'rooms' => fn($q) => $q->availableRoom($params),
                ...$roomRelations
            ];

            $query                      = self::where(['slug' => $params['slug'], 'status' => 'active']);

            $query->with($withRelations);

            $hotel                      = $query->first();

            $hotel->recommended_rooms   = self::getRecommendedRoom([...$params, 'hotel' => $hotel]) ?? [];
            $hotel->breadcrumb          = self::getBreadcrumb($hotel->location);

            // cache relative hotel ===================
            $paramsReative              = [
                'hotel_id'      => $hotel->id,
                'city_id'       => $hotel->location->city_id ?? null,
                'district_id'   => $hotel->location->district_id ?? null,
                'ward_id'       => $hotel->location->ward_id ?? null,
            ];


            if (isset($hotel->rooms)) unset($hotel->rooms);
            $hotel->relative_hotels     = self::listItem($paramsReative, ['task' => 'relative-hotel']) ?? [];
            $hotel->reviews             = self::getReviews($hotel->id) ?? null;

            $result                     = $hotel->toArray();
            //xử lý policy other
            $result['policy_others']    = collect($result['policy_others'])
                ->keyBy(fn($item) => $item['policy_name']['slug']);
            $result['keymaps']          = AttributeModel::select('id', 'name', 'parent_id', 'slug')
                ->with('parents:id,name,slug')
                ->whereHas('parents', function ($q) {
                    $q->whereIn('slug', ['method_deposit', 'adult_require', 'duccument_require', 'serving_type', 'breakfast_type']);
                })
                ->get()
                ->map(function ($item) {
                    return $item;
                });

            return $result;
        }

        if ($options['task'] == 'meta') {
            $result         = self::select('id', 'name', 'slug', 'meta_title', 'meta_description', 'meta_keyword')
                ->where('slug', $params['slug'] ?? '')
                ->where('status', 'active')
                ->first();

            return $result;
        }
    }



    // ================ detail start ======================

    private function getReviews($hotel_id)
    {
        $reviews            = ReviewModel::with('images')
            ->where('hotel_id', $hotel_id)
            ->orderBy('point', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        $list_images        = collect($reviews->toArray())->flatMap(function (array $item) {
            return collect($item['images'])->map(function ($img) use ($item) {
                return [
                    'id'              => $img['id'],
                    'hotel_review_id' => $img['hotel_review_id'],
                    'image'           => $img['image'],
                    'username'        => $item['username'],
                    'created_at'      => $item['created_at'],
                ];
            });
        });

        $grouped            = $reviews->flatMap->qualities->groupBy('quality');

        $dataReview         = [
            0 =>  ['name' => 'Sạch sẽ', 'key' => 'clean'],
            1 =>  ['name' => 'Thoải mái', 'key' => 'comfortable'],
            2 =>  ['name' => 'Đồ ăn', 'key' => 'food'],
            3 =>  ['name' => 'Vị trí', 'key' => 'location'],
            4 =>  ['name' => 'Giá cả', 'key' => 'price'],
        ];
        $mapping             = collect($dataReview)->pluck('key', 'name');

        // Xử lý dữ liệu grouped
        $rating             = $grouped->mapWithKeys(function ($group, $quality) use ($mapping) {
            $key            = $mapping[$quality] ?? $quality;
            return [
                $key        => [
                    'avg'       => round($group->avg('quality_point'), 2),
                    'count'     => $group->count(),
                    'name'      => $quality,
                ]
            ];
        })->all();

        $avg                = ReviewModel::where('status', 'active')->where('hotel_id', $hotel_id)->avg('point') ?? 0;
        return [
            'avg'           => $avg,
            'list'          => $reviews,
            'rating'        => $rating,
            'list_images'   => $list_images
        ];
    }
    private function getBreadcrumb($location)
    {
        $categories = HotelCategoryModel::select('id', 'name', 'slug', 'type_location')
            ->where('status', 'active')
            ->where('is_default', true)
            ->where(function ($q) use ($location) {
                $q->where(function ($sub) use ($location) {
                    $sub->where('type_location', 'country')
                        ->where('country_id', $location->country_id);
                })

                    ->orWhere(function ($sub) use ($location) {
                        $sub->where('type_location', 'province')
                            ->where('province_id', $location->province_id);
                    })
                    ->orWhere(function ($sub) use ($location) {
                        $sub->where('type_location', 'ward')
                            ->where('ward_id', $location->ward_id);
                    });
            })
            ->get()->makeHidden('product_counts');

        $requiredLevels     = ['country',  'province', 'ward'];
        $location           = $location->toArray();
        $categoriesMap      = collect($categories->toArray())->keyBy('type_location');

        // Chuẩn bị mảng mới theo đúng thứ tự
        $finalCategories    = [];

        foreach ($requiredLevels as $level) {
            if ($categoriesMap->has($level)) {
                $finalCategories[] = $categoriesMap[$level];
            } else {
                $idKey      = $level . '_id';
                $nameKey    = $level . '_name';
                $slugKey =   $level . '_slug';

                if (empty($location[$idKey])) {
                    continue;
                }
                $finalCategories[] = [
                    'id'             => $location[$idKey],
                    'name'           => $location[$nameKey] ?? '',
                    'slug'           => $location[$slugKey] ?? '',
                    'type_location'  => $level,
                ];
            }
        }
        return $finalCategories;
    }

    private function getRecommendedRoom($params)
    {
        // làm sạch phòng hợp lệ
        $rooms                              = $params['hotel']->rooms ?? [];
        if (count($rooms) == 0) return [];
        $params['policy_cancellations']     = $params['hotel']->policy_cancellations ?? [];

        $params['dateStart']                = Carbon::parse($params['date_start']);
        $params['dateEnd']                  = Carbon::parse($params['date_end']);
        // Tạo khoảng ngày không bao gồm ngày kết thúc
        $period                             = CarbonPeriod::create($params['dateStart'], $params['dateEnd'])->excludeEndDate();
        $params['date_count']               =  $period->count();
        $params['date_now']                 =  Carbon::now();
        $roomAvailables                     = [];

        $expectedDates                      = collect($period)->map(fn($date) => $date->format('Y-m-d'))->toArray();

        foreach ($rooms as $room) {

            $room_inventories               = [];
            // nếu có price_detail thì lấy các loại giá hợp lệ
            if ($room->price_details->count() > 0) {
                // Lấy các phòng theo  từng date => mở và số lượng phải đủ
                $validPriceDetails          = collect($room->price_details)
                    ->where('status', '!=', 'close') // loại bỏ các phòng đóng
                    ->filter(function ($detail) use ($params, $room) {

                        // Lấy số lượng gốc và số đã đặt (đặt mặc định ngay tại đây)
                        $quantity       = $detail['quantity']   ?? $room['quantity'];
                        $booked         = $detail['room_booked'] ?? 0;

                        // Chỉ giữ lại khi còn đủ phòng trống
                        return ($quantity - $booked) >= $params['quantity'];
                    });

                // nhóm price_detail theo price_type_id
                $price_type_groups = $this->price_type_groups($params, $room, $validPriceDetails);

                // Lọc ra những price_type_id có đủ ngày trừ trường hợp price_type_id = 0 (giá tiêu chuẩn)
                $validRecords    = $this->price_type_valids($params, $price_type_groups, $expectedDates, $room);

                if (count($validRecords) > 0) {
                    // dd($validRecords);
                    // Kiểm tra xem có loại giá tiêu chuẩn (price_type_id = 0)
                    $hasPriceTypeStandard   = $validRecords->contains(function ($item) {
                        return collect($item['prices'])->contains(function ($priceItem) {
                            return isset($priceItem['price_type_id']) && $priceItem['price_type_id'] === 0;
                        });
                    });
                    if (!$hasPriceTypeStandard) {
                        // nếu không có price_type_id = 0 thì thêm vào giá tiêu chuẩn
                        $validRecords->put(0, [
                            'prices'    => collect($expectedDates)->map(function ($date) use ($room) {
                                return [
                                    'price_type_id'         => 0,
                                    'price'                 => $room['price_standard'],
                                    'date'                  => $date,
                                    'promotions'            => [],
                                    'num_remaining_rooms'   => $room['quantity']
                                ];
                            }),
                            'surcharge' => self::get_surcharge($room, [...$params, 'price_type_id' => 0])
                        ]);
                    }
                    $room_inventories    = $validRecords;
                }
            } else {
                $prices             = [];
                foreach ($period as $date) {
                    $prices[]       = [
                        'price_type_id'         => 0,
                        'price'                 => $room->price_standard,
                        'date'                  => Carbon::parse($date)->format('Y-m-d'),
                        'promotions'            => [],
                        'num_remaining_rooms'   => $room['quantity']
                    ];
                }

                // lấy giá phụ thu theo sức chưa nếu có sẽ là tăng hay giảm phụ thuộc vào số khách tiêu chuẩn trên phòng đó
                $surcharge          = self::get_surcharge($room, [...$params, 'price_type_id' => 0]);

                $room_inventories[] = [
                    'surcharge'     => $surcharge,
                    'prices'        => $prices
                ];
            }

            if ($room_inventories) {
                // Sau khi lấy kết quả sạch sẽ thì sẽ áp dụng chính sách hoàn hủy và bữa sáng nếu có
                $policyGlobal       = $params['policy_cancellations']->firstWhere('is_global', true);

                $room_inventories   = collect($room_inventories)
                    ->values()
                    ->map(function ($item) use ($params, $policyGlobal) {
                        // Tính tổng giá trị cơ bản và sau giảm giá
                        $totalPrice = $this->calculate_total_price($item['prices'], $item['surcharge']);

                        $firstPrice     = data_get($item, 'prices.0'); // lấy phần tử đầu của mảng $item['prices'][0]
                        $priceTypeId    = $firstPrice['price_type_id'] ?? null;

                        $policy         = null;
                        if ($priceTypeId) {
                            $policy     = $params['policy_cancellations']->first(
                                function ($p) use ($priceTypeId) {
                                    return collect($p->price_types)
                                        ->contains('id', $priceTypeId);
                                }
                            ) ?? ($priceTypeId != 0 ? $policyGlobal : null);

                            $policy?->offsetUnset('price_types'); // Xóa phần tử 'price_types'
                        }

                        $item['policy_cancellation'] = $policy;
                        $item['final_price']         = $totalPrice;

                        return $item;
                    });
                $room               = $room->toArray();

                // Lấy giá trị cần thiết từ room
                unset($room['price_details'], $room['price_settings'], $room['promotions']);

                $roomAvailables[]   = [
                    ...$room,
                    'room_inventory_list'  => $room_inventories
                ];
            }
        }
        return $roomAvailables;
    }
    private function price_type_groups($params, $room, $validPriceDetails)
    {
        return collect($validPriceDetails)->flatMap(function ($detail) use ($params, $room) {
            return collect($detail['price_detail_price_types'])->map(function ($priceType) use ($detail, $params, $room) {
                $price_type_valid       = true;
                $price_type             = $priceType['price_type'] ?? null;
                if ($price_type) {
                    // Kiểm tra số ngày hợp lệ
                    if (
                        $price_type['status'] == 'inactive' ||
                        $price_type['deleted_at'] !== null ||
                        ($params['date_count'] < $price_type['night_min'] && $params['date_count'] > $price_type['night_max']) ||
                        ($params['date_now']->diffInDays($params['dateStart']) < $price_type['date_min'] &&
                            $params['date_now']->diffInDays($params['dateStart']) > $price_type['date_max'])
                    ) {
                        $price_type_valid = false;
                    }
                }

                if ($price_type_valid) {
                    // Tính thêm phí phụ thu + voucher nếu có
                    $promotions           = $this->get_promotion_perday([...$params, 'price_type_id' => $priceType['price_type_id'], 'date' => $detail['date']], $room);
                    $result               = $this->calculate_best_discount([...$params, 'date' => $detail['date']], $promotions, $priceType['price']);

                    return [
                        'price_type_id'   => $priceType['price_type_id'],
                        'price_detail_id' => $detail['id'],
                        'date'            => $detail['date'],
                        'quantity'        => $detail['quantity'],
                        'room_booked'     => $detail['room_booked'],
                        'price'           => $priceType['price'],
                        'room_id'         => $priceType['room_id'],
                        'promotions'      => [
                            'discount_amount'    => $result['total_discount'],
                            'applied_vouchers'   => $result['applied_promotions']
                        ]
                    ];
                }
            })->filter(); // loại bỏ các giá trị null
        })->groupBy('price_type_id');
    }
    private function price_type_valids($params, $price_type_groups, $expectedDates, $room)
    {
        return  $price_type_groups->flatMap(function ($items, $priceTypeId) use ($expectedDates, $room) {
            $availableDates     = $items->pluck('date')->unique()->all();

            // Nếu là price_type_id = 0 và thiếu ngày
            if ((int) $priceTypeId === 0) {
                $missingDates   = array_diff($expectedDates, $availableDates);

                // Tạo các bản ghi bổ sung với giá mặc định
                $filledItems    = collect($missingDates)->map(function ($missingDate) use ($room) {
                    return  [
                        'price_type_id'         => 0,
                        'date'                  => $missingDate,
                        'price'                 => $room['price_standard'], // giá mặc định
                        'num_remaining_rooms'   => $room['quantity']
                    ];
                });

                // Gộp bản gốc với bản bổ sung
                $items          = $items->map(function ($item) use ($room) {
                    return [
                        'price_type_id'         => $item['price_type_id'],
                        'date'                  => $item['date'],
                        'price'                 => $item['price'],
                        'num_remaining_rooms'   => ($item['quantity'] ?? $room['quantity']) - ($item['room_booked'] ?? 0) // lấy số lượng phòng trống theo ngày
                    ];
                })->merge($filledItems);

                return $items;
            }

            // Với price_type_id khác 0: chỉ giữ nếu đầy đủ ngày
            if (empty(array_diff($expectedDates, $availableDates))) {

                return  $items->map(function ($item) use ($room) {
                    return  [
                        'price_type_id'         => $item['price_type_id'],
                        'date'                  => $item['date'],
                        'price'                 => $item['price'],
                        'promotions'            => $item['promotions'],
                        'num_remaining_rooms'   => ($item['quantity'] ?? $room['quantity']) - ($item['room_booked'] ?? 0) // lấy số lượng phòng trống theo ngày
                    ];
                });
            }
            // Nếu thiếu ngày → loại bỏ
            return collect();
        })
            ->groupBy('price_type_id') // Nhóm lại theo price_type_id
            ->map(function ($items) use ($params, $room) {

                $items      = $items->values(); // Reset key nội bộ cho từng nhóm

                // lấy giá phụ thu theo sức chưa nếu có sẽ là tăng hay giảm phụ thuộc vào số khách tiêu chuẩn trên phòng đó
                $surcharge  = self::get_surcharge($room, [...$params, 'price_type_id' => $items->first()['price_type_id']]);
                return  [
                    'prices'    => $items,
                    'surcharge' => $surcharge
                ];
            });
    }
    private function  calculate_total_price($items, $surcharge = 0)
    {
        $totalPrice     = collect($items)->reduce(function ($carry, $item) use ($surcharge) {
            $price                          = $item['price'] ?? 0;
            $discount                       = $item['promotions']['discount_amount'] ?? 0;

            $carry['price_base']           += ($price + $surcharge);
            $carry['price_after_discount'] += ($price - $discount + $surcharge);

            return $carry;
        }, [
            'price_base'            => 0,
            'price_after_discount'  => 0
        ]);

        return $totalPrice;
    }



    private function get_promotion_perday($params, $room)
    {
        $promotions         = collect($room->promotions);
        $date               = Carbon::parse($params['date'])->startOfDay();

        return $promotions->filter(function ($promo) use ($date, $params, $room) {
            // 1) Kiểm tra ngày hiệu lực
            $start      = Carbon::parse($promo['start_date'])->startOfDay();
            $end        = $promo['end_date'] ? Carbon::parse($promo['end_date'])->endOfDay() : null;

            $dateValid  = $date->gte($start) && ($end === null || $date->lte($end));

            // 2) Kiểm tra room_id trong pivot
            $roomValid  = isset($promo['pivot']['room_id']) && $promo['pivot']['room_id'] === $room->id;

            // 3) Kiểm tra price_type_id trong danh sách price_types
            $priceValid = collect($promo['price_types'])
                ->contains(fn($pt) => $pt['pivot']['price_type_id'] == $params['price_type_id']);

            return $dateValid && $roomValid && $priceValid;
        })
            ->values();
    }
    private function calculate_best_discount($params, $promotions, $basePrice)
    {
        // Tách voucher cộng dồn và không cộng dồn

        $stackable          = $promotions->filter(fn($p) => $p['is_stackable']);
        $nonStackable       = $promotions->filter(fn($p) => !$p['is_stackable']);

        // Tính tổng mức giảm từ các voucher cộng dồn
        $stackableDiscount  = 0;
        $stackableApplied   = [];

        foreach ($stackable as $promo) {
            $discount       = $this->get_promo_discount_amount($params, $promo, $basePrice);
            if ($discount > 0) {
                $stackableDiscount  += $discount;
                $stackableApplied[] = $promo;
            }
        }

        // Tính mức giảm từng non-stackable
        $nonStackableOptions    = $nonStackable->map(function ($promo) use ($basePrice, $params) {
            return [
                'promo'     => $promo,
                'discount'  => $this->get_promo_discount_amount($params, $promo, $basePrice),
            ];
        });

        $bestNonStackable       = $nonStackableOptions
            ->sortByDesc('discount')
            ->first();

        // So sánh hai phương án
        if ($stackableDiscount >= ($bestNonStackable['discount'] ?? 0)) {
            return  [
                'total_discount'        => $stackableDiscount,
                'applied_promotions'    => $stackableApplied,
            ];
        } else {
            return [
                'total_discount'        => $bestNonStackable['discount'] ?? 0,
                'applied_promotions'    => $bestNonStackable ? [$bestNonStackable['promo']] : [],
            ];
        }
    }
    private function get_promo_discount_amount($params, $promo, $basePrice)
    {
        $type       = $promo['type']; // Ví dụ: first_night, each_nights
        $value      = floatval($promo['value']);

        switch ($type) {
            case 'first_night':
                // Chỉ áp dụng nếu ngày đang xét chính là đêm đầu tiên
                if ($params['date'] === $params['date_start']) {
                    return ($value / 100) * $basePrice;
                }
                return 0;

            case 'each_nights':
                // Áp dụng cho mỗi đêm trong khoảng từ date_start -> date_end
                return ($value / 100) * $basePrice;

            case 'day_of_weeks':
                $date       = Carbon::parse($params['date']);
                $dayOfWeek  = $date->dayOfWeekIso;

                // Tìm phần tử khớp với day_

                // Truy cập value nếu cần
                $value      = $promo['day_' . $dayOfWeek] ?? 0;
                return ($value / 100) * $basePrice;
            default:
                return 0;
        }
    }
    private function get_surcharge($room, $params)
    {
        $price      = optional($room->price_settings)->firstWhere(function ($item) use ($room, $params) {
            return $item['price_type_id'] == $params['price_type_id']
                && $item['room_id']  == $room->id
                && $item['capacity'] == $params['capacity'];
        })['price'] ?? 0;
        if ($params['capacity'] < $room->standard_guests) {
            $price  = -abs($price);
        }
        return $price;
    }
    // ================ detail end ======================

    public function listItem($params = null, $options = null)
    {
        $results = null;
        if ($options['task'] == 'list1') {
            // dd($params);

            $limit      = $params['limit'] ?? '8';
            $image_url  = $this->getImageUrl($params, $this->table);

            $items = self::select('id', 'name', 'avg_price', 'stars', $image_url)
                ->with(['hotelImage:id,hotel_id,point_id,type,image', 'priorities:id,hotel_id,priority'])
                ->whereHas('priorities', function ($q) {
                    $q->orderBy('priority', 'ASC');
                });

            if (isset($params['featured'])) {
                $items->where('featured', true);
            }

            if (isset($params['slug-category'])) {
                $slug = explode(',', $params['slug-category']);
                $items->whereHas('categories', function ($query) use ($params, $slug) {
                    $query->whereIn('slug', $slug);
                });

                $tempItems    = $items->get();
                $groupedItems = $tempItems->flatMap(function ($item) {
                    return collect($item['categories'])->map(function ($category) use ($item) {
                        $itemCopy = clone $item;
                        $itemCopy->category_slug = $category['slug'];
                        return $itemCopy;
                    });
                })
                    ->groupBy('category_slug')->map(function ($group) use ($limit) {
                        return $group->unique('id')->take($limit)->each->makeHidden('categories');
                    });

                return [
                    'status'        => !$groupedItems->isEmpty(),
                    'status_code'   => 200,
                    'message'       => 'Lấy sản phẩm thành công.',
                    'data'          => $groupedItems->toArray(),
                ];
            }
            $items = $items->paginate($limit);
            $results = [
                'status'       => false,
                'status_code'  => 200,
                'message'      => 'Không có khách sạn hoặc xảy ra lỗi.'
            ];

            if ($items) {
                $items   = $items->toArray();
                $results = [
                    'status'        => true,
                    'status_code'   => 200,
                    'message'       => 'Lấy danh sách khách sạn thành công.',
                    'data'          => [
                        'current_page'  => $items['current_page'],
                        'total_page'    => $items['last_page'],
                        'total_item'    => $items['total'],
                        'list'          => $items['data'],
                    ],
                ];
            }
        }
        if ($options['task'] === 'search1') {
            $limit   = $params['limit'] ?? 8;
            $keyword = trim($params['keyword'] ?? '');

            $results = [
                'status'      => false,
                'status_code' => 200,
                'message'     => 'Không có khách sạn hoặc xảy ra lỗi.'
            ];

            $query = self::select('id', 'name', 'slug')
                ->with(['categories:id,name,slug', 'location'])
                ->where(function ($q) use ($keyword) {
                    $q->where('name', 'LIKE', '%' . $keyword . '%')
                        ->orWhereHas('categories', function ($q) use ($keyword) {
                            $q->where('name', 'LIKE', '%' . $keyword . '%');
                        })
                        ->orWhereHas('location', function ($q) use ($keyword) {
                            $q->where('city_name', 'LIKE', '%' . $keyword . '%');
                        });
                })->get();

            if ($query) {
                $results = [
                    'status'      => true,
                    'status_code' => 200,
                    'message'     => 'Lấy danh sách khách sạn thành công.',
                    'data'        => $query,
                ];
            }
        }

        if ($options['task'] === 'search') {
            // -Địa điểm : Danh mục
            // -Khách sạn: Hotel
            // -Khu vực: Location
            // -Chỗi khách sạn: Chain
            $limit                      = $params['limit'] ?? 10;

            $search                     = $params['search'] ?? '';
            $results['categories']      = HotelCategoryModel::select('id', 'name', 'slug', 'image', 'priority', 'country_id', 'city_id', 'ward_id', 'district_id', 'type_location', 'position')
                ->where('name', 'LIKE', "%{$search}%")
                ->where('status', 'active')
                ->orderBy('priority', 'asc')
                ->limit($limit)
                ->get()
                ->makeVisible(['id', 'name', 'slug', 'type_location', 'image']);

            $results['hotels']          = HotelModel::select('id', 'name', 'slug')
                ->with('location:id,hotel_id,country_name,city_name,district_name,ward_name,address')
                ->where('name', 'LIKE', "%{$search}%")
                ->where('status', 'active')
                ->orderBy('name', 'asc')
                ->limit($limit)->get();


            $tblCountry                 = TABLE_GENERAL_COUNTRY;
            $tblCity                    = TABLE_GENERAL_CITY;
            $tblDistrict                = TABLE_GENERAL_DISTRICT;
            // 1: District
            $districtQuery              = DB::table($tblDistrict)
                ->leftJoin($tblCity, "{$tblDistrict}.city_id", '=', "{$tblCity}.id")
                ->leftJoin($tblCountry, "{$tblCity}.country_id", '=', "$tblCountry.id")
                ->where("{$tblDistrict}.name", 'LIKE', "%$search%")
                ->selectRaw("
                                            {$tblDistrict}.id AS id,
                                            {$tblCountry}.name AS country_name,
                                            {$tblCountry}.slug AS country_slug,
                                            {$tblCity}.name AS city_name,
                                            {$tblCity}.slug AS city_slug,
                                            {$tblDistrict}.name AS district_name,
                                            {$tblDistrict}.slug AS district_slug,
                                            'district' AS type,
                                            CONCAT({$tblDistrict}.name, ', ', {$tblCity}.name, ', ', {$tblCountry}.name) AS label
                                        ");
            // 2: City
            $cityQuery                  = DB::table($tblCity)
                ->leftJoin($tblCountry, "{$tblCity}.country_id", '=', "{$tblCountry}.id")
                ->where("{$tblCity}.name", 'LIKE', "%$search%")
                ->selectRaw("
                                            {$tblCity}.id AS id,
                                            {$tblCountry}.name AS country_name,
                                            {$tblCountry}.slug AS country_slug,
                                            {$tblCity}.name AS city_name,
                                            {$tblCity}.slug AS city_slug,
                                            NULL AS district_name,
                                            NULL AS district_slug,
                                            'city' AS type,
                                            CONCAT({$tblCity}.name, ', ', {$tblCountry}.name) AS label
                                        ")
                ->unionAll($districtQuery);

            // 3: Country
            $finalQuery                 = DB::table($tblCountry)
                ->where("{$tblCountry}.name", 'LIKE', "%$search%")
                ->selectRaw("
                                            {$tblCountry}.id AS id,
                                            {$tblCountry}.name AS country_name,
                                            {$tblCountry}.slug AS country_slug,
                                            NULL AS city_name,
                                            NULL AS city_slug,
                                            NULL AS district_name,
                                            NULL AS district_slug,
                                            'country' AS type,
                                            {$tblCountry}.name AS label
                                        ")
                ->unionAll($cityQuery);
            // query lấy địa chỉ
            $results['locations']       = $finalQuery->limit($limit)->get();

            // Lấy theo chuỗi khách sạn
            $results['chains']          = ChainModel::select('id', 'name', 'slug')
                ->where('name', 'LIKE', "%{$search}%")
                ->orderBy('name', 'asc')
                ->limit($limit)->get();

            return $results;
        }
        if ($options['task'] == 'list') {
            $limit                  = $params['limit'] ?? 8;

            // 1: Lays categories | 'trending', 'best_price'
            $categories             = HotelCategoryModel::whereJsonContains('position', 'trending')
                ->orWhereJsonContains('position', 'best_price')
                ->get();
            // return  $categories;
            // 2: Group categories by type_location & ID
            $categoryMap            = [];
            $categoryObjects        = [];

            foreach ($categories as $category) {
                foreach ($category->position as $positionType) {
                    if (!in_array($positionType, ['trending', 'best_price'])) continue;
                    $type           = $category->type_location;
                    $id             = $category->{$type . '_id'};

                    if (!$id) continue;

                    $categoryMap[$positionType][$type][$id]             = $category->id;

                    if (!isset($categoryObjects[$positionType][$category->id])) {
                        $categoryObjects[$positionType][$category->id]  = [
                            'id'            => $category->id,
                            'name'          => $category->name,
                            'slug'          => $category->slug,
                            // 'position'      => $category->position,
                            'type_location' => $type,
                            'hotels'        => [],
                        ];
                    }
                }
            }

            // 3: Lấy hotels cho từng category theo type_location và gán trực tiếp 2 x 2 x 6
            foreach (['trending', 'best_price'] as $positionType) {
                foreach ($categoryMap[$positionType] ?? [] as $type => $ids) {
                    foreach ($ids as $locationId => $catId) {
                        // Truy vấn hotel thuộc vị trí đó
                        $hotels     = self::select([
                            "{$this->table}.id",
                            "{$this->table}.name",
                            "{$this->table}.slug",
                            "{$this->table}.stars",
                            "{$this->table}.avg_price",
                            "{$this->table}.image",
                            "{$this->table}.accommodation_id",
                            "{$this->table}.position"
                        ])
                            ->join(TABLE_HOTEL_LOCATION, TABLE_HOTEL_LOCATION . '.hotel_id', '=', $this->table . '.id')
                            ->with([
                                'hotelImage' => function ($q) {
                                    $q->select('id', 'hotel_id', 'point_id', 'type', 'image')->orderBy('priority', 'asc')->limit(5);
                                },
                                'facilities' => function ($q) {
                                    $q->select(TABLE_HOTEL_SERVICE . '.id', TABLE_HOTEL_SERVICE . '.name')->limit(5);
                                },
                                'accommodation:id,name',
                                'location'
                            ])
                            ->where($this->table . '.status', 'active')
                            ->whereNotNull($this->table . '.position')
                            ->where(TABLE_HOTEL_LOCATION . ".{$type}_id", $locationId)
                            ->orderBy(TABLE_HOTEL_LOCATION . ".{$type}_index")
                            ->take($limit)
                            ->get();

                        // Nếu không có hotel, bỏ qua
                        if ($hotels->isEmpty()) continue;
                        // Gán vào object category
                        $categoryObjects[$positionType][$catId]['hotels'] = $hotels->toArray();
                    }
                }
            }

            return  [
                'trending'   => array_values($categoryObjects['trending'] ?? []),
                'best_price' => array_values($categoryObjects['best_price'] ?? []),
            ];
        }

        if ($options['task'] == 'filter') {
            if (($params['type'] ?? false) && $params['type'] == 'chain') {
                $category                   = ChainModel::select('id', 'name')->where(['slug' => $params['slug'], 'status' => 'active'])->first();
            } else {
                $category                   = HotelCategoryModel::where(['slug' => $params['slug'], 'type_location' => $params['type'], 'status' => 'active'])->first();
            }


            $query                      = self::select([
                "{$this->table}.id",
                "{$this->table}.name",
                "{$this->table}.stars",
                "{$this->table}.avg_price",
                "{$this->table}.slug",
                "{$this->table}.created_at",
                "{$this->table}.status",
                "{$this->table}.image",
                "{$this->table}.accommodation_id"
            ])
                ->with([
                    'hotelImage' => function ($q) {
                        $q->select('id', 'hotel_id', 'point_id', 'type', 'image')->orderBy('priority', 'asc')->limit(5);
                    },
                    'facilities' => function ($q) {
                        $q->select(TABLE_HOTEL_SERVICE . '.id', TABLE_HOTEL_SERVICE . '.name')->limit(5);
                    },
                    'accommodation:id,name',
                    'location'
                ])
                ->where("{$this->table}.status", 'active');
            if ($category) {
                $category               = $category->toArray();
                // lấy theo danh mục tương ứng
                switch ($category['type'] ?? 'chain') {
                    case 'location':
                        $query->whereHas('location', function ($q) use ($category) {
                            $q->where($category['type_location'] . '_id', $category[$category['type_location'] . '_id']);
                        });
                        break;
                    case 'accommodation':
                        $query->whereHas('location', function ($q) use ($category) {
                            $q->where($category['type_location'] . '_id', $category[$category['type_location'] . '_id']);
                        })->where('accommodation_id', $category['accommodation_id']);
                        break;
                    case 'location_radius':
                    case 'landmark':
                        $query->whereHas('location', function ($q) use ($category) {
                            $radius = ($category['location_radius'] ?? 5) * 1000;
                            $q->whereRaw("ST_Distance_Sphere(POINT(longitude, latitude),POINT(?, ?)) <= ?", [$category['lon'], $category['lat'], $radius]);
                        });
                        break;
                    case 'facility':
                        $query->whereHas('location', function ($q) use ($category) {
                            $q->where($category['type_location'] . '_id', $category[$category['type_location'] . '_id']);
                        })->whereHas('facilities', function ($q) use ($category) {
                            $q->where(TABLE_HOTEL_SERVICE . '.id', $category['facility_id']);
                        });
                        break;
                    case 'chain':
                        $query->where('chain_id', $category['id']);
                        break;
                }
            } else {
                $data_point     = [
                    'country'  => CountryModel::class,
                    'province' => ProvinceModel::class,
                    'ward'     => WardModel::class,
                ];

                $point          = $data_point[$params['type']]::where(['slug' => $params['slug'], 'status' => 'active'])->first()->toArray();

                $query->whereHas('location', function ($q) use ($point, $params) {
                    $q->where($params['type'] . '_id', $point['id']);
                });
            }


            // filter theo ngày đặt
            // if (isset($params['date_start']) && isset($params['date_end'])) {
            //     $params['adt']      = (int)($params['adt'] ?? 1);
            //     $params['chd']      = (int)($params['chd'] ?? 0);
            //     $params['quantity'] = (int)($params['quantity'] ?? 1);

            //     $params['capacity'] = (int) ceil(($params['adt'] + $params['chd']) / $params['quantity']); //sức chứa trung bình mỗi phòng
            //     $params['avg_adt']  = (int) ceil($params['adt'] / $params['quantity']); //số khách tiêu chuẩn trên mỗi phòng
            //     $params['avg_chd']  = (int) ceil($params['chd'] / $params['quantity']); //số trẻ em tiêu chuẩn trên mỗi phòng

            //     $query                  = self::queryRoomHotel($query, $params);
            // }

            // by range price
            if (isset($params['price_min']) && isset($params['price_max'])) {
                // if (isset($params['date_start']) && isset($params['date_end'])) {
                //     $query->whereBetween('price_after_discount', [$params['price_min'], $params['price_max']]);
                // } else {
                // }
                $query->whereBetween('avg_price', [$params['price_min'], $params['price_max']]);
            }
            // by accommodation
            if ($params['accommodation_id'] ?? false) {
                $query->whereIn('accommodation_id', $params['accommodation_id']);
            }
            // by star
            if ($params['stars'] ?? false) {
                $query->whereIn('stars', $params['stars']);
            }

            // by facility
            if (!empty($params['facilities'])) {
                $query->whereHas('facilities', function ($q) use ($params) {
                    $q->whereIn(TABLE_HOTEL_SERVICE . '.id', $params['facilities']);
                });
            }
            // by amentities
            if (!empty($params['amenities'])) {
                $query->whereHas('amenities', function ($q) use ($params) {
                    $q->whereIn(TABLE_HOTEL_SERVICE . '.id', $params['amenities']);
                });
            }

            // by sort
            if ($params['sort'] ?? false) {
                $direction      = $params['direction'] ?? 'desc';
                switch ($params['sort']) {
                    case 'popular':
                        $query->withSum('reviews as total_review_point', 'point')
                            ->orderBy('total_review_point', $direction ?? 'desc');
                        break;
                    case 'price':
                        if (isset($params['date_start']) && isset($params['date_end'])) {
                            $query->orderBy('price_after_discount', $direction);
                        } else {
                            $query->orderBy($this->table . '.avg_price', $direction);
                        }
                        break;
                    case 'review':
                        $query->withSum('reviews as total_review_point', 'point')
                            ->orderBy('total_review_point', $direction ?? 'desc');
                        break;
                    default:
                        $query->orderBy('created_at', 'desc');
                        break;
                }
            } else {
                // Mặc định sort theo index
                $query->leftJoin(TABLE_HOTEL_LOCATION, TABLE_HOTEL_LOCATION . '.hotel_id', '=', $this->table . '.id');
                if ($category) {
                    if ($params['type'] == 'chain') {
                        // độ ưu tiên theo chuỗi khách sạn

                    } else {
                        // độ ưu tiên theo location
                        if ($category['type'] == 'landmark' || $category['type'] == 'location_radius') {
                            $query->orderBy(TABLE_HOTEL_LOCATION . '.location_index', 'asc');
                        } else {
                            $query->orderBy(TABLE_HOTEL_LOCATION . '.' . $params['type'] . '_index', 'asc');
                        }
                    }
                } else {
                    $query->orderBy(TABLE_HOTEL_LOCATION . '.' . $params['type'] . '_index', 'asc');
                }
            }
            $results    =  $query->paginate($params['limit'] ?? 9);
        }
        if ($options['task'] == 'relative-hotel') {
            $limit      = $params['limit'] ?? 4;

            // lấy hotel liên quan theo category hoặc location
            $items      = self::select('id', 'name', 'slug', 'avg_price', 'stars', 'image', 'accommodation_id')
                ->with([
                    'hotelImage' => function ($q) {
                        $q->select('id', 'hotel_id', 'point_id', 'type', 'image')->orderBy('priority', 'asc')->limit(5);
                    },
                    'facilities' => function ($q) {
                        $q->select(TABLE_HOTEL_SERVICE . '.id', TABLE_HOTEL_SERVICE . '.name')->limit(5);
                    },
                    'location',
                    'accommodation:id,name',
                ])
                ->where('status', 'active')
                ->where('id', '!=', $params['hotel_id'])
                ->where(function ($query) use ($params) {
                    if (!empty($params['district_id']) || !empty($params['city_id']) || !empty($params['ward_id'])) {
                        $query->orWhereHas('location', function ($q) use ($params) {
                            $q->where(function ($subQ) use ($params) {
                                if (!empty($params['district_id'])) {
                                    $subQ->orWhere('district_id', $params['district_id']);
                                }
                                if (!empty($params['city_id'])) {
                                    $subQ->orWhere('city_id', $params['city_id']);
                                }
                                if (!empty($params['ward_id'])) {
                                    $subQ->orWhere('ward_id', $params['ward_id']);
                                }
                            });
                        });
                    }
                })
                ->orderBy('avg_price', 'asc')
                ->limit($limit)
                ->get();

            $results    = $items->toArray() ?? [];
        }
        return $results;
    }

    // ================ filter start ======================
    private function applyLocationOrCategoryFilter($query, $params)
    {
        return $query->where(function ($q) use ($params) {
            $q->whereNotNull(TABLE_HOTEL_PRIORITY . '.priority')
                ->orWhere(function ($subQ) use ($params) {
                    switch ($params['type']) {
                        case 'category':
                            $subQ->whereHas('categories', function ($q2) use ($params) {
                                $q2->where(TABLE_HOTEL_HOTEL_CATEGORY . '.id', $params['id']);
                            });
                            break;
                        default:
                            $subQ->whereHas('location', function ($q2) use ($params) {
                                $q2->where(TABLE_HOTEL_LOCATION . '.' . $params['type'] . '_id', $params['id']);
                            });
                            break;
                    }
                });
        });
    }
    // 0. Lấy khách sạn sao cho có ít nhất 1 phòng thỏa mãn điều kiện => nếu có thì lấy giá thấp nhất cửa khách sạn đó đạt điều kiện
    private function queryRoomHotel($query, $params)
    {
        // $query->whereHas('rooms', function($q)use($params){
        //     $q->availableRoom($params);
        // });
        $query->leftJoinSub(self::queryMinPrice($params), 'price_summary', function ($join) {
            $join->on($this->table . '.id', '=', 'price_summary.hotel_id');
        });

        $query->selectRaw('price_summary.total_price,price_summary.price_after_discount, price_summary.room_id');

        return $query;
    }

    // 1. Tạo calendar SQL theo khoảng ngày đặt
    private function queryGenCalendar($params)
    {
        // Tạo lịch sql: "select * from (SELECT "2025-06-17" AS date UNION ALL SELECT "2025-06-18" AS date) AS calendar"
        $dates          = [];
        $current        = strtotime($params['date_start']);
        $end            = strtotime($params['date_end']);

        while ($current < $end) {
            $dates[]    = ['date' => date('Y-m-d', $current)];
            $current    = strtotime('+1 day', $current);
        }

        // Tạo calendar SQL
        $calendarSql    = implode(' UNION ALL ', array_map(fn($d) => 'SELECT "' . $d['date'] . '" AS date', $dates));
        $calendarQuery  = DB::table(DB::raw("({$calendarSql}) AS calendar"));

        return $calendarQuery;
    }
    // 2. Lấy loại giá nhỏ nhất được áp dụng / phòng
    private function queryMinPriceType($params)
    {
        $subQueryMinPriceType   = DB::table(TABLE_HOTEL_PRICE_DETAIL_PRICE_TYPE)
            ->selectRaw('
                                    id,
                                    price_detail_id,
                                    price,
                                    room_id,
                                    price_type_id,
                                    ROW_NUMBER() OVER (PARTITION BY price_detail_id ORDER BY price ASC) AS rn
                                '); // Đánh thêm rn nhóm theo price_detail_id và sắp xếp theo tăng dần
        // dd($subQueryMinPriceType->get());
        // Lấy loại giá có price nhỏ nhất sau đó join với price_setting để lấy giá phụ thu nếu có theo số lượng khách
        $minPriceType           = DB::table(DB::raw("({$subQueryMinPriceType->toSql()}) AS ranked"))
            ->mergeBindings($subQueryMinPriceType)
            ->where('rn', 1)
            ->leftJoin(TABLE_HOTEL_PRICE_SETTING, function ($join) use ($params) {
                $join->on('ranked.room_id', '=', TABLE_HOTEL_PRICE_SETTING . '.room_id')
                    ->on('ranked.price_type_id', '=', TABLE_HOTEL_PRICE_SETTING . '.price_type_id')
                    ->where(TABLE_HOTEL_PRICE_SETTING . '.capacity', '=', $params['capacity'])
                    ->where(TABLE_HOTEL_PRICE_SETTING . '.status', '=', 'active');
            })
            ->select([
                'ranked.*',
                DB::raw('COALESCE(' . TABLE_HOTEL_PRICE_SETTING . '.price, 0) AS price_setting') //nếu có price_setting hợp lệ thì lấy k thì mặc định là 0
            ]);
        // dd( $minPriceType->get());
        return $minPriceType;
    }
    // 3 Lấy tất cả các promo lợp lệ trong khoảng ngày và loại giá được áp dụng ở B2 và tính tổng theo từng ngày
    private function queryDiscountPromo($params)
    {
        // quuery tất cả promotion hợp lệ trong khoảng ngày đặt

        $promotionsQuery    = DB::table(DB::raw("({$this->queryGenCalendar($params)->toSql()}) AS calendar"))
            ->mergeBindings($this->queryGenCalendar($params))
            ->join(TABLE_HOTEL_PROMOTION . ' as p', function ($join) {
                $join->on(DB::raw('calendar.date'), '>=', 'p.start_date')
                    ->whereRaw('p.end_date IS NULL OR calendar.date <= p.end_date');
            })
            ->join(TABLE_HOTEL_PROMOTION_ROOM . ' as pr', 'p.id', '=', 'pr.promotion_id')
            ->join(TABLE_HOTEL_PROMOTION_PRICE_TYPE . ' as pt', 'p.id', '=', 'pt.promotion_id')
            ->where('p.status', 'active')
            ->select(
                'calendar.date',
                'p.id as promotion_id',
                'p.type',
                'pr.room_id',
                'pt.price_type_id',
                'p.value',
                'p.is_stackable',
                'p.start_date',
                'p.end_date',
                // Tính giá trị áp dụng trên mỗi ngày nếu first_night thì lấy ngày đầu và các ngày sau là 0
                DB::raw("
                                        CASE
                                            -- 1. Khuyến mãi áp dụng cho MỌI đêm
                                            WHEN p.type = 'each_nights' THEN CAST(p.value AS UNSIGNED)
                                            -- 2. Khuyến mãi chỉ áp dụng cho ĐÊM ĐẦU
                                            WHEN p.type = 'first_night' AND calendar.date = '{$params['date_start']}' THEN CAST(p.value AS UNSIGNED)
                                            -- 3. Khuyến mãi theo thứ trong tuần
                                            WHEN p.type = 'day_of_weeks'  THEN ( CASE ((DAYOFWEEK(calendar.date) + 5) % 7 + 1)
                                                    WHEN 1 THEN CAST(p.day_1 AS UNSIGNED)
                                                    WHEN 2 THEN CAST(p.day_2 AS UNSIGNED)
                                                    WHEN 3 THEN CAST(p.day_3 AS UNSIGNED)
                                                    WHEN 4 THEN CAST(p.day_4 AS UNSIGNED)
                                                    WHEN 5 THEN CAST(p.day_5 AS UNSIGNED)
                                                    WHEN 6 THEN CAST(p.day_6 AS UNSIGNED)
                                                    WHEN 7 THEN CAST(p.day_7 AS UNSIGNED)
                                                    ELSE 0
                                                END )
                                            ELSE 0
                                        END AS effective_value
                                    ")
            );
        // tính tổng ưu đãi
        $valueProQueryped   = DB::table(DB::raw("({$promotionsQuery->toSql()}) as valid_promotions"))
            ->mergeBindings($promotionsQuery)
            ->select(
                'date',
                'room_id',
                'price_type_id',
                DB::raw("
                                        CASE
                                            WHEN SUM(CASE WHEN is_stackable = 0 THEN 1 ELSE 0 END) > 0
                                                THEN MAX(CASE WHEN is_stackable = 0 THEN effective_value ELSE 0 END)
                                            ELSE SUM(CASE WHEN is_stackable = 1 THEN effective_value ELSE 0 END)
                                        END AS total_discount
                                    ")
            )
            ->groupBy('date', 'room_id', 'price_type_id');

        return $valueProQueryped;
    }
    // 4. Tính tổng tiền mỗi ngày sau khi áp dụng phụ thu và khuyễn mãi
    private function queryTotalDailyPrice($params)
    {

        $calendarSql    = $this->queryGenCalendar($params);
        $capacity       = intval($params['capacity']);
        $roomTable      = TABLE_HOTEL_ROOM;
        $priceField     = "
                            CASE
                                WHEN applied_price_type.price IS NOT NULL THEN
                                    CASE
                                        WHEN {$capacity} > {$roomTable}.standard_guests THEN applied_price_type.price + COALESCE(applied_price_type.price_setting, 0)
                                        WHEN {$capacity} < {$roomTable}.standard_guests THEN applied_price_type.price - COALESCE(applied_price_type.price_setting, 0)
                                        ELSE applied_price_type.price
                                    END
                                ELSE
                                    CASE
                                        WHEN {$capacity} > {$roomTable}.standard_guests THEN {$roomTable}.price_standard + COALESCE(applied_price_type.price_setting, 0)
                                        WHEN {$capacity} < {$roomTable}.standard_guests THEN {$roomTable}.price_standard - COALESCE(applied_price_type.price_setting, 0)
                                        ELSE {$roomTable}.price_standard
                                    END
                            END
                        ";
        // Tạo query lấy tất cả ngày trong khoảng đặt và kết hợp với bảng phòng
        // sau đó join với bảng giá phòng và loại giá để tính toán giá mỗi ngày
        // và áp dụng các khuyến mãi nếu có
        // Lưu ý: nếu không có loại giá thì sẽ lấy giá tiêu chuẩn của phòng

        $query = DB::table(DB::raw("({$calendarSql->toSql()}) AS calendar"))
            ->mergeBindings($calendarSql)
            ->crossJoin($roomTable)
            ->where("{$roomTable}.status", 'active')
            ->where("{$roomTable}.max_extra_adults", '>=', $params['avg_adt'])
            ->where("{$roomTable}.max_extra_children", '>=', $params['avg_chd'])
            ->where("{$roomTable}.max_capacity", '>=', $params['capacity'])
            ->leftJoin(TABLE_HOTEL_PRICE_DETAIL, function ($join) use ($roomTable) {
                $join->on(TABLE_HOTEL_PRICE_DETAIL . '.room_id', '=', $roomTable . '.id')
                    ->on('calendar.date', '=', TABLE_HOTEL_PRICE_DETAIL . '.date');
            })
            ->leftJoinSub($this->queryMinPriceType($params), 'applied_price_type', function ($join) {
                $join->on('applied_price_type.price_detail_id', '=', TABLE_HOTEL_PRICE_DETAIL . '.id');
            })
            ->leftJoinSub($this->queryDiscountPromo($params), 'daily_discounts', function ($join) use ($roomTable) {
                $join->on('calendar.date', '=', 'daily_discounts.date')
                    ->on("{$roomTable}.id", '=', 'daily_discounts.room_id')
                    ->on('applied_price_type.price_type_id', '=', 'daily_discounts.price_type_id');
            })
            ->join($this->table, "{$this->table}.id", '=', "{$roomTable}.hotel_id")
            ->select([
                DB::raw("{$this->table}.id AS hotel_id"),
                DB::raw("{$roomTable}.id AS room_id"),
                DB::raw('calendar.date'),
                DB::raw('applied_price_type.price_type_id'),
                DB::raw('COALESCE(daily_discounts.total_discount, 0) AS total_discount'),
                DB::raw("{$priceField} AS daily_price"),
                DB::raw("ROUND(({$priceField}) * (100 - COALESCE(daily_discounts.total_discount, 0)) / 100.0, 2) AS price_after_discount"),
            ]);
        // dd($query->get());
        return $query;
    }
    // 5. Tính tổng tiền mỗi phòng = tiền các ngày cộng lại
    private function queryTotalPriceRoom($params)
    {
        return DB::table(DB::raw("({$this->queryTotalDailyPrice($params)->toSql()}) AS daily_prices"))
            ->mergeBindings($this->queryTotalDailyPrice($params))
            ->groupBy('room_id', 'hotel_id')
            ->select(
                'hotel_id',
                'room_id',
                DB::raw('SUM(daily_price) AS total_price'),
                DB::raw('SUM(price_after_discount) AS price_after_discount'),
                DB::raw('MAX(price_type_id) AS price_type_id') // giả sử tất cả ngày dùng 1 loại giá — nếu không thì để null hoặc array
            );
    }
    // 6. Lấy min nhỏ nhất trong các phòng
    private function queryMinPrice($params)
    {

        // Tổng hợp các bước trên => nhóm giá phòng theo mỗi khách sạn qua đánh dấu row number sắp xếp theo price khuyến mãi tăng dần
        $ranked             = DB::table(DB::raw("({$this->queryTotalPriceRoom($params)->toSql()}) AS ranked_prices"))
            ->mergeBindings($this->queryTotalPriceRoom($params))
            ->selectRaw('
                                hotel_id,
                                room_id,
                                total_price,
                                ranked_prices.price_after_discount,
                                price_type_id,
                                ROW_NUMBER() OVER (PARTITION BY hotel_id ORDER BY ranked_prices.price_after_discount ASC) AS rn
                            ');
        // => Trả kết quả: 1 phòng có giá thấp nhất mỗi khách sạn tại vị trí rm = 1 (nhỏ nhất)
        $sql                = DB::table(DB::raw("({$ranked->toSql()}) AS final"))
            ->mergeBindings($ranked)
            ->where('rn', 1)
            ->select('hotel_id', 'room_id', 'total_price', 'price_type_id', 'price_after_discount');

        return $sql;
    }

    // ================= filter end ======================





    // ================= relations start =========================
    public function hotelImage()
    {
        return $this->hasMany(AlbumModel::class, 'hotel_id', 'id')->where('type', 'hotel');
    }
    public function album()
    {
        return $this->hasMany(AlbumModel::class, 'hotel_id', 'id');
    }
    public function getImageUrl($params, $table)
    {
        return $this->getImageColumn($params, [
            "'/'",
            $table . ".image",
        ], 'image_url');
    }


    // public function categories()
    // {
    //     return $this->belongsToMany(HotelCategoryModel::class, TABLE_HOTEL_HOTEL_CATEGORY_ID, 'hotel_id', 'category_id');
    // }

    public function location()
    {
        return $this->hasOne(LocationModel::class, 'hotel_id', 'id');
    }
    public function priorities()
    {
        return $this->hasMany(PriorityModel::class, 'hotel_id', 'id')->where('status', 'active');
    }
    public function accommodation()
    {
        return $this->belongsTo(AttributeModel::class, 'accommodation_id', 'id');
    }
    public function facilities()
    {
        return $this->belongsToMany(ServiceModel::class, TABLE_HOTEL_HOTEL_SERVICE, 'point_id', 'service_id')->where(TABLE_HOTEL_HOTEL_SERVICE . '.type', 'hotel');
    }
    public function amenities()
    {
        return $this->belongsToMany(ServiceModel::class, TABLE_HOTEL_HOTEL_SERVICE, 'point_id', 'service_id')->where(TABLE_HOTEL_HOTEL_SERVICE . '.type', 'room');
    }
    public function reviews()
    {
        return $this->hasMany(ReviewModel::class, 'hotel_id', 'id');
    }
    public function rooms()
    {
        return $this->hasMany(RoomModel::class, 'hotel_id', 'id')->where('status', 'active');
    }
    public function price_settings()
    {
        return $this->hasMany(PriceSettingModel::class, 'price_type_id', 'price_type_id', 'room_id');
    }
    public function near_locations()
    {
        return $this->hasMany(NearbyLocationModel::class, 'hotel_id', 'id');
    }
    public function policy_cancellations()
    {
        return $this->hasMany(PolicyCancellationModel::class, 'hotel_id', 'id')->where('status', 'active');
    }
    public function policy_others()
    {
        return $this->hasMany(PolicyOtherModel::class, 'hotel_id', 'id');
    }
    public function policy_generals()
    {
        return $this->hasMany(PolicyGeneralModel::class, 'hotel_id', 'id');
    }
    public function policy_children()
    {
        return $this->hasMany(PolicyChildrenModel::class, 'hotel_id', 'id')->orderBy('age_from', 'asc');
    }
    public function chain()
    {
        return $this->belongsTo(ChainModel::class, 'chain_id', 'id');
    }
    public function language()
    {
        return $this->belongsTo(CountryModel::class, 'language', 'id');
    }

    // ================= relations end =========================
    // scrope
    public function scopeFilterByCategory($query, array $category, array $params = [])
    {
        $query->where('status', 'active');

        // nếu là chain
        if ($category['origin'] === 'chain') {
            $query->where('chain_id', $category['id']);
            return $query;
        } else {

            if ($category['origin'] === 'location') {
                $query->whereHas(
                    'location',
                    fn($q) =>
                    $q->where($params['type'] . '_id', $category['id'])
                );
                return $query;
            }

            switch ($category['type']) {
                case 'location':
                    $query->whereHas('location', function ($q) use ($category) {
                        $field = $category['type_location'] . '_id';
                        $q->where($field, $category[$field]);
                    });
                    break;

                case 'accommodation':
                    $query->whereHas('location', function ($q) use ($category) {
                        $field = $category['type_location'] . '_id';
                        $q->where($field, $category[$field]);
                    })->where('accommodation_id', $category['accommodation_id']);
                    break;

                case 'location_radius':
                case 'landmark':
                    $query->whereHas('location', function ($q) use ($category) {
                        $radius = ($category['location_radius'] ?? 5) * 1000;
                        $q->whereRaw("
                            ST_Distance_Sphere(
                                POINT(longitude, latitude),
                                POINT(?, ?)
                            ) <= ?
                        ", [$category['lon'], $category['lat'], $radius]);
                    });
                    break;

                case 'facility':
                    $query->whereHas('location', function ($q) use ($category) {
                        $field = $category['type_location'] . '_id';
                        $q->where($field, $category[$field]);
                    })->whereHas('facilities', function ($q) use ($category) {
                        $q->where(TABLE_HOTEL_SERVICE . '.id', $category['facility_id']);
                    });
                    break;
            }
        }
        return $query;
    }
}
