<?php

namespace Weixin\Wx\Model\Shop\Spu;

/**
 * sku信息
 */
class Sku extends \Weixin\Model\Base
{
    /**
     * out_product_id	string	是	商家自定义商品ID
     */
    public $out_product_id = NULL;

    /**
     * out_sku_id	string	是	商家自定义skuID
     */
    public $out_sku_id = NULL;

    /**
     * thumb_img	string	是	sku小图
     */
    public $thumb_img = NULL;

    /**
     * sale_price	number	是	售卖价格,以分为单位
     */
    public $sale_price = NULL;

    /**
     * market_price	number	是	市场价格,以分为单位
     */
    public $market_price = NULL;

    /**
     * stock_num	number	是	库存
     */
    public $stock_num = NULL;

    /**
     * barcode	string	否	条形码
     */
    public $barcode = NULL;

    /**
     * sku_code	string	否	商品编码
     */
    public $sku_code = NULL;

    /**
     * sku_attrs[]	string	是	销售属性
     */
    public $sku_attrs = NULL;

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

        if ($this->isNotNull($this->thumb_img)) {
            $params['thumb_img'] = $this->thumb_img;
        }

        if ($this->isNotNull($this->sale_price)) {
            $params['sale_price'] = $this->sale_price;
        }

        if ($this->isNotNull($this->market_price)) {
            $params['market_price'] = $this->market_price;
        }

        if ($this->isNotNull($this->stock_num)) {
            $params['stock_num'] = $this->stock_num;
        }

        if ($this->isNotNull($this->barcode)) {
            $params['barcode'] = $this->barcode;
        }

        if ($this->isNotNull($this->sku_code)) {
            $params['sku_code'] = $this->sku_code;
        }
        if ($this->isNotNull($this->sku_attrs)) {
            foreach ($this->sku_attrs as $sku_attr) {
                $params['sku_attrs'][] = $sku_attr->getParams();
            }
        }

        return $params;
    }
}
