<?php

namespace app\admin\service;

use app\admin\model\Permissions;
use think\Exception;
use think\model\Collection;

class PermissionService
{
    use Base;

    protected $model;

    /**
     * 初始化方法
     *
     * PermissionService constructor.
     * @param Permissions $permission
     *
     */
    public function __construct(Permissions $permission)
    {
        $this->model = $permission;
    }

    /**
     * 获取分页
     *
     * @return \think\Paginator
     */
    function getList()
    {
        return $this->model->paginate(...$this->getPaginateDefault());
    }

    /**
     * 添加权限
     *
     * @param $data
     * @return bool
     */
    function store($data)
    {
        $this->model->startTrans();

        try
        {
            $data['icon'] = ($data['icon']  === null) ?  '' : $data['icon'];
            $data['display_menu'] = isset($data['display_menu']) ?  1 : 0;
            $data['level_name'] = $data['description'];
            $data['level'] = 0;
            $data['level_id'] = 0;

            $this->model->save($data);
            $permission = $this->model->findOrFail($this->model->id);

            if($data['parent_id'] == 0){
                $permission->save(['level_id'=>$this->model->id]);
            }else{
                $level_id = $this->_getLevelIds($permission->id);
                $level_name = $this->_getLevelNames($permission->id);
                $level = substr_count($level_id,',');
                $permission->save(
                    ['level_id'=>$level_id,'level_name'=>$level_name,'level'=>$level]
                );
            }

            $this->model->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->model->rollback();
            return false;
        }

    }

    /**
     * 权限更新操作
     *
     * @param $data
     * @return bool
     */
    function update($data)
    {
        $this->model->startTrans();
        $id = $data['id'];
        try
        {
            $data['icon'] = ($data['icon']  === null) ?  '' : $data['icon'];
            $data['display_menu'] = isset($data['display_menu']) ?  1 : 0;
            $data['level_name'] = $data['description'];
            $data['level'] = 0;
            $data['level_id'] = 0;

            $this->model->update($data);

            $permission = $this->model->findOrFail($id);

            if($data['parent_id'] == 0){
                $permission->save(['level_id'=>$id]);
            }else{
                $level_id = $this->_getLevelIds($permission->id);
                $level_name = $this->_getLevelNames($permission->id);
                $level = substr_count($level_id,',');
                $permission->save(
                    ['level_id'=>$level_id,'level_name'=>$level_name,'level'=>$level]
                );
            }

            $this->model->commit();
            return true;
        }
        catch (Exception $e)
        {
            $this->model->rollback();
            return false;
        }

    }

    /**
     * 获取权限列表
     *
     * @return array|\PDOStatement|string|\think\Collection
     */
    function getPermissionList()
    {
        $parent_list = $this->model
            ->with('roles')
            ->where('parent_id',0)
            ->select();

        foreach ($parent_list as $key => $value){
            $parent_list[$key]['child'] = $this->_getListById($value['id']);
        }
        return $parent_list;
    }

    /**
     * 递归方法--通过ID获取权限列表
     *
     * @param $id
     * @param $type
     * @return array|\PDOStatement|string|\think\Collection
     */
    function _getListById($id, $type='')
    {
        switch ($type){
            case 'navbar':
                $list = $this->model
                    ->field(['id','name','description','icon'])
                    ->where('parent_id',$id)
                    ->where('display_menu',1)
                    ->order('sort_order,id')
                    ->select();
                break;
            default:
                $list = $this->model
                    ->field(['id','name','description'])
                    ->with('roles')
                    ->where('parent_id',$id)
                    ->select();
                break;
        }

        if($list){
            foreach ($list as $key => $value){
                $list[$key]['child'] = $this->_getListById($value['id'],$type);
            }
        }

        return $list;
    }

    /**
     * 递归方法--通过ID获取权限等级ID
     *
     * @param $permission_id
     * @return string
     */
    function _getLevelIds($permission_id)
    {
        $level_id = '';

        $permission = $this->model->find($permission_id);

        $parent_id = $permission->parent_id;

        if($parent_id){
            $level_id .=  $this->_getLevelIds($parent_id).','.$permission_id;
        }else{
            $level_id = $permission_id;
        }

        return $level_id;
    }

    /**
     * 递归方法--通过ID获取权限等级名称
     *
     * @param $permission_id
     * @return mixed|string
     */
    function _getLevelNames($permission_id)
    {
        $level_name = '';

        $permission = $this->model->find($permission_id);

        $parent_id = $permission->parent_id;

        if($parent_id){
            $level_name .=  $this->_getLevelNames($parent_id).' > '.$permission->description;
        }else{
            $level_name = $permission->description;
        }

        return $level_name;
    }

    /**
     * 获取Navbar列表
     *
     * @return array|\PDOStatement|string|\think\Collection
     */
    function getNavbarList()
    {
        $list = $this->model
            ->field(['id','name','description','icon'])
            ->where('parent_id',0)
            ->where('display_menu',1)
            ->order('sort_order,id')
            ->select();

        if($list){
            foreach ($list as $key => $value){
                $list[$key]['child'] = $this->_getListById($value['id'],'navbar');
            }
        }

        return $list;
    }

}
