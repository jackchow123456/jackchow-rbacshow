<?php
namespace app\admin\controller;

use think\Controller;

class Base extends Controller
{
    public function __construct()
    {
        parent::__construct();

        behavior('app\\admin\\behavior\\CheckAuth'); //验证登录

        behavior('app\\admin\\behavior\\RbacAuth');  //权限

    }




}
