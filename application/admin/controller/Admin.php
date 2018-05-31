<?php
namespace app\admin\controller;

use app\admin\controller\Base as BaseController;
use app\admin\service\AdminService;
use think\facade\Request;
use app\admin\service\RoleService;
use app\admin\validate\AdminValidate;

class Admin extends BaseController
{
    /**
     * 初始化方法
     *
     * @param  \app\admin\service\AdminService $admin
     */
    public function __construct(AdminService $admin)
    {
        parent::__construct();

        $this->service = $admin;
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
    public function store(AdminValidate $adminValidate)
    {
        $param = Request::param();

        if(!$adminValidate->check($param)){
            $this->error('提交数据错误',null,$adminValidate->getError());
        }

        $this->service->store($param);

        return redirect('admin/index')->with(
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
    public function update()
    {
        $param = Request::param();

        $id = $param['id'];
        $password = $param['password'];

        if(!$this->service->isExist($id,$password)){
            $this->error('输入原密码有误');
        }

        $this->service->update($param);

        return redirect('admin/index')->with(
            ['success'=>true,'msg'=>'修改成功！']
        );
    }

    /**
     * 用户权限页面
     *
     * @param $id
     * @param RoleService $adminService
     * @return \think\response\View
     */
    public function role($id,RoleService $roleService)
    {
        $roles = $roleService->getRoleList();
        
        return view('',compact('roles','id'));
    }

    /**
     * 提交用户权限操作
     *
     * @return \think\Response\Redirect
     */
    public function role_store()
    {
        $data = Request::param();

        $id = $data['id'];

        $role = $data['role'];

        $this->service->role_store($id,$role);

        return redirect('admin/index')->with(
            ['success'=>true,'msg'=>'修改成功！']
        );
    }
}
