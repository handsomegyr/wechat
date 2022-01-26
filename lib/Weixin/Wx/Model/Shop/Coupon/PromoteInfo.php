<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 优惠券推广
 */
class PromoteInfo extends \Weixin\Model\Base
{
    /**
     * promote_type	number	优惠券推广类型
     */
    public $promote_type = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Coupon\Finder
     * finder	\Weixin\Wx\Model\Shop\Coupon\Finder	推广视频号
     */
    public $finder = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->promote_type)) {
            $params['promote_type'] = $this->promote_type;
        }

        if ($this->isNotNull($this->finder)) {
            $params['finder'] = $this->finder->getParams();
        }

        return $params;
    }
}
