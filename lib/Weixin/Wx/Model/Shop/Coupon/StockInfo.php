<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 优惠券库存
 */
class StockInfo extends \Weixin\Model\Base
{
    /**
     * issued_num	number	优惠券剩余量
     */
    public $issued_num = NULL;

    /**
     * receive_num	number	优惠券发放量
     */
    public $receive_num = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->issued_num)) {
            $params['issued_num'] = $this->issued_num;
        }

        if ($this->isNotNull($this->receive_num)) {
            $params['receive_num'] = $this->receive_num;
        }

        return $params;
    }
}
