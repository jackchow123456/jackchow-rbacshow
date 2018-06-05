<?php

namespace app\admin\Transformers;

use App\admin\model\Roles;
use League\Fractal\TransformerAbstract;

class RolesTransformer extends TransformerAbstract
{
    public function transform(Roles $role)
    {
        return [
            'id' => $role->id,
            'name' => $role->name,
            'description' => $role->description,
            'created_at' => $role->created_at
        ];
    }
}