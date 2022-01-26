<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 买赠券
 */
class BuygetInfo extends \Weixin\Model\Base
{
    /**
     * buy_out_product_id	string	购买商品商家侧ID，买赠券必需
     */
    public $buy_out_product_id = NULL;

    /**
     * buy_product_cnt	number	购买商品数，买赠券必需
     */
    public $buy_product_cnt = NULL;

    /**
     * get_out_product_id	string	赠送商品商家侧ID，买赠券必需
     */
    public $get_out_product_id = NULL;

    /**
     * get_product_cnt	number	赠送商品数，买赠券必需
     */
    public $get_product_cnt = NULL;


    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->buy_out_product_id)) {
            $params['buy_out_product_id'] = $this->buy_out_product_id;
        }

        if ($this->isNotNull($this->buy_product_cnt)) {
            $params['buy_product_cnt'] = $this->buy_product_cnt;
        }

        if ($this->isNotNull($this->get_out_product_id)) {
            $params['get_out_product_id'] = $this->get_out_product_id;
        }

        if ($this->isNotNull($this->get_product_cnt)) {
            $params['get_product_cnt'] = $this->get_product_cnt;
        }

        return $params;
    }
}
