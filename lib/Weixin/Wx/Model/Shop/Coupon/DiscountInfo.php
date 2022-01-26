<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 折扣
 */
class DiscountInfo extends \Weixin\Model\Base
{
    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\DiscountCondition
     * discount_condition	\Weixin\Wx\Model\Shop\Coupon\DiscountCondition	折扣条件
     */
    public $discount_condition = NULL;

    /**
     * discount_num	number	折扣数,比如5.1折,则填5100,折扣券必需
     */
    public $discount_num = NULL;

    /**
     * discount_fee	number	减金额,单位为分，直减券必需
     */
    public $discount_fee = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->discount_condition)) {
            $params['discount_condition'] = $this->discount_condition->getParams();
        }

        if ($this->isNotNull($this->discount_num)) {
            $params['discount_num'] = $this->discount_num;
        }

        if ($this->isNotNull($this->discount_fee)) {
            $params['discount_fee'] = $this->discount_fee;
        }

        return $params;
    }
}
