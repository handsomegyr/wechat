<?php
namespace Weixin\Manager\Shakearound;

use Weixin\Client;

/**
 * 设备信息
 *
 * @author happy
 *
 */
class User
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shakearound/user/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     *  获取设备及用户信息
     *  接口说明
     *  获取设备信息，包括UUID、major、minor，以及距离、openID等信息。
     */
    public function getShakeInfo($ticket,$need_poi=1){
        $params=array(
            "ticket"=>$ticket,
            "need_poi"=>$need_poi
        );
        $rst = $this->_request->post($this->_url . 'getshakeinfo', $params);
        return $this->_client->rst($rst);
    }
}
