<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 订单
 */
class Order extends \Weixin\Model\Base
{
    /**
     * create_time	string	是	创建时间，yyyy-MM-dd HH:mm:ss
     */
    public $create_time = NULL;

    /**
     * out_order_id	string	是	商家自定义订单ID
     */
    public $out_order_id = NULL;

    /**
     * openid	string	是	用户的openid
     */
    public $openid = NULL;

    /**
     * path	string	是	商家小程序该订单的页面path，用于微信侧订单中心跳转
     */
    public $path = NULL;

    /**
     * scene	number	是	下单时小程序的场景值，可通getLaunchOptionsSync或onLaunch/onShow拿到
     */
    public $scene = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Order\OrderDetail
     * order_detail	\Weixin\Wx\Model\Shop\Order\OrderDetail	是	商家订单详情
     */
    public $order_detail = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Order\DeliveryDetail
     * delivery_detail	\Weixin\Wx\Model\Shop\Order\DeliveryDetail	物流
     */
    public $delivery_detail = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Order\AddressInfo
     * address_info	\Weixin\Wx\Model\Shop\Order\AddressInfo	否	地址信息
     */
    public $address_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->create_time)) {
            $params['create_time'] = $this->create_time;
        }

        if ($this->isNotNull($this->out_order_id)) {
            $params['out_order_id'] = $this->out_order_id;
        }

        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }

        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }

        if ($this->isNotNull($this->scene)) {
            $params['scene'] = $this->scene;
        }

        if ($this->isNotNull($this->order_detail)) {
            $params['order_detail'] = $this->order_detail->getParams();
        }

        if ($this->isNotNull($this->delivery_detail)) {
            $params['delivery_detail'] = $this->delivery_detail->getParams();
        }

        if ($this->isNotNull($this->address_info)) {
            $params['address_info'] = $this->address_info->getParams();
        }

        return $params;
    }
}
