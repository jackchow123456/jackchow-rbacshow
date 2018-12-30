<?php
namespace lib;

use think\facade\Cache;

class Auth
{
    private $guard;

    /**
     * Create a new class instance.
     *
     * @param $guard
     *
     */
    public function __construct($guard='admin')
    {
        $this->guard = $guard;
    }

    /**
     * 检查用户是有登录
     *
     * @return boolean
     */
    public function guest()
    {
        $result = session('?'.$this->guard) ? false : true;

        if($result){
            $name =  cookie('name');
            $password =  cookie('password');
            if(!$name || !$password){
                return true;
            }else{
                return $this->login($name,$password,false) ? false : true;
            }
        }
        return $result;
    }

    /**
     * 登录方法
     *
     * @param $name
     * @param $password
     * @param $remember
     *
     * @return boolean
     */
    public function login($name,$password,$remember)
    {
        $result = model(config('Auth.'.$this->guard.'.model'))
            ->where(['name'=>$name,'password'=>md5($password)])
            ->find();
        if($result){
            session($this->guard,$result);
            $result->last_login_time = get_time();
            $result->save();
            if($remember){
                cookie('name',$name,3600);
                cookie('password',$password,3600);
            }
            return true;
        }
        return false;
    }

    /**
     * 登出方法
     */
    public function logout(){
        session($this->guard,null);
        cookie('name',null);
        cookie('password',null);
        Cache::clear();
    }


    /**
     * 初始化方法
     *
     * @return \lib\Auth
     */
    public static function guard($name='admin')
    {
        return new self($name);
    }

    /**
     * 获取用户数据
     *
     * @return array|null
     */
    public function user(){
        return session($this->guard);
    }

}
