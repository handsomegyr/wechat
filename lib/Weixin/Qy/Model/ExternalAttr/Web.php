<?php

namespace Weixin\Qy\Model\ExternalAttr;

/**
 * 额外属性-网页类型构体
 */
class Web extends \Weixin\Qy\Model\ExternalAttr\Base
{
    /**
     * external_attr.type 属性类型: 0-文本 1-网页 2-小程序 是
     */
    protected $type = 1;

    /**
     * external_attr.web 网页类型的属性，url和title字段要么同时为空表示清除该属性，要么同时不为空 type为1时必填
     */
    protected $web = NULL;

    /**
     * external_attr.web.url 网页的url,必须包含http或者https头 否
     */
    public $url = NULL;

    /**
     * external_attr.web.title 网页的展示标题,长度限制12个UTF8字符 否
     */
    public $title = NULL;

    public function __construct($name, $url, $title)
    {
        $this->name = $name;
        $this->url = $url;
        $this->title = $title;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->url)) {
            $params['web']['url'] = $this->url;
        }

        if ($this->isNotNull($this->title)) {
            $params['web']['title'] = $this->title;
        }

        return $params;
    }
}
