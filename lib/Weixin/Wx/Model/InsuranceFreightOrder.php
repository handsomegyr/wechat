<?php

namespace Weixin\Wx\Model;

/**
 * 投保
 */
class InsuranceFreightOrder extends \Weixin\Model\Base
{
    // openid	买家openid	string	Y	必须和理赔openid一致
    public $openid = NULL;
    // order_no	微信支付单号	string	Y	一个微信支付单号只能投保一次
    public $order_no = NULL;
    // pay_time	微信支付时间	uint32	Y	秒级时间戳，时间误差3天内
    public $pay_time = NULL;
    // pay_amount	微信支付金额	uint32	Y	单位：分
    public $pay_amount = NULL;
    // delivery_no	发货运单号	string	Y
    public $delivery_no = NULL;

    /**
     * @var \Weixin\Wx\Wxa\Business\Model\InsuranceFreightOrder\Place
     * delivery_place	发货地址	object	Y
     */
    public $delivery_place = NULL;

    /**
     * @var \Weixin\Wx\Wxa\Business\Model\InsuranceFreightOrder\Place
     * receipt_place	收货地址	object	Y
     */
    public $receipt_place = NULL;

    /**
     * @var \Weixin\Wx\Wxa\Business\Model\InsuranceFreightOrder\ProductInfo
     * product_info	投保订单信息	object	Y	用于微信下发投保和理赔通知给用户，用户点击可查看投保订单，点击订单可跳回商家小程序
     */
    public $product_info = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // openid	买家openid	string	Y	必须和理赔openid一致
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        // order_no	微信支付单号	string	Y	一个微信支付单号只能投保一次
        if ($this->isNotNull($this->order_no)) {
            $params['order_no'] = $this->order_no;
        }
        // pay_time	微信支付时间	uint32	Y	秒级时间戳，时间误差3天内
        if ($this->isNotNull($this->pay_time)) {
            $params['pay_time'] = $this->pay_time;
        }
        // pay_amount	微信支付金额	uint32	Y	单位：分
        if ($this->isNotNull($this->pay_amount)) {
            $params['pay_amount'] = $this->pay_amount;
        }
        // delivery_no	发货运单号	string	Y
        if ($this->isNotNull($this->delivery_no)) {
            $params['delivery_no'] = $this->delivery_no;
        }
        // delivery_place	发货地址	object	Y
        if ($this->isNotNull($this->delivery_place)) {
            $params['delivery_place'] = $this->delivery_place->getParams();
        }
        // receipt_place	收货地址	object	Y
        if ($this->isNotNull($this->receipt_place)) {
            $params['receipt_place'] = $this->receipt_place->getParams();
        }
        // product_info	投保订单信息	object	Y	用于微信下发投保和理赔通知给用户，用户点击可查看投保订单，点击订单可跳回商家小程序
        if ($this->isNotNull($this->product_info)) {
            $params['product_info'] = $this->product_info->getParams();
        }

        return $params;
    }
}
