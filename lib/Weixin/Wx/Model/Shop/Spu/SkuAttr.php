<?php

namespace Weixin\Wx\Model\Shop\Spu;

/**
 * 销售属性
 */
class SkuAttr extends \Weixin\Model\Base
{
    /**
     * attr_key	string	是	销售属性key（自定义）
     */
    public $attr_key = NULL;

    /**
     * attr_value	string	是	销售属性value（自定义
     */
    public $attr_value = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->attr_key)) {
            $params['attr_key'] = $this->attr_key;
        }

        if ($this->isNotNull($this->attr_value)) {
            $params['attr_value'] = $this->attr_value;
        }

        return $params;
    }
}
