<?php
namespace support;

use think\Response as thinkResponse;
use think\Paginator;
use League\Fractal\Manager;
use League\Fractal\Resource\Collection;
use League\Fractal\Resource\Item;
use League\Fractal\TransformerAbstract;
use League\Fractal\Serializer\DataArraySerializer;
use think\model\Collection as thinkCollection;
use app\admin\transformers\EmptyTransformer;
use support\Paginator\ThinkPaginatorAdapter;

class Transform
{
    protected $fractal;

    public function __construct(Manager $fractal)
    {
        $this->fractal = $fractal;

        $this->fractal->setSerializer(new DataArraySerializer);
    }

    /**
     * 转换一组Collection数据
     *
     * @param $data
     * @param TransformerAbstract|null $transformer
     *
     * @return array
     */
    public function collection($data, TransformerAbstract $transformer = null)
    {
        $transformer = $transformer ?: $this->getDefaultTransformer($data);

        $resource  = new Collection($data, $transformer);

        if($data instanceof Paginator){
            $resource->setPaginator(new ThinkPaginatorAdapter($data));
        }

        return $this->fractal->createData($resource)->toArray();

    }

    /**
     * 转换一个简单的数据.
     *
     * @param $data
     * @param TransformerAbstract|null $transformer
     *
     * @return array
     */
    public function item($data, TransformerAbstract $transformer = null)
    {
        $transformer = $transformer ?: $this->getDefaultTransformer($data);

        return $this->fractal->createData(
            new Item($data, $transformer)
        )->toArray();
    }

    /**
     * 尝试获取给定数据的默认转换器
     *
     * @param $data
     *
     * @return EmptyTransformer
     * @throws \Exception
     */
    public function getDefaultTransformer($data)
    {

        if (($data instanceof Paginator || $data instanceof thinkCollection) && $data->isEmpty()) {
            return new EmptyTransformer();
        }

        $className = $this->getClassName($data);

        $classBasename = class_basename($className);

        if(!class_exists($transformer = "app\\admin\\transformers\\{$classBasename}Transformer")){
            throw new \Exception("No transformer for {$className}");
        }

        return new $transformer;
    }

    /**
     * 从给定对象获取类名
     *
     * @param $object
     *
     * @return string
     * @throws \Exception
     */
    protected function getClassName($object)
    {
        if ($object instanceof Paginator || $object instanceof thinkCollection) {
            return get_class(array_first($object));
        }

        if (!is_string($object) && !is_object($object)) {
            throw new \Exception("No transformer of \"{$object}\" found.");
        }

        return get_class($object);
    }

}