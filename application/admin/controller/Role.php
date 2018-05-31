<?php
namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use app\admin\service\RoleService;
use think\facade\Request;
use app\admin\service\PermissionService;
use app\admin\validate\RoleValidate;

class Role extends BaseController
{
    /**
     * 初始化方法
     *
     * @param  \app\admin\service\RoleService $role
     */
    public function __construct(RoleService $role)
    {
        parent::__construct();

        $this->service = $role;
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
        return view();
    }

    /**
     * 新增操作
     *
     * @return \think\response\Redirect
     */
    public function store(RoleValidate $roleValidate)
    {
        $param = Request::param();

        if(!$roleValidate->check($param)){
            $this->error('提交数据错误',null,$roleValidate->getError());
        }

        $this->service->store($param);

        return redirect('role/index')->with(
            ['success'=>true,'msg'=>'新增成功！']
        );
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

        return view('',compact('data'));
    }

    /**
     * 更新操作
     *
     * @return \think\response\Redirect
     */
    public function update(RoleValidate $roleValidate)
    {
        $param = Request::param();

        if(!$roleValidate->check($param)){
            $this->error('提交数据错误',null,$roleValidate->getError());
        }

        $this->service->update($param);

        return redirect('role/index')->with(
            ['success'=>true,'msg'=>'修改成功！']
        );
    }

    /**
     * 角色权限页面
     *
     * @param $id
     * @param PermissionService $permissionService
     * @return \think\response\View
     */
    public function perm($id,PermissionService $permissionService)
    {
        $permissions = $permissionService->getPermissionList();

        return view('',compact('permissions','id'));
    }

    /**
     * 提交角色权限操作
     *
     * @return \think\Response\Redirect
     */
    public function perm_store()
    {
        $data = Request::param();

        $id = $data['id'];

        $perm = $data['perm'];

        $this->service->perm_store($id,$perm);

        cache('rbac_permissions_for_role_id',null);

        return redirect('role/index')->with(
            ['success'=>true,'msg'=>'修改成功！']
        );
    }
}
