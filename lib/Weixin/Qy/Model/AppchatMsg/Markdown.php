<?php

namespace Weixin\Qy\Model\AppchatMsg;

/**
 * markdown消息构体
 * https://work.weixin.qq.com/api/doc/90000/90135/90236
 */
class Markdown extends \Weixin\Qy\Model\AppchatMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：markdown
     */
    protected $msgtype = 'markdown';

    /**
     * content 是 markdown内容，最长不超过2048个字节，必须是utf8编码
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
