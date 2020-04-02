<?php

namespace Weixin\Qy\Model\LinkedcorpMsg;

/**
 * 消息类型构体
 */
class Base extends \Weixin\Model\Base
{

    /**
     * touser 否 成员ID列表（消息接收者，最多支持1000个）。每个元素的格式为： corpid/userid，其中，corpid为该互联成员所属的企业，userid为该互联成员所属企业中的帐号。如果是本企业的成员，则直接传userid即可
     */
    public $touser = NULL;

    /**
     * toparty 否 部门ID列表，最多支持100个。partyid在互联圈子内唯一。每个元素都是字符串类型，格式为：linked_id/party_id，其中linked_id是互联id，party_id是在互联圈子中的部门id。如果是本企业的部门，则直接传party_id即可。
     */
    public $toparty = NULL;

    /**
     * totag 否 本企业的标签ID列表，最多支持100个。
     */
    public $totag = NULL;

    /**
     * toall 否 1表示发送给应用可见范围内的所有人（包括互联企业的成员），默认为0
     */
    public $toall = NULL;

    /**
     * msgtype 是 消息类型，此时固定为：voice
     */
    protected $msgtype = null;

    /**
     * agentid 是 企业应用的id，整型。可在应用的设置页面查看
     */
    public $agentid = NULL;

    /**
     * safe 否 表示是否是保密消息，0表示否，1表示是，默认0
     */
    public $safe = NULL;

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
        if ($this->isNotNull($this->toall)) {
            $params['toall'] = $this->toall;
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

        return $params;
    }
}
