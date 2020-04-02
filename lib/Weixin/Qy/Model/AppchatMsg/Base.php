<?php

namespace Weixin\Qy\Model\AppchatMsg;

/**
 * 消息类型构体
 */
class Base extends \Weixin\Model\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：file
     */
    protected $msgtype = NULL;

    /**
     * chatid 是 群聊id
     */
    public $chatid = NULL;

    /**
     * safe 否 表示是否是保密消息，0表示否，1表示是，默认0
     */
    public $safe = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->msgtype)) {
            $params['msgtype'] = $this->msgtype;
        }
        if ($this->isNotNull($this->chatid)) {
            $params['chatid'] = $this->chatid;
        }
        if ($this->isNotNull($this->safe)) {
            $params['safe'] = $this->safe;
        }

        return $params;
    }
}
