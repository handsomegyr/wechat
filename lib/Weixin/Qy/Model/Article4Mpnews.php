<?php

namespace Weixin\Qy\Model;

/**
 * 图文构体
 */
class Article4Mpnews extends \Weixin\Model\Base
{

    /**
     * title 是 标题，不超过128个字节，超过会自动截断（支持id转译）
     */
    public $title = NULL;

    /**
     * thumb_media_id 是 图文消息缩略图的media_id, 可以通过素材管理接口获得。此处thumb_media_id即上传接口返回的media_id
     */
    public $thumb_media_id = NULL;

    /**
     * author 否 图文消息的作者，不超过64个字节
     */
    public $author = NULL;

    /**
     * content_source_url 否 图文消息点击“阅读原文”之后的页面链接
     */
    public $content_source_url = NULL;

    /**
     * content 是 图文消息的内容，支持html标签，不超过666 K个字节（支持id转译）
     */
    public $content = NULL;

    /**
     * digest 否 图文消息的描述，不超过512个字节，超过会自动截断（支持id转译）
     */
    public $digest = NULL;

    public function __construct($title, $content, $thumb_media_id)
    {
        $this->title = $title;
        $this->content = $content;
        $this->thumb_media_id = $thumb_media_id;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->thumb_media_id)) {
            $params['thumb_media_id'] = $this->thumb_media_id;
        }
        if ($this->isNotNull($this->author)) {
            $params['author'] = $this->author;
        }
        if ($this->isNotNull($this->content_source_url)) {
            $params['content_source_url'] = $this->content_source_url;
        }
        if ($this->isNotNull($this->content)) {
            $params['content'] = $this->content;
        }
        if ($this->isNotNull($this->digest)) {
            $params['digest'] = $this->digest;
        }
        return $params;
    }
}
