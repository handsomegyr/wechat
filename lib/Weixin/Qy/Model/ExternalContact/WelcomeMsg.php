<?php

namespace Weixin\Qy\Model\ExternalContact;

/**
 * 新客户欢迎语
 * text、image、link和miniprogram四者不能同时为空；
 * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
 * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
 * media_id可以通过素材管理接口获得。
 */
class WelcomeMsg extends \Weixin\Model\Base
{

    /**
     * welcome_code 是 通过添加外部联系人事件推送给企业的发送欢迎语的凭证，有效期为20秒*
     */
    public $welcome_code = NULL;

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

    public function __construct($welcome_code)
    {
        $this->welcome_code = $welcome_code;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->welcome_code)) {
            $params['welcome_code'] = $this->welcome_code;
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
