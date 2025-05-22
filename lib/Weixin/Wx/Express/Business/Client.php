<?php

/**
 * 小程序物流助手总调度器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 * 
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/testUpdateOrder.html
 *
 */

namespace Weixin\Wx\Express\Business;

use Weixin\Wx\Express\Business\Manager\Path;
use Weixin\Wx\Express\Business\Manager\Order;
use Weixin\Wx\Express\Business\Manager\Quota;
use Weixin\Wx\Express\Business\Manager\Account;
use Weixin\Wx\Express\Business\Manager\Printer;
use Weixin\Wx\Express\Business\Manager\Delivery;

class Client
{
    private $_client;

    public function __construct(\Weixin\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取物流账号管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\Account
     */
    public function getAccountManager()
    {
        return new Account($this->_client);
    }

    /**
     * 获取运单管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\Order
     */
    public function getOrderManager()
    {
        return new Order($this->_client);
    }

    /**
     * 获取快递公司管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\Delivery
     */
    public function getDeliveryManager()
    {
        return new Delivery($this->_client);
    }

    /**
     * 获取运单轨迹管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\Path
     */
    public function getPathManager()
    {
        return new Path($this->_client);
    }

    /**
     * 获取面单打印员管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\Printer
     */
    public function getPrinterManager()
    {
        return new Printer($this->_client);
    }

    /**
     * 获取电子面单余额管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\Quota
     */
    public function getQuotaManager()
    {
        return new Quota($this->_client);
    }
}
