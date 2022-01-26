<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 商品
 */
class Spu extends \Weixin\Model\Base
{
    /**
     * out_product_id	string	是	商家自定义商品ID
     */
    public $out_product_id = NULL;

    /**
     * title	string	是	标题
     */
    public $title = NULL;

    /**
     * path	string	是	绑定的小程序商品路径
     */
    public $path = NULL;

    /**
     * head_img	string array	是	主图,多张,列表
     */
    public $head_img = NULL;

    /**
     * qualification_pics	string array	否	商品资质图片
     */
    public $qualification_pics = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Spu\DescInfo
     * desc_info	string	否	商品详情
     */
    public $desc_info = NULL;

    /**
     * third_cat_id	number	是	第三级类目ID
     */
    public $third_cat_id = NULL;

    /**
     * brand_id	number	是	品牌id
     */
    public $brand_id = NULL;

    /**
     * info_version	string	否	预留字段，用于版本控制
     */
    public $info_version = NULL;

    /**
     * skus[]	object array	是	sku数组
     */
    public $skus = NULL;

    /**
     * supplier	string	否	供应商名称
     */
    public $supplier = NULL;

    /**
     * express_fee	number	否	快递费用,以分为单位
     */
    public $express_fee = NULL;

    /**
     * product_type	string	否	商品属性，如：1、预售商品，2、虚拟电子凭证商品，3、自定义
     */
    public $product_type = NULL;

    /**
     * sell_time	string	否	定时上架时间
     */
    public $sell_time = NULL;

    /**
     * pick_up_type	string array	否	配送方式 1快递 2同城 3上门自提 4点餐
     */
    public $pick_up_type = NULL;

    /**
     * onsale	number	否	0-不在售 1-在售
     */
    public $onsale = NULL;

    /**
     * unitname	string	否	商品单位
     */
    public $unitname = NULL;

    /**
     * unitfactor	number	否	包装因子
     */
    public $unitfactor = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_product_id)) {
            $params['out_product_id'] = $this->out_product_id;
        }

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }

        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }

        if ($this->isNotNull($this->head_img)) {
            $params['head_img'] = $this->head_img;
        }

        if ($this->isNotNull($this->qualification_pics)) {
            $params['qualification_pics'] = $this->qualification_pics;
        }

        if ($this->isNotNull($this->desc_info)) {
            $params['desc_info'] = $this->desc_info->getParams();
        }

        if ($this->isNotNull($this->third_cat_id)) {
            $params['third_cat_id'] = $this->third_cat_id;
        }

        if ($this->isNotNull($this->brand_id)) {
            $params['brand_id'] = $this->brand_id;
        }

        if ($this->isNotNull($this->info_version)) {
            $params['info_version'] = $this->info_version;
        }

        if ($this->isNotNull($this->skus)) {
            foreach ($this->skus as $sku) {
                $params['skus'][] = $sku->getParams();
            }
        }

        if ($this->isNotNull($this->supplier)) {
            $params['supplier'] = $this->supplier;
        }

        if ($this->isNotNull($this->express_fee)) {
            $params['express_fee'] = $this->express_fee;
        }

        if ($this->isNotNull($this->product_type)) {
            $params['product_type'] = $this->product_type;
        }

        if ($this->isNotNull($this->sell_time)) {
            $params['sell_time'] = $this->sell_time;
        }
        
        if ($this->isNotNull($this->pick_up_type)) {
            $params['pick_up_type'] = $this->pick_up_type;
        }

        if ($this->isNotNull($this->onsale)) {
            $params['onsale'] = $this->onsale;
        }

        if ($this->isNotNull($this->unitname)) {
            $params['unitname'] = $this->unitname;
        }

        if ($this->isNotNull($this->unitfactor)) {
            $params['unitfactor'] = $this->unitfactor;
        }

        return $params;
    }
}
