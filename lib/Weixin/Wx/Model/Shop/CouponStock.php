<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 优惠券库存
 */
class CouponStock extends \Weixin\Model\Base
{
    /**
     * out_coupon_id	string	优惠券商家侧ID
     */
    public $out_coupon_id = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\StockInfo
     * stock_info	number	优惠券库存
     */
    public $stock_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_coupon_id)) {
            $params['out_coupon_id'] = $this->out_coupon_id;
        }

        if ($this->isNotNull($this->stock_info)) {
            $params['stock_info'] = $this->stock_info->getParams();
        }

        return $params;
    }
}
