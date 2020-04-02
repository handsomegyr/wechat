<?php

namespace Weixin\Qy\Model\LinkedcorpMsg;

/**
 * 文本消息构体
 */
class Text extends \Weixin\Qy\Model\LinkedcorpMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：text
     */
    protected $msgtype = 'text';

    /**
     * content 是 消息内容，最长不超过2048个字节，超过将截断（支持id转译）
     */
    public $content = NULL;

    public function __construct($agentid, $content)
    {
        $this->agentid = $agentid;
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
