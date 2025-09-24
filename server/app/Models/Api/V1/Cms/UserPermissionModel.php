<?php

namespace App\Models\Api\V1\Cms;

use App\Models\HmsModel;


class UserPermissionModel extends HmsModel
{
    public function __construct()
    {
        $this->table        = TABLE_CMS_USER_PERMISSION;
        parent::__construct();
    }

    public $crudNotAccepted         = [];
    protected $guarded              = [];
    protected $hidden = [];

    public function listItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'list') {

            return $results;
        }
        return $results;
    }
    public function saveItem($params = null, $options = null)
    {
        $results        = null;
        if ($options['task'] == 'add-item') {
        }

        return $results;
    }
}
