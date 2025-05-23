<?php

namespace Weixin\Wx\Express\Delivery\Manager;

use Weixin\Client;

/**
 * 物流查询 物流消息管理API
 *
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/industry/express/business/express_search.html
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/industry/express/business/express_open_msg.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class OpenMsg
{
  // 接口地址
  private $_url = 'https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/';
  private $_client;
  private $_request;
  public function __construct(Client $client)
  {
    $this->_client = $client;
    $this->_request = $client->getRequest();
  }

  /**
   * 传运单接口 trace_waybill
   * 描述：商户使用此接口向微信提供某交易单号对应的运单号。微信后台会跟踪运单的状态变化
   * 请求方法： POST application/json
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/trace_waybill?access_token=XXX
   * 请求参数
   * 参数名称 类型 必选 备注
   * openid string 是 用户openid
   * sender_phone string 否 寄件人手机号
   * receiver_phone string 是 收件人手机号，部分运力需要用户手机号作为查单依据
   * delivery_id string 否 运力id（运单号所属运力公司id），该字段从 get_delivery_list 获取。
   * 该参数用于提高运单号识别的准确度；特别是对非主流快递公司，建议传入该参数，确保查询正确率。
   * waybill_id string 是 运单号
   * goods_info object 是 商品信息
   * trans_id string 是 交易单号（微信支付生成的交易单号，一般以420开头）
   * order_detail_path string 否 点击落地页商品卡片跳转路径（建议为订单详情页path），不传默认跳转小程序首页。
   * 本次更新点：sender_phone，receiver_phone。
   *
   * 其中goods_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * detail_list array 是 商品信息
   * 其中goods_info.detail_list的每一项的内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_name string 是 商品名称
   * goods_img_url string 是 商品图片url
   * goods_desc string 否 商品详情描述，不传默认取“商品名称”值，最多40汉字
   * 返回参数
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * errmsg string 是 错误信息
   * waybill_token string 是 查询id
   * 示例 请求参数
   * {
   * "openid":"ovtZW4yB7DIj3CxOb6ii-nk4HhFo",
   * "waybill_id":"WXTESTEXPRESS0000014",
   * "sender_phone":"12345678901" ,
   * "receiver_phone":"123456566" ,
   * "delivery_id":"KYSY",
   * "goods_info":{
   * "detail_list":[
   * {
   * "goods_name":"测试名字",
   * "goods_img_url":"www.qq.com"
   * },
   * {
   * "goods_name":"测试名字2",
   * "goods_img_url":"www.qq.com"
   * }
   * ]
   * }
   * }
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "waybill_token": "o_ARWHaxIxzWHmdui-AIw9KBr8qNnbmc08V0KhDyXE-IMLo6AcOqJkPsNLcLzfTb"
   * }
   */
  public function traceWaybill($openid, $sender_phone, $receiver_phone, $delivery_id, $waybill_id, \Weixin\Wx\Express\Delivery\Model\GoodsInfo $goods_info, $trans_id, $order_detail_path)
  {
    // openid string 是 用户openid
    // sender_phone string 否 寄件人手机号
    // receiver_phone string 是 收件人手机号，部分运力需要用户手机号作为查单依据
    // delivery_id string 否 运力id（运单号所属运力公司id），该字段从 get_delivery_list 获取。该参数用于提高运单号识别的准确度；特别是对非主流快递公司，建议传入该参数，确保查询正确率。
    // waybill_id string 是 运单号
    // goods_info object 是 商品信息
    // trans_id string 是 交易单号（微信支付生成的交易单号，一般以420开头）
    // order_detail_path string 否 点击落地页商品卡片跳转路径（建议为订单详情页path），不传默认跳转小程序首页。
    $params = array();
    $params['openid'] = $openid;
    if (! empty($sender_phone)) {
      $params['sender_phone'] = $sender_phone;
    }
    $params['receiver_phone'] = $receiver_phone;
    if (! empty($delivery_id)) {
      $params['delivery_id'] = $delivery_id;
    }
    $params['waybill_id'] = $waybill_id;
    $params['goods_info'] = $goods_info->getParams();
    $params['trans_id'] = $trans_id;
    if (! empty($order_detail_path)) {
      $params['order_detail_path'] = $order_detail_path;
    }
    $rst = $this->_request->post($this->_url . 'trace_waybill', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 查询运单接口 query_trace
   * 描述：商户在调用完trace_waybill接口后，可以使用本接口查询到对应运单的详情信息
   * 请求方法： POST application/json
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/query_trace?access_token=XXX
   * 请求参数
   * 参数名称 类型 必选 备注
   * waybill_token string 是 查询id
   * 返回参数
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * errmsg string 是 错误信息
   * waybill_info object 是 运单信息
   * shop_info object 否 商品信息
   * delivery_info object 否 运力信息
   * 其中waybill_info内容如下：
   *
   * 参数名称 类型 必选 备注
   * status number 是 运单状态，见运单状态
   * waybill_id string 是 运单号
   * 其中shop_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_info object 否 商品信息
   * 其中shop_info.goods_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * detail_list array 是 商品详情
   * 其中shop_info.goods_info.detail_list的每一项内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_name string 是 商品名称(最大长度为utf-8编码下的60个字符）
   * goods_img_url string 是 商品图片url
   * 其中delivery_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * delivery_id string 是 运力公司 id
   * delivery_name string 否 运力公司名称
   * 示例 请求参数
   * {
   * "waybill_token":"o_ARWHaxIxzWHmdui-AIw8SuE1QtaUZK8aUnZguAn1nsZ72ZjWlq8btV8j-wAc94",
   * "openid":"ovtZW4yB7DIj3CxOb6ii-nk4HhFo"
   * }
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "waybill_info": {
   * "status": 0,
   * "waybill_id": "WXTESTEXPRESS0000014"
   * },
   * "shop_info": {
   * "goods_info": {
   * "detail_list": [
   * {
   * "goods_name": "测试名字",
   * "goods_img_url": "www.qq.com"
   * },
   * {
   * "goods_name": "测试名字2",
   * "goods_img_url": "www.qq.com"
   * }
   * ]
   * }
   * }
   * }
   */
  public function queryTrace($waybill_token)
  {
    // waybill_token string 是 查询id
    $params = array();
    $params['waybill_token'] = $waybill_token;
    // $params['openid'] = $openid;
    $rst = $this->_request->post($this->_url . 'query_trace', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 更新物流信息接口 update_waybill_goods
   * 描述：更新物品信息
   * 请求方法： POST application/json
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/update_waybill_goods?access_token=XXX
   * 请求参数
   * 参数名称 类型 必选 备注
   * waybill_token string 是 查询id
   * goods_info object 是 商品信息
   * 其中goods_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * detail_list array 是 商品信息
   * 其中goods_info.detail_list的每一项的内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_name string 是 商品名称(最大长度为utf-8编码下的60个字符）
   * goods_img_url string 是 商品图片url
   * 返回参数
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * errmsg string 是 错误信息
   * 示例 请求参数
   * {
   * "waybill_token":"o_ARWHaxIxzWHmdui-AIw8SuE1QtaUZK8aUnZguAn1nsZ72ZjWlq8btV8j-wAc94",
   * "openid":"ovtZW4yB7DIj3CxOb6ii-nk4HhFo",
   * "goods_info":{
   * "detail_list":[
   * {
   * "goods_name":"测试更新商品" ,
   * "goods_img_url":"www.qq.com"
   * }
   * ]
   * }
   * }
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok"
   * }
   * 3. 接口错误码
   * 错误码 释义
   * -1 系统错误
   * 9300560 达到修改次数上限
   * 40003 openid参数错误
   * 9300534 access_token与openid参数不匹配
   * 9300513 调用次数达到上限
   * 9300507 waybill_token参数错误
   * 9300559 运单不存在
   * 4. 运单状态
   * 运单状态 释义
   * 0 运单不存在或者未揽收
   * 1 已揽件
   * 2 运输中
   * 3 派件中
   * 4 已签收
   * 5 异常
   * 6 代签收
   */
  public function updateWaybillGoods($waybill_token, \Weixin\Wx\Express\Delivery\Model\GoodsInfo $goods_info)
  {
    // waybill_token string 是 查询id
    // goods_info object 是 商品信息
    $params = array();
    $params['waybill_token'] = $waybill_token;
    $params['goods_info'] = $goods_info->getParams();
    $rst = $this->_request->post($this->_url . 'update_waybill_goods', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 4.1、传运单接口 follow_waybill
   * 描述：商户使用此接口向微信提供某交易单号对应的运单号。微信后台会跟踪运单的状态变化，在关键物流节点给下单用户推送消息通知。
   * 请求方法： POST application/json
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/follow_waybill?access_token=XXX
   * 请求参数
   * 参数名称 类型 必选 备注
   * openid string 是 用户openid
   * sender_phone string 否 寄件人手机号
   * receiver_phone string 是 收件人手机号，部分运力需要用户手机号作为查单依据
   * delivery_id string 否 运力id（运单号所属运力公司id），该字段从 get_delivery_list 获取。
   * 该参数用于提高运单号识别的准确度；特别是对非主流快递公司，建议传入该参数，确保查询正确率。
   * waybill_id string 是 运单号
   * goods_info object 是 商品信息
   * trans_id string 是 交易单号（微信支付生成的交易单号，一般以420开头）
   * order_detail_path string 否 点击落地页商品卡片跳转路径（建议为订单详情页path），不传默认跳转小程序首页。
   * 其中goods_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * detail_list array 是 商品信息
   * 其中goods_info.detail_list的每一项的内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_name string 是 商品名称(最大长度为utf-8编码下的60个字符）
   * goods_img_url string 是 商品图片url
   * goods_desc string 否 商品详情描述，不传默认取“商品名称”值，最多40汉字
   * 返回参数
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * errmsg string 是 错误信息
   * waybill_token string 是 查询id
   * 示例
   * 请求参数
   *
   * {
   * "openid":"ovtZW4yB7DIj3CxOb6ii-nk4HhFo",
   * "waybill_id":"WXTESTEXPRESS0000014",
   * "sender_phone":"12345678901" ,
   * "receiver_phone":"123456566" ,
   * "goods_info":{
   * "detail_list":[
   * {
   * "goods_name":"测试名字",
   * "goods_img_url":"www.qq.com"
   * },
   * {
   * "goods_name":"测试名字2",
   * "goods_img_url":"www.qq.com"
   * }
   * ]
   * }
   * }
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "waybill_token": "o_ARWHaxIxzWHmdui-AIw9KBr8qNnbmc08V0KhDyXE-IMLo6AcOqJkPsNLcLzfTb"
   * }
   */
  public function followWaybill($openid, $sender_phone, $receiver_phone, $delivery_id, $waybill_id, \Weixin\Wx\Express\Delivery\Model\GoodsInfo $goods_info, $trans_id, $order_detail_path)
  {
    // openid string 是 用户openid
    // sender_phone string 否 寄件人手机号
    // receiver_phone string 是 收件人手机号，部分运力需要用户手机号作为查单依据
    // delivery_id string 否 运力id（运单号所属运力公司id），该字段从 get_delivery_list 获取。该参数用于提高运单号识别的准确度；特别是对非主流快递公司，建议传入该参数，确保查询正确率。
    // waybill_id string 是 运单号
    // goods_info object 是 商品信息
    // trans_id string 是 交易单号（微信支付生成的交易单号，一般以420开头）
    // order_detail_path string 否 点击落地页商品卡片跳转路径（建议为订单详情页path），不传默认跳转小程序首页。
    $params = array();
    $params['openid'] = $openid;
    if (! empty($sender_phone)) {
      $params['sender_phone'] = $sender_phone;
    }
    $params['receiver_phone'] = $receiver_phone;
    if (! empty($delivery_id)) {
      $params['delivery_id'] = $delivery_id;
    }
    $params['waybill_id'] = $waybill_id;
    $params['goods_info'] = $goods_info->getParams();
    $params['trans_id'] = $trans_id;
    if (! empty($order_detail_path)) {
      $params['order_detail_path'] = $order_detail_path;
    }
    $rst = $this->_request->post($this->_url . 'follow_waybill', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 4.2、查运单接口 query_follow_trace
   * 描述：商户在调用完trace_waybill接口后，可以使用本接口查询到对应运单的详情信息
   * 请求方法： POST application/json
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/query_follow_trace?access_token=XXX
   * 请求参数
   * 参数名称 类型 必选 备注
   * waybill_token string 是 查询id
   * 返回参数
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * errmsg string 是 错误信息
   * waybill_info object 是 运单信息
   * shop_info object 否 商品信息
   * delivery_info object 否 运力信息
   * 其中waybill_info内容如下：
   *
   * 参数名称 类型 必选 备注
   * status number 是 运单状态，见运单状态
   * waybill_id string 是 运单号
   * 其中shop_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_info object 否 商品信息
   * 其中shop_info.goods_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * detail_list array 是 商品详情
   * 其中shop_info.goods_info.detail_list的每一项内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_name string 是 商品名称
   * goods_img_url string 是 商品图片url
   * 其中delivery_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * delivery_id string 是 运力公司 id
   * delivery_name string 否 运力公司名称
   * 示例
   * 请求参数
   *
   * {
   * "waybill_token":"o_ARWHaxIxzWHmdui-AIw8SuE1QtaUZK8aUnZguAn1nsZ72ZjWlq8btV8j-wAc94",
   * "openid":"ovtZW4yB7DIj3CxOb6ii-nk4HhFo"
   * }
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "waybill_info": {
   * "status": 0,
   * "waybill_id": "WXTESTEXPRESS0000014"
   * },
   * "shop_info": {
   * "goods_info": {
   * "detail_list": [
   * {
   * "goods_name": "测试名字",
   * "goods_img_url": "www.qq.com"
   * },
   * {
   * "goods_name": "测试名字2",
   * "goods_img_url": "www.qq.com"
   * }
   * ]
   * }
   * }
   * }
   * 4.3、更新
   */
  public function queryFollowTrace($waybill_token)
  {
    // waybill_token string 是 查询id
    $params = array();
    $params['waybill_token'] = $waybill_token;
    // $params['openid'] = $openid;
    $rst = $this->_request->post($this->_url . 'query_follow_trace', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 4.3、更新物品信息接口 update_follow_waybill_goods
   * 描述：更新物品信息
   * 请求方法： POST application/json
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/update_follow_waybill_goods?access_token=XXX
   * 请求参数
   * 参数名称 类型 必选 备注
   * waybill_token string 是 查询id
   * goods_info object 是 商品信息
   * 其中goods_info的内容如下：
   *
   * 参数名称 类型 必选 备注
   * detail_list array 是 商品信息
   * 其中goods_info.detail_list的每一项的内容如下：
   *
   * 参数名称 类型 必选 备注
   * goods_name string 是 商品名称(最大长度为utf-8编码下的60个字符）
   * goods_img_url string 是 商品图片url
   * 返回参数
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * errmsg string 是 错误信息
   * 示例
   * 请求参数
   *
   * {
   * "waybill_token":"o_ARWHaxIxzWHmdui-AIw8SuE1QtaUZK8aUnZguAn1nsZ72ZjWlq8btV8j-wAc94",
   * "openid":"ovtZW4yB7DIj3CxOb6ii-nk4HhFo",
   * "goods_info":{
   * "detail_list":[
   * {
   * "goods_name":"测试更新商品" ,
   * "goods_img_url":"www.qq.com"
   * }
   * ]
   * }
   * }
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok"
   * }
   */
  public function updateFollowWaybillGoods($waybill_token, \Weixin\Wx\Express\Delivery\Model\GoodsInfo $goods_info)
  {
    // waybill_token string 是 查询id
    // goods_info object 是 商品信息
    $params = array();
    $params['waybill_token'] = $waybill_token;
    $params['goods_info'] = $goods_info->getParams();
    $rst = $this->_request->post($this->_url . 'update_follow_waybill_goods', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 4.4获取运力id列表get_delivery_list
   * 描述：商户使用此接口获取所有运力id的列表
   *
   * 请求方法： POST application/json
   *
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/open_msg/get_delivery_list?access_token=XXX
   *
   * 请求参数 {}
   *
   * 返回参数
   *
   * 参数名称 类型 必选 备注
   * errcode number 是 返回码
   * delivery_list array 是 运力公司列表
   * count number 是 运力公司个数
   * 示例 请求参数
   * {}
   * 返回参数
   *
   * {
   * "errcode": 0,
   * "delivery_list": [
   * {
   * "delivery_id": "(AU)",
   * "delivery_name": "Interparcel"
   * },
   * {
   * "delivery_id": "BDT",
   * "delivery_name": "八达通"
   * },
   * {
   * "delivery_id": "YD",
   * "delivery_name": "韵达速递"
   * },
   * ...
   * ],
   * "count": 1379
   * }
   * 五、接口错误码
   * 错误码 释义
   * -1 系统错误
   * 9300560 达到修改次数上限
   * 40003 openid参数错误
   * 9300534 access_token与openid参数不匹配
   * 9300513 调用次数达到上限
   * 9300507 waybill_token参数错误
   * 9300559 运单不存在
   * 六、运单状态
   * 运单状态 释义
   * 0 运单不存在或者未揽收
   * 1 已揽件
   * 2 运输中
   * 3 派件中
   * 4 已签收
   * 5 异常
   * 6 代签收
   */
  public function getDeliveryList()
  {
    $params = array();
    $rst = $this->_request->post($this->_url . 'get_delivery_list', $params);
    return $this->_client->rst($rst);
  }
}
