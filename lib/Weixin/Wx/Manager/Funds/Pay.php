<?php

namespace Weixin\Wx\Manager\Funds;

use Weixin\Client;

/**
 * 支付下单接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/wxafunds/API/order/create_order.html
 * 订单分账接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/wxafunds/API/order/profitsharing_order.html
 * 退款接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/wxafunds/API/order/refunds_order.html
 * 
 * @author guoyongrong
 *        
 */
class Pay
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/pay/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 小程序支付管理服务 /支付下单接口 /创建支付单
     * 创建订单
     * 接口请求示例
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/pay/createorder?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "combine_trade_no": "P20150806125346",
     * "expire_time":1647360558,
     * "sub_orders":[
     * {
     * "mchid":"1230000109",
     * "amount":100,
     * "trade_no":"20150806125346",
     * "description": "Image形象店-深圳腾大-QQ公仔"
     * }
     * ]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "payment_params": {
     * "timeStamp":1639124652
     * "nonceStr":"123",
     * "package":"prepay_id=123",
     * "paySign":"12904324823458940394",
     * "signType":"MD5"
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * openid string 是 用户的openid
     * combine_trade_no string 是 商家合单支付总交易单号，长度为6～32个字符，只能是数字、大小写字母_-|*@，小程序系统内保证唯一。同一combine_trade_no视为同一请求，不允许修改子单等参数。
     * expire_time number 否 订单失效时间，秒级时间戳
     * sub_orders Array Object SubOrder 是 子单列表
     * 回包参数说明
     * 字段名 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * payment_params Object PaymentParams 支付参数
     * Object SubOrder
     * 字段名 类型 是否必填 说明
     * mchid string 是 交易单对应的商家商户号
     * description string 是 商品描述
     * amount number 是 订单金额，单位为分
     * trade_no string 是 商家交易单号，只能是数字、大小写字母_-|*@ ，长度为6～32个字符，小程序系统内保证唯一。同一trade_no不允许修改价格等参数。
     * Object PaymentParams
     * 字段名 类型 是否必填 说明
     * timeStamp string 是 时间戳，从 1970 年 1 月 1 日 00:00:00 至今的秒数，即当前的时间
     * nonceStr string 是 随机字符串，长度为32个字符以下
     * package string 是 统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=***
     * paySign string 是 签名，具体见微信支付文档
     * signType string 是 签名算法
     */
    public function createOrder(\Weixin\Wx\Model\Funds\Pay\Order $order)
    {
        $params = $order->getParams();
        $rst = $this->_request->post($this->_url . 'createorder', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /支付下单接口 /关闭支付单
     * 关闭订单
     * 接口请求示例
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/pay/closeorder?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "combine_trade_no": "P20150806125346",
     * "sub_orders":[
     * {
     * "mchid":"1900000109",
     * "trade_no":"20150806125346"
     * }
     * ]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * openid string 是 用户的openid
     * combine_trade_no string 是 商家合单支付总交易单号
     * sub_orders Array Object SubCloseOrder 是 子单列表
     * Object SubCloseOrder
     * 字段名 类型 是否必填 说明
     * mchid string 是 交易单对应的商家商户号
     * trade_no string 是 商家交易单号
     * 返回参数说明
     * 字段名 类型 是否必填 说明
     * errcod number 是 错误码
     * errmsg string 是 错误信息
     */
    public function closeOrder(\Weixin\Wx\Model\Funds\Pay\Order $order)
    {
        $params = $order->getParams();
        $rst = $this->_request->post($this->_url . 'closeorder', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /支付下单接口 /查询订单详情
     * 查询订单详情
     * 接口请求示例
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/pay/getorder?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "trade_no": "123455"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "order":
     * {
     * "trade_no": "522346",
     * "transaction_id": "4302900974202204024351451925",
     * "combine_trade_no": "512346",
     * "mchid": "1623426221",
     * "create_time": 1648880172,
     * "update_time": 1648880485,
     * "pay_time": 1648880315,
     * "expire_time": 1651161600,
     * "amount": 1,
     * "description": "测试商品",
     * "refund_list": [{
     * "amount": 1,
     * "create_time": 1648880476,
     * "finish_time": 1648880483,
     * "result": "SUCCESS",
     * "refund_id": "50301901362022040218937476250",
     * "refund_no": "522347"
     * }],
     * "profit_sharing_list": [{
     * "mchid": "1623426221",
     * "amount": 1,
     * "create_time": 1648880985,
     * "finish_time": 1648881016,
     * "result": "SUCCESS",
     * "profit_sharing_id": "30002107912022040228952584675",
     * "profit_sharing_no": "512341"
     * }],
     * "profit_sharing_delay": 30,
     * "profit_sharing_frozen": 0,
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * trade_no string 是 商家交易单号
     * 返回参数说明
     * 参数 类型 是否必填 说明
     * errcode number 是 错误码
     * errmsg string 是 错误信息
     * order Object Order 是 订单信息
     * Object Order
     * 字段名 类型 是否必填 说明
     * trade_no string 是 商家交易单号
     * combine_trade_no string 是 商家合单支付总交易单号
     * mchid string 是 商户号
     * transaction_id string 否 微信支付侧交易单号
     * create_time number 是 订单创建时间，秒级时间戳
     * update_time number 是 订单更新时间，秒级时间戳
     * pay_time number 否 订单支付时间，秒级时间戳
     * expire_time number 否 订单过期时间，秒级时间戳
     * close_status number 否 订单关闭状态，0: 正常；1:已关闭
     * close_time number 否 订单关闭时间，秒级时间戳
     * amount number 是 订单金额，单位为分
     * description string 是 订单描述
     * profit_sharing_list Array Object ProfitSharingRecord 否 分账信息列表
     * refund_list Array Object RefundRecord 否 退款信息列表
     * profit_sharing_delay number 否 账期，订单由支付时间开始多少天后可以分账
     * profit_sharing_frozen number 否 订单当前是否被冻结分账，1:不能分账，0可以正常分账
     * Object ProfitSharingRecord
     * 字段名 类型 是否必填 说明
     * profit_sharing_no string 是 商家分账单号
     * profit_sharing_id string 是 微信支付侧分账单号
     * mchid string 是 商户号
     * amount number 是 分账金额，单位为分
     * create_time number 是 分账申请时间，秒级时间戳
     * finish_time number 否 分账完成时间，秒级时间戳
     * result string 否 分账结果
     * fail_reason string 否 失败原因
     * Object RefundRecord
     * 字段名 类型 是否必填 说明
     * refund_no string 是 商家退款单号
     * refund_id string 是 微信支付侧退款单号
     * amount number 是 退款金额，单位为分
     * create_time number 是 退款申请时间，秒级时间戳
     * finish_time number 否 退款完成时间，秒级时间戳
     * result string 否 退款结果
     * fail_reason string 否 失败原因
     */
    public function getOrder($trade_no)
    {
        // trade_no string 是 商家交易单号
        $params = array();
        $params['trade_no'] = $trade_no;
        $rst = $this->_request->post($this->_url . 'getorder', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /支付下单接口 /查询订单列表
     * 查询订单列表
     * 接口调用请求说明
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/pay/getorderlist?access_token=xxxxxxxxx
     * 请求参数
     * {
     * "begin_create_time": 1648137600,
     * "end_create_time": 1648173600,
     * "last_index": "12345",
     * "page_size": 10,
     * "mchid":"1230000109"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "has_more": true,
     * "last_index":"12345",
     * "trade_no_list": [
     * "12345",
     * ....
     * ]
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * last_index string 否 分页过程中上次请求返回的索引值
     * page_size number 是 每页订单数，上限100
     * begin_create_time number 是 起始创建时间，秒级时间戳，（起始和终止时间间隔不能超过1天）
     * end_create_time number 是 最终创建时间，秒级时间戳，（起始和终止时间间隔不能超过1天）
     * mchid string 否 商户号，不填默认拉取小程序系统内所有订单
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * trade_no_list Array string 交易单号列表
     * has_more bool 是否还有下一页
     * last_index string 当前索引值
     */
    public function getOrderList(\Weixin\Wx\Model\Funds\Pay\OrderQuery $query, $last_index = "", $page_size = 100)
    {
        $params = $query->getParams();
        // last_index string 否 分页过程中上次请求返回的索引值
        if (! empty($last_index)) {
            $params['last_index'] = $last_index;
        }
        // page_size number 是 每页订单数，上限100
        $params['page_size'] = $page_size;
        $rst = $this->_request->post($this->_url . 'getorderlist', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /分账接口 /订单分账
     * 订单分账
     * 接口请求示例
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/pay/profitsharingorder?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "mchid":"1230000109",
     * "trade_no": "1217752501201407033233368018",
     * "transaction_id":"4208450740201411110007820472",
     * "profit_sharing_no":"P20150806125346"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * openid string 是 用户的openid
     * mchid string 是 订单对应的商家商户号
     * trade_no string 是 商家交易单号
     * transaction_id string 是 支付单号
     * profit_sharing_no string 是 商家分账单号，小程序系统内唯一，同一分账单号多次请求等同一次。长度为6～32个字符。
     * 返回参数说明
     * 段名 类型 是否必填 说明
     * errcode number 是 错误码
     * errmsg string 是 错误信息
     * 返回码
     * 返回码 错误类型
     * -1 系统异常
     * 9720004 订单待分账余额为0
     */
    public function profitSharingOrder($openid, $mchid, $trade_no, $transaction_id, $profit_sharing_no)
    {
        $params = array();
        // openid string 是 用户的openid
        // mchid string 是 订单对应的商家商户号
        // trade_no string 是 商家交易单号
        // transaction_id string 是 支付单号
        // profit_sharing_no string 是 商家分账单号，小程序系统内唯一，同一分账单号多次请求等同一次。长度为6～32个字符。

        $params['openid'] = $openid;
        $params['mchid'] = $mchid;
        $params['trade_no'] = $trade_no;
        $params['transaction_id'] = $transaction_id;
        $params['profit_sharing_no'] = $profit_sharing_no;

        $rst = $this->_request->post($this->_url . 'profitsharingorder', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /退款接口 /申请退款
     * 订单退款
     * 接口请求示例
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/pay/refundorder?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "mchid":"1230000109",
     * "trade_no": "1217752501201407033233368018",
     * "transaction_id":"4208450740201411110007820472",
     * "refund_no":"1217752501201407033233368018",
     * "total_amount":100,
     * "refund_amount":50
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * openid string 是 用户的openid
     * mchid string 是 订单对应的商家商户号
     * trade_no string 是 商家交易单号
     * transaction_id string 是 支付单号
     * refund_no string 是 商家退款单号，小程序系统内部唯一，只能是数字、大小写字母_-|*@，同一退款单号多次请求只退一笔。长度为6～32个字符。
     * total_amount number 是 订单总金额
     * refund_amount number 是 退款金额
     * 返回参数说明
     * 字段名 类型 是否必填 说明
     * errcode number 是 错误码
     * errmsg string 是 错误信息
     */
    public function refundOrder($openid, $mchid, $trade_no, $transaction_id, $refund_no, $total_amount, $refund_amount)
    {
        $params = array();
        // openid string 是 用户的openid
        // mchid string 是 订单对应的商家商户号
        // trade_no string 是 商家交易单号
        // transaction_id string 是 支付单号
        // refund_no string 是 商家退款单号，小程序系统内部唯一，只能是数字、大小写字母_-|*@，同一退款单号多次请求只退一笔。长度为6～32个字符。
        // total_amount number 是 订单总金额
        // refund_amount number 是 退款金额
        $params['openid'] = $openid;
        $params['mchid'] = $mchid;
        $params['trade_no'] = $trade_no;
        $params['transaction_id'] = $transaction_id;
        $params['refund_no'] = $refund_no;
        $params['total_amount'] = $total_amount;
        $params['refund_amount'] = $refund_amount;

        $rst = $this->_request->post($this->_url . 'refundorder', $params);
        return $this->_client->rst($rst);
    }
}
