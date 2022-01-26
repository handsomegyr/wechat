<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 换购券
 */
class TradeinInfo extends \Weixin\Model\Base
{
    /**
     * out_product_id	string	换购商品商家侧ID，换购券必需
     */
    public $out_product_id = NULL;

    /**
     * price	number	需要支付的金额，单位分，换购券必需
     */
    public $price = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_product_id)) {
            $params['out_product_id'] = $this->out_product_id;
        }

        if ($this->isNotNull($this->price)) {
            $params['price'] = $this->price;
        }

        return $params;
    }
}
