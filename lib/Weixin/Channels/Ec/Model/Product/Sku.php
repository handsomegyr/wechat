<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 商品SKU
 */
class Sku extends \Weixin\Model\Base
{
    /**
     * skus[].out_sku_id	string	否	商家自定义sku_id，小店后台不作任何唯一性约束，开发者自行保证，一旦添加成功后该字段无法修改，最多128字符
     */
    public $out_sku_id = NULL;

    /**
     * skus[].thumb_img	string	否	sku小图
     */
    public $thumb_img = NULL;

    /**
     * skus[].sale_price	number	是	售卖价格，以分为单位，不超过1000000000（1000万元）
     */
    public $sale_price = NULL;
    /**
     * skus[].stock_num	number	是	库存
     */
    public $stock_num = NULL;
    /**
     * skus[].sku_code	string	否	sku编码，最多100字符
     */
    public $sku_code = NULL;
    /**
     * skus[].sku_attrs[]	array	是	销售属性，每个spu下面的第一个sku的sku_attr.key顺序决定商品详情页规格名称的排序。部分类目有必填的销售属性，具体参考文档获取类目信息中的字段attr.sale_attr_list[].is_required
     */
    public $sku_attrs = NULL;

    /**
     * @var \Weixin\Channels\Ec\Model\Product\Sku\DeliverInfo
     * skus[].sku_deliver_info	number	否	sku库存情况
     */
    public $sku_deliver_info = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_sku_id)) {
            $params['out_sku_id'] = $this->out_sku_id;
        }

        if ($this->isNotNull($this->thumb_img)) {
            $params['thumb_img'] = $this->thumb_img;
        }

        if ($this->isNotNull($this->sale_price)) {
            $params['sale_price'] = $this->sale_price;
        }

        if ($this->isNotNull($this->stock_num)) {
            $params['stock_num'] = $this->stock_num;
        }

        if ($this->isNotNull($this->sku_code)) {
            $params['sku_code'] = $this->sku_code;
        }

        if ($this->isNotNull($this->sku_attrs)) {
            foreach ($this->sku_attrs as $skuAttrInfo) {
                $params['sku_attrs'][] = $skuAttrInfo->getParams();
            }            
        }

        if ($this->isNotNull($this->sku_deliver_info)) {
            $params['sku_deliver_info'] = $this->sku_deliver_info->getParams();
        }

        return $params;
    }
}
