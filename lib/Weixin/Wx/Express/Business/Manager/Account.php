<?php

namespace Weixin\Wx\Express\Business\Manager;

use Weixin\Client;

/**
 * 物流账号管理API
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/bindAccount.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class Account
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/express/business/account/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 物流助手 /小程序使用 /绑定/解绑物流账号
绑定/解绑物流账号
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
bindAccount

功能描述
该接口用于绑定、解绑物流账号

调用方式
HTTPS 调用

POST https://api.weixin.qq.com/cgi-bin/express/business/account/bind?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.bindAccount

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

请求参数
属性	类型	必填	说明
access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
type	string	是	bind表示绑定，unbind表示解除绑定
biz_id	string	是	快递公司客户编码
delivery_id	string	是	快递公司ID
password	string	否	快递公司客户密码
remark_content	string	否	备注内容（提交EMS审核需要） 格式要求： 电话：xxxxx 联系人：xxxxx 服务类型：xxxxx 发货地址：xxxx
返回参数
属性	类型	说明
errcode	number	错误码
errmsg	string	错误信息
调用示例
示例说明: HTTPS调用

请求数据示例

{
  "type": "bind",
  "biz_id": "123456",
  "delivery_id": "YUNDA",
  "password": "123456789123456789"
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
    const result = await cloud.openapi.logistics.bindAccount({
        "type": 'bind',
        "password": '123456789123456789',
        "bizId": '123456',
        "deliveryId": 'YUNDA'
      })
    return result
  } catch (err) {
    return err
  }
} 

返回数据示例

{
  "errcode": 0,
  "errmsg": "ok"
} 

错误码
错误码	错误码取值	解决方案
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function bind($type, $biz_id, $delivery_id, $password, $remark_content)
    {
        // 属性	类型	必填	说明
        // access_token	string	是	接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
        // type	string	是	bind表示绑定，unbind表示解除绑定
        // biz_id	string	是	快递公司客户编码
        // delivery_id	string	是	快递公司ID
        // password	string	否	快递公司客户密码
        // remark_content	string	否	备注内容（提交EMS审核需要） 格式要求： 电话：xxxxx 联系人：xxxxx 服务类型：xxxxx 发货地址：xxxx

        $params = array();
        $params['type'] = $type;
        $params['biz_id'] = $biz_id;
        $params['delivery_id'] = $delivery_id;
        $params['password'] = $password;
        $params['remark_content'] = $remark_content;
        $rst = $this->_request->post($this->_url . 'bind', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 物流助手 /小程序使用 /获取所有绑定的物流账号
获取所有绑定的物流账号
 调试工具

接口应在服务器端调用，详细说明参见服务端API。

本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0

接口说明
接口英文名
getAllAccount

功能描述
该接口用于获取所有绑定的物流账号。

调用方式
HTTPS 调用

GET https://api.weixin.qq.com/cgi-bin/express/business/account/getall?access_token=ACCESS_TOKEN 

云调用
出入参和HTTPS调用相同，调用方式可查看云调用说明文档

接口方法为: openapi.logistics.getAllAccount

第三方调用
调用方式以及出入参和HTTPS相同，仅是调用的token不同

该接口所属的权限集id为：45、71

服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用

返回参数
属性	类型	说明
count	number	账号数量
list	array<object>	账号列表
属性	类型	说明
biz_id	string	快递公司客户编码
delivery_id	string	快递公司ID
create_time	number	账号绑定时间
update_time	number	账号更新时间
status_code	number	绑定状态
alias	string	账号别名
remark_wrong_msg	string	账号绑定失败的错误信息（EMS审核结果）
remark_content	string	账号绑定时的备注内容（提交EMS审核需要）
quota_num	number	电子面单余额
quota_update_time	number	电子面单余额更新时间
service_type	array<object>	该绑定账号支持的服务类型
属性	类型	说明
service_type	number	service_type
service_name	string	服务类型名称
errcode	number	错误码
errmsg	string	错误信息
调用示例
示例说明: HTTPS调用

请求数据示例

GET https://api.weixin.qq.com/cgi-bin/express/business/account/getall?access_token=ACCESS_TOKEN 

返回数据示例

{
       "count": 1,
       "list": [
           {
               "biz_id": "123456789",
               "delivery_id": "YUNDA",
               "create_time": 1555482786,
               "update_time": 1556594799,
               "status_code": 0,
               "alias": "",
               "remark_wrong_msg": "",
               "remark_content": "",
               "quota_num": 55,
               "quota_update_time": 1556594799
           }
       ]
   } 

错误码
错误码	错误码取值	解决方案
-1	system error	系统繁忙，此时请开发者稍候再试
40001	invalid credential  access_token isinvalid or not latest	获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getAll()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'getall', $params);
        return $this->_client->rst($rst);
    }
}
