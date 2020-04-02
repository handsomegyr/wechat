<?php

/**
 * 发票控制器
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Qy\Manager\Card;

use Weixin\Qy\Client;
use Weixin\Qy\Manager\Card\Invoice\Reimburse;

class Invoice
{
    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取电子发票对象
     *
     * @return \Weixin\Qy\Manager\Card\Invoice\Reimburse
     */
    public function getReimburseManager()
    {
        return new Reimburse($this->_client);
    }
}
