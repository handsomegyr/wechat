<?php

namespace Weixin\Wx\Model\InsuranceFreightOrder;

/**
 * 商品信息，会展示到物流服务通知和电子面单中
 */
class ProductInfo extends \Weixin\Model\Base
{
    // - order_path	投保订单在商家小程序的path	string	Y	投保订单在商家小程序的path
    public $order_path = NULL;
    // - goods_list	投保订单商品列表	Array	Y	投保商品list，一个元素为对象的数组,结构如下↓
    public $goods_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // - order_path	投保订单在商家小程序的path	string	Y	投保订单在商家小程序的path
        if ($this->isNotNull($this->order_path)) {
            $params['order_path'] = $this->order_path;
        }
        // - goods_list	投保订单商品列表	Array	Y	投保商品list，一个元素为对象的数组,结构如下↓
        if ($this->isNotNull($this->goods_list)) {
            foreach ($this->goods_list as $detail) {
                $params['goods_list'][] = $detail->getParams();
            }
        }

        return $params;
    }
}
