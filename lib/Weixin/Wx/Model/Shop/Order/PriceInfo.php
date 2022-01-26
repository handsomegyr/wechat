<?php

namespace Weixin\Wx\Model\Shop\Order;

/**
 * 金额
 */
class PriceInfo extends \Weixin\Model\Base
{
    /**
     * order_price	number	是	该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
     */
    public $order_price = NULL;

    /**
     * freight	number	是	运费（单位：分）
     */
    public $freight = NULL;

    /**
     * discounted_price	number	否	优惠金额（单位：分）
     */
    public $discounted_price = NULL;

    /**
     * additional_price	number	否	附加金额（单位：分）
     */
    public $additional_price = NULL;

    /**
     * additional_remarks	string	否	附加金额备注
     */
    public $additional_remarks = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->order_price)) {
            $params['order_price'] = $this->order_price;
        }

        if ($this->isNotNull($this->freight)) {
            $params['freight'] = $this->freight;
        }

        if ($this->isNotNull($this->discounted_price)) {
            $params['discounted_price'] = $this->discounted_price;
        }

        if ($this->isNotNull($this->additional_price)) {
            $params['additional_price'] = $this->additional_price;
        }

        if ($this->isNotNull($this->additional_remarks)) {
            $params['additional_remarks'] = $this->additional_remarks;
        }

        return $params;
    }
}
