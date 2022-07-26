<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 手机号
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/phonenumber/phonenumber.getPhoneNumber.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class PhoneNumber
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
	 * 手机号 /getPhoneNumber
	 * phonenumber.getPhoneNumber
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * code换取用户手机号。 每个 code 只能使用一次，code的有效期为5min
	 *
	 * 调用方式：
	 *
	 * HTTPS 调用
	 * 云调用
	 *
	 * HTTPS 调用
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * code string 是 手机号获取凭证
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误提示信息
	 * phone_info Object 用户手机号信息
	 * errcode 的合法值
	 *
	 * 值 说明 最低版本
	 * 0 请求成功
	 * -1 系统繁忙，此时请开发者稍候再试
	 * 40029 不合法的code（code不存在、已过期或者使用过）
	 * phone_info 的结构
	 *
	 * 属性 类型 说明
	 * phoneNumber string 用户绑定的手机号（国外手机号会有区号）
	 * purePhoneNumber string 没有区号的手机号
	 * countryCode string 区号
	 * watermark Object 数据水印
	 * watermark 的结构
	 *
	 * 属性 类型 说明
	 * appid string 小程序appid
	 * timestamp number 用户获取手机号操作的时间戳
	 * 调用示例
	 * curl -H "Accept: application/json" -H "Content-type: application/json" -X POST -d '{"code": "e31968a7f94cc5ee25fafc2aef2773f0bb8c3937b22520eb8ee345274d00c144"}' https://api.weixin.qq.com/wxa/business/getuserphonenumber?access_token=ACCESS_TOKEN&
	 * 返回结果示例
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "phone_info": {
	 * "phoneNumber":"xxxxxx",
	 * "purePhoneNumber": "xxxxxx",
	 * "countryCode": 86,
	 * "watermark": {
	 * "timestamp": 1637744274,
	 * "appid": "xxxx"
	 * }
	 * }
	 * }
	 */
	public function getUserPhoneNumber($code)
	{
		$params = array();
		$params['code'] = $code;
		$rst = $this->_request->post($this->_url . 'wxa/business/getuserphonenumber', $params);
		return $this->_client->rst($rst);
	}
}
