<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 改价
 */
class ChangeOrderInfo extends \Weixin\Model\Base
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
     * change_price	number	是	订单中该商品修改后的总价，以分为单位
     */
    public $change_price = NULL;

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
        if ($this->isNotNull($this->change_price)) {
            $params['change_price'] = $this->change_price;
        }
        return $params;
    }
}
