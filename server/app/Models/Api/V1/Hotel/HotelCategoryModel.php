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
        $this->hidden       = [];
        $this->appends      = [];
        parent::__construct();
    }
    protected $casts        = [
                                'type' => 'array'
                            ];
    protected $hidden       = ['pivot'];
    public function listItem($params = null, $options = null)
    {
        $results    = null;

        if ($options['task'] == 'list') {
            
            $results    = self::select('id', 'name', 'slug','image','type')
                            ->withCount(['hotels as hotels_count' => function ($q) {
                                $q->where('status','active');
                            }])
                            ->where('status', 'active')
                            ->orderBy('created_at', 'desc')
                            ->orderBy('priority', 'asc')
                            ->limit($params['limit'] ?? 999)
                            ->get();

            //  group by type item
            $data_group     = collect();
            foreach ($results as $item) {
                $types      = is_array($item->type) ? $item->type : json_decode($item->type, true);
                if (is_array($types)) {
                    foreach ($types as $type) {
                        // create if not exist
                        $data_group[$type] ??= collect(); 
                        $data_group[$type]->push($item);
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
        if($options['task'] == 'search'){
            $results = self::select('id', 'name', 'slug', 'image')
            ->withCount('hotels')
            ->where('status', 'active')
            ->where('name', 'LIKE', '%'.$params['keyword'].'%')
            ->get();
        }
        return $results;
    }
    public function getItem($params = null, $options = null)
    {
        
        if ($options['task'] == 'item-info') {
            $key            = "{$params['prefix']}.{$params['controller']}.{$params['action']}.{$params['type']}.{$params['id']}";
            
            $results        = $this->rememberCacheJson($key,function () use ($params) {
                                return self::item_info($params);
                            }, 3600);
            return $results;
        }
    }
    public function item_info($params){
            $modelSelect            = self::dataModel($params['type']);

            $item                   = $modelSelect['class']::select('id','name','slug')->where('id',$params['id'])->first()->makeHidden('image_url');

            $item->hotels_count     = $modelSelect['counter']($item) ?? 0;
            $item->filter           = $modelSelect['filter']($item);
            
            return $item->toArray();
    }

    private function dataModel($type){
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
                            'filter'    => fn($item)=> self::filter($item,$type)
                        ];
            case 'chain':

                break;
            default:
                return  [
                            'class'     => $classMap[$type],
                            'counter'   => fn($item) => HotelModel::whereHas('location', fn($q) => $q->where($type.'_id', $item->id))->count(),
                            'filter'    => fn($item)=> self::filter($item,$type)
                        ];
        }
    }

    private function filter($item = null,$type){
        $data                   = null ;
       
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
        $data['accommodation']  = AttributeModel::select('id','name','slug')
                                ->where('status','active')
                                ->whereHas('parents', fn($q) => $q->where('slug','accommodation_type'))
                                ->get()->toArray();
        
        // get facility-amentity
        $data['service']        = ServiceModel::select('id','name','type','slug','parent_id')
                                ->withDepth()
                                ->where('status','active')
                                ->get()
                                ->where('depth','>',0)
                                ->groupBy('type')
                                ->makeHidden(['depth','parent_id','type'])
                                ->toArray()
                                ;
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
    public function rememberCacheJson( $key, $callback,  $ttl = 3600): array
    {
        if(!RedisHelper::checkRedis()){
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
    
    public function getImageAttribute()
    {
        return $this->attributes['image'] ? URL_DATA_IMAGE.'hotel/hotel-category/images/'.$this->id.'/'. $this->attributes['image'] : null;
    }
    public function hotels(){
        return $this->belongsToMany(HotelModel::class, TABLE_HOTEL_HOTEL_CATEGORY_ID,'category_id','hotel_id');
    }
}
