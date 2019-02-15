<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------
error_reporting(E_ERROR | E_WARNING | E_PARSE);
// 应用公共文件
if (!function_exists('auth')) {
    /**
     * 实例化auth'
     *
     * @param string  $name auth名称，如果为数组表示进行auth设置
     *
     * @return mixed
     */
    function auth($name='admin')
    {
        return \lib\Auth::guard('admin');
    }
}

/**
 * 取出数组|对象中的第一个元素
 *
 * @param  array|object  $arr
 *
 * @return array|object
 */
function array_first($arr)
{
    return $arr[0];
}

/**
 * 获取时间格式YYYYmmdd
 *
 * @return string
 */
function get_time()
{
    return date('Y-m-d H:i:s');
}