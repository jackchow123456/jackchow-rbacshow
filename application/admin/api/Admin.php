<?php
namespace app\admin\api;

use app\admin\service\AdminService;
use think\facade\Request;

class Admin extends Base
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
     * 接口--获取用户列表
     *
     * @return
     */
    public function getList()
    {
        return $this->response->collection(
            $this->service->getList()
        );
    }

    /**
     * 接口--删除单条记录操作
     *
     * @return
     */
    public function delete()
    {
        $id = Request::param('id');

        $this->service->destroy($id);

        return $this->response->json(
            ['success'=> true]
        );
    }

    /**
     * 接口--删除多条记录操作
     *
     * @return
     */
    public function deleteAll()
    {
        $ids = Request::param('ids');

        $ids = array_filter(explode(',',$ids));

        foreach ($ids as $id){
            $this->service->destroy($id);
        }

        return $this->response->json(
            ['success'=> true]
        );
    }
}
