<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ApiModel extends Model
{

    protected $table            = '';
    protected $crudNotAccepted  = ['_token', 'prefix', 'controller', 'action', 'as', '_method', 'ID','avatar_remove'];
    protected $_data            = [];
    public $timestamps          = false;
    public $checkall            = true;
    public function __construct()
    {
        $this->primaryKey = $this->columnPrimaryKey();
    }
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];


    // okaosdkaos

    public function getTable()
    {
        if ($this->table) return $this->table;

        $className  = class_basename($this);
        $baseName   = str_replace('Model', '', $className);
        $table      = Str::snake($baseName);
        return 'TABLE_' . strtoupper($table);
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
            'totalItemsPerPage'
        ];
        $crudNotAccepted = array_merge($this->crudNotAccepted, $crudNotAccepted);
        return array_diff_key($params, array_flip($crudNotAccepted));
    }
}
