<?php

namespace Weixin\Wx\Model\Shop\Order;

/**
 * 发货
 */
class DeliveryDetail extends \Weixin\Model\Base
{
    /**
     * delivery_type	number	是	1: 正常快递, 2: 无需快递, 3: 线下配送, 4: 用户自提 （默认1）
     */
    public $delivery_type = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->delivery_type)) {
            $params['delivery_type'] = $this->delivery_type;
        }

        return $params;
    }
}
