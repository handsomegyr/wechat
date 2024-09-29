<?php

namespace Weixin\Channels\Ec\Manager;

use Weixin\Client;

/**
 * 订单管理API
 * https://developers.weixin.qq.com/doc/store/API/order/list_get.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class Order
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/channels/ec/order/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 微信小店API /订单API /获取订单列表
     * 获取订单列表
     * 接口说明
     * 可通过该接口获取微信小店的订单列表
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/list/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * create_time_range object TimeRange 时间范围至少填一个 订单创建时间范围，具体结构请参考TimeRange结构体
     * update_time_range object TimeRange 时间范围至少填一个 订单更新时间范围，具体结构请参考TimeRange结构体
     * status number 否 订单状态，具体枚举值请参考RequestOrderStatus枚举
     * openid string 否 买家身份标识
     * next_key string 否 分页参数，上一页请求返回
     * page_size number 是 每页数量(不超过100)
     * 请求参数示例
     * {
     * "create_time_range": {
     * "start_time": 1658505600,
     * "end_time": 1658509200
     * },
     * "page_size": 10,
     * "next_key": "THE_NEXT_KEY"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode string 错误码
     * errmsg string 错误信息
     * order_id_list array string 订单号列表
     * next_key string 分页参数，下一页请求返回
     * has_more bool 是否还有下一页，true:有下一页；false:已经结束，没有下一页。
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "order_id_list": [
     * "3704612354559743232",
     * "3704849110714209536"
     * ],
     * "next_key": "THE_NEXT_KEY_NEW",
     * "has_more": true
     * }
     */
    public function listGet(
        \Weixin\Channels\Ec\Model\Order\TimeRange $create_time_range,
        \Weixin\Channels\Ec\Model\Order\TimeRange $update_time_range,
        $status = 0,
        $openid = '',
        $page_size = 100,
        $next_key = ""
    ) {
        $params = array();

        $create_time_range_data = $create_time_range->getParams();
        if (!empty($create_time_range_data)) {
            $params['create_time_range'] = $create_time_range_data;
        }

        $update_time_range_data = $update_time_range->getParams();
        if (!empty($update_time_range_data)) {
            $params['update_time_range'] = $update_time_range_data;
        }

        if (!empty($status)) {
            $params['status'] = $status;
        }

        if (!empty($openid)) {
            $params['openid'] = $openid;
        }

        $params['page_size'] = $page_size;
        $params['next_key'] = $next_key;

        $rst = $this->_request->post($this->_url . 'list/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /订单API /获取订单详情
     * 获取订单详情
     * 接口说明
     * 可通过该接口获取订单的详细信息
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单ID，可从获取订单列表中获得
     * encode_sensitive_info bool 否 用于商家提前测试订单脱敏效果，如果传true，即对订单进行脱敏，后期会默认对所有订单脱敏
     * 请求参数示例
     * {
     * "order_id": "37423523451235145"
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * order object Order 订单结构，具体结构请参考Order结构体
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "order": {
     * "order_id": "37423523451235145",
     * "status": 20,
     * "create_time": 1658505600,
     * "update_time": 1658505600,
     * "order_detail": {
     * "product_infos": [
     * {
     * "product_id": 234245,
     * "sku_id": 23424,
     * "sku_cnt": 10,
     * "on_aftersale_sku_cnt": 10,
     * "finish_aftersale_sku_cnt": 0,
     * "title": "健身环",
     * "thumb_img": "https://mmecimage.cn/p/wx37f38d59298839c3/HJE9eJaEc5bJk-eaArVdILSB7MMaHgdK2-JIn51nMQ",
     * "sale_price": 2000,
     * "market_price": 2000,
     * "sku_attrs": [
     * {
     * "attr_key": "产地",
     * "attr_value": "四川成都"
     * },
     * {
     * "attr_key": "材质",
     * "attr_value": "玻璃"
     * },
     * {
     * "attr_key": "适用人群",
     * "attr_value": "青年;中年"
     * },
     * {
     * "attr_key": "数量",
     * "attr_value": "33"
     * },
     * {
     * "attr_key": "精度",
     * "attr_value": "3.001"
     * },
     * {
     * "attr_key": "重量",
     * "attr_value": "38 mg"
     * },
     * {
     * "attr_key": "毛重",
     * "attr_value": "380 kg"
     * }
     * ]
     * }
     * ],
     * "pay_info": {
     * "prepay_id": "42526234625",
     * "transaction_id": "131456479687",
     * "prepay_time": 1658509200,
     * "pay_time": 1658509200,
     * "payment_method":1
     * },
     * "price_info": {
     * "product_price": 20000,
     * "order_price": 10500,
     * "freight": 500,
     * "discounted_price": 10000,
     * "is_discounted": true
     * },
     * "delivery_info": {
     * "address_info": {
     * "user_name": "陈先生",
     * "postal_code": "2435245",
     * "province_name": "广东",
     * "city_name": "广州",
     * "county_name": "海珠区",
     * "detail_info": "大塘",
     * "tel_number": "24534252"
     * },
     * "delivery_product_info": [
     * {
     * "waybill_id": "134654612313",
     * "delivery_id": "STO",
     * "delivery_time": 1620738080,
     * "deliver_type": 1,
     * "product_infos": [
     * {
     * "product_id": "234245",
     * "sku_id": "23424",
     * "product_cnt": 1
     * }
     * ]
     * }
     * ],
     * "ship_done_time": 1620738080,
     * "deliver_method":0
     * },
     * "coupon_info":{
     * "user_coupon_id":"301234567890"
     * },
     * "ext_info": {
     * "customer_notes": "发顺丰",
     * "merchant_notes": "库存不足，取消",
     * "finder_id": "sph3FZbOEY46mAB",
     * "live_id": "export/UzFfAgtgekIEAQAAAAAAt40WWe5njQAAAAstQy6ubaLX4KHWvLEZgBPE5KNoYRJdUeaEzNPgMJq4tEJ8QSCaA2N_Iua2abcd",
     * "order_scene": 2
     *
     * },
     * "sharer_info":{
     * "sharer_openid": "SHAREROPENID",
     * "sharer_unionid": "SHARERUNIONID",
     * "sharer_type": 1,
     * "share_scene": 1,
     * "handling_progress": 1
     * },
     * "settle_info":{
     * "commission_fee" : 10,
     * "predict_commission_fee": 10
     * },
     * "sku_sharer_infos":[
     * {
     * "sharer_openid": "SHAREROPENID",
     * "sharer_unionid": "SHARERUNIONID",
     * "sharer_type": 1,
     * "share_scene": 1,
     * "sku_id": "23424"
     * }
     * ]
     * },
     * "aftersale_detail": {
     * "aftersale_order_list": [
     * {
     * "aftersale_order_id": "1234",
     * "status": 13
     * }
     * ],
     * "on_aftersale_order_cnt": 1
     * },
     * "openid": "OPENID"
     * }
     * }
     */
    public function infoGet($order_id, $encode_sensitive_info = false)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $params['encode_sensitive_info'] = $encode_sensitive_info;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /订单API /修改订单价格
     * 修改订单价格
     * 接口说明
     * 可通过该接口修改订单价格。
     *
     * 注意事项
     * 目前只支持改低价格， 暂时不支持改高价格；
     * 每次修改价格时以每种商品(同一sku_id)为单位，定义该种商品的最新总价，如果某种商品在请求中不输入，则默认该商品的价格不修改；
     * 订单在付款前可以进行最多不超过50次的修改价格操作，同一订单每次新的改价操作执行成功后之前所有的改价操作都将失效。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/price/update?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可通过获取订单列表接口获取
     * change_express bool 是 是否修改运费
     * express_fee number 否 修改后的运费价格（change_express=true时必填），以分为单位
     * change_order_infos array ChangeOrderInfo 是 改价列表，具体可见结构体ChangeOrderInfo
     * 请求参数示例
     * {
     * "order_id": "123456",
     * "change_express": true,
     * "express_fee": 0,
     * "change_order_infos": [
     * {
     * "product_id": "1234",
     * "sku_id": "5678",
     * "change_price": 300
     * }
     * ]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function priceUpdate($order_id, $change_express, $express_fee, array $change_order_infos)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $params['change_express'] = $change_express;
        $params['express_fee'] = $express_fee;
        foreach ($change_order_infos as $change_order_info) {
            $params['change_order_infos'][] = $change_order_info->getParams();
        }
        $rst = $this->_request->post($this->_url . 'price/update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /订单API /修改订单备注
     * 修改订单备注
     * 接口说明
     * 可通过该接口修改订单备注。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/merchantnotes/update?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可通过获取订单列表接口获取
     * merchant_notes string 是 备注内容
     * 请求参数示例
     * {
     * "order_id": "123456",
     * "merchant_notes": "abc"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * }
     */
    public function merchantnotesUpdate($order_id, $merchant_notes)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $params['merchant_notes'] = $merchant_notes;
        $rst = $this->_request->post($this->_url . 'merchantnotes/update', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /修改订单地址
     * 修改订单地址
     * 接口说明
     * 可通过该接口对订单地址进行修改。
     *
     * 注意事项
     * 未发货的订单可以修改，次数限制为5次。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/address/update?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可通过获取订单列表接口获取
     * user_address object AddressInfo 是 新地址，具体可见结构体AddressInfo
     * 请求参数示例
     * {
     * "order_id": "123456",
     * "user_address": {
     * "user_name": "陈先生",
     * "postal_code": "2435245",
     * "province_name": "广东",
     * "city_name": "广州",
     * "county_name": "海珠区",
     * "detail_info": "大塘",
     * "national_code": "234234",
     * "tel_number": "24534252"
     * }
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function addressUpdate($order_id, \Weixin\Channels\Ec\Model\Order\AddressInfo $user_address)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $params['user_address'] = $user_address->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /修改物流信息
     * 修改物流信息
     * 接口说明
     * 可通过该接口修改物流信息。
     *
     * 注意事项
     * 发货完成的订单可以修改，最多修改1次；
     * 拆包发货的订单暂不允许修改物流；
     * 虚拟商品订单暂不允许修改物流。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/deliveryinfo/update?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可通过获取订单列表接口获取
     * delivery_list array DeliveryInfo 是 物流信息，具体可见结构体DeliveryInfo
     * 请求参数示例
     * {
     * "order_id": "12345",
     * "delivery_list": [{
     * "delivery_id": "EMS",
     * "waybill_id": "1234",
     * "deliver_type": 1,
     * "product_infos": [{
     * "product_cnt": 1,
     * "product_id": "112233",
     * "sku_id": "445566"
     * }]
     * }]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function deliveryinfoUpdate($order_id, array $delivery_list)
    {
        $params = array();
        $params['order_id'] = $order_id;
        foreach ($delivery_list as $delivery) {
            $params['delivery_list'][] = $delivery->getParams();
        }
        $rst = $this->_request->post($this->_url . 'deliveryinfo/update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /订单API /上传生鲜质检信息
     * 上传生鲜质检信息
     * 接口说明
     * 可通过该接口给生鲜类质检订单上传商品打包信息
     *
     * 注意事项
     * 非生鲜质检的订单不能进行上传。
     * 图片url必须用图片上传接口获取
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/freshinspect/submit?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id
     * audit_items array AuditItem 是 审核项，结构体详情请参考AuditItem
     * 请求参数示例
     * 上传商品打包信息
     * {
     * "order_id":"12345",
     * "audit_items":[
     * {
     * "item_name":"product_express_pic_url",
     * "item_value":"https://store.mp.video.tencent-cloud.com/x"
     * },
     * {
     * "item_name":"product_packaging_box_panoramic_video_url",
     * "item_value":"https://store.mp.video.tencent-cloud.com/y"
     * },
     * {
     * "item_name":"product_unboxing_panoramic_video_url",
     * "item_value":"https://store.mp.video.tencent-cloud.com/z"
     * },
     * {
     * "item_name":"single_product_detail_panoramic_video_url",
     * "item_value":"https://store.mp.video.tencent-cloud.com/p"
     * }
     * ]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function freshinspectSubmit($order_id, array $audit_items)
    {
        $params = array();
        $params['order_id'] = $order_id;
        foreach ($audit_items as $audit) {
            $params['audit_items'][] = $audit->getParams();
        }
        $rst = $this->_request->post($this->_url . 'freshinspect/submit', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /同意用户修改收货地址申请
     * 同意用户修改收货地址申请
     * 接口说明
     * 可通过该接口同意用户修改收货地址申请。
     *
     * 注意事项
     * 买家对下单超过6小时的订单修改收货地址的操作，需要商家审批同意，如果从发起申请开始后12小时商家均未同意或者拒绝，则系统自动通过申请。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/addressmodify/accept?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可通过获取订单列表接口获取
     * 请求参数示例
     * {
     * "order_id": "123456",
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function addressmodifyAccept($order_id)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $rst = $this->_request->post($this->_url . 'addressmodify/accept', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /拒绝用户修改收货地址申请
     * 拒绝用户修改收货地址申请
     * 接口说明
     * 可通过该接口拒绝买家的订单修改收货地址申请
     *
     * 注意事项
     * 当买家对下单超过6小时的订单修改收货地址的操作后，需要商家进行审批操作，如果从发起申请开始后12小时内商家均未同意或者拒绝，则系统自动通过申请。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/addressmodify/reject?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可在获取订单列表获取
     * 请求参数示例
     * {
     * "order_id": "123456",
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function addressmodifyReject($order_id)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $rst = $this->_request->post($this->_url . 'addressmodify/reject', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /订单搜索
     * 订单搜索
     * 接口说明
     * 该接口用于根据传递的条件搜索订单
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/search?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * search_condition object SearchCondition 是 搜索条件，具体结构请参考SearchCondition结构体
     * on_aftersale_order_exist number 否 不传该参数：搜索全部订单；
     * 0：搜索没有正在售后的订单；
     * 1：搜索正在售后且售后单数量>=1的订单
     *
     * 除了以下几种售后单状态（AfterSaleStatus）外其它的都是正在售后的状态：
     * USER_CANCELD
     * MERCHANT_REFUND_RETRY_FAIL
     * MERCHANT_FAIL
     * MERCHANT_REFUND_SUCCESS
     * MERCHANT_RETURN_SUCCESS
     * status number 否 订单状态，枚举值见RequestOrderStatus
     * next_key string 是 分页参数，上一页请求返回
     * page_size number 是 每页数量(不超过100)
     * 请求参数示例
     * {
     * "search_condition": {
     * "title": "标题关键字",
     * "sku_code": "12321",
     * "user_name": "张三",
     * "tel_number": "13700000000",
     * "order_id": "3713218625342112768",
     * "merchant_notes": "晚点发货",
     * "customer_notes": "发顺丰"
     * },
     * "on_aftersale_order_exist": 0,
     * "status": 20,
     * "page_size": 10,
     * "next_key": "THE_NEXT_KEY"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode string 错误码
     * errmsg string 错误信息
     * order_id_list array string 订单号列表
     * next_key string 分页参数，下一个页请求回传
     * has_more bool 是否还有下一页, true:有下一页；false:已经结束，没有下一页。
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "orders": [
     * "3715847042071365120",
     * "3715847042071365121"
     * ],
     * "has_more": false,
     * "next_key": "THE_NEXT_KEY_NEW"
     * }
     */
    public function search(\Weixin\Channels\Ec\Model\Order\SearchCondition $search_condition, $on_aftersale_order_exist = 0, $status = "", $page_size = 100, $next_key = "")
    {
        $params = array();
        $params['search_condition'] = $search_condition;
        $params['on_aftersale_order_exist'] = $on_aftersale_order_exist;
        $params['status'] = $status;
        $params['next_key'] = $next_key;
        $params['page_size'] = $page_size;
        $rst = $this->_request->post($this->_url . 'search', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /兑换虚拟号
     * 兑换虚拟号
     * 接口说明
     * 可通过该接口兑换虚拟号
     *
     * 注意事项
     * 重新兑换的虚拟号码有效期为3天，每个订单可以兑换3次。
     * 该接口用于在订单结束后，原虚拟号码会失效，商家可按需重新兑换虚拟号码。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/virtualtelnumber/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id，可通过获取订单列表接口获取
     * 请求参数示例
     * {
     * "order_id": "12345"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * virtual_tel_number string 虚拟号码
     * virtual_tel_expire_time number 虚拟号码过期时间
     * get_virtual_tel_cnt number 兑换虚拟号码次数
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "virtual_tel_number": "6767532382",
     * "virtual_tel_expire_time": xxxxxxxx,
     * "get_virtual_tel_cnt": 1
     * }
     */
    public function virtualtelnumberGet($order_id)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $rst = $this->_request->post($this->_url . 'virtualtelnumber/get', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /订单API /解码订单包含的敏感数据
     * 解码订单包含的敏感数据
     * 接口说明
     * 为保护敏感数据（如收货人昵称、电话号码、详细收货地址），平台对这些信息进行了部分隐藏。通过本接口操作订单后，可以获取到这些信息的完整数据。
     *
     * 注意事项
     * 本接口仅适用于已付款的订单；
     * 解码操作对订单数量有严格限制。请合理调用，避免不必要的重复请求。超出限制将导致接口报错。对同一订单的多次调用，系统仅计算一次；
     * 商家可用基础解码数为30次/日，次日重置，若当日次数不满足使用需通过微信小店后台申请提额，商家可继续使用通过次数，次日失效。详情可见订单信息解密额度调整上线公告
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/order/sensitiveinfo/decode?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * order_id string 是 订单id
     * 请求参数示例
     * {
     * "order_id": "123456"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * address_info Object AddressInfo 收货信息，具体枚结构请参考AddressInfo结构体
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function sensitiveinfoDecode($order_id)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $rst = $this->_request->post($this->_url . 'sensitiveinfo/decode', $params);
        return $this->_client->rst($rst);
    }
}
