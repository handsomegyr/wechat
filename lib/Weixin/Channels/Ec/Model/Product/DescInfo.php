<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 商品详情信息
 */
class DescInfo extends \Weixin\Model\Base
{
    /**
     * desc_info[].imgs	array[string]	否	商品详情图片（最少1张，最多20张。其中食品饮料和生鲜类目商品最少3张）。不得有重复图片
     */
    public $imgs = NULL;
    /**
     * desc_info[].desc	string	否	商品详情文本
     */
    public $desc = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->imgs)) {
            $params['imgs'] = $this->imgs;
        }

        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }

        return $params;
    }
}
