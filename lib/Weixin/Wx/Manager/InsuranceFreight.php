<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 无忧退货（运费险）管理API
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/industry/express/business/freight_insurance.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class InsuranceFreight
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
   * 开通无忧退货接口
   * PathName: /wxa/business/insurance_freight/open
   * 请求参数：
   * 无
   * 返回参数：
   * 无
   */
  public function open()
  {
    $params = array();
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/open', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 查询开通状态接口
   * PathName: /wxa/business/insurance_freight/query_open
   * 请求参数：
   * 无
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * is_open 是否开通 uint32 0:否，1:是
   * 投保接口(发货时投保)
   */
  public function queryOpen()
  {
    $params = array();
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/query_open', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 投保接口(发货时投保)
   * PathName: /wxa/business/insurance_freight/createorder
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * openid 买家openid string Y 必须和理赔openid一致
   * order_no 微信支付单号 string Y 一个微信支付单号只能投保一次
   * pay_time 微信支付时间 uint32 Y 秒级时间戳，时间误差3天内
   * pay_amount 微信支付金额 uint32 Y 单位：分
   * delivery_no 发货运单号 string Y
   * delivery_place 发货地址 object Y
   * - province 省 string Y
   * - city 市 string Y
   * - county 区 string Y
   * - address 详细地址 string Y
   * receipt_place 收货地址 object Y
   * - province 省 string Y
   * - city 市 string Y
   * - county 区 string Y
   * - address 详细地址 string Y
   * product_info 投保订单信息 object Y 用于微信下发投保和理赔通知给用户，用户点击可查看投保订单，点击订单可跳回商家小程序
   * - order_path 投保订单在商家小程序的path string Y 投保订单在商家小程序的path
   * - goods_list 投保订单商品列表 Array Y 投保商品list，一个元素为对象的数组,结构如下↓
   * goods_list内对象参数名称 类型 必选 备注
   * name string Y 投保商品名称
   * url string Y 投保商品图片url
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * policy_no 保单号 string
   * insurance_end_date 保险止期 string 格式: yyyy-mm-dd hh24:mi:ss
   * estimate_amount 保险公司预估理赔金额 uint64 单位： 分
   * premium 保费 uint32 单位： 分
   * 请求参数示例
   *
   * {
   * "openid":"oZGTP5DwGDPfEf1EBBHH_oxHw2aU",
   * "order_no": "4200001197202103228672982585",
   * "pay_amount": 1,
   * "pay_time": 1679473667,
   * "delivery_place":{
   * "province":"广东省",
   * "city": "广州市",
   * "county": "海珠区",
   * "address": "创业园23号"
   * },
   * "receipt_place":{
   * "province":"广东省",
   * "city": "惠州市",
   * "county": "惠普区",
   * "address": "龙山村10-2"
   * },
   * "delivery_no": "d20230322001"
   * }
   * 返回参数示例
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "policy_no": "10288003264673876282",
   * "insurance_end_date": "2023-06-20 16:36:54",
   * "estimate_amount": 1200
   * }
   */
  public function createOrder(\Weixin\Wx\Model\InsuranceFreightOrder $order)
  {
    $params = $order->getParams();
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/createorder', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 理赔接口 (收到用户退货后再触发)
   * PathName: /wxa/business/insurance_freight/claim
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * openid 买家openid string Y 与投保保持一致
   * order_no 微信支付单号 string Y 与投保保持一致
   * refund_delivery_no 退款运单号 string Y 理赔退款运单号唯一
   * refund_company 退款快递公司 string Y
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * report_no 理赔报案号 string 成功申请理赔时返回
   * is_home_pick_up 是否上门取件 uint32 0:否；1:是
   * 请求参数示例
   *
   * {
   * "openid": "oZGTP5DwGDPfEf1EBBHH_oxHw2aU",
   * "order_no": "4200001197202103228672982585",
   * "refund_delivery_no" : "rd20230322001",
   * "refund_company": "SF"
   * }
   * 返回参数示例
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "report_no": "90581008120350195232",
   * "is_home_pick_up": 1
   * }
   */
  public function claim($openid, $order_no, $refund_delivery_no, $refund_company)
  {
    // openid 买家openid string Y 与投保保持一致
    // order_no 微信支付单号 string Y 与投保保持一致
    // refund_delivery_no 退款运单号 string Y 理赔退款运单号唯一
    // refund_company 退款快递公司 string Y
    $params = array();
    $params['openid'] = $openid;
    $params['order_no'] = $order_no;
    $params['refund_delivery_no'] = $refund_delivery_no;
    $params['refund_company'] = $refund_company;
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/claim', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 申请充值订单号接口 (支持自定义金额)
   * PathName: /wxa/business/insurance_freight/createchargeid
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * quota 充值金额 uint64 Y 单位：分
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * order_id 充值订单id uint64
   * 请求参数示例
   *
   * {
   * "quota" : 1000
   * }
   * 返回参数示例
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "order_id": 2850151276313431996
   * }
   */
  public function createChargeId($quota)
  {
    $params = array();
    $params['quota'] = $quota;
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/createchargeid', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 申请支付接口
   * PathName: /wxa/business/insurance_freight/applypay
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * order_id 充值订单id uint64 Y 与createchargeid 保持一致，js等语言防止精度错误传string
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * pay_url 充值链接 string
   * 特别提示： 充值后退款只能退回原充值账号
   *
   * 请求参数示例
   *
   * {
   * "order_id" : 2850151276313431996
   * }
   * 返回参数示例
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "pay_url": "https://fuwu.weixin.qq.com/service/common/buy?hasApply=1&orderId=2850151276313431996"
   * }
   */
  public function applyPay($order_id)
  {
    $params = array();
    $params['order_id'] = $order_id;
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/applypay', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 拉取充值订单信息接口
   * PathName: /wxa/business/insurance_freight/getpayorderlist
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * status_list 订单状态 array[uint32] Y 状态如下:
   * 1: 待支付
   * 2: 支付成功
   * 3: 使用中
   * 4: 已用完
   * 5: 退款中
   * 6: 已退款
   * 10: 支付超时
   * offset 分页offset uint32 N 默认0
   * limit 分页limit uint32 N 默认30
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * total 总数 uint32 总数
   * list 充值订单列表 array[object]
   * - order_id 充值单号 uint64
   * - order_status 订单状态 uint32 状态如下:
   * 1: 待支付
   * 2: 支付成功
   * 3: 使用中
   * 4: 已用完
   * 5: 退款中
   * 6: 已退款
   * 10: 支付超时
   * - total_price 充值金额 uint64 单位：分
   * - create_time 订单创建时间 uint32 秒级时间戳
   * - pay_time 支付时间 uint32 秒级时间戳
   * - can_refund 是否可以退款 bool
   * - refund_time 退款时间 uint32 秒级时间戳
   * - refund_status 退款状态 uint32 状态如下:
   * 1: 未退款
   * 2: 退款中
   * 4: 退款成功
   * 5: 退款失败
   * - refund_amt 退款金额 uint64 单位：分
   * 请求参数示例
   *
   * {
   * "status_list": [
   * 2, 3, 4, 5, 6
   * ],
   * "offset": 0,
   * "limit": 20
   * }
   * 返回参数示例
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "list": [
   * {
   * "order_id": 2850151276313431996,
   * "order_status": 5,
   * "total_price": 1000,
   * "create_time": 1678966793,
   * "pay_time": 1678966880,
   * "can_refund": true,
   * "refund_time": 0,
   * "refund_status": 1
   * }
   * ],
   * "total": 1
   * }
   */
  public function getPayOrderList(array $status_list, $offset = 0, $limit = 30)
  {
    // status_list 订单状态 array[uint32] Y 状态如下:
    // offset 分页offset uint32 N 默认0
    // limit 分页limit uint32 N 默认30
    $params = array();
    $params['status_list'] = $status_list;
    $params['offset'] = $offset;
    $params['limit'] = $limit;
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/getpayorderlist', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 退款接口
   * PathName: /wxa/business/insurance_freight/refund
   * 请求参数：
   * 无 返回参数：
   * 无
   * 特别提示： 充值后退款只能退回原充值账号
   */
  public function refund()
  {
    $params = array();
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/refund', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 拉取摘要接口 (查询当前保费、投保单量、理赔单量、账号余额等信息)
   * PathName: /wxa/business/insurance_freight/getsummary
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * begin_time 查询开始时间 uint32 N 秒级时间戳
   * end_time 查询结束时间戳 uint32 N 秒级时间戳
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * total 投保总数 uint32
   * claim_num 理赔总数 uint32
   * claim_succ_num 理赔成功数 uint32
   * premium 当前保费 uint32 单位：分
   * funds 当前账号余额 uint32 单位: 分
   * need_close 是否不能投保 bool 系统安全原因不能投保
   */
  public function getSummary($begin_time, $end_time)
  {
    // begin_time 查询开始时间 uint32 N 秒级时间戳
    // end_time 查询结束时间戳 uint32 N 秒级时间戳
    $params = array();
    if (! empty($begin_time)) {
      $params['begin_time'] = $begin_time;
    }
    if (! empty($end_time)) {
      $params['end_time'] = $end_time;
    }
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/getsummary', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 拉取保单信息接口
   * PathName: /wxa/business/insurance_freight/getorderlist
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * openid 买家openid string N 与投保理赔保持一致
   * order_no 微信支付单号 string N 与投保理赔保持一致
   * policy_no 保单号 string N
   * report_no 理赔报案号 string N
   * delivery_no 发货运单号 string N
   * refund_delivery_no 退款运单号 string N
   * begin_time 查询开始时间 uint32 N 秒级时间戳
   * end_time 查询结束时间 uint32 N 秒级时间戳
   * status_list 保单状态 array[uint32] N 状态如下：
   * 2: 保障中
   * 4: 理赔中
   * 5: 理赔成功
   * 6: 理赔失败
   * 7: 投保过期
   * offset 分页offset uint32 N
   * limit 分页limit uint32 N 默认为100，最大为100
   * sort_direct 排序方式 uint32 N 0：create_time正序，1：create_time倒序
   * 返回参数：
   *
   * 参数名 参数描述 类型 备注
   * total 总数 uint32
   * list 保单列表 array[object]
   * - order_no 微信支付单号 string
   * - policy_no 保单号 string
   * - report_no 理赔报案号 string
   * - delivery_no 发货运单号 string
   * - refund_delivery_no 退款运单号 string
   * - premium 保费 uint32 单位：分
   * - estimate_amount 预估理赔金额 uint32 单位：分
   * - status 保单状态 uint32 状态如下：
   * 2: 保障中
   * 4: 理赔中
   * 5: 理赔成功
   * 6: 理赔失败
   * 7: 投保过期
   * - pay_fail_reason 理赔打款失败原因 string
   * - pay_finish_time 理赔款打给用户的时间 uint32
   * - is_home_pick_up 是否上门取件 uint32 0:否；1:是
   * 请求参数示例
   *
   * {
   * "status_list": [
   * 2, 4, 5
   * ],
   * "offset": 0,
   * "limit": 20
   * }
   * 返回参数示例
   *
   *
   * {
   * "errcode": 0,
   * "errmsg": "ok",
   * "list": [
   * {
   * "order_no": "4200001197202103228672982584",
   * "policy_no": "10288003264673876281",
   * "report_no": "",
   * "status": 2,
   * "insurance_end_date": "2023-06-14 19:41:34",
   * "premium": 20,
   * "estimate_amount": 1200,
   * "delivery_no": "delivery20230321001",
   * "refund_delivery_no": "delivery20230322001",
   * "is_home_pick_up": 1
   * },
   * {
   * "order_no": "4200001197202103228672982585",
   * "policy_no": "10288003264673876282",
   * "report_no": "90581008120350195232",
   * "status": 4,
   * "insurance_end_date": "2023-06-20 16:36:54",
   * "premium": 20,
   * "estimate_amount": 1200,
   * "delivery_no": "delivery20230322001",
   * "refund_delivery_no": "delivery20230322001",
   * "is_home_pick_up": 1
   * }
   * ],
   * "total": 2
   * }
   */
  public function getOrderList(\Weixin\Wx\Model\InsuranceFreightOrderQuery $orderQuery, $offset = 0, $limit = 100, $sort_direct = 0)
  {
    $params = $orderQuery->getParams();

    // offset 分页offset uint32 N
    $params['offset'] = $offset;
    // limit 分页limit uint32 N 默认为100，最大为100
    $params['limit'] = $limit;
    // sort_direct 排序方式 uint32 N 0：create_time正序，1：create_time倒序
    $params['sort_direct'] = $sort_direct;
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/getorderlist', $params);
    return $this->_client->rst($rst);
  }

  /**
   * 设置告警余额接口
   * 开发者可通过接口自定义余额为xx时通知小程序管理员（余额xx无改动情况下24h内通知一次）。通知消息将通过 微信公众平台 下发。
   *
   * PathName: /wxa/business/insurance_freight/update_notify_funds
   * 请求参数：
   *
   * 参数名 参数描述 类型 是否必须 备注
   * notify_funds 通知的金额 uint32 N 单位：分；设置为0不通知
   * 返回参数：
   * 无
   */
  public function updateNotifyFunds($notify_funds)
  {
    // notify_funds 通知的金额 uint32 N 单位：分；设置为0不通知
    $params = array();
    $params['notify_funds'] = $notify_funds;
    $rst = $this->_request->post($this->_url . 'wxa/business/insurance_freight/update_notify_funds', $params);
    return $this->_client->rst($rst);
  }
}
