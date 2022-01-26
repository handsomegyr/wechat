<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 用户优惠券核销
 */
class ExtInfo extends \Weixin\Model\Base
{
    /**
     * use_time	number	用户优惠券核销时间（未核销不填）
     */
    public $use_time = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->use_time)) {
            $params['use_time'] = $this->use_time;
        }

        return $params;
    }
}
