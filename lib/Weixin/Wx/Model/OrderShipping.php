<?php

namespace Weixin\Wx\Model;

/**
 * 发货信息
 */
class OrderShipping extends \Weixin\Model\Base
{
    /**
     * @var \Weixin\Wx\Model\OrderShipping\OrderKey
     * order_key	object	是	订单，需要上传物流信息的订单
     */
    public $order_key = NULL;
    // logistics_type	number	是	物流模式，发货方式枚举值：1、实体物流配送采用快递公司进行实体物流配送形式 2、同城配送 3、虚拟商品，虚拟商品，例如话费充值，点卡等，无实体配送形式 4、用户自提
    public $logistics_type = NULL;
    // delivery_mode	number	是	发货模式，发货模式枚举值：1、UNIFIED_DELIVERY（统一发货）2、SPLIT_DELIVERY（分拆发货） 示例值: UNIFIED_DELIVERY
    public $delivery_mode = NULL;
    // is_all_delivered	boolean	否	分拆发货模式时必填，用于标识分拆发货模式下是否已全部发货完成，只有全部发货完成的情况下才会向用户推送发货完成通知。示例值: true/false
    public $is_all_delivered = NULL;
    // shipping_list	array<object>	是	物流信息列表，发货物流单列表，支持统一发货（单个物流单）和分拆发货（多个物流单）两种模式，多重性: [1, 10]
    public $shipping_list = NULL;
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
        // logistics_type	number	是	物流模式，发货方式枚举值：1、实体物流配送采用快递公司进行实体物流配送形式 2、同城配送 3、虚拟商品，虚拟商品，例如话费充值，点卡等，无实体配送形式 4、用户自提
        if ($this->isNotNull($this->logistics_type)) {
            $params['logistics_type'] = $this->logistics_type;
        }
        // delivery_mode	number	是	发货模式，发货模式枚举值：1、UNIFIED_DELIVERY（统一发货）2、SPLIT_DELIVERY（分拆发货） 示例值: UNIFIED_DELIVERY
        if ($this->isNotNull($this->delivery_mode)) {
            $params['delivery_mode'] = $this->delivery_mode;
        }
        // is_all_delivered	boolean	否	分拆发货模式时必填，用于标识分拆发货模式下是否已全部发货完成，只有全部发货完成的情况下才会向用户推送发货完成通知。示例值: true/false
        if ($this->isNotNull($this->is_all_delivered)) {
            $params['is_all_delivered'] = $this->is_all_delivered;
        }
        // shipping_list	array<object>	是	物流信息列表，发货物流单列表，支持统一发货（单个物流单）和分拆发货（多个物流单）两种模式，多重性: [1, 10]
        if ($this->isNotNull($this->shipping_list)) {
            foreach ($this->shipping_list as $detail) {
                $params['shipping_list'][] = $detail->getParams();
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
