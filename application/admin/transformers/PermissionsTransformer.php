<?php

namespace app\admin\transformers;

use App\admin\model\Permissions;
use League\Fractal\TransformerAbstract;

class PermissionsTransformer extends TransformerAbstract
{
    public function transform(Permissions $role)
    {
        return [
            'id'           => $role->id,
            'name'         => $role->name,
            'description'  => $role->description,
            'sort_order'   => $role->sort_order,
            'created_at'   => $role->created_at
        ];
    }
}