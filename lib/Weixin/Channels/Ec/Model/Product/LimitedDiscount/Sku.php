<?php

namespace Weixin\Channels\Ec\Model\Product\LimitedDiscount;

/**
 * 参与抢购的商品
 */
class Sku extends \Weixin\Model\Base
{
    /**
     * limited_discount_skus[].sku_id	string(uint64)	是	参与抢购的商品ID下，不同规格（SKU）的商品信息
     */
    public $sku_id = NULL;
    /**
     * limited_discount_skus[].sale_price	number	是	SKU的抢购价格，必须小于原价（原价为1分钱的商品无法创建抢购任务）
     */
    public $sale_price = NULL;
    /**
     * limited_discount_skus[].sale_stock	number	是	参与抢购的商品库存，必须小于等于现有库存
     */
    public $sale_stock = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->sku_id)) {
            $params['sku_id'] = $this->sku_id;
        }
        if ($this->isNotNull($this->sale_price)) {
            $params['sale_price'] = $this->sale_price;
        }
        if ($this->isNotNull($this->sale_stock)) {
            $params['sale_stock'] = $this->sale_stock;
        }

        return $params;
    }
}
