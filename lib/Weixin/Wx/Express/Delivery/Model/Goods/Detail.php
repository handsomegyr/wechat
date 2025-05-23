<?php

namespace Weixin\Wx\Express\Delivery\Model\Goods;

/**
 * 商品
 */
class Detail extends \Weixin\Model\Base
{
    // goods_name	string	是	商品名称(最大长度为utf-8编码下的60个字符）
    public $goods_name = NULL;
    // goods_img_url	string	是	商品图片url
    public $goods_img_url = NULL;
    // goods_desc	string	否	商品详情描述，不传默认取“商品名称”值，最多40汉字
    public $goods_desc = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // goods_name	string	是	商品名称(最大长度为utf-8编码下的60个字符）
        if ($this->isNotNull($this->goods_name)) {
            $params['goods_name'] = $this->goods_name;
        }
        // goods_img_url	string	是	商品图片url
        if ($this->isNotNull($this->goods_img_url)) {
            $params['goods_img_url'] = $this->goods_img_url;
        }
        // goods_desc	string	否	商品详情描述，不传默认取“商品名称”值，最多40汉字
        if ($this->isNotNull($this->goods_desc)) {
            $params['goods_desc'] = $this->goods_desc;
        }
        return $params;
    }
}
