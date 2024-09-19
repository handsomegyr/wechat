<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 类目
 */
class Cat extends \Weixin\Model\Base
{
    /**
     * cats[].cat_id	string(uint64)	是	类目ID，需要先通过获取类目接口拿到可用的cat_id；这里的cat_id顺序与一，二，三级类目严格一致，即数组下标为0的是一级类目，数组下标为1的是二级类目，数组下标为2的是三级类目
     */
    public $cat_id = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->cat_id)) {
            $params['cat_id'] = $this->cat_id;
        }

        return $params;
    }
}
