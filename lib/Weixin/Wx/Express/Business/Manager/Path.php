<?php

namespace Weixin\Wx\Express\Business\Manager;

use Weixin\Client;

/**
 * 运单轨迹管理API
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/getPath.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Path
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/cgi-bin/express/business/path/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 物流助手 /小程序使用 /查询运单轨迹
查询运单轨迹
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
getPath

功能描述
该接口用于查询运单轨迹。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/path/get?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.getPath

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
openid	string	否	用户openid，当add_source=2时无需填写（不发送物流服务通知）
delivery_id	string	是	快递公司ID，参见getAllDelivery
waybill_id	string	是	运单ID
返回参数
属性	类型	说明
openid	string	用户openid
delivery_id	string	快递公司 ID
waybill_id	string	运单 ID
path_item_num	number	轨迹节点数量
path_item_list	array<object>	轨迹节点列表
属性	类型	说明
action_time	number	轨迹节点 Unix 时间戳
action_type	number	轨迹节点类型
action_msg	string	轨迹节点详情
其他说明
action_type 的合法值
值	说明
100001	揽件阶段-揽件成功
100002	揽件阶段-揽件失败
100003	揽件阶段-分配业务员
200001	运输阶段-更新运输轨迹
300002	派送阶段-开始派送
300003	派送阶段-签收成功
300004	派送阶段-签收失败
400001	异常阶段-订单取消
400002	异常阶段-订单滞留
调用示例
示例说明: HTTPS调用

请求数据示例

{
  "order_id": "01234567890123456789",
  "openid": "oABC123456",
  "delivery_id": "SF",
  "waybill_id": "123456789"
} 

返回数据示例

{
  "openid": "OPENID",
  "delivery_id": "SF",
  "waybill_id": "12345678901234567890",
  "path_item_num": 3,
  "path_item_list": [
    {
      "action_time": 1533052800,
      "action_type": 100001,
      "action_msg": "快递员已成功取件"
    },
    {
      "action_time": 1533062800,
      "action_type": 200001,
      "action_msg": "快件已到达xxx集散中心，准备发往xxx"
    },
    {
      "action_time": 1533072800,
      "action_type": 300001,
      "action_msg": "快递员已出发，联系电话xxxxxx"
    }
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
    const result = await cloud.openapi.logistics.getPath({
        "openid": 'oABC123456',
        "orderId": '01234567890123456789',
        "deliveryId": 'SF',
        "waybillId": '123456789'
      })
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
  "openid": "OPENID",
  "deliveryId": "SF",
  "waybillId": "12345678901234567890",
  "pathItemNum": 3,
  "pathItemList": [
    {
      "actionTime": 1533052800,
      "actionType": 100001,
      "actionMsg": "快递员已成功取件"
    },
    {
      "actionTime": 1533062800,
      "actionType": 200001,
      "actionMsg": "快件已到达xxx集散中心，准备发往xxx"
    },
    {
      "actionTime": 1533072800,
      "actionType": 300001,
      "actionMsg": "快递员已出发，联系电话xxxxxx"
    }
  ],
  "errMsg": "openapi.logistics.getPath:ok"
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
	 */
	public function infoGet($openid, $delivery_id, $waybill_id)
	{
		// openid	string	否	用户openid，当add_source=2时无需填写（不发送物流服务通知）
		// delivery_id	string	是	快递公司ID，参见getAllDelivery
		// waybill_id	string	是	运单ID

		$params = array();
		if (! empty($openid)) {
			$params['openid'] = $openid;
		}
		$params['delivery_id'] = $delivery_id;
		$params['waybill_id'] = $waybill_id;
		$rst = $this->_request->post($this->_url . 'get', $params);
		return $this->_client->rst($rst);
	}
}
