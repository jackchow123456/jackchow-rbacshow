<?php
namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use think\facade\Cache;

class Index extends BaseController
{

    public function index()
    {
        return $this->fetch();
    }

    public function main()
    {
        return $this->fetch();
    }

    public function clearCache()
    {
        Cache::clear();
        return $this->success('清除缓存成功!');
    }
}
