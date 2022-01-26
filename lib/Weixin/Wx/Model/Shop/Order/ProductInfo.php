<?php

namespace Weixin\Wx\Model\Shop\Order;

/**
 * 商品
 */
class ProductInfo extends \Weixin\Model\Base
{
    /**
     * out_product_id	string	是	商家自定义商品ID
     */
    public $out_product_id = NULL;

    /**
     * out_sku_id	string	是	商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
     */
    public $out_sku_id = NULL;

    /**
     * product_cnt	number	是	购买的数量
     */
    public $product_cnt = NULL;

    /**
     * sale_price	number	是	生成订单时商品的售卖价（单位：分），可以跟上传商品接口的价格不一致
     */
    public $sale_price = NULL;

    /**
     * real_price	number	是	扣除优惠后单件sku的均摊价格（单位：分），如果没优惠则与sale_price一致
     */
    public $real_price = NULL;

    /**
     * head_img	string	是	生成订单时商品的头图
     */
    public $head_img = NULL;

    /**
     * title	string	是	生成订单时商品的标题
     */
    public $title = NULL;

    /**
     * path	string	是	绑定的小程序商品路径
     */
    public $path = NULL;

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

        if ($this->isNotNull($this->sale_price)) {
            $params['sale_price'] = $this->sale_price;
        }

        if ($this->isNotNull($this->real_price)) {
            $params['real_price'] = $this->real_price;
        }

        if ($this->isNotNull($this->head_img)) {
            $params['head_img'] = $this->head_img;
        }

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }

        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }
        return $params;
    }
}
