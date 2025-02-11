<?php

/**
 * 小程序客户端总调度器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Channels\Ec;

use Weixin\Channels\Ec\Manager\Product;
use Weixin\Channels\Ec\Manager\Order;
use Weixin\Channels\Ec\Manager\Promoter;
use Weixin\Channels\Ec\Manager\Sharer;
use Weixin\Channels\Ec\Manager\League\Headsupplier;

class Client
{
    private $_client;

    public function __construct(\Weixin\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取商品管理器
     *
     * @return \Weixin\Channels\Ec\Manager\Product
     */
    public function getProductManager()
    {
        return new Product($this->_client);
    }

    /**
     * 获取订单管理器
     *
     * @return \Weixin\Channels\Ec\Manager\Order
     */
    public function getOrderManager()
    {
        return new Order($this->_client);
    }

    /**
     * 获取分享人管理器
     *
     * @return \Weixin\Channels\Ec\Manager\Sharer
     */
    public function getSharerManager()
    {
        return new Sharer($this->_client);
    }


    /**
     * 获取分享人管理器
     *
     * @return \Weixin\Channels\Ec\Manager\League\Headsupplier
     */
    public function getLeagueHeadsupplierManager()
    {
        return new Headsupplier($this->_client);
    }

    /**
     * 获取分享人管理器
     *
     * @return \Weixin\Channels\Ec\Manager\Promoter
     */
    public function getPromoterManager()
    {
        return new Promoter($this->_client);
    }
}
