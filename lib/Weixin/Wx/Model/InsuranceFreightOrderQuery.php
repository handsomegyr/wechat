<?php

namespace Weixin\Wx\Model;

/**
 * 投保查询条件
 */
class InsuranceFreightOrderQuery extends \Weixin\Model\Base
{
    // openid	买家openid	string	N	与投保理赔保持一致
    public $openid = NULL;
    // order_no	微信支付单号	string	N	与投保理赔保持一致
    public $order_no = NULL;
    // policy_no	保单号	string	N
    public $policy_no = NULL;
    // report_no	理赔报案号	string	N
    public $report_no = NULL;
    // delivery_no	发货运单号	string	N
    public $delivery_no = NULL;
    // refund_delivery_no	退款运单号	string	N
    public $refund_delivery_no = NULL;
    // begin_time	查询开始时间	uint32	N	秒级时间戳
    public $begin_time = NULL;
    // end_time	查询结束时间	uint32	N	秒级时间戳
    public $end_time = NULL;
    // status_list	保单状态	array[uint32]	N	状态如下：
    public $status_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // openid	买家openid	string	N	与投保理赔保持一致
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        // order_no	微信支付单号	string	N	与投保理赔保持一致
        if ($this->isNotNull($this->order_no)) {
            $params['order_no'] = $this->order_no;
        }
        // policy_no	保单号	string	N
        if ($this->isNotNull($this->policy_no)) {
            $params['policy_no'] = $this->policy_no;
        }
        // report_no	理赔报案号	string	N
        if ($this->isNotNull($this->report_no)) {
            $params['report_no'] = $this->report_no;
        }
        // delivery_no	发货运单号	string	N
        if ($this->isNotNull($this->delivery_no)) {
            $params['delivery_no'] = $this->delivery_no;
        }
        // refund_delivery_no	退款运单号	string	N
        if ($this->isNotNull($this->refund_delivery_no)) {
            $params['refund_delivery_no'] = $this->refund_delivery_no;
        }
        // begin_time	查询开始时间	uint32	N	秒级时间戳
        if ($this->isNotNull($this->begin_time)) {
            $params['begin_time'] = $this->begin_time;
        }
        // end_time	查询结束时间	uint32	N	秒级时间戳
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }
        // status_list	保单状态	array[uint32]	N	状态如下：
        if ($this->isNotNull($this->status_list)) {
            $params['status_list'] = $this->status_list;
        }

        return $params;
    }
}
