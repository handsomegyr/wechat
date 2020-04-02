<?php

namespace Weixin\Qy\Model\Message;

/**
 * 消息类型构体
 */
class Base extends \Weixin\Model\Base
{

    /**
     * touser 否 指定接收消息的成员，成员ID列表（多个接收者用‘|’分隔，最多支持1000个）。特殊情况：指定为”@all”，则向该企业应用的全部成员发送
     */
    public $touser = NULL;

    /**
     * toparty 否 指定接收消息的部门，部门ID列表，多个接收者用‘|’分隔，最多支持100个。当touser为”@all”时忽略本参数
     */
    public $toparty = NULL;

    /**
     * totag 否 指定接收消息的标签，标签ID列表，多个接收者用‘|’分隔，最多支持100个。当touser为”@all”时忽略本参数
     */
    public $totag = NULL;

    /**
     * msgtype 是 消息类型，此时固定为：file
     */
    protected $msgtype = NULL;

    /**
     * agentid 是 企业应用的id，整型。企业内部开发，可在应用的设置页面查看；第三方服务商，可通过接口 获取企业授权信息 获取该参数值
     */
    public $agentid = NULL;

    /**
     * safe 否 表示是否是保密消息，0表示否，1表示是，默认0
     */
    public $safe = NULL;

    /**
     * enable_id_trans 否 表示是否开启id转译，0表示否，1表示是，默认0
     */
    public $enable_id_trans = NULL;

    /**
     * enable_duplicate_check 否 表示是否开启重复消息检查，0表示否，1表示是，默认0
     */
    public $enable_duplicate_check = NULL;

    /**
     * duplicate_check_interval 否 表示是否重复消息检查的时间间隔，默认1800s，最大不超过4小时
     */
    public $duplicate_check_interval = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->touser)) {
            $params['touser'] = $this->touser;
        }
        if ($this->isNotNull($this->toparty)) {
            $params['toparty'] = $this->toparty;
        }
        if ($this->isNotNull($this->totag)) {
            $params['totag'] = $this->totag;
        }
        if ($this->isNotNull($this->msgtype)) {
            $params['msgtype'] = $this->msgtype;
        }
        if ($this->isNotNull($this->agentid)) {
            $params['agentid'] = $this->agentid;
        }
        if ($this->isNotNull($this->safe)) {
            $params['safe'] = $this->safe;
        }
        if ($this->isNotNull($this->enable_id_trans)) {
            $params['enable_id_trans'] = $this->enable_id_trans;
        }
        if ($this->isNotNull($this->enable_duplicate_check)) {
            $params['enable_duplicate_check'] = $this->enable_duplicate_check;
        }
        if ($this->isNotNull($this->duplicate_check_interval)) {
            $params['duplicate_check_interval'] = $this->duplicate_check_interval;
        }

        return $params;
    }
}
