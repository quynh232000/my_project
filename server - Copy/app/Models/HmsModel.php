<?php

namespace App\Models;

use App\Models\Api\V1\Flight\AirportModel;
use App\Models\Api\V1\Flight\ArticleModel;
use App\Models\Api\V1\General\CityModel;
use App\Models\Api\V1\General\CountryModel;
use App\Models\Department\DepartmentViewModel;
use App\Models\System\RoleModel;
use App\Models\System\UserModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\NumberParseException;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class HmsModel extends Model
{

    protected $table            = '';
    protected $folderUpload     = '';
    protected $connection       = 'mysql';
    // protected $crudNotAccepted  = [
    //                                 '_token',
    //                                 '_method',
    //                                 'as',
    //                                 'prefix',
    //                                 'controller',
    //                                 'action',
    //                                 'totalItemsPerPage'
    //                                 ];
    protected $_data                  = [];
    public $timestamps      = false;
    public $checkall        = true;

    public function __construct($connection = 'mysql')
    {
        $this->connection = $connection;
        $this->primaryKey = $this->columnPrimaryKey();
    }

    public function columnPrimaryKey($key = 'id')
    {
        return $key;
    }
    public function prepareParams($params)
    {
        $crudNotAccepted = [
            '_token',
            'prefix',
            'controller',
            'action',
            'as',
            '_method',
            'totalItemsPerPage',
        ];
        $crudNotAccepted = array_merge($this->crudNotAccepted ?? [], $crudNotAccepted);

        return array_diff_key($params, array_flip($crudNotAccepted));
    }


    // public function getImageColumn($params,$options = null, $alias = 'image_url')
    // {
    //     $options = array_merge(["'" . URL_DATA_IMAGE . $params['prefix'] . '/' . $params['controller'] . "'"], $options);
    //     return DB::raw("CONCAT(" . join(" , ", $options) . ") AS " . $alias);
    // }
}
