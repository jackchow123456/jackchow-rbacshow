<?php
namespace app\admin\api;

use app\admin\service\PermissionService;
use app\admin\Transformers\NavBarTransformer;

class Index extends Base
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
     * 接口--获取后台菜单列表
     *
     * @return
     */
    public function getNavbarList(PermissionService $permissionService, NavBarTransformer $barTransformer)
    {
        $list = $permissionService->getNavbarList();

        return $this->response->collection(
            $list,
            $barTransformer
        );
    }
}
