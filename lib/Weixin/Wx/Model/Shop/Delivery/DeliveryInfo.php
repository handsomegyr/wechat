<?php

namespace Weixin\Wx\Model\Shop\Delivery;

/**
 * 快递信息
 */
class DeliveryInfo extends \Weixin\Model\Base
{
    /**
     * delivery_id	string	是	快递公司ID，通过获取快递公司列表获取
     */
    public $delivery_id = NULL;

    /**
     * waybill_id	string	是	快递单号
     */
    public $waybill_id = NULL;

    /**
     * product_info_list[]	DeliveryProduct[]	是	物流单对应的商品信息
     */
    public $product_info_list = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->delivery_id)) {
            $params['delivery_id'] = $this->delivery_id;
        }

        if ($this->isNotNull($this->waybill_id)) {
            $params['waybill_id'] = $this->waybill_id;
        }

        if ($this->isNotNull($this->product_info_list)) {
            foreach ($this->product_info_list as $delivery_product) {
                $params['product_info_list'][] = $delivery_product->getParams();
            }
        }

        return $params;
    }
}
