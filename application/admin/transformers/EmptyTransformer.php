<?php

namespace app\admin\transformers;

use League\Fractal\TransformerAbstract;

class EmptyTransformer extends TransformerAbstract
{
    public function transform()
    {
        return [

        ];
    }
}