<?php

namespace Weixin\Qy\Model\AppchatMsg;

/**
 * 文本消息构体
 */
class Text extends \Weixin\Qy\Model\AppchatMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：text
     */
    protected $msgtype = 'text';

    /**
     * 消息内容，最长不超过2048个字节
     */
    public $content = NULL;

    public function __construct($chatid, $content)
    {
        $this->chatid = $chatid;
        $this->content = $content;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->content)) {
            $params[$this->msgtype]['content'] = $this->content;
        }

        return $params;
    }
}
