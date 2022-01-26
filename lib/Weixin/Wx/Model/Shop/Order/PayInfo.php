<?php

namespace Weixin\Wx\Model\Shop\Order;

/**
 * 付款
 */
class PayInfo extends \Weixin\Model\Base
{
    /**
     * pay_method_type	number	是	支付方式，0，微信支付，1: 货到付款，2：商家会员储蓄卡（默认0）
     */
    public $pay_method_type = NULL;

    /**
     * prepay_id	string	否	预支付ID，支付方式为“微信支付”必填
     */
    public $prepay_id = NULL;

    /**
     * prepay_time	string	否	预付款时间（拿到prepay_id的时间）， 支付方式为“微信支付”必填，yyyy-MM-dd HH:mm:ss
     */
    public $prepay_time = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->pay_method_type)) {
            $params['pay_method_type'] = $this->pay_method_type;
        }

        if ($this->isNotNull($this->prepay_id)) {
            $params['prepay_id'] = $this->prepay_id;
        }

        if ($this->isNotNull($this->prepay_time)) {
            $params['prepay_time'] = $this->prepay_time;
        }

        return $params;
    }
}
