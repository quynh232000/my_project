<?php

namespace App\Models\Api\V1\Hotel;

use App\Helpers\RedisHelper;
use App\Models\Api\V1\General\CityModel;
use App\Models\Api\V1\General\CountryModel;
use App\Models\Api\V1\General\DistrictModel;
use App\Models\Api\V1\General\WardModel;
use App\Models\ApiModel;
use Illuminate\Support\Facades\Redis;

class HotelCategoryModel extends ApiModel
{
    public function __construct()
    {

        $this->table        = TABLE_HOTEL_HOTEL_CATEGORY;
        $this->hidden       = ['created_by', 'updated_at', 'updated_by', 'status', '_lft', '_rgt'];
        $this->appends      = ['product_counts'];
        parent::__construct();
    }
    protected $casts        = [
        'position' => 'array'
    ];
    protected $hidden       = ['pivot'];
    public function listItem($params = null, $options = null)
    {
        $results        = null;

        if ($options['task'] == 'list') {
            $results            = self::select('id', 'name', 'slug', 'image', 'priority', 'created_at', 'country_id', 'province_id', 'ward_id', 'type_location', 'position')
                ->where('status', 'active')
                ->whereNotNull('position')
                ->orderBy('created_at', 'desc')
                ->orderBy('priority', 'asc')
                ->limit($params['limit'] ?? 999)
                ->get();

            //  group by type item
            $data_group         = collect();
            foreach ($results as $item) {
                $positions      = is_array($item->position) ? $item->position : json_decode($item->position, true);
                if (is_array($positions)) {
                    foreach ($positions as $position) {
                        // create if not exist
                        if ($position != 'trending' && $position != 'best_price') {
                            $data_group[$position] ??= collect();
                            unset($item->position);
                            $data_group[$position]->push($item);
                        }
                    }
                }
            }
            $results        =  $data_group;
        }
        if ($options['task'] == 'hot-location') {

            $params['controller'] = 'hotel-category';
            // $image_url = $this->getImageUrl($params, TABLE_HOTEL_HOTEL_CATEGORY);
            $categories = HotelCategoryModel::where('status', 'active')
                ->select('id', 'name', 'slug', 'image', 'type')
                ->withCount('hotels')
                ->get();
            if ($categories) {
                $groupedCategories = $categories->flatMap(function ($category) {
                    return collect($category->type)->map(function ($type) use ($category) {
                        return [
                            'type' => $type,
                            'id' => $category->id,
                            'name' => $category->name,
                            'slug' => $category->slug,
                            'image' => $category->image,
                            'hotels_count' => $category->hotels_count,
                        ];
                    });
                })->filter(function ($item) {
                    return in_array($item['type'], ['destination', 'popular']);
                })->groupBy('type');
                $results = [
                    'status' => true,
                    'status_code' => 200,
                    'message' => 'Tìm kiếm thành công',
                    'data' => $groupedCategories,
                ];
            } else {
                $results = [
                    'status' => false,
                    'status_code' => 200,
                    'message' => 'Tham số tìm kiếm không hợp lệ.',
                ];
            }
        }
        if ($options['task'] == 'search') {
            $results = self::select('id', 'name', 'slug', 'image')
                ->withCount('hotels')
                ->where('status', 'active')
                ->where('name', 'LIKE', '%' . $params['keyword'] . '%')
                ->get();
        }
        return $results;
    }
    public function getItem($params = null, $options = null)
    {
        $result = null;
        if ($options['task'] == 'item-info') {
            if ($params['type'] == 'chain') {
                $result['info']     = ChainModel::where(['slug' => $params['slug'], 'status' => 'active'])->first();
            } else {
                $result['info']     = self::where(['slug' => $params['slug'], 'status' => 'active', 'type_location' => $params['type']])->first();
            }

            if (!$result['info']) {
                $data_point     = [
                    'country'  => CountryModel::class,
                    'city'     => CityModel::class,
                    'district' => DistrictModel::class,
                    'ward'     => WardModel::class,
                ];
                $result['info']                     = $data_point[$params['type']]::select('id', 'name', 'slug')->where(['slug' => $params['slug'], 'status' => 'active'])
                    ->first()
                    ->makeHidden('image_url')
                    ->toArray();

                $result['info']['type_location']    = 'location';
                $result['info']['origin']           = 'location';
            } else {
                $result['info']                    = $result['info']->toArray();
                if ($params['type'] == 'chain') {
                    $result['info']['origin']           = 'chain';
                } else {
                    $result['info']['origin']           = 'category';
                }
            }

            $result['accommodation']    = AttributeModel::select('id', 'name', 'slug')
                ->where('status', 'active')
                ->whereHas('parents', fn($q) => $q->where('slug', 'accommodation_type'))
                ->whereHas('hotels', function ($query) use ($result, $params) {
                    $query->filterByCategory($result['info'], $params);
                })
                ->get()->toArray();

            $result['facilities']       = HotelServiceModel::with('hotel', 'facility:id,name')
                ->where('type', 'hotel')
                ->whereHas('hotel', function ($query) use ($result, $params) {
                    $query->filterByCategory($result['info'], $params);
                })
                ->get()
                ->unique('service_id')
                ->values()
                ->makeHidden(['hotel', 'point_id', 'type']);

            $result['amenities']        = HotelServiceModel::with('amenity:id,name')
                ->where('type', 'room')
                ->whereHas('room', function ($q) use ($result, $params) {
                    $q->where('status', 'active')
                        ->whereHas('hotel', function ($query) use ($result, $params) {
                            $query->filterByCategory($result['info'], $params);
                        });
                })
                ->get()
                ->unique('service_id')
                ->values()
                ->makeHidden(['room', 'point_id', 'type']);

            // $result['info']             = [
            //                                 'id'                => $result['info']['id'],
            //                                 'name'              => $result['info']['name'],
            //                                 'slug'              => $result['info']['slug'] ?? '',
            //                                 'type_location'     => $result['info']['type_location'],
            //                                 'origin'            => $result['info']['origin'],
            //                                 'description'       => $result['info']['description'] ?? '',
            //                                 'image'             => $result['info']['image'] ?? '',
            //                                 'meta_title'        => $result['info']['meta_title'] ?? '',
            //                                 'meta_keyword'      => $result['info']['meta_keyword'] ?? '',
            //                                 'meta_description'  => $result['info']['meta_description'] ?? '',
            //                             ];

            return $result;
        }
    }
    public function item_info($params)
    {
        $modelSelect            = self::dataModel($params['type']);

        $item                   = $modelSelect['class']::select('id', 'name', 'slug')->where('id', $params['id'])->first()->makeHidden('image_url');

        $item->hotels_count     = $modelSelect['counter']($item) ?? 0;
        $item->filter           = $modelSelect['filter']($item);

        return $item->toArray();
    }

