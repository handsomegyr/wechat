<?php

namespace Weixin\Qy\Model\ExternalContact\Conclusion;

/**
 * 图文消息构体
 */
class Link extends \Weixin\Model\Base
{

    /**
     * link.title 图文消息标题，最长为128字节
     */
    public $title = NULL;

    /**
     * link.picurl 图文消息封面的url
     */
    public $picurl = NULL;

    /**
     * link.desc 图文消息的描述，最长为512字节
     */
    public $desc = NULL;

    /**
     * link.url 图文消息的链接
     */
    public $url = NULL;

    public function __construct($title, $picurl, $desc, $url)
    {
        $this->title = $title;
        $this->picurl = $picurl;
        $this->desc = $desc;
        $this->url = $url;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->picurl)) {
            $params['picurl'] = $this->picurl;
        }
        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        return $params;
    }
}
