<?php

/**
 * 微信物流服务（商家查看）总调度器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 * 
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/industry/express/business/introduction.html
 *
 */

namespace Weixin\Wx\Express\Delivery;

use Weixin\Wx\Express\Delivery\Manager\OpenMsg;

class Client
{
    private $_client;

    public function __construct(\Weixin\Client $client)
    {
        $this->_client = $client;
    }

    /**
     * 获取物流消息能力管理器
     *
     * @return \Weixin\Wx\Express\Business\Manager\OpenMsg
     */
    public function getOpenMsgManager()
    {
        return new OpenMsg($this->_client);
    }
}
