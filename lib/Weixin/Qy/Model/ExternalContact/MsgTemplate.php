<?php

namespace Weixin\Qy\Model\ExternalContact;

/**
 * 企业群发消息任务
 * text、image、link和miniprogram四者不能同时为空；
 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
 * media_id可以通过素材管理接口获得。
 */
class MsgTemplate extends \Weixin\Model\Base
{

    /**
     * chat_type 否 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
     */
    public $chat_type = NULL;

    /**
     * external_userid 否 客户的外部联系人id列表，仅在chat_type为single时有效，不可与sender同时为空，最多可传入1万个客户
     */
    public $external_userid = NULL;

    /**
     * sender 否 发送企业群发消息的成员userid，当类型为发送给客户群时必填
     */
    public $sender = NULL;

    /**
     * text 消息文本
     *
     * @var \Weixin\Qy\Model\ExternalContact\Conclusion\Text
     */
    public $text = NULL;

    /**
     * image 图片
     *
     * @var \Weixin\Qy\Model\ExternalContact\Conclusion\Image
     */
    public $image = NULL;

    /**
     * link 图文消息
     *
     * @var \Weixin\Qy\Model\ExternalContact\Conclusion\Link
     */
    public $link = NULL;

    /**
     * miniprogram 小程序消息
     *
     * @var \Weixin\Qy\Model\ExternalContact\Conclusion\Miniprogram
     */
    public $miniprogram = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->chat_type)) {
            $params['chat_type'] = $this->chat_type;
        }
        if ($this->isNotNull($this->external_userid)) {
            $params['external_userid'] = $this->external_userid;
        }
        if ($this->isNotNull($this->sender)) {
            $params['sender'] = $this->sender;
        }

        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text->getParams();
        }
        if ($this->isNotNull($this->image)) {
            $params['image'] = $this->image->getParams();
        }
        if ($this->isNotNull($this->link)) {
            $params['link'] = $this->link->getParams();
        }
        if ($this->isNotNull($this->miniprogram)) {
            $params['miniprogram'] = $this->miniprogram->getParams();
        }
        return $params;
    }
}
