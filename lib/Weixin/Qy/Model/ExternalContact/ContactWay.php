<?php

namespace Weixin\Qy\Model\ExternalContact;

/**
 * 「联系我」方式构体
 */
class ContactWay extends \Weixin\Model\Base
{

    /**
     * config_id 是 联系方式的配置id
     */
    public $config_id = NULL;

    /**
     * type 是 联系方式类型,1-单人, 2-多人
     */
    public $type = NULL;

    /**
     * scene 是 场景，1-在小程序中联系，2-通过二维码联系
     */
    public $scene = NULL;

    /**
     * style 否 在小程序中联系时使用的控件样式，详见附表
     */
    public $style = NULL;

    /**
     * remark 否 联系方式的备注信息，用于助记，不超过30个字符
     */
    public $remark = NULL;

    /**
     * skip_verify 否 外部客户添加时是否无需验证，默认为true
     */
    public $skip_verify = NULL;

    /**
     * state 否 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值，不超过30个字符
     */
    public $state = NULL;

    /**
     * user 否 使用该联系方式的用户userID列表，在type为1时为必填，且只能有一个
     */
    public $user = NULL;

    /**
     * party 否 使用该联系方式的部门id列表，只在type为2时有效
     */
    public $party = NULL;

    /**
     * is_temp 否 是否临时会话模式，true表示使用临时会话模式，默认为false
     */
    public $is_temp = NULL;

    /**
     * expires_in 否 临时会话二维码有效期，以秒为单位。该参数仅在is_temp为true时有效，默认7天
     */
    public $expires_in = NULL;

    /**
     * chat_expires_in 否 临时会话有效期，以秒为单位。该参数仅在is_temp为true时有效，默认为添加好友后24小时
     */
    public $chat_expires_in = NULL;

    /**
     * unionid 否 可进行临时会话的客户unionid，该参数仅在is_temp为true时有效，如不指定则不进行限制
     */
    public $unionid = NULL;

    /**
     * conclusions 否 结束语，会话结束时自动发送给客户，可参考“结束语定义”，仅在is_temp为true时有效
     *
     * @var \Weixin\Qy\Model\ExternalContact\Conclusion
     */
    public $conclusions = NULL;

    /**
     * qr_code 联系二维码的URL，仅在scene为2时返回
     */
    public $qr_code = NULL;

    public function __construct($type, $scene)
    {
        $this->type = $type;
        $this->scene = $scene;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->config_id)) {
            $params['config_id'] = $this->config_id;
        }

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->scene)) {
            $params['scene'] = $this->scene;
        }
        if ($this->isNotNull($this->style)) {
            $params['style'] = $this->style;
        }
        if ($this->isNotNull($this->remark)) {
            $params['remark'] = $this->remark;
        }
        if ($this->isNotNull($this->skip_verify)) {
            $params['skip_verify'] = $this->skip_verify;
        }
        if ($this->isNotNull($this->state)) {
            $params['state'] = $this->state;
        }
        if ($this->isNotNull($this->user)) {
            $params['user'] = $this->user;
        }
        if ($this->isNotNull($this->party)) {
            $params['party'] = $this->party;
        }
        if ($this->isNotNull($this->is_temp)) {
            $params['is_temp'] = $this->is_temp;
        }
        if ($this->isNotNull($this->expires_in)) {
            $params['expires_in'] = $this->expires_in;
        }
        if ($this->isNotNull($this->chat_expires_in)) {
            $params['chat_expires_in'] = $this->chat_expires_in;
        }
        if ($this->isNotNull($this->unionid)) {
            $params['unionid'] = $this->unionid;
        }
        if ($this->isNotNull($this->conclusions)) {
            $params['conclusions'] = $this->conclusions->getParams();
        }
        if ($this->isNotNull($this->qr_code)) {
            $params['qr_code'] = $this->qr_code;
        }
        return $params;
    }
}
