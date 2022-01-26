<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 发货
 */
class Delivery extends \Weixin\Model\Base
{
    /**
     * order_id number 否 订单ID
     */
    public $order_id = NULL;

    /**
     * out_order_id string 否 商家自定义订单ID，与 order_id 二选一
     */
    public $out_order_id = NULL;

    /**
     * openid string 是 用户的openid
     */
    public $openid = NULL;

    /**
     * finish_all_delivery number 是 发货完成标志位, 0: 未发完, 1:已发完
     */
    public $finish_all_delivery = NULL;

    /**
     * delivery_list	DeliveryInfo[]	否	快递信息，delivery_type=1时必填
     */
    public $delivery_list = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->order_id)) {
            $params['order_id'] = $this->order_id;
        }

        if ($this->isNotNull($this->out_order_id)) {
            $params['out_order_id'] = $this->out_order_id;
        }

        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }

        if ($this->isNotNull($this->finish_all_delivery)) {
            $params['finish_all_delivery'] = $this->finish_all_delivery;
        }

        if ($this->isNotNull($this->delivery_list)) {
            foreach ($this->delivery_list as $delivery_info) {
                $params['delivery_list'][] = $delivery_info->getParams();
            }
        }

        return $params;
    }
}
