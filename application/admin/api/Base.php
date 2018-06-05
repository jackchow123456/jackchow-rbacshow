<?php
namespace app\admin\api;

use think\Controller;
use support\Response;
use support\Transform;
use League\Fractal\Manager;

class Base extends Controller
{
    protected $response;

    public function __construct()
    {
        parent::__construct();

        behavior('app\\admin\\behavior\\CheckAuth'); //验证登录

        behavior('app\\admin\\behavior\\RbacAuth');  //权限

        $manage = new Manager();

        $this->response = new Response(new Transform($manage));
    }



}
