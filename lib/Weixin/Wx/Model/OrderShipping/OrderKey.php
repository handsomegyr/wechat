<?php

namespace Weixin\Wx\Model\OrderShipping;

/**
 * 订单，需要上传物流信息的订单
 */
class OrderKey extends \Weixin\Model\Base
{
    // order_number_type	number	是	订单单号类型，用于确认需要上传详情的订单。枚举值1，使用下单商户号和商户侧单号；枚举值2，使用微信支付单号。
    public $order_number_type = NULL;
    // transaction_id	string	否	原支付交易对应的微信订单号
    public $transaction_id = NULL;
    // mchid	string	否	支付下单商户的商户号，由微信支付生成并下发。
    public $mchid = NULL;
    // out_trade_no	string	否	商户系统内部订单号，只能是数字、大小写字母`_-*`且在同一个商户号下唯一
    public $out_trade_no = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // order_number_type	number	是	订单单号类型，用于确认需要上传详情的订单。枚举值1，使用下单商户号和商户侧单号；枚举值2，使用微信支付单号。
        if ($this->isNotNull($this->order_number_type)) {
            $params['order_number_type'] = $this->order_number_type;
        }
        // transaction_id	string	否	原支付交易对应的微信订单号
        if ($this->isNotNull($this->transaction_id)) {
            $params['transaction_id'] = $this->transaction_id;
        }
        // mchid	string	否	支付下单商户的商户号，由微信支付生成并下发。
        if ($this->isNotNull($this->mchid)) {
            $params['mchid'] = $this->mchid;
        }
        // out_trade_no	string	否	商户系统内部订单号，只能是数字、大小写字母`_-*`且在同一个商户号下唯一
        if ($this->isNotNull($this->out_trade_no)) {
            $params['out_trade_no'] = $this->out_trade_no;
        }
        return $params;
    }
}