    private function dataModel($type)
    {
        $classMap   =   [
            'category' => HotelCategoryModel::class,
            'country'  => CountryModel::class,
            'city'     => CityModel::class,
            'district' => DistrictModel::class,
            'ward'     => WardModel::class,
        ];

        switch ($type) {
            case 'category':
                return  [
                    'class'     => $classMap[$type],
                    'counter'   => fn($item) => $item->hotels()->count(),
                    'filter'    => fn($item) => self::filter($item, $type)
                ];
            case 'chain':

                break;
            default:
                return  [
                    'class'     => $classMap[$type],
                    'counter'   => fn($item) => HotelModel::whereHas('location', fn($q) => $q->where($type . '_id', $item->id))->count(),
                    'filter'    => fn($item) => self::filter($item, $type)
                ];
        }
    }

    private function filter($item = null, $type)
    {
        $data                   = null;

        // get min - max price
        // if($type == 'category'){
        //     $priceRange     = $item->hotels()
        //                         ->selectRaw('MIN(avg_price) as min_price, MAX(avg_price) as max_price')
        //                         ->first();
        // }else{
        //     $priceRange     = HotelModel::whereHas('location', function ($q) use ($type, $item) {
        //                             $q->where($type.'_id', $item->id);
        //                         })
        //                         ->selectRaw('MIN(avg_price) as min_price, MAX(avg_price) as max_price')
        //                         ->first();
        // }
        // $data['price']      = [
        //                         'min' => $priceRange->min_price ?? 0,
        //                         'max' => $priceRange->max_price ?? 0,
        //                     ];

        // get accommodation
        $data['accommodation']  = AttributeModel::select('id', 'name', 'slug')
            ->where('status', 'active')
            ->whereHas('parents', fn($q) => $q->where('slug', 'accommodation_type'))
            ->get()->toArray();

        // get facility-amentity
        $data['service']        = ServiceModel::select('id', 'name', 'type', 'slug', 'parent_id')
            ->withDepth()
            ->where('status', 'active')
            ->get()
            ->where('depth', '>', 0)
            ->groupBy('type')
            ->makeHidden(['depth', 'parent_id', 'type'])
            ->toArray();
        return $data;
    }
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
    }



    public function getProductCountsAttribute()
    {
        $query          = LocationModel::whereHas('hotel', function ($q) {
            $q->where('status', 'active');
        });

        switch ($this->type_location) {
            case 'province':
                $query->where('province_id', $this->province_id);
                break;
            case 'country':
                $query->where('country_id', $this->country_id);
                break;

            case 'ward':
                $query->where('ward_id', $this->ward_id);
                break;
        }

        return $query->count();
    }
}
