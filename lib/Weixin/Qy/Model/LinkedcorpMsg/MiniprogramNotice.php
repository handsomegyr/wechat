<?php

namespace Weixin\Qy\Model\LinkedcorpMsg;

/**
 * 小程序通知消息构体
 */
class MiniprogramNotice extends \Weixin\Qy\Model\LinkedcorpMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：miniprogram_notice
     */
    protected $msgtype = 'miniprogram_notice';

    /**
     * appid 是 小程序appid，必须是与当前小程序应用关联的小程序
     */
    public $appid = NULL;

    /**
     * page 否 点击消息卡片后的小程序页面，仅限本小程序内的页面。该字段不填则消息点击后不跳转。
     */
    public $page = NULL;

    /**
     * title 是 消息标题，长度限制4-12个汉字（支持id转译）
     */
    public $title = NULL;

    /**
     * description 否 消息描述，长度限制4-12个汉字（支持id转译）
     */
    public $description = NULL;

    /**
     * emphasis_first_item 否 是否放大第一个content_item
     */
    public $emphasis_first_item = NULL;

    /**
     * content_item 否 消息内容键值对，最多允许10个item
     */
    public $content_item = NULL;

    public function __construct($appid, $title)
    {
        $this->title = $title;
        $this->appid = $appid;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->appid)) {
            $params[$this->msgtype]['appid'] = $this->appid;
        }
        if ($this->isNotNull($this->page)) {
            $params[$this->msgtype]['page'] = $this->page;
        }
        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->description)) {
            $params[$this->msgtype]['description'] = $this->description;
        }
        if ($this->isNotNull($this->emphasis_first_item)) {
            $params[$this->msgtype]['emphasis_first_item'] = $this->emphasis_first_item;
        }
        if ($this->isNotNull($this->content_item)) {
            $params[$this->msgtype]['content_item'] = $this->content_item;
        }

        return $params;
    }
}
