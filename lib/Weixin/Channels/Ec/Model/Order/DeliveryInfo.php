<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 物流信息
 */
class DeliveryInfo extends \Weixin\Model\Base
{
    /**
     * delivery_id	string	是	快递公司id，通过获取快递公司列表接口获得，非主流快递公司可以填OTHER
     */
    public $delivery_id = NULL;

    /**
     * waybill_id	string	是	快递单号
     */
    public $waybill_id = NULL;

    /**
     * deliver_type	number	是	发货方式，1:自寄快递发货，目前仅支持1
     */
    public $deliver_type = NULL;

    /**
     * product_infos	array DeliveryProductInfo	是	包裹中的商品信息，具体可见结构体DeliveryProductInfo
     */
    public $product_infos = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->delivery_id)) {
            $params['delivery_id'] = $this->delivery_id;
        }
        if ($this->isNotNull($this->waybill_id)) {
            $params['waybill_id'] = $this->waybill_id;
        }
        if ($this->isNotNull($this->deliver_type)) {
            $params['deliver_type'] = $this->deliver_type;
        }
        if ($this->isNotNull($this->product_infos)) {
            foreach ($this->product_infos as $product_info) {
                $params['product_infos'][] = $product_info->getParams();
            }
        }
        return $params;
    }
}
