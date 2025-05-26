<?php

namespace Weixin\Wx\Model;

/**
 * 发货信息
 */
class OrderShippingCombined extends \Weixin\Model\Base
{
    /**
     * @var \Weixin\Wx\Model\OrderShipping\OrderKey
     * order_key	object	是	订单，需要上传物流信息的订单
     */
    public $order_key = NULL;
    // sub_orders	array<object>	否	子单物流详情 object 是 \Weixin\Wx\Model\OrderShipping
    public $sub_orders = NULL;
    // upload_time	string	是	上传时间，用于标识请求的先后顺序 示例值: `2022-12-15T13:29:35.120+08:00`
    public $upload_time = NULL;

    /**
     * @var \Weixin\Wx\Model\OrderShipping\Payer
     * payer	object	是	支付者，支付者信息
     */
    public $payer = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // order_key	object	是	订单，需要上传物流信息的订单
        if ($this->isNotNull($this->order_key)) {
            $params['order_key'] = $this->order_key->getParams();
        }
        // sub_orders	array<object>	否	子单物流详情
        if ($this->isNotNull($this->sub_orders)) {
            foreach ($this->sub_orders as $detail) {
                $params['sub_orders'][] = $detail->getParams();
            }
        }
        // upload_time	string	是	上传时间，用于标识请求的先后顺序 示例值: `2022-12-15T13:29:35.120+08:00`
        if ($this->isNotNull($this->upload_time)) {
            $params['upload_time'] = $this->upload_time;
        }
        // payer	object	是	支付者，支付者信息
        if ($this->isNotNull($this->payer)) {
            $params['payer'] = $this->payer->getParams();
        }

        return $params;
    }
}
