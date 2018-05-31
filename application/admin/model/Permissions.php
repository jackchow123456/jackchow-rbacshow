<?php

namespace app\admin\model;

use Jackchow\Rbac\RbacPermission;

class Permissions extends RbacPermission
{
    protected $auto = [];
    protected $insert = ['created_at','updated_at'];
    protected $update = ['updated_at'];
    protected $type = [
        'id'          =>  'integer',
        'name'        =>  'string',
        'description' =>  'string',
        'display_menu'=>  'integer',
        'parent_id'   =>  'integer',
        'level'       =>  'integer',
        'level_id'    =>  'string',
        'level_name'  =>  'string',
        'sort_order'  =>  'integer',
        'icon'        =>  'string',
        'created_at'  =>  'datetime',
        'updated_at'  =>  'datetime',
    ];

    protected function setCreatedAtAttr()
    {
        return get_time();
    }

    protected function setUpdatedAtAttr()
    {
        return get_time();
    }
}
