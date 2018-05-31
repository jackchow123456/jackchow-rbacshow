<?php
namespace app\admin\validate;

use think\Validate;

class AdminValidate extends Validate
{
    protected $batch = true; //开启批量验证

    protected $rule = [
        'name'  => 'require|max:25',
        'password'  => 'require|confirm',
    ];

    protected $message  =   [
        'name.require' => '名称必须',
        'password.require' => '密码必须',
        'password.confirm' => '两次输入密码必须一样',
    ];
}