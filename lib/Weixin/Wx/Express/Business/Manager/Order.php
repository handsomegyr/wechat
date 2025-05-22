<?php

namespace Weixin\Wx\Express\Business\Manager;

use Weixin\Client;

/**
 * 运单管理API
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/cancelOrder.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class Order
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/express/business/order/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 物流助手 /小程序使用 /取消运单
取消运单
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
cancelOrder

功能描述
该接口用于取消运单。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/order/cancel?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.cancelOrder

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
order_id	string	是	订单 ID，需保证全局唯一
返回参数
属性	类型	说明
errcode	number	错误码
errmsg	string	错误信息
delivery_resultcode	number	运力返回的错误码
delivery_resultmsg	string	运力返回的错误信息
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
  "errcode": 0,
  "errmsg": "ok",
  "delivery_resultcode": 0,
  "delivery_resultmsg": ""
} 

示例说明: 云函数调用

请求数据示例

const cloud = require('wx-server-sdk')
cloud.init({
  env: cloud.DYNAMIC_CURRENT_ENV,
})
exports.main = async (event, context) => {
  try {
    const result = await cloud.openapi.logistics.cancelOrder({
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
  "errCode": 0,
  "errMsg": "openapi.logistics.cancelOrder:ok",
  "deliveryResultcode": 0,
  "deliveryResultmsg": ""
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function cancel(
        $openid,
        $delivery_id,
        $waybill_id,
        $order_id
    ) {
        // openid	string	否	用户openid，当add_source=2时无需填写（不发送物流服务通知）
        // delivery_id	string	是	快递公司ID，参见getAllDelivery
        // waybill_id	string	是	运单ID
        // order_id	string	是	订单 ID，需保证全局唯一
        $params = array();
        $params['delivery_id'] = $delivery_id;
        $params['waybill_id'] = $waybill_id;
        $params['order_id'] = $order_id;
        if (!empty($openid)) {
            $params['openid'] = $openid;
        }
        $rst = $this->_request->post($this->_url . 'cancel', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 物流助手 /小程序使用 /获取运单数据
获取运单数据
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
getOrder

功能描述
该接口用于获取运单数据。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/order/get?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.getOrder

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
order_id	string	是	订单 ID，需保证全局唯一
openid	string	否	该参数仅在getOrder接口生效，batchGetOrder接口不生效。用户openid，当add_source=2时无需填写（不发送物流服务通知）
delivery_id	string	是	快递公司ID，参见getAllDelivery, 必须和waybill_id对应
waybill_id	string	否	运单ID
print_type	number	否	该参数仅在getOrder接口生效，batchGetOrder接口不生效。获取打印面单类型【1：一联单，0：二联单】，默认获取二联单
custom_remark	string	否	
返回参数
属性	类型	说明
errcode	number	错误码
errmsg	string	错误信息
print_html	string	运单 html 的 BASE64 结果
waybill_data	array<object>	运单信息
属性	类型	说明
key	string	运单信息 key
value	string	运单信息 value
order_id	string	订单ID
delivery_id	string	快递公司ID
waybill_id	string	运单号
order_status	number	运单状态, 0正常，1取消
调用示例
示例说明: HTTPS调用

请求数据示例

{
  "order_id": "01234567890123456789",
  "openid": "oABC123456",
  "delivery_id": "SF",
  "waybill_id": "123456789",
  "print_type":1
} 

返回数据示例

{
  "print_html": "jh7DjipP4ul4CQYUh69cniskrQZuOPwa1inAbXIqKbU0t71c0s65Au54cdWBZW0QJY4LYeofdM",
  "waybill_data": [
    {
      "key": "SF_bagAddr",
      "value": "广州"
    },
    {
      "key": "SF_mark",
      "value": "101- 07-03 509"
    }
  ],
  "delivery_id": "SF",
  "waybill_id": "123456",
  "order_id": "123456",
  "order_status": 0
} 

示例说明: 云函数调用

请求数据示例

const cloud = require('wx-server-sdk')
cloud.init({
  env: cloud.DYNAMIC_CURRENT_ENV,
})
exports.main = async (event, context) => {
  try {
    const result = await cloud.openapi.logistics.getOrder({
        "openid": 'oABC123456',
        "orderId": '01234567890123456789',
        "deliveryId": 'SF',
        "waybillId": '123456789',
        "printType": 1
      })
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
  "print_html": "jh7DjipP4ul4CQYUh69cniskrQZuOPwa1inAbXIqKbU0t71c0s65Au54cdWBZW0QJY4LYeofdM",
  "waybill_data": [
    {
      "key": "SF_bagAddr",
      "value": "广州"
    },
    {
      "key": "SF_mark",
      "value": "101- 07-03 509"
    }
  ],
  "delivery_id": "SF",
  "waybill_id": "123456",
  "order_id": "123456",
  "order_status": 0
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function infoGet($order_id, $openid, $delivery_id, $waybill_id, $custom_remark)
    {
        // order_id	string	是	订单 ID，需保证全局唯一
        // openid	string	否	该参数仅在getOrder接口生效，batchGetOrder接口不生效。用户openid，当add_source=2时无需填写（不发送物流服务通知）
        // delivery_id	string	是	快递公司ID，参见getAllDelivery, 必须和waybill_id对应
        // waybill_id	string	否	运单ID
        // print_type	number	否	该参数仅在getOrder接口生效，batchGetOrder接口不生效。获取打印面单类型【1：一联单，0：二联单】，默认获取二联单
        // custom_remark	string	否

        $params = array();
        $params['order_id'] = $order_id;
        if (!empty($openid)) {
            $params['openid'] = $openid;
        }
        $params['delivery_id'] = $delivery_id;

        if (!empty($waybill_id)) {
            $params['waybill_id'] = $waybill_id;
        }
        if (!empty($print_type)) {
            $params['print_type'] = $print_type;
        }
        if (!empty($custom_remark)) {
            $params['custom_remark'] = $custom_remark;
        }

        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 物流助手 /小程序使用 /模拟更新订单状态
模拟更新订单状态
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

接口说明
接口英文名
testUpdateOrder

功能描述
该接口用于模拟快递公司更新订单状态, 该接口只能用户测试。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/test_update_order?access_token=ACCESS_TOKEN 

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
biz_id	string	是	商户id,需填test_biz_id
order_id	string	是	订单号
delivery_id	string	是	快递公司id,需填TEST
waybill_id	string	是	运单号
action_time	number	是	轨迹变化 Unix 时间戳
action_type	number	是	轨迹变化类型
action_msg	string	是	轨迹变化具体信息说明,使用UTF-8编码
返回参数
属性	类型	说明
errcode	number	错误码
errmsg	string	错误信息
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
  "biz_id": "test_biz_id",
  "order_id": "xxxxxxxxxxxx",
  "delivery_id": "TEST",
  "waybill_id": "xxxxxxxxxx",
  "action_time": 123456789,
  "action_type": 100001,
  "action_msg": "揽件阶段"
} 

返回数据示例

{
  "errcode": 0,
  "errmsg": "ok"
} 

错误码
错误码	错误码取值	解决方案
-1	system error	系统繁忙，此时请开发者稍候再试
     */
    public function testUpdateOrder($biz_id, $order_id, $delivery_id, $waybill_id, $action_time, $action_type, $action_msg)
    {
        // biz_id	string	是	商户id,需填test_biz_id
        // order_id	string	是	订单号
        // delivery_id	string	是	快递公司id,需填TEST
        // waybill_id	string	是	运单号
        // action_time	number	是	轨迹变化 Unix 时间戳
        // action_type	number	是	轨迹变化类型
        // action_msg	string	是	轨迹变化具体信息说明,使用UTF-8编码

        $params = array();
        $params['biz_id'] = $biz_id;
        $params['order_id'] = $order_id;
        $params['delivery_id'] = $delivery_id;
        $params['waybill_id'] = $waybill_id;
        $params['action_time'] = $action_time;
        $params['action_type'] = $action_type;
        $params['action_msg'] = $action_msg;
        $rst = $this->_request->post('https://api.weixin.qq.com/cgi-bin/express/business/test_update_order', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 物流助手 /小程序使用 /批量获取运单数据
批量获取运单数据
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
batchGetOrder

功能描述
该接口用于批量获取运单数据。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/order/batchget?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.batchGetOrder

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken 或者 authorizer_access_token
order_list	array<object>	是	订单列表, 最多不能超过100个
属性	类型	必填	说明
order_id	string	是	订单 ID，需保证全局唯一
delivery_id	string	是	快递公司ID，参见getAllDelivery, 必须和waybill_id对应
waybill_id	string	否	运单ID
返回参数
属性	类型	说明
order_list	array<object>	运单列表
属性	类型	说明
errcode	number	错误码
errmsg	string	错误信息
print_html	string	运单 html 的 BASE64 结果
waybill_data	array<object>	运单信息
属性	类型	说明
key	string	运单信息 key
value	string	运单信息 value
order_id	string	订单ID
delivery_id	string	快递公司ID
waybill_id	string	运单号
order_status	number	运单状态, 0正常，1取消
errcode	number	错误码
errmsg	string	错误信息
调用示例
示例说明: HTTPS调用

请求数据示例

{
   "order_list": [
       {
          "order_id": "01234567890123456789",
          "delivery_id": "SF",
          "waybill_id": "123456789"
       },
       {
          "order_id": "01234567890123456789",
          "delivery_id": "SF",
          "waybill_id": "123456789"
       }
   ]
} 

返回数据示例

{
   "order_list": [
       {
          "errcode": 0,
          "errmsg": "ok",
          "order_id": "01234567890123456789",
          "delivery_id": "SF",
          "waybill_id": "123456789",
          "print_html": "jh7DjipP4ul4CQYUh69cniskrQZuOPwa1inAbXIqKbU0t71c0s65Au54cdWBZW0QJY4LYeofdM",
          "waybill_data": [
               {
                   "key": "SF_bagAddr",
                   "value": "广州"
               },
               {
                  "key": "SF_mark",
                  "value": "101- 07-03 509"
               }
           ],
           "order_status": 0
       },
       {
          "errcode": 0,
          "errmsg": "ok",
          "order_id": "01234567890123456789_2",
          "delivery_id": "SF",
          "waybill_id": "123456789_2",
          "print_html": "jh7DjipP4ul4CQYUh69cniskrQZuOPwa1inAbXIqKbU0t71c0s65Au54cdWBZW0QJY4LYeofdM",
          "waybill_data": [
               {
                   "key": "SF_bagAddr",
                   "value": "广州"
               },
               {
                  "key": "SF_mark",
                  "value": "101- 07-03 509"
               }
           ],
           "order_status": 0
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
    const result = await cloud.openapi.logistics.batchGetOrder({
        "orderList": [
          {
            "orderId": '01234567890123456789',
            "deliveryId": 'SF',
            "waybillId": '123456789'
          },
          {
            "orderId": '01234567890123456789',
            "deliveryId": 'SF',
            "waybillId": '123456789'
          }
        ]
      })
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
  "orderList": [
    {
      "errcode": 0,
      "errmsg": "ok",
      "orderId": "01234567890123456789",
      "deliveryId": "SF",
      "waybillId": "123456789",
      "printHtml": "jh7DjipP4ul4CQYUh69cniskrQZuOPwa1inAbXIqKbU0t71c0s65Au54cdWBZW0QJY4LYeofdM",
      "waybillData": [
        {
          "key": "SF_bagAddr",
          "value": "广州"
        },
        {
          "key": "SF_mark",
          "value": "101- 07-03 509"
        }
      ],
      "orderStatus": 0
    },
    {
      "errcode": 0,
      "errmsg": "ok",
      "orderId": "01234567890123456789_2",
      "deliveryId": "SF",
      "waybillId": "123456789_2",
      "printHtml": "jh7DjipP4ul4CQYUh69cniskrQZuOPwa1inAbXIqKbU0t71c0s65Au54cdWBZW0QJY4LYeofdM",
      "waybillData": [
        {
          "key": "SF_bagAddr",
          "value": "广州"
        },
        {
          "key": "SF_mark",
          "value": "101- 07-03 509"
        }
      ],
      "orderStatus": 0
    }
  ],
  "errMsg": "openapi.logistics.batchGetOrder:ok"
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function batchget($order_list)
    {
        $params = array();
        $params['order_list'] = $order_list;
        $rst = $this->_request->post($this->_url . 'batchget', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 物流助手 /小程序使用 /生成运单
生成运单
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

接口说明
接口英文名
addOrder

功能描述
该接口用于生成运单。

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/order/add?access_token=ACCESS_TOKEN 

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken 或者 authorizer_access_token
order_id	string	是	订单ID，须保证全局唯一，不超过512字节
openid	string	是	用户openid，当add_source=2时无需填写（不发送物流服务通知）
delivery_id	string	是	快递公司ID，参见getAllDelivery
biz_id	string	是	快递客户编码或者现付编码
custom_remark	string	否	快递备注信息，比如"易碎物品"，不超过1024字节
tagid	number	否	订单标签id，用于平台型小程序区分平台上的入驻方，tagid须与入驻方账号一一对应，非平台型小程序无需填写该字段
add_source	number	是	订单来源，0为小程序订单，2为App或H5订单，填2则不发送物流服务通知
wx_appid	string	否	App或H5的appid，add_source=2时必填，需和开通了物流助手的小程序绑定同一open帐号
sender	object	是	发件人信息
属性	类型	必填	说明
name	string	否	发/收件人姓名，不超过64字节
tel	string	否	发/收件人座机号码，若不填写则必须填写 mobile，不超过32字节
mobile	string	否	发/收件人手机号码，若不填写则必须填写 tel，不超过32字节
company	string	否	发/收件人公司名称，不超过64字节
post_code	string	否	发/收件人邮编，不超过10字节
country	string	否	发/收件人国家，不超过64字节
province	string	否	发/收件人省份，比如："广东省"，不超过64字节
city	string	否	发/收件人市/地区，比如："广州市"，不超过64字节
area	string	否	发/收件人区/县，比如："海珠区"，不超过64字节
address	string	否	发/收件人详细地址，比如："XX路XX号XX大厦XX"，不超过512字节
receiver	object	是	收件人信息
属性	类型	必填	说明
name	string	否	发/收件人姓名，不超过64字节
tel	string	否	发/收件人座机号码，若不填写则必须填写 mobile，不超过32字节
mobile	string	否	发/收件人手机号码，若不填写则必须填写 tel，不超过32字节
company	string	否	发/收件人公司名称，不超过64字节
post_code	string	否	发/收件人邮编，不超过10字节
country	string	否	发/收件人国家，不超过64字节
province	string	否	发/收件人省份，比如："广东省"，不超过64字节
city	string	否	发/收件人市/地区，比如："广州市"，不超过64字节
area	string	否	发/收件人区/县，比如："海珠区"，不超过64字节
address	string	否	发/收件人详细地址，比如："XX路XX号XX大厦XX"，不超过512字节
cargo	object	是	包裹信息，将传递给快递公司
属性	类型	必填	说明
count	number	是	包裹数量, 默认为1
weight	number	是	货物总重量，比如1.2，单位是千克(kg)
space_x	number	是	货物长度，比如20.0，单位是厘米(cm)
space_y	number	是	货物宽度，比如15.0，单位是厘米(cm)
space_z	number	是	货物高度，比如10.0，单位是厘米(cm)
detail_list	array<object>	是	货物总重量，单位是千克(kg)
属性	类型	必填	说明
name	string	是	商品名，不超过128字节
count	number	是	商品数量
shop	object	是	商品信息，会展示到物流服务通知和电子面单中
属性	类型	必填	说明
wxa_path	string	否	商家小程序的路径，建议为订单页面
img_url	string	否	商品缩略图 url；shop.detail_list为空则必传，shop.detail_list非空可不传。
goods_name	string	否	商品名称, 不超过128字节；shop.detail_list为空则必传，shop.detail_list非空可不传。
goods_count	number	否	商品数量；shop.detail_list为空则必传。shop.detail_list非空可不传，默认取shop.detail_list的size
detail_list	Array.<object>	否	商品详情列表，适配多商品场景，用以消息落地页展示。（新规范，新接入商家建议用此字段）
insured	object	是	保价信息
属性	类型	必填	说明
use_insured	number	否	是否保价，0 表示不保价，1 表示保价
insured_value	number	否	保价金额，单位是分，比如: 10000 表示 100 元
service	object	是	服务类型
属性	类型	必填	说明
service_type	number	是	服务类型ID，详见已经支持的快递公司基本信息
service_name	string	是	服务名称，详见已经支持的快递公司基本信息
expect_time	number	否	Unix 时间戳, 单位秒，顺丰必须传。 预期的上门揽件时间，0表示已事先约定取件时间；否则请传预期揽件时间戳，需大于当前时间，收件员会在预期时间附近上门。例如expect_time为“1557989929”，表示希望收件员将在2019年05月16日14:58:49-15:58:49内上门取货。说明：若选择 了预期揽件时间，请不要自己打单，由上门揽件的时候打印。如果是下顺丰散单，则必传此字段，否则不会有收件员上门揽件。
take_mode	number	否	分单策略，【0：线下网点签约，1：总部签约结算】，不传默认线下网点签约。目前支持圆通。
返回参数
属性	类型	说明
errcode	number	微信侧错误码，下单失败时返回
errmsg	string	微信侧错误信息，下单失败时返回
order_id	string	订单ID，下单成功时返回
waybill_id	string	运单ID，下单成功时返回
delivery_resultcode	number	快递侧错误码，下单失败时返回
delivery_resultmsg	string	快递侧错误信息，下单失败时返回
waybill_data	array<object>	运单信息，下单成功时返回
属性	类型	说明
key	string	运单信息 key
value	string	运单信息 value
调用示例
示例说明: 下单成功的例子

请求数据示例

{
  "add_source": 0,
  "order_id": "01234567890123456789",
  "openid": "oABC123456",
  "delivery_id": "SF",
  "biz_id": "xyz",
  "custom_remark": "易碎物品",
  "sender": {
    "name": "张三",
    "tel": "020-88888888",
    "mobile": "18666666666",
    "company": "公司名",
    "post_code": "123456",
    "country": "中国",
    "province": "广东省",
    "city": "广州市",
    "area": "海珠区",
    "address": "XX路XX号XX大厦XX栋XX"
  },
  "receiver": {
    "name": "王小蒙",
    "tel": "020-77777777",
    "mobile": "18610000000",
    "company": "公司名",
    "post_code": "654321",
    "country": "中国",
    "province": "广东省",
    "city": "广州市",
    "area": "天河区",
    "address": "XX路XX号XX大厦XX栋XX"
  },
  "shop": {
    "wxa_path": "/index/index?from=waybill&id=01234567890123456789",
    "detail_list": [
      {
        "goods_name": "微信气泡狗抱枕（小号）",
        "goods_img_url": "https://mmbiz.qpic.cn/mmbiz_png/OiaFLUqewuIDNQnTiaCInIG8ibdosYHhQHPbXJUrqYSNIcBL60vo4LIjlcoNG1QPkeH5GWWEB41Ny895CokeAah8A/640",
        "goods_desc": "40cm * 40cm尺寸"
      },
      {
        "goods_name": "微信气泡狗抱枕（中号）",
        "goods_img_url": "https://mmbiz.qpic.cn/mmbiz_png/OiaFLUqewuIDNQnTiaCInIG8ibdosYHhQHPbXJUrqYSNIcBL60vo4LIjlcoNG1QPkeH5GWWEB41Ny895CokeAah8A/640",
        "goods_desc": "50cm * 50cm尺寸"
      }
    ]
  },
  "cargo": {
    "count": 2,
    "weight": 5.5,
    "space_x": 30.5,
    "space_y": 20,
    "space_z": 20,
    "detail_list":[{
"name":"微信气泡狗抱枕（中号)",
"count":1
},{"name":"微信气泡狗（大号）"，
”count":1}]
  },
  "insured": {
    "use_insured": 1,
    "insured_value": 10000
  },
  "service": {
    "service_type": 0,
    "service_name": "标准快递"
  }
} 

返回数据示例

{
  "order_id": "01234567890123456789",
  "waybill_id": "123456789",
  "waybill_data": [
    {
      "key": "SF_bagAddr",
      "value": "广州"
    },
    {
      "key": "SF_mark",
      "value": "101- 07-03 509"
    }
  ]
} 

示例说明: 下单失败的例子

请求数据示例

同上 

返回数据示例

{
  "errcode": 9300501,
  "errmsg": "delivery logic fail",
  "delivery_resultcode": 10002,
  "delivery_resultmsg": "客户密码不正确"
} 

错误码
错误码	错误描述	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
-1	system error	系统繁忙，此时请开发者稍候再试
47001	data format error	解析 JSON/XML 内容错误;post 数据中参数缺失;检查修正后重试。
40003	invalid openid	不合法的 OpenID ，请开发者确认 OpenID （该用户）是否已关注公众号，或是否是其他公众号的 OpenID
9300502	Delivery side sys error	快递公司系统错误
9300501	Delivery side error	快递侧逻辑错误，详细原因需要看 delivery_resultcode。请先确认一下编码方式，python建议 json.dumps(b, ensure_ascii=False)，php建议 json_encode($arr, JSON_UNESCAPED_UNICODE)
9300503	Specified delivery id is not registerred	delivery_id 不存在
9300510	invalid service type	service_type 不存在
9300526	arg size exceed limit	参数字段长度不正确
930561	args error	参数错误
9300525	biz id not bind	bizid未绑定
9300534	invalid shop args	access_token与openid参数不匹配
9300535	invalid shop args	shop字段商品缩略图 url、商品名称为空或者非法，或者商品数量为0
9300536	invalid wxa_appid	add_source=2时，wx_appid无效
9300531	invalid biz_id or password	bizid无效 或者密码错误
930564	quota run out	沙盒环境调用无配额
930559	invaild openid	沙盒环境openid无效
     */
    public function add(\Weixin\Wx\Express\Business\Model\Order $order)
    {
        $params = $order->getParams();
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }
}
