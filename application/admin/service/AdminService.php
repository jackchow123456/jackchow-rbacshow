<?php

namespace app\admin\service;

use app\admin\model\Admins;

class AdminService
{
    use Base;

    /**
     * @var Admins
     */
    protected $model;

    /**
     * 初始化方法
     *
     * AdminService constructor.
     * @param Admins $admin
     */
    public function __construct(Admins $admin)
    {
        $this->model = $admin;
    }

    /**
     * 用户分页
     *
     * @return \think\Paginator
     */
    function getList()
    {
        return $this->model->paginate(...$this->getPaginateDefault());
    }

    /**
     * 新建用户
     *
     * @param $data
     * @return false|int
     */
    function store($data)
    {
        $data['password'] = md5($data['password']);
        $data['last_login_time'] = get_time();

        return $this->model->save($data);
    }

    /**
     * 修改用户
     */
    function update($data)
    {

        $data['password'] = md5($data['new_password']);

        return $this->model->update($data);
    }

    /**
     * 检查用户是否存在
     */
    function isExist($id,$password)
    {
        return $this->model->where([
            'id' => $id,
            'password' => md5($password)
        ])->find();
    }
    /**
     * 修改角色操作
     *
     * @param $id
     * @param $roles
     */
    function role_store($id,$roles)
    {
        $admin = $this->getById($id);

        $admin->roles()->sync($roles);
    }
}
