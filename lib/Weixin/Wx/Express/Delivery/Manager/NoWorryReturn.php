<?php

namespace Weixin\Wx\Express\Delivery\Manager;

use Weixin\Client;

/**
 * 无忧退货管理API
 *
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/industry/express/business/freight_insurance.html#_6-API%E6%8E%A5%E5%8F%A3%E5%88%97%E8%A1%A8
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class NoWorryReturn
{
  // 接口地址
  private $_url = 'https://api.weixin.qq.com/cgi-bin/express/delivery/no_worry_return/';
  private $_client;
  private $_request;
  public function __construct(Client $client)
  {
    $this->_client = $client;
    $this->_request = $client->getRequest();
  }

  /**
   * 创建退货 ID
   * 描述：商家在同意用户退货之后，通过本接口创建退货ID，shop_order_id和退货 ID 一一对应。一个订单需要多次退货”的场景，可以在商家内部 1 个退货订单号映射多个shop_order_id。注：该接口中文相关的字段用UTF-8。
   * 提醒退货通知：商家创建退货 ID 时，平台会自动下发模板消息给用户，提醒用户退货。
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/no_worry_return/add?access_token=ACCESS_TOKEN
   * 请求方式：POST
   * 请求参数
   * 参数名称 类型 必选 备注
   * shop_order_id string 是 商家内部系统使用的退货编号
   * biz_addr object 是 商家退货地址
   * user_addr object 否 用户购物时的收货地址
   * openid string 是 退货用户的openid
   * wx_pay_id string 是 填写已投保的微信支付单号
   * order_path string 是 退货订单在商家小程序的path。如投保时已传入订单商品信息，则以投保时传入的为准
   * goods_list Array 是 退货商品list，一个元素为对象的数组,结构如下↓ 如投保时已传入订单商品信息，则以投保时传入的为准
   * goods_list内对象参数名称 类型 必选 备注
   * name string 是 退货商品的名称
   * url string 是 退货商品图片的url
   * //请求示例
   * {
   * "shop_order_id": "xxx",//商家内部系统使用的退货编号
   * "biz_addr": { //商家退货地址，必填
   * "name": "张三",
   * "mobile": "13600000000",//仅支持输入一个联系方式
   * "country": "中国",
   * "province": "广东省",
   * "city": "广州市",
   * "area": "海珠区",
   * "address": "xx路xx号"
   * },
   * "user_addr": { //用户购物时的收货地址，选填
   * "name": "李四",
   * "mobile": "13600000000",
   * "country": "中国",
   * "province": "广东省",
   * "city": "广州市",
   * "area": "海珠区",
   * "address": "xx路xx号"
   * },
   * "openid":"xxx",//退货用户的openid，用于给用户下发模版消息，通过模版消息用户可以选择退货方式
   * "order_path":"xxx",//退货订单在商家小程序的path
   * "goods_list":[
   * {
   * "name":"xxx",//退货商品的名称
   * "url":"xxx"//退货商品图片的url
   * }
   * ],
   * "order_price":1//退货订单的价格,
   * "wx_pay_id":"420000198020231123341140012"//微信支付投保单号
   * }
   *
   * 返回参数
   * {
   * "errcode": 0,
   * "errmsg": "OK",
   * "return_id": "1935761508265738242"
   * }
   *
   * 错误码列表
   * "errcode": 40097 //参数错误:order_id为空或者退货地址为空或者wx_pay_id为空
   * "errcode": 9300522 //参数错误:shop_order_id 已存在
   * "errcode": 9300569 //参数错误:wx_pay_id 为空
   * "errcode": 9300570 //逻辑错误:该微信支付单号填写错误或未投保
   * "errcode": -1 //系统错误:请联系微信平台解决
   */
  public function add(\Weixin\Wx\Express\Delivery\Model\NoWorryReturn $noWorryReturn)
  {
    $params = $noWorryReturn->getParams();
    $rst = $this->_request->post($this->_url . 'add', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 查询退货 ID 状态
   * 描述：本接口用于商家查询用户退货状态（是否填写退货信息）及追踪用户退货物流，方便仓库收货。通过本接口查询退货 ID 状态，其中status是退货ID状态，order_status是退货 ID 对应的用户运单号的状态。
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/no_worry_return/get?access_token=ACCESS_TOKEN
   * 请求方式：POST
   * 请求参数
   * {
   * "return_id": "1935761508265738242"
   * }
   * 返回参数
   * {
   * "errcode": 0,
   * "errmsg": "OK",
   * "status": "1", // 0.用户未填写退货信息 1.预约上门取件 2.填写自行寄回运单号
   * "waybill_id": "JDxxxxxx", //运单号
   * "order_status": 0, //0.已下单待揽件 1.已揽件 2.运输中 3.派件中 4.已签收 5.异常 6.代签收 7.揽收失败 8.签收失败（拒收，超区） 11.已取消 13.退件中 14.已退件 99.未知
   * "delivery_name": "申通快递"//运力公司名称
   * "delivery_id": SF，//运力公司编码
   * }
   * 错误码列表
   * "errcode": 40097 //参数错误:return_id为空
   * "errcode": 931023 //参数错误:运单不存在
   * "errcode": -1 //系统错误:请联系微信平台解决
   */
  public function infoGet($return_id)
  {
    $params = array();
    $params['return_id'] = $return_id;
    $rst = $this->_request->post($this->_url . 'get', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 解绑退货 ID
   * 描述：当商家同意退货申请之后，与用户达成协商「无需退货」时，可以通过本接口可以解除商家退货单与退货 ID的绑定。考虑到预约快递员上门取件的情况在用户侧发生，因此只有当用户是自主填写运单号情况下才支持解绑退货 ID 。
   * 请求地址：https://api.weixin.qq.com/cgi-bin/express/delivery/no_worry_return/unbind?access_token=ACCESS_TOKEN
   * 请求方式：POST
   * 请求参数
   * {
   * "return_id": "1935761508265738242"
   * }
   *
   * 返回参数
   * {
   * "errcode": 0,
   * "errmsg": "OK",
   * }
   * 错误码列表
   * "errcode": 40097 //参数错误:return_id为空
   * "errcode": 931023 //参数错误:运单不存在
   * "errcode": -1 //系统错误:请联系微信平台解决
   */
  public function unbind($return_id)
  {
    $params = array();
    $params['return_id'] = $return_id;
    $rst = $this->_request->post($this->_url . 'unbind', $params);
    return $this->_client->rst($rst);
  }
}
