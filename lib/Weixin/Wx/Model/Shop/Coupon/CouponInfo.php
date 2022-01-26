<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 优惠券
 */
class CouponInfo extends \Weixin\Model\Base
{
    /**
     * name	string	优惠券名
     */
    public $name = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\PromoteInfo
     * promote_info	\Weixin\Wx\Model\Shop\Coupon\PromoteInfo	优惠券推广
     */
    public $promote_info = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\DiscountInfo
     * discount_info	\Weixin\Wx\Model\Shop\Coupon\DiscountInfo	折扣
     */
    public $discount_info = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\ReceiveInfo
     * receive_info	\Weixin\Wx\Model\Shop\Coupon\ReceiveInfo	领取
     */
    public $receive_info = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\ValidInfo
     * valid_info	\Weixin\Wx\Model\Shop\Coupon\ValidInfo	有效期
     */
    public $valid_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }

        if ($this->isNotNull($this->promote_info)) {
            $params['promote_info'] = $this->promote_info->getParams();
        }

        if ($this->isNotNull($this->discount_info)) {
            $params['discount_info'] = $this->discount_info->getParams();
        }

        if ($this->isNotNull($this->receive_info)) {
            $params['receive_info'] = $this->receive_info->getParams();
        }

        if ($this->isNotNull($this->valid_info)) {
            $params['valid_info'] = $this->valid_info->getParams();
        }

        return $params;
    }
}
