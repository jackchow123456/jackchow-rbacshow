<?php

namespace app\admin\service;

use app\admin\model\Roles;

class RoleService
{
    use Base;

    /**
     * @var Roles
     */
    protected $model;

    /**
     * 初始化方法
     *
     * RoleService constructor.
     * @param Roles $role
     */
    public function __construct(Roles $role)
    {
        $this->model = $role;
    }

    /**
     * 角色分页
     *
     * @return \think\Paginator
     */
    function getList()
    {
        return $this->model->paginate(...$this->getPaginateDefault());
    }

    /**
     * 修改权限操作
     *
     * @param $id
     * @param $perms
     */
    function perm_store($id,$perms)
    {
        $role = $this->getById($id);

        $role->perms()->sync($perms);
    }

    /**
     * 获取角色列表
     *
     * @return array|\PDOStatement|string|\think\Collection
     */
    function getRoleList()
    {
        $parent_list = $this->model->select();

        return $parent_list;
    }
}
