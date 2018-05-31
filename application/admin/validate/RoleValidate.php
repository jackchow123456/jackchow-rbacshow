<?php
namespace app\admin\validate;

use think\Validate;

class RoleValidate extends Validate
{
    protected $batch = true; //开启批量验证

    protected $rule = [
        'name'  => 'require|max:25',
    ];

    protected $message  =   [
        'name.require' => '名称必须',
    ];
}