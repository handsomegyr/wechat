<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 物流接口
 *
 * @author guoyongrong
 *        
 */
class Delivery
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/delivery/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取快递公司列表
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/delivery/get_company_list.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/delivery/get_company_list?access_token=xxxxxxxxx
     * 请求参数示例
     * {}
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "company_list":
     * [
     * {
     * "delivery_id": "SF",
     * "delivery_name":"顺丰速运"
     * },
     * {
     * "delivery_id": "YTO",
     * "delivery_name":"圆通快速"
     * },
     * {
     * "delivery_id": "ZTO",
     * "delivery_name":"中通快速"
     * },
     * ...
     * ]
     * }
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * company_list[].delivery_id string 快递公司id
     * company_list[].delivery_name string 快递公司名称
     */
    public function getCompanyList()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get_company_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 订单发货
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/delivery/send.html
     * 接口调用请求说明
     * 新增订单时请指定delivery_type：1: 正常快递, 2: 无需快递, 3: 线下配送, 4: 用户自提。
     *
     * 对于没有物流的订单，可以不传delivery_list。
     *
     * delivery_id请参考获取快递公司列表接口的数据结果，不能自定义，如果对应不上，请传"delivery_id":"OTHERS"。
     *
     * 当finish_all_delivery=1时，把订单状态从20（待发货）流转到30（待收货）。
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/delivery/send?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "order_id": 123456,,
     * "out_order_id": "xxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "finish_all_delivery": 0,
     * "delivery_list":
     * [
     * {
     * "delivery_id": "SF",
     * "waybill_id": "23424324253",
     * "product_info_list": [
     * {
     * "out_product_id": 1,
     * "out_sku_id": 2,
     * "product_cnt": 1
     * }
     * ]
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
     * order_id number 否 订单ID
     * out_order_id string 否 商家自定义订单ID，与 order_id 二选一
     * openid string 是 用户的openid
     * finish_all_delivery number 是 发货完成标志位, 0: 未发完, 1:已发完
     * delivery_list DeliveryInfo[] 否 快递信息，delivery_type=1时必填
     * delivery_list[].delivery_id string 是 快递公司ID，通过获取快递公司列表获取
     * delivery_list[].waybill_id string 是 快递单号
     * delivery_list[].product_info_list[] DeliveryProduct[] 是 物流单对应的商品信息
     * delivery_list[].product_info_list[].out_product_id string 是 订单里的out_product_id
     * delivery_list[].product_info_list[].out_sku_id string 是 订单里的out_sku_id
     * delivery_list[].product_info_list[].product_cnt number 是 商品数量
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function send(\Weixin\Wx\Model\Shop\Delivery $delivery)
    {
        $params = $delivery->getParams();
        $rst = $this->_request->post($this->_url . 'send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 订单确认收货
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/delivery/recieve.html
     * 接口调用请求说明
     * 把订单状态从30（待收货）流转到100（完成）
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/delivery/recieve?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "order_id": 123456,
     * "out_order_id": "xxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * order_id number 否 订单ID
     * out_order_id string 否 商家自定义订单ID，与 order_id 二选一
     * openid string 是 用户的openid
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function recieve($openid, $order_id = "", $out_order_id = "")
    {
        $params = array();
        if (!empty($order_id)) {
            $params['order_id'] = $order_id;
        }
        if (!empty($out_order_id)) {
            $params['out_order_id'] = $out_order_id;
        }
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . 'recieve', $params);
        return $this->_client->rst($rst);
    }
}
