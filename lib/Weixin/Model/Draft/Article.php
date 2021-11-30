<?php

namespace Weixin\Model\Draft;

use Weixin\Model\Base;

/**
 * 草稿结构体信息
 */
class Article extends Base
{
    // title	是	标题
    public $title = NULL;
    // author	否	作者
    public $author = NULL;
    // digest	否	图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空。如果本字段为没有填写，则默认抓取正文前54个字。
    public $digest = NULL;
    // content	是	图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS,涉及图片url必须来源 "上传图文消息内的图片获取URL"接口获取。外部图片url将被过滤。
    public $content = NULL;
    // content_source_url	否	图文消息的原文地址，即点击“阅读原文”后的URL
    public $content_source_url = NULL;
    // thumb_media_id	是	图文消息的封面图片素材id（必须是永久MediaID）
    public $thumb_media_id = NULL;
    // show_cover_pic	否	是否显示封面，0为false，即不显示，1为true，即显示(默认)
    public $show_cover_pic = NULL;
    // need_open_comment	否	Uint32 是否打开评论，0不打开(默认)，1打开
    public $need_open_comment = NULL;
    // only_fans_can_comment	否	Uint32 是否粉丝才可评论，0所有人可评论(默认)，1粉丝才可评论
    public $only_fans_can_comment = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->author)) {
            $params['author'] = $this->author;
        }
        if ($this->isNotNull($this->digest)) {
            $params['digest'] = $this->digest;
        }
        if ($this->isNotNull($this->content)) {
            $params['content'] = $this->content;
        }
        if ($this->isNotNull($this->content_source_url)) {
            $params['content_source_url'] = $this->content_source_url;
        }
        if ($this->isNotNull($this->thumb_media_id)) {
            $params['thumb_media_id'] = $this->thumb_media_id;
        }
        if ($this->isNotNull($this->show_cover_pic)) {
            $params['show_cover_pic'] = $this->show_cover_pic;
        }
        if ($this->isNotNull($this->need_open_comment)) {
            $params['need_open_comment'] = $this->need_open_comment;
        }
        if ($this->isNotNull($this->only_fans_can_comment)) {
            $params['only_fans_can_comment'] = $this->only_fans_can_comment;
        }
        return $params;
    }
}
