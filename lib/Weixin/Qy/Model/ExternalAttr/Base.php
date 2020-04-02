<?php

namespace Weixin\Qy\Model\ExternalAttr;

/**
 * 对外属性构体
 */
class Base extends \Weixin\Model\Base
{
    /**
     * external_attr.name 属性名称： 需要先确保在管理端有创建该属性，否则会忽略 是
     */
    public $name = NULL;

    /**
     * external_attr.type 属性类型: 0-文本 1-网页 2-小程序 是
     */
    protected $type = null;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }

        return $params;
    }
}
