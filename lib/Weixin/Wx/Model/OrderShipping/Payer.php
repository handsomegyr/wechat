<?php

namespace Weixin\Wx\Model\OrderShipping;

/**
 * 支付者，支付者信息
 */
class Payer extends \Weixin\Model\Base
{
    // openid	string	是	用户标识，用户在小程序appid下的唯一标识。 下单前需获取到用户的Openid 示例值: oUpF8uMuAJO_M2pxb1Q9zNjWeS6o 字符字节限制: [1, 128]
    public $openid = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // openid	string	是	用户标识，用户在小程序appid下的唯一标识。 下单前需获取到用户的Openid 示例值: oUpF8uMuAJO_M2pxb1Q9zNjWeS6o 字符字节限制: [1, 128]
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        return $params;
    }
}
