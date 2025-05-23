<?php

namespace Weixin\Wx\Express\Delivery\Model;

/**
 * 商品信息
 */
class GoodsInfo extends \Weixin\Model\Base
{
    // detail_list	array	是	商品信息
    public $detail_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // detail_list	array	是	商品信息      
        if ($this->isNotNull($this->detail_list)) {
            foreach ($this->detail_list as $detail) {
                $params['detail_list'][] = $detail->getParams();
            }
        }

        return $params;
    }
}
