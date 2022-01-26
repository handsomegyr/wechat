<?php

namespace Weixin\Wx\Model\Shop\Order;

/**
 * 订单详情
 */
class OrderDetail extends \Weixin\Model\Base
{
    /**
     * product_infos[]	string	是	商家自定义商品
     */
    public $product_infos = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Order\PayInfo
     * pay_info	\Weixin\Wx\Model\Shop\Order\PayInfo	是	支付
     */
    public $pay_info = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Order\PriceInfo
     * price_info	\Weixin\Wx\Model\Shop\Order\PriceInfo	是	该订单最终的实付金额
     */
    public $price_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->product_infos)) {
            foreach ($this->product_infos as $product_info) {
                $params['product_infos'][] = $product_info->getParams();
            }
        }

        if ($this->isNotNull($this->pay_info)) {
            $params['pay_info'] = $this->pay_info->getParams();
        }

        if ($this->isNotNull($this->price_info)) {
            $params['price_info'] = $this->price_info->getParams();
        }

        return $params;
    }
}
