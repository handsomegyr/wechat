<?php

namespace Weixin\Qy\Model\ExternalAttr;

/**
 * 额外属性-小程序类型构体
 */
class Miniprogram extends \Weixin\Qy\Model\ExternalAttr\Base
{
    /**
     * external_attr.type 属性类型: 0-文本 1-网页 2-小程序 是
     */
    protected $type = 2;
    /**
     * external_attr.miniprogram 小程序类型的属性，appid和title字段要么同时为空表示清除改属性，要么同时不为空 type为2时必填
     */
    protected $miniprogram = NULL;

    /**
     * external_attr.miniprogram.appid 小程序appid，必须是有在本企业安装授权的小程序，否则会被忽略 否
     */
    public $appid = NULL;

    /**
     * external_attr.miniprogram.title 小程序的展示标题,长度限制12个UTF8字符 否
     */
    public $title = NULL;

    /**
     * external_attr.miniprogram.pagepath 小程序的页面路径 否
     */
    public $pagepath = NULL;

    public function __construct($name, $appid, $title, $pagepath)
    {
        $this->name = $name;
        $this->appid = $appid;
        $this->title = $title;
        $this->pagepath = $pagepath;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->appid)) {
            $params['miniprogram']['appid'] = $this->appid;
        }

        if ($this->isNotNull($this->title)) {
            $params['miniprogram']['title'] = $this->title;
        }

        if ($this->isNotNull($this->pagepath)) {
            $params['miniprogram']['pagepath'] = $this->pagepath;
        }

        return $params;
    }
}
