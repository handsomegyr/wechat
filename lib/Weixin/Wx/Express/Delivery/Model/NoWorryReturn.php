<?php

namespace Weixin\Wx\Express\Delivery\Model;

/**
 * 退货信息
 */
class NoWorryReturn extends \Weixin\Model\Base
{
    // shop_order_id	string	是	商家内部系统使用的退货编号
    public $shop_order_id = NULL;

    /**
     * @var \Weixin\Wx\Express\Delivery\Model\NoWorryReturn\Addr
     * biz_addr	object	是	商家退货地址
     */
    public $biz_addr = NULL;

    /**
     * @var \Weixin\Wx\Express\Delivery\Model\NoWorryReturn\Addr
     * user_addr	object	否	用户购物时的收货地址
     */
    public $user_addr = NULL;

    // openid	string	是	退货用户的openid
    public $openid = NULL;
    // wx_pay_id	string	是	填写已投保的微信支付单号
    public $wx_pay_id = NULL;
    // order_path	string	是	退货订单在商家小程序的path。如投保时已传入订单商品信息，则以投保时传入的为准
    public $order_path = NULL;
    // goods_list	Array	是	退货商品list，一个元素为对象的数组,结构如下↓ 如投保时已传入订单商品信息，则以投保时传入的为准
    public $goods_list = NULL;

    // "order_price":1//退货订单的价格,
    public $order_price = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // shop_order_id	string	是	商家内部系统使用的退货编号
        if ($this->isNotNull($this->shop_order_id)) {
            $params['shop_order_id'] = $this->shop_order_id;
        }
        // biz_addr	object	是	商家退货地址
        if ($this->isNotNull($this->biz_addr)) {
            $params['biz_addr'] = $this->biz_addr->getParams();
        }
        // user_addr	object	否	用户购物时的收货地址
        if ($this->isNotNull($this->user_addr)) {
            $params['user_addr'] = $this->user_addr->getParams();
        }
        // openid	string	是	退货用户的openid
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        // wx_pay_id	string	是	填写已投保的微信支付单号
        if ($this->isNotNull($this->wx_pay_id)) {
            $params['wx_pay_id'] = $this->wx_pay_id;
        }
        // order_path	string	是	退货订单在商家小程序的path。如投保时已传入订单商品信息，则以投保时传入的为准
        if ($this->isNotNull($this->order_path)) {
            $params['order_path'] = $this->order_path;
        }
        // goods_list	Array	是	退货商品list，一个元素为对象的数组,结构如下↓ 如投保时已传入订单商品信息，则以投保时传入的为准
        if ($this->isNotNull($this->goods_list)) {
            foreach ($this->goods_list as $detail) {
                $params['goods_list'][] = $detail->getParams();
            }
        }
        // order_price 退货订单的价格
        if ($this->isNotNull($this->order_price)) {
            $params['order_price'] = $this->order_price;
        }
        return $params;
    }
}
