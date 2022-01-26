<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 折扣条件
 */
class DiscountCondition extends \Weixin\Model\Base
{
    /**
     * product_cnt	number	折扣条件所需的商品数
     */
    public $product_cnt = NULL;

    /**
     * product_price	number	折扣条件所需满足的金额
     */
    public $product_price = NULL;

    /**
     * out_product_ids	string array	指定商品商家侧ID，商品券必需
     */
    public $out_product_ids = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\TradeinInfo
     * tradein_info	\Weixin\Wx\Model\Shop\Coupon\TradeinInfo	换购商品商家侧ID，换购券必需
     */
    public $tradein_info = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\BuygetInfo
     * buyget_info	\Weixin\Wx\Model\Shop\Coupon\BuygetInfo	购买商品商家侧ID，买赠券必需
     */
    public $buyget_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->product_cnt)) {
            $params['product_cnt'] = $this->product_cnt;
        }

        if ($this->isNotNull($this->product_price)) {
            $params['product_price'] = $this->product_price;
        }

        if ($this->isNotNull($this->out_product_ids)) {
            $params['out_product_ids'] = $this->out_product_ids;
        }

        if ($this->isNotNull($this->tradein_info)) {
            $params['tradein_info'] = $this->tradein_info->getParams();
        }

        if ($this->isNotNull($this->buyget_info)) {
            $params['buyget_info'] = $this->buyget_info->getParams();
        }

        return $params;
    }
}
