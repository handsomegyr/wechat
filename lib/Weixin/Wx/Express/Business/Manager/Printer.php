<?php

namespace Weixin\Wx\Express\Business\Manager;

use Weixin\Client;

/**
 * 面单打印员管理API
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/updatePrinter.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Printer
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/cgi-bin/express/business/printer/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 物流助手 /小程序使用 /配置面单打印员
配置面单打印员
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
updatePrinter

功能描述
该接口用于配置面单打印员，可以设置多个，若需要使用微信打单 PC 软件，才需要调用。
注：面单打印员不需要为小程序项目成员。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/printer/update?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.updatePrinter

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
openid	string	是	打印员 openid
update_type	string	是	更新类型。bind表示绑定；unbind表示解除绑定。
tagid_list	string	否	用于平台型小程序设置入驻方的打印员面单打印权限，同一打印员最多支持10个tagid，使用半角逗号分隔，中间不加空格，如填写123,456，表示该打印员可以拉取到tagid为123和456的下的单，非平台型小程序无需填写该字段
返回参数
属性	类型	说明
errcode	number	错误码
errmsg	string	错误信息
调用示例
示例说明: HTTPS调用

请求数据示例

{
  "openid": "oJ4v0wRAfiXcnIbM3SgGEUkTw3Qw",
  "update_type": "bind",
  "tagid_list": "123,456"
} 

返回数据示例

{
  "errcode": 0,
  "errmsg": "ok"
} 

示例说明: 云函数调用

请求数据示例

const cloud = require('wx-server-sdk')
cloud.init({
  env: cloud.DYNAMIC_CURRENT_ENV,
})
exports.main = async (event, context) => {
  try {
    const result = await cloud.openapi.logistics.updatePrinter({
        "openid": 'oJ4v0wRAfiXcnIbM3SgGEUkTw3Qw',
        "updateType": 'bind',
        "tagidList": '123,456'
      })
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
  "errCode": 0,
  "errMsg": "openapi.logistics.updatePrinter:ok"
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
	 */
	public function update($openid, $update_type, $tagid_list)
	{
		// openid	string	是	打印员 openid
		// update_type	string	是	更新类型。bind表示绑定；unbind表示解除绑定。
		// tagid_list	string	否	用于平台型小程序设置入驻方的打印员面单打印权限，同一打印员最多支持10个tagid，使用半角逗号分隔，中间不加空格，如填写123,456，表示该打印员可以拉取到tagid为123和456的下的单，非平台型小程序无需填写该字段

		$params = array();
		$params['openid'] = $openid;
		$params['update_type'] = $update_type;

		if (!empty($tagid_list)) {
			$params['tagid_list'] = $tagid_list;
		}
		$rst = $this->_request->post($this->_url . 'update', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 物流助手 /小程序使用 /获取打印员
获取打印员
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
getPrinter

功能描述
该接口用于获取打印员。若需要使用微信打单 PC 软件，才需要调用。

调用方式
HTTPS 调用

GET https://api.weixin.qq.com/cgi-bin/express/business/printer/getall?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.getPrinter

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
返回参数
属性	类型	说明
count	number	打印员数量
openid	array<string>	打印员openid
tagid_list	array<string>	tagid列表
调用示例
示例说明: HTTPS调用

请求数据示例

GET https://api.weixin.qq.com/cgi-bin/express/business/printer/getall?access_token=ACCESS_TOKEN 

返回数据示例

{
 "count": 2,
 "openid": [
   "oABC",
   "oXYZ"
 ],
 "tagid_list": [
   "123",
   "456"
 ]
} 

示例说明: 云函数调用

请求数据示例

const cloud = require('wx-server-sdk')
cloud.init({
  env: cloud.DYNAMIC_CURRENT_ENV,
})
exports.main = async (event, context) => {
  try {
    const result = await cloud.openapi.logistics.getPrinter({})
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
 "count": 2,
 "openid": [
   "oABC",
   "oXYZ"
 ],
 "tagid_list": [
   "123",
   "456"
 ]
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
	 */
	public function getAll()
	{
		$params = array();
		$rst = $this->_request->get($this->_url . 'getall', $params);
		return $this->_client->rst($rst);
	}
}
