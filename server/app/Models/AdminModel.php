<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminModel extends Model
{
    public function getTable()
    {
        if ($this->table) return $this->table;

        // Lấy tên class không có namespace
        $className = class_basename($this); // "RolePermissionModel"

        // Bỏ "Model" và convert sang định dạng TABLE_NAME
        $baseName = str_replace('Model', '', $className); // "RolePermission"

        // Chuyển từ camel case sang UPPER_SNAKE_CASE
        $table = Str::snake($baseName); // "role_permission"
        return 'TABLE_'.strtoupper($table);      // "ROLE_PERMISSION"
    }
}
