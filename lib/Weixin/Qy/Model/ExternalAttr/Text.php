<?php

namespace Weixin\Qy\Model\ExternalAttr;

/**
 * 额外属性-文本构体
 */
class Text extends \Weixin\Qy\Model\ExternalAttr\Base
{
    /**
     * external_attr.type 属性类型: 0-文本 1-网页 2-小程序 是
     */
    protected $type = 0;

    /**
     * external_attr.text 文本类型的属性 type为0时必填
     */
    protected $text = NULL;

    /**
     * external_attr.text.value 文本属性内容,长度限制12个UTF8字符 否
     */
    public $value = NULL;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->value)) {
            $params['text']['value'] = $this->value;
        }

        return $params;
    }
}
