<?php

namespace Weixin\Wx\Model\Shop\Delivery;

/**
 * 物流单对应的商品信息
 */
class DeliveryProduct extends \Weixin\Model\Base
{
    /**
     * out_product_id	string	是	订单里的out_product_id
     */
    public $out_product_id = NULL;

    /**
     * out_sku_id	string	是	订单里的out_sku_id
     */
    public $out_sku_id = NULL;

    /**
     * product_cnt	number	是	商品数量
     */
    public $product_cnt = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_product_id)) {
            $params['out_product_id'] = $this->out_product_id;
        }

        if ($this->isNotNull($this->out_sku_id)) {
            $params['out_sku_id'] = $this->out_sku_id;
        }

        if ($this->isNotNull($this->product_cnt)) {
            $params['product_cnt'] = $this->product_cnt;
        }

        return $params;
    }
}
