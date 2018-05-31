<?php
namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use app\admin\service\PermissionService;
use app\admin\validate\PermissionValidate;
use think\facade\Request;

class Permission extends BaseController
{
    /**
     * 初始化方法
     *
     * @param  \app\admin\service\PermissionService $permission
     */
    public function __construct(PermissionService $permission)
    {
        parent::__construct();

        $this->service = $permission;
    }

    /**
     * 主页
     *
     * @return \think\response\View
     */
    public function index()
    {
        return view();
    }

    /**
     * 添加页面
     *
     * @return \think\response\View
     */
    public function add()
    {
        $parent_id = Request::param('parene_id');

        $permissionList = $this->service->getPermissionList();

        return view('',compact('permissionList','parent_id'));
    }

    /**
     * 新增操作
     *
     * @return \think\response\Redirect
     */
    public function store(PermissionValidate $permissionValidate)
    {
        $param = Request::param();

        if(!$permissionValidate->check($param)){
            $this->error('提交数据错误',null,$permissionValidate->getError());
        }

        $result = $this->service->store($param)
            ? ['success'=>true,'msg'=>'新增成功！']
            : ['success'=>false,'msg'=>'新增失败！'];

        return redirect('permission/index')->with($result);
    }

    /**
     * 编辑页面
     *
     * @param $id
     *
     * @return \think\response\View
     */
    public function edit($id)
    {
        $data = $this->service->getById($id);

        $permissionList = $this->service->getPermissionList();

        return view('',compact('data','permissionList'));
    }

    /**
     * 更新操作
     *
     * @return \think\response\Redirect
     */
    public function update(PermissionValidate $permissionValidate)
    {
        $param = Request::param();

        if(!$permissionValidate->check($param)){
            $this->error('提交数据错误',null,$permissionValidate->getError());
        }

        $result = $this->service->update($param)
            ? ['success'=>true,'msg'=>'修改成功！']
            : ['success'=>false,'msg'=>'修改失败！'];

        return redirect('permission/index')->with($result);
    }
}
