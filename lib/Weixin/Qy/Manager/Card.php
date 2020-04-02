<?php

/**
 * 卡控制器
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;
use Weixin\Qy\Manager\Card\Invoice;

class Card
{

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取发票对象
     *
     * @return \Weixin\Qy\Manager\Card\Invoice
     */
    public function getInvoiceManager()
    {
        return new Invoice($this->_client);
    }
}
