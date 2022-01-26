<?php

namespace Weixin\Wx\Model\Shop\Aftersale;

/**
 * 退货相关商品
 */
class ProductInfo extends \Weixin\Model\Base
{
    /**
     * out_product_id	string	是	商家自定义商品ID
     */
    public $out_product_id = NULL;

    /**
     * out_sku_id	string	是	商家自定义sku ID, 如果没有则不填
     */
    public $out_sku_id = NULL;

    /**
     * product_cnt	number	product_infos存在时必填	参与售后的商品数量
     */
    public $product_cnt = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_product_id)) {
            $params['out_product_id'] = $this->out_product_id;
        }

        if ($this->isNotNull($this->out_sku_id)) {
            $params['out_sku_id'] = $this->out_sku_id;
        }

        if ($this->isNotNull($this->product_cnt)) {
            $params['product_cnt'] = $this->product_cnt;
        }

        return $params;
    }
}
