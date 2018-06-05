<?php
namespace support;

use think\Response as thinkResponse;
use League\Fractal\TransformerAbstract;

class Response
{
    protected $manage;

    /**
     * Create a new class instance.
     *
     * @param $transform
     */
    public function __construct(Transform $Transformer)
    {
        $this->manage = $Transformer;
    }

    /**
     * Make a JSON response.
     *
     * @param $items
     * @param TransformerAbstract|null $transformer
     *
     * @return \think\Response\Json
     */
    public function collection($items, TransformerAbstract $transformer = null, $result = [])
    {
        return $this->json(
            array_merge($this->manage->collection($items, $transformer),$result)
        );
    }

    /**
     * Make a JSON response with the transformed items.
     *
     * @param $item
     * @param TransformerAbstract|null $transformer
     *
     * @return \think\Response\Json
     */
    public function item($item, TransformerAbstract $transformer = null, $result = [])
    {
        return $this->json(
            array_merge($this->manage->item($item, $transformer),$result)
        );
    }

    /**
     * Make a JSON response .
     *
     * @param $item
     * @param TransformerAbstract|null $transformer
     *
     * @return \think\Response\Json
     */
    public function json($data)
    {
        return json($data);
    }


}