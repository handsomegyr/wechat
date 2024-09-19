<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 改价
 */
class DeliveryProductInfo extends \Weixin\Model\Base
{
    /**
     * product_id	string	是	商品id
     */
    public $product_id = NULL;

    /**
     * sku_id	string	是	商品sku
     */
    public $sku_id = NULL;

    /**
     * product_cnt	number	是	商品数量
     */
    public $product_cnt = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->product_id)) {
            $params['product_id'] = $this->product_id;
        }
        if ($this->isNotNull($this->sku_id)) {
            $params['sku_id'] = $this->sku_id;
        }
        if ($this->isNotNull($this->product_cnt)) {
            $params['product_cnt'] = $this->product_cnt;
        }
        return $params;
    }
}
