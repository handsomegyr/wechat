<?php

namespace Weixin\Qy\Model;

/**
 * 回调信息构体
 */
class Callback extends \Weixin\Model\Base
{

    /**
     * url 否 企业应用接收企业微信推送请求的访问协议和地址，支持http或https协议
     */
    public $url = NULL;

    /**
     * token 否 用于生成签名
     */
    public $token = NULL;

    /**
     * encodingaeskey 否 用于消息体的加密，是AES密钥的Base64编码
     */
    public $encodingaeskey = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        if ($this->isNotNull($this->token)) {
            $params['token'] = $this->token;
        }
        if ($this->isNotNull($this->encodingaeskey)) {
            $params['encodingaeskey'] = $this->encodingaeskey;
        }
        return $params;
    }
}
