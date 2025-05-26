<?php

namespace Weixin\Wx\Model;

/**
 * 查询订单发货状态条件
 */
class OrderShippingQuery extends \Weixin\Model\Base
{
    /**
     * @var \Weixin\Wx\Model\OrderShipping\PayTimeRange
     * pay_time_range	object	否	支付时间所属范围。
     */
    public $pay_time_range = NULL;
    // order_state	number	否	订单状态枚举：(1) 待发货；(2) 已发货；(3) 确认收货；(4) 交易完成；(5) 已退款；(6) 资金待结算。
    public $order_state = NULL;
    // openid	string	否	支付者openid。
    public $openid = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // pay_time_range	object	否	支付时间所属范围。
        if ($this->isNotNull($this->pay_time_range)) {
            $params['pay_time_range'] = $this->pay_time_range->getParams();
        }

        // order_state	number	否	订单状态枚举：(1) 待发货；(2) 已发货；(3) 确认收货；(4) 交易完成；(5) 已退款；(6) 资金待结算。
        if ($this->isNotNull($this->order_state)) {
            $params['order_state'] = $this->order_state;
        }
        // openid	string	否	支付者openid。
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        return $params;
    }
}
