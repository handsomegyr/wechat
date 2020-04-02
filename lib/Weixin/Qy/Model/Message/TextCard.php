<?php

namespace Weixin\Qy\Model\Message;

/**
 * 文本卡片消息构体
 */
class TextCard extends \Weixin\Qy\Model\Message\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：textcard
     */
    protected $msgtype = 'textcard';

    /**
     * title 是 标题，不超过128个字节，超过会自动截断（支持id转译）
     */
    public $title = NULL;

    /**
     * description 是 描述，不超过512个字节，超过会自动截断（支持id转译）
     */
    public $description = NULL;

    /**
     * url 是 点击后跳转的链接。
     */
    public $url = NULL;

    /**
     * btntxt 否 按钮文字。 默认为“详情”， 不超过4个文字，超过自动截断。
     */
    public $btntxt = NULL;

    public function __construct($agentid, $title, $description, $url, $touser = '@all')
    {
        $this->agentid = $agentid;
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->touser = $touser;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->description)) {
            $params[$this->msgtype]['description'] = $this->description;
        }
        if ($this->isNotNull($this->url)) {
            $params[$this->msgtype]['url'] = $this->url;
        }
        if ($this->isNotNull($this->btntxt)) {
            $params[$this->msgtype]['btntxt'] = $this->btntxt;
        }

        return $params;
    }
}
