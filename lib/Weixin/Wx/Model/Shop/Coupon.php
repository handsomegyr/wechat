<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 优惠券
 */
class Coupon extends \Weixin\Model\Base
{
    /**
     * out_coupon_id	string	商家侧优惠券ID
     */
    public $out_coupon_id = NULL;

    /**
     * type	number	优惠券类型
     */
    public $type = NULL;

    /**
     * promote_type	number	优惠券推广类型
     */
    public $promote_type = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon
     * coupon_info	\Weixin\Wx\Model\Shop\Coupon	优惠券
     */
    public $coupon_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_coupon_id)) {
            $params['out_coupon_id'] = $this->out_coupon_id;
        }

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }

        if ($this->isNotNull($this->promote_type)) {
            $params['promote_type'] = $this->promote_type;
        }

        if ($this->isNotNull($this->coupon_info)) {
            $params['coupon_info'] = $this->coupon_info->getParams();
        }

        return $params;
    }
}
