<?php
namespace app\admin\validate;

use think\Validate;

class PermissionValidate extends Validate
{
    protected $batch = true; //开启批量验证

    protected $rule = [
        'name'  => 'require|max:25',
        'parent_id'  => 'require',
    ];

    protected $message  =   [
        'name.require' => '名称必须',
        'parent_id.require' => '选择权限组必须',
    ];
}