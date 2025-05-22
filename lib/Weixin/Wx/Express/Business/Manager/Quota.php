<?php

namespace Weixin\Wx\Express\Business\Manager;

use Weixin\Client;

/**
 * 电子面单余额管理API
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/getQuota.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Quota
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/cgi-bin/express/business/quota/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 物流助手 /小程序使用 /获取电子面单余额
获取电子面单余额
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
getQuota

功能描述
该接口用于获取电子面单余额。仅在使用加盟类快递公司时，才可以调用。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/quota/get?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.getQuota

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
delivery_id	string	是	快递公司ID，参见getAllDelivery
biz_id	string	是	快递公司客户编码
返回参数
属性	类型	说明
quota_num	number	电子面单余额
errcode	number	接口报错时返回，错误码
errmsg	string	接口报错时返回，错误信息
调用示例
示例说明: HTTPS调用

请求数据示例

{
  "delivery_id": "YTO",
  "biz_id": "xyz"
} 

返回数据示例

{
  "quota_num": 210
} 

示例说明: 云函数调用

请求数据示例

const cloud = require('wx-server-sdk')
cloud.init({
  env: cloud.DYNAMIC_CURRENT_ENV,
})
exports.main = async (event, context) => {
  try {
    const result = await cloud.openapi.logistics.getQuota({
        "deliveryId": 'YTO',
        "bizId": 'xyz'
      })
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
  "quotaNum": 210,
  "errMsg": "openapi.logistics.getQuota:ok"
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
	 */
	public function infoGet($delivery_id, $biz_id)
	{
		// delivery_id	string	是	快递公司ID，参见getAllDelivery
		// biz_id	string	是	快递公司客户编码
		$params = array();
		$params['delivery_id'] = $delivery_id;
		$params['biz_id'] = $biz_id;
		$rst = $this->_request->post($this->_url . 'get', $params);
		return $this->_client->rst($rst);
	}
}
