<?php

namespace app\admin\transformers;

use League\Fractal\TransformerAbstract;

class NavBarTransformer extends TransformerAbstract
{

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $defaultIncludes  = [
        'children'
    ];

    public function transform($data)
    {
        return [
            'title'  => $data->description,
            'icon'   => $data->icon ?: '',
            'spread' => false,
            'href'   => $data->name,
        ];
    }

    /**
     * Include Children
     *
     * @return \League\Fractal\Resource\Collection
     */
    public function includeChildren($data)
    {
        $Children = $data->child;

        return $this->collection($Children, function ($Children){
            return [
                'title'  => $Children->description,
                'icon'   => $Children->icon ?: '',
                'href'   => $Children->name,
            ];
        });
    }
}