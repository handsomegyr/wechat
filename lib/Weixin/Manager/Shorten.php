<?php

namespace Weixin\Manager;

use Weixin\Client;

/**
 * 短key托管接口
 * https://developers.weixin.qq.com/doc/offiaccount/Account_Management/KEY_Shortener.html
 *
 * 短key托管类似于短链API，开发者可以通过GenShorten将不超过4KB的长信息转成短key，再通过FetchShorten将短key还原为长信息。
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Shorten
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/shorten/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * GenShorten
     *
     * http请求方式： POST https://api.weixin.qq.com/cgi-bin/shorten/gen?access_token=ACCESS_TOKEN
     *
     * 参数说明
     *
     * 参数 是否必须 类型 说明
     * access_token 是 string 调用接口凭证
     * long_data 是 string 需要转换的长信息，不超过4KB
     * expire_seconds 否 uint32 过期秒数，最大值为2592000（即30天），默认为2592000
     * 错误码
     *
     * 错误码 说明
     * 44002 POST Data为空
     * 47001 POST数据格式错误
     * 47003 参数错误（没有传入long_data）
     * 9410010 long_data长度超过限制
     * 9410011 expire_seconds超过限制
     * -1 系统错误
     * 调用举例
     *
     * curl 'https://api.weixin.qq.com/cgi-bin/shorten/gen?access_token=ACK' -d '{"long_data":"loooooong data", "expire_seconds": 86400}'
     * 返回说明 正常情况下，会返回下述JSON：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "short_key": "iTqRJFSEqk9RvPk"
     * }
     * 参数说明
     *
     * 参数 说明
     * short_key 短key，15字节，base62编码(0-9/a-z/A-Z)
     */
    public function gen($long_data, $expire_seconds = 2592000)
    {
        $params = array();
        $params['long_data'] = $long_data;
        $params['expire_seconds'] = $expire_seconds;
        $rst = $this->_request->post($this->_url . 'gen', $params);
        return $this->_client->rst($rst);
    }

    /**
     * FetchShorten
     *
     * http请求方式： POST https://api.weixin.qq.com/cgi-bin/shorten/fetch?access_token=ACCESS_TOKEN
     *
     * 参数说明
     *
     * 参数 是否必须 类型 说明
     * access_token 是 string 调用接口凭证
     * short_key 是 string 短key
     * 错误码
     *
     * 错误码 说明
     * 44002 POST Data为空
     * 47001 POST数据格式错误
     * 47003 参数错误（没有传入short_key）
     * 9410012 传入的short_key不存在，或者已过期，或者不属于本账号
     * -1 系统错误
     * 调用举例
     *
     * curl 'https://api.weixin.qq.com/cgi-bin/shorten/fetch?access_token=ACCESS_TOKEN' -d '{"short_key": "iTqRJFSEqk9RvPk"}'
     * 返回说明 正常情况下，会返回下述JSON：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "long_data": "loooooong data",
     * "create_time": 1611047541,
     * "expire_seconds": 86300
     * }
     * 参数说明
     *
     * 参数 说明
     * long_data 长信息
     * create_time 创建的时间戳
     * expire_seconds 剩余的过期秒数
     */
    public function fetch($short_key)
    {
        $params = array();
        $params['short_key'] = $short_key;
        $rst = $this->_request->post($this->_url . 'fetch', $params);
        return $this->_client->rst($rst);
    }
}
