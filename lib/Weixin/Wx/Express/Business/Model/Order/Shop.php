<?php

namespace Weixin\Wx\Express\Business\Model\Order;

/**
 * 商品信息，会展示到物流服务通知和电子面单中
 */
class Shop extends \Weixin\Model\Base
{
    // wxa_path	string	否	商家小程序的路径，建议为订单页面
    public $wxa_path = NULL;
    // img_url	string	否	商品缩略图 url；shop.detail_list为空则必传，shop.detail_list非空可不传。
    public $img_url = NULL;
    // goods_name	string	否	商品名称, 不超过128字节；shop.detail_list为空则必传，shop.detail_list非空可不传。
    public $goods_name = NULL;
    // goods_count	number	否	商品数量；shop.detail_list为空则必传。shop.detail_list非空可不传，默认取shop.detail_list的size
    public $goods_count = NULL;
    // detail_list	Array.<object>	否	商品详情列表，适配多商品场景，用以消息落地页展示。（新规范，新接入商家建议用此字段）
    public $detail_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // wxa_path	string	否	商家小程序的路径，建议为订单页面
        if ($this->isNotNull($this->wxa_path)) {
            $params['wxa_path'] = $this->wxa_path;
        }
        // img_url	string	否	商品缩略图 url；shop.detail_list为空则必传，shop.detail_list非空可不传。
        if ($this->isNotNull($this->img_url)) {
            $params['img_url'] = $this->img_url;
        }
        // goods_name	string	否	商品名称, 不超过128字节；shop.detail_list为空则必传，shop.detail_list非空可不传。
        if ($this->isNotNull($this->goods_name)) {
            $params['goods_name'] = $this->goods_name;
        }
        // goods_count	number	否	商品数量；shop.detail_list为空则必传。shop.detail_list非空可不传，默认取shop.detail_list的size
        if ($this->isNotNull($this->goods_count)) {
            $params['goods_count'] = $this->goods_count;
        }
        // detail_list	Array.<object>	否	商品详情列表，适配多商品场景，用以消息落地页展示。（新规范，新接入商家建议用此字段）
        if ($this->isNotNull($this->detail_list)) {
            foreach ($this->detail_list as $detail) {
                $params['detail_list'][] = $detail->getParams();
            }
        }
        return $params;
    }
}
