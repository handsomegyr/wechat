<?php

namespace Weixin\Qy\Model\ExternalContact\Conclusion;

/**
 * 消息文本内容构体
 */
class Text extends \Weixin\Model\Base
{

    /**
     * text.content 消息文本内容,最长为4000字节
     */
    public $content = NULL;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->content)) {
            $params['content'] = $this->content;
        }

        return $params;
    }
}
