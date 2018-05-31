<?php

namespace app\admin\Transformers;

use App\admin\model\Admins;
use League\Fractal\TransformerAbstract;

class AdminsTransformer extends TransformerAbstract
{
    public function transform(Admins $admin)
    {
        return [
            'id' => $admin->id,
            'name' => $admin->name,
            'created_at' => $admin->created_at
        ];
    }
}