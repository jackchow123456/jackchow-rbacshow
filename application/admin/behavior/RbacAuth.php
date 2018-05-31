<?php
namespace app\admin\behavior;

use lib\Auth;
use think\Controller;
use think\facade\Request;

class RbacAuth extends Controller
{

    public function run()
    {
        if(Request::isAjax()){
            $permission_name = trim(substr(Request::path(),strpos(Request::path(),'/')), '/');
        }else{
            $permission_name = strtolower(Request::controller()) . '/' . Request::action(true);
        }

        $user = Auth::guard()->user();

        if($user->can($permission_name) === false){
            dump('你的权限不足，无法访问该页面!'.$permission_name)  ;
            exit;
        }

    }

}
