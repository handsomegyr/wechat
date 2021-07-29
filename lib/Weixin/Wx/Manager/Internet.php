<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 网络
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/internet/internet.getUserEncryptKey.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Internet
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * internet.getUserEncryptKey
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 获取用户encryptKey。 会获取用户最近3次的key，每个key的存活时间为3600s。
	 *
	 *
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/business/getuserencryptkey?access_token=ACCESS_TOKEN&openid=OPENID&signature=SIGNATURE&sig_method=hmac_sha256
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * openid string 是 用户的openid
	 * signature string 是 用sessionkey对空字符串签名得到的结果
	 * sig_method string 是 签名方法，只支持 hmac_sha256
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误提示信息
	 * key_info_list Array.<Object> 用户最近三次的加密key列表
	 * errcode 的合法值
	 *
	 * 值 说明 最低版本
	 * 0 请求成功
	 * -1 系统繁忙，此时请开发者稍候再试
	 * key_info_list 的结构
	 *
	 * 属性 类型 说明
	 * encrypt_key string 加密key
	 * iv string 加密iv
	 * version number key的版本号
	 * expire_in number 剩余有效时间
	 * create_time number 创建key的时间戳
	 * 调用示例
	 * curl -X POST "https://api.weixin.qq.com/wxa/business/getuserencryptkey?access_token=ACCESS_TOKEN&openid=OPENID&signature=SIGNATURE&sig_method=hmac_sha256"
	 * 返回结果示例
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "key_info_list":
	 * [
	 * {
	 * "encrypt_key":"VI6BpyrK9XH4i4AIGe86tg==",
	 * "version":10,
	 * "expire_in":3597,
	 * "iv":"6003f73ec441c386",
	 * "create_time":1616572301
	 * },
	 * {
	 * "encrypt_key":"aoUGAHltcliiL9f23oTKHA==",
	 * "version":9,
	 * "expire_in":0,
	 * "iv":"7996656384218dbb",
	 * "create_time":1616504886
	 * },
	 * {
	 * "encrypt_key":"MlZNQNnRQz3zXHHcr6A3mA==",
	 * "version":8,
	 * "expire_in":0,
	 * "iv":"58a1814f88883024",
	 * "create_time":1616488061
	 * }
	 * ]
	 * }
	 */
	public function getUserEncryptKey($openid, $signature, $sig_method = "hmac_sha256")
	{
		$params = array();
		$params['openid'] = $openid;
		$params['signature'] = $signature;
		$params['sig_method'] = $sig_method;
		$rst = $this->_request->post($this->_url . 'wxa/business/getuserencryptkey', $params);
		return $this->_client->rst($rst);
	}
}
