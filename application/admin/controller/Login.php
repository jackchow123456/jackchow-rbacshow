<?php
namespace app\admin\controller;

use lib\Auth;
use think\Controller;
use think\facade\Request;

class Login extends Controller
{
    public function index()
    {
        behavior('app\\admin\\behavior\\CheckGuest');
        return $this->fetch();
    }

    public function Login()
    {
        behavior('app\\admin\\behavior\\CheckGuest');
        $name = Request::param('name');
        $password = Request::param('password');
        $remember = Request::param('remember');
        if(!Auth::guard()->login($name,$password,$remember)){
            $this->error('登录失败，请重新检查账号密码输入是否正确.');
        };
        $this->redirect('admin/index/index');
    }

    public function logout()
    {
        behavior('app\\admin\\behavior\\CheckAuth');
        Auth::guard()->logout();
        $this->redirect('admin/login/index');
    }
}
