<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 用户优惠券
 */
class UserCoupon extends \Weixin\Model\Base
{
    /**
     * out_user_coupon_id	string	商家侧用户优惠券ID
     */
    public $out_user_coupon_id = NULL;

    /**
     * out_coupon_id	string	商家侧优惠券ID
     */
    public $out_coupon_id = NULL;

    /**
     * status	number	用户优惠券状态
     */
    public $status = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\ExtInfo
     * ext_info	number	用户优惠券核销
     */
    public $ext_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_user_coupon_id)) {
            $params['out_user_coupon_id'] = $this->out_user_coupon_id;
        }

        if ($this->isNotNull($this->out_coupon_id)) {
            $params['out_coupon_id'] = $this->out_coupon_id;
        }

        if ($this->isNotNull($this->status)) {
            $params['status'] = $this->status;
        }

        if ($this->isNotNull($this->ext_info)) {
            $params['ext_info'] = $this->ext_info->getParams();
        }

        return $params;
    }
}
