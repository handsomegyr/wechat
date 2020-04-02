<?php

namespace Weixin\Qy\Model\AppchatMsg;

/**
 * 图文消息构体
 */
class Mpnews extends \Weixin\Qy\Model\AppchatMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：mpnews
     */
    protected $msgtype = 'mpnews';

    /**
     * articles 是 图文消息，一个图文消息支持1到8条图文
     */
    public $articles = NULL;

    public function __construct($chatid, array $articles)
    {
        $this->chatid = $chatid;
        $this->articles = $articles;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if (!empty($this->articles)) {
            foreach ($this->articles as $article) {
                $params[$this->msgtype]['articles'][] = $article->getParams();
            }
        }

        return $params;
    }
}
