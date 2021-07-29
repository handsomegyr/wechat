<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 生物认证
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/soter/soter.verifySignature.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Soter
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/cgi-bin/soter/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * soter.verifySignature
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * SOTER 生物认证秘钥签名验证
	 *
	 * 调用方式：
	 *
	 * HTTPS 调用
	 * 云调用
	 *
	 * HTTPS 调用
	 * 请求地址
	 * POST https://api.weixin.qq.com/cgi-bin/soter/verify_signature?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * openid string 是 用户 openid
	 * json_string string 是 通过 wx.startSoterAuthentication 成功回调获得的 resultJSON 字段
	 * json_signature string 是 通过 wx.startSoterAuthentication 成功回调获得的 resultJSONSignature 字段
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * errmsg string 错误信息
	 * errcode number 错误码
	 * is_ok boolean 验证结果
	 * 请求示例
	 * {
	 * "openid": "$openid",
	 * "json_string": "$resultJSON",
	 * "json_signature": "$resultJSONSignature"
	 * }
	 */
	public function verifySignature($openid, $json_string, $json_signature)
	{
		$params = array();
		$params['openid'] = $openid;
		$params['json_string'] = $json_string;
		$params['json_signature'] = $json_signature;
		$rst = $this->_request->post($this->_url . 'verify_signature', $params);
		return $this->_client->rst($rst);
	}
}
