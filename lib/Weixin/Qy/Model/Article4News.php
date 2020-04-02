<?php

namespace Weixin\Qy\Model;

/**
 * 图文构体
 */
class Article4News extends \Weixin\Model\Base
{

    /**
     * title 是 标题，不超过128个字节，超过会自动截断（支持id转译）
     */
    public $title = NULL;

    /**
     * description 否 描述，不超过512个字节，超过会自动截断（支持id转译）
     */
    public $description = NULL;

    /**
     * url 是 点击后跳转的链接。
     */
    public $url = NULL;

    /**
     * picurl 否 图文消息的图片链接，支持JPG、PNG格式，较好的效果为大图 1068*455，小图150*150。
     */
    public $picurl = NULL;

    public function __construct($title, $description, $url)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        if ($this->isNotNull($this->picurl)) {
            $params['picurl'] = $this->picurl;
        }
        return $params;
    }
}
