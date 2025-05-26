<?php

namespace Weixin\Wx\Model\Funds\Pay;

/**
 * 订单检索条件
 */
class OrderQuery extends \Weixin\Model\Base
{
    // begin_create_time	number	是	起始创建时间，秒级时间戳，（起始和终止时间间隔不能超过1天）
    public $begin_create_time = NULL;
    // end_create_time	number	是	最终创建时间，秒级时间戳，（起始和终止时间间隔不能超过1天）
    public $end_create_time = NULL;
    // mchid	string	否	商户号，不填默认拉取小程序系统内所有订单
    public $mchid = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // begin_create_time	number	是	起始创建时间，秒级时间戳，（起始和终止时间间隔不能超过1天）
        if ($this->isNotNull($this->begin_create_time)) {
            $params['begin_create_time'] = $this->begin_create_time;
        }
        // end_create_time	number	是	最终创建时间，秒级时间戳，（起始和终止时间间隔不能超过1天）
        if ($this->isNotNull($this->end_create_time)) {
            $params['end_create_time'] = $this->end_create_time;
        }
        // mchid	string	否	商户号，不填默认拉取小程序系统内所有订单
        if ($this->isNotNull($this->mchid)) {
            $params['mchid'] = $this->mchid;
        }
        return $params;
    }
}
