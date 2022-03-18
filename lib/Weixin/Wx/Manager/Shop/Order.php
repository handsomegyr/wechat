<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 订单接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/order_readme.html
 *
 * @author guoyongrong
 *        
 */
class Order
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/order/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 生成订单
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/add_order.html
     * 接口调用请求说明
     * 该接适用于使用ticket支付校验方案或不需要拉起收银台（requestOrderPayment）的场景，详情请见开发指引第3.3节
     *
     * 注意：该接口可重入，如果order_id或out_order_id已存在，会直接更新整个订单数据
     *
     * 请求成功后将会创建一个status=10的订单（status枚举见下文）
     *
     * 每个ticket只能消费一次，创建订单接口可以多次调，但是不是生成新ticket要视情况而定 场景A: 第一次生成ticketA，拉起收银台消费ticketA后ticketA就失效了 第二次再调就生成新的ticketB了
     *
     * 场景B: 第一次生成ticketA，不调收银台消费这个ticket，那么24小时内再调生成的还是ticketA，超过24小时生成的是新的ticketA'
     *
     * 目前只有订单支付成功后进入的才会将订单同步至订单中心。
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/order/add?access_token=xxxxxxxxx
     * 请求参数示例一(普通支付场景)
     * {
     * "create_time": "2020-03-25 13:05:25",
     * "out_order_id": "xxxxx", // 必填，普通场景下的外部订单ID；合单支付（多订单合并支付一次）场景下是主外部订单ID
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "path": "/pages/order.html?out_order_id=xxxxx", // 这里的path中的最好有一个参数的值能和out_order_id的值匹配上
     * "scene": 1177, // 下单时小程序的场景值，可通过[getLaunchOptionsSync](https://developers.weixin.qq.com/miniprogram/dev/api/base/app/life-cycle/wx.getLaunchOptionsSync.html)或[onLaunch/onShow](https://developers.weixin.qq.com/miniprogram/dev/reference/api/App.html#onLaunch-Object-object)拿到
     * "out_user_id": "323232323",
     * "order_detail":
     * {
     * "product_infos":
     * [
     * {
     * "out_product_id": "12345",
     * "out_sku_id":"23456",
     * "product_cnt": 10,
     * "sale_price": 100, //生成这次订单时商品的售卖价，可以跟上传商品接口的价格不一致
     * "real_price": 100, // 扣除优惠后单件sku的分摊价格（单位：分），如果没优惠则与sale_price一致
     * "path": "pages/productDetail/productDetail?productId=2176180",
     * "title" : "洗洁精",
     * "head_img": "http://img10.360buyimg.com/n1/s450x450_jfs/t1/85865/39/13611/488083/5e590a40E4bdf69c0/55c9bf645ea2b727.jpg",
     * },
     * ...
     * ],
     * "pay_info": {
     * "pay_method_type": 0, // 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
     * "prepay_id": "42526234625", // pay_method_type = 0时必填
     * "prepay_time": "2020-03-25 14:04:25"
     * },
     * "price_info": { // 注意价格字段的单价是分，不是元
     * "order_price": 1600,
     * "freight": 500,
     * "discounted_price": 100,
     * "additional_price": 200,
     * "additional_remarks": "税费"
     * }
     * },
     * "delivery_detail": {
     * "delivery_type": 1, // 1: 正常快递, 2: 无需快递, 3: 线下配送, 4: 用户自提
     * },
     * "address_info": {
     * "receiver_name": "张三",
     * "detailed_address": "详细收货地址信息",
     * "tel_number": "收货人手机号码",
     * "country": "国家，选填",
     * "province": "省份，选填",
     * "city": "城市，选填",
     * "town": "乡镇，选填"
     * }
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data":
     * {
     * "order_id":32434234,
     * "out_order_id": "xxxxx",
     * "ticket": "xxxxxxx",
     * "ticket_expire_time": "2020-12-01 00:00:00",
     * "final_price": 10500 //final_price=product_price+freight-discounted_price+additional_price
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * create_time string 是 创建时间，yyyy-MM-dd HH:mm:ss
     * out_order_id string 是 商家自定义订单ID
     * openid string 是 用户的openid
     * path string 是 商家小程序该订单的页面path，用于微信侧订单中心跳转
     * scene number 是 下单时小程序的场景值，可通getLaunchOptionsSync或onLaunch/onShow拿到
     * order_detail.product_infos[].out_product_id string 是 商家自定义商品ID
     * order_detail.product_infos[].out_sku_id string 是 商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
     * order_detail.product_infos[].product_cnt number 是 购买的数量
     * order_detail.product_infos[].sale_price number 是 生成订单时商品的售卖价（单位：分），可以跟上传商品接口的价格不一致
     * order_detail.product_infos[].real_price number 是 扣除优惠后单件sku的均摊价格（单位：分），如果没优惠则与sale_price一致
     * order_detail.product_infos[].head_img string 是 生成订单时商品的头图
     * order_detail.product_infos[].title string 是 生成订单时商品的标题
     * order_detail.product_infos[].path string 是 绑定的小程序商品路径
     * order_detail.pay_info.pay_method_type number 是 支付方式，0，微信支付，1: 货到付款，2：商家会员储蓄卡（默认0）
     * order_detail.pay_info.prepay_id string 否 预支付ID，支付方式为“微信支付”必填
     * order_detail.pay_info.prepay_time string 否 预付款时间（拿到prepay_id的时间）， 支付方式为“微信支付”必填，yyyy-MM-dd HH:mm:ss
     * order_detail.price_info.order_price number 是 该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
     * order_detail.price_info.freight number 是 运费（单位：分）
     * order_detail.price_info.discounted_price number 否 优惠金额（单位：分）
     * order_detail.price_info.additional_price number 否 附加金额（单位：分）
     * order_detail.price_info.additional_remarks string 否 附加金额备注
     * delivery_detail.delivery_type number 是 1: 正常快递, 2: 无需快递, 3: 线下配送, 4: 用户自提 （默认1）
     * address_info object 否 地址信息，delivery_type = 2 无需设置, delivery_type = 4 填写自提门店地址
     * address_info.receiver_name string 是 收件人姓名
     * address_info.detailed_address string 是 详细收货地址信息
     * address_info.tel_number string 是 收件人手机号码
     * address_info.country string 否 国家
     * address_info.province string 否 省份
     * address_info.city string 否 城市
     * address_info.town string 否 乡镇
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data.order_id number(uint64) 交易组件平台订单ID
     * data.out_order_id string 交易组件平台订单ID
     * data.ticket string 拉起收银台的ticket
     * data.ticket_expire_time string ticket有效截止时间
     * data.final_price number 订单最终价格（单位：分）
     * 枚举-status
     * 枚举值 描述
     * 10 待付款
     * 11 收银台支付完成（自动流转，对商家来说和10同等对待即可）
     * 20 待发货（已付款/用户已付尾款）
     * 30 待收货
     * 100 完成
     * 200 全部商品售后之后，订单取消
     * 250 用户主动取消/待付款超时取消/商家取消
     */
    public function add(\Weixin\Wx\Model\Shop\Order $order)
    {
        $params = $order->getParams();
        // die(\myJsonEncode($params));
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 同步订单支付结果
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/pay_order.html
     * 接口调用请求说明
     * 如果action_type=1，即支付成功调用该接口后，订单状态status会从10（待付款）或11（收银台支付完成）变成20（待发货）。
     *
     * 否则，订单状态status会从10（待付款）变成250（取消)
     *
     * 如果订单状态不是10（待付款）将报错，错误码为100000。
     *
     * transaction_id在以下情况下必填：
     *
     * action_type=1且order/add时传的pay_method_type=0(默认0)时必填
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/order/pay?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "order_id":32434234,
     * "out_order_id": "xxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI",
     * "action_type": 1,
     * "transaction_id": "131456479687",
     * "pay_time": "2020-03-25 14:04:25"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * order_id number(uint64) 否 订单ID
     * out_order_id string 否 商家自定义订单ID，与 order_id 二选一
     * openid string 是 用户的openid
     * action_type number 是 类型，默认1:支付成功,2:支付失败,3:用户取消,4:超时未支付;5:商家取消;10:其他原因取消
     * action_remark string 否 其他具体原因
     * transaction_id string 否 支付订单号，action_type=1且order/add时传的pay_method_type=0时必填
     * pay_time string 否 支付完成时间，action_type=1时必填，yyyy-MM-dd HH:mm:ss
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function pay($openid, $action_type = 1, $order_id = "", $out_order_id = "", $action_remark = "", $transaction_id = "", $pay_time = "")
    {
        $params = array();
        if (!empty($order_id)) {
            $params['order_id'] = $order_id;
        }
        if (!empty($out_order_id)) {
            $params['out_order_id'] = $out_order_id;
        }
        $params['openid'] = $openid;
        $params['action_type'] = $action_type;
        if (!empty($action_remark)) {
            $params['action_remark'] = $action_remark;
        }
        if (!empty($transaction_id)) {
            $params['transaction_id'] = $transaction_id;
        }
        if (!empty($pay_time)) {
            $params['pay_time'] = $pay_time;
        }
        $rst = $this->_request->post($this->_url . 'pay', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取订单详情
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/get_order.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/order/get?access_token=xxxxxxxxx
     * 请求参数
     * {
     * "order_id": 123455,
     * "out_order_id": "xxxxx",
     * "openid": "oTVP50O53a7jgmawAmxKukNlq3XI"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "order":
     * {
     * "order_id": 123455,
     * "out_order_id": "xxxxx",
     * "status": 20,
     * "path": "/pages/order.html?out_order_id=xxxxx",
     * "order_detail":
     * {
     * "promotion_info":{
     * "promoter_id":"PROMOTER_ID",
     * "finder_nickname":"FINDER_NICKNAME"
     * },
     * "sharer_info":{
     * "sharer_openid": "SHARER_OPENID"
     * },
     * "product_infos":
     * [
     * {
     * "out_product_id": "12345",
     * "out_sku_id":"23456",
     * "product_cnt": 10,
     * "sale_price": 200,
     * "path": "pages/productDetail/productDetail?productId=2176180",
     * "title": "标题",
     * "head_image": "http://img10.360buyimg.com/n1/s450x450_jfs/t1/85865/39/13611/488083/5e590a40E4bdf69c0/55c9bf645ea2b727.jpg",
     * "real_price": 200
     * },
     * ...
     * ],
     * "pay_info":
     * {
     * "pay_method": "微信支付",
     * "prepay_id": "42526234625",
     * "prepay_time": "2020-03-25 14:04:25",
     * "transaction_id": "131456479687",
     * "pay_time": "2020-03-25 14:05:25",
     * "pay_method_type": 0
     * },
     * "price_info":
     * {
     * "order_price": 1600,
     * "freight": 500,
     * "discounted_price": 1000,
     * "additional_price": 100,
     * "additional_remarks": "税费"
     * },
     * "delivery_detail": // 必须调过发货接口才会存在这个字段
     * {
     * "delivery_type": 1,
     * "finish_all_delivery": 1,
     * "delivery_list":
     * [
     * {
     * "waybill_id": "SFXXXX",
     * "delivery_id": "SF"
     * }
     * ]
     * }
     * }
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * order_id number(uint64) 是 微信侧订单id （订单id二选一）
     * out_order_id string 是 商家自定义订单ID
     * openid string 是 用户的openid
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * order Order 订单
     * order.order_id number(uint64) 交易组件平台订单ID
     * order.out_order_id string 商家自定义订单ID
     * order.status number 订单状态
     * order.path string 商家小程序该订单的页面path，用于微信侧订单中心跳转
     * order.order_detail.promotion_info.promoter_id string 推广员唯一ID
     * order.order_detail.promotion_info.finder_nickname string 推广员视频号昵称
     * order.order_detail.promotion_info.finder_nickname string 推广员视频号昵称
     * order.order_detail.sharer_info.sharer_openid string 分享员openid
     * order.order_detail.product_infos[].out_product_id string 商家自定义商品ID
     * order.order_detail.product_infos[].out_sku_id string 商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
     * order.order_detail.product_infos[].product_cnt number 购买的数量
     * order.order_detail.product_infos[].sale_price number 生成这次订单时商品的售卖价（单位：分），可以跟上传商品接口的价格不一致
     * order.order_detail.product_infos[].real_price number 扣除优惠后单件sku的均摊价格（单位：分），如果没优惠则与sale_price一致
     * order.order_detail.product_infos[].path number 绑定的小程序商品路径
     * order.order_detail.product_infos[].head_image number 生成订单时商品的头图
     * order.order_detail.product_infos[].title number 生成订单时商品的标题
     * order.order_detail.pay_info.pay_method_type number 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
     * order.order_detail.pay_info.prepay_id string 预支付ID
     * order.order_detail.pay_info.prepay_time string 预付款时间（拿到prepay_id的时间），yyyy-MM-dd HH:mm:ss
     * order.order_detail.pay_info.transaction_id string 支付ID
     * order.order_detail.pay_info.pay_time string 付款时间（拿到transaction_id的时间） ，yyyy-MM-dd HH:mm:ss
     * order.order_detail.price_info.freight number 运费（单位：分）
     * order.order_detail.price_info.order_price number 该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
     * order.order_detail.price_info.discounted_price number 优惠金额（单位：分）
     * order.order_detail.price_info.additional_price number 附加金额（单位：分）
     * order.order_detail.price_info.additional_remarks string 附加金额备注
     * order.order_detail.delivery_detail.delivery_type number 发货类型
     * order.order_detail.delivery_detail.finish_all_delivery number 是否发货完成
     * order.order_detail.delivery_detail.delivery_list[].delivery_id string 快递公司ID，通过获取快递公司列表获取
     * order.order_detail.delivery_detail.delivery_list[].waybill_id string 快递单号
     * order.order_detail.delivery_detail.delivery_list[].deliverer_name string 快递员姓名
     * order.order_detail.delivery_detail.delivery_list[].deliverer_phone string 快递员电话
     * order.order_detail.delivery_detail.delivery_list[].delivey_status string 物流状态
     * order.order_detail.shop_id string 门店ID
     * order.order_detail.dg_id string 导购ID
     * order.order_detail.remark_info.buyer_message string 买家留言
     * order.order_detail.remark_info.trade_memo string 卖家备注
     * order.order_detail.buyer_info.delivery_name string 买家信息——收货人姓名
     * order.order_detail.buyer_info.delivery_mobile string 买家信息——收货人手机号码
     * order.order_detail.buyer_info.delivery_address string 买家信息——收货地址(街道)
     * order.order_detail.buyer_info.province string 买家信息——省
     * order.order_detail.buyer_info.city string 买家信息——市
     * order.order_detail.buyer_info.area string 买家信息——区
     * order.order_detail.buyer_info.zip_code string 买家信息——邮政编码
     * order.order_detail.buyer_info.lastedchange_time string 买家信息——最近更新时间
     * order.order_detail.price_detail.total_amount number 原价
     * order.order_detail.price_detail.benefit_type number 优惠方式 0 无 1减免金额 2打折
     * order.order_detail.price_detail.discount_type string 优惠类型 vip；coupon；integral
     * order.order_detail.price_detail.benefit_name string 优惠券名称
     * order.order_detail.price_detail.benefit_info string 优惠券描述
     * order.order_detail.price_detail.benefit_condition number 满减条件金额
     * order.order_detail.price_detail.benefit_value number 满减金额
     * order.order_detail.price_detail.benefit_discount number 实际减免金额
     * order.order_detail.price_detail.coupon_id number 优惠券id
     * order.order_detail.service_orders[].out_product_id string 服务子订单列表——商家自定义商品ID（订单行商品）
     * order.order_detail.service_orders[].sub_order_price number 服务子订单列表——子订单总价
     * order.order_detail.service_orders[].sub_order_amount number 服务子订单列表——子订单商品数量
     * order.order_detail.service_orders[].sub_order_id string 服务子订单列表—— 子订单id
     * <!--
     * order.order_detail.pay_info_list[].pay_method_type number 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
     * order.order_detail.pay_info_list[].prepay_id string 预支付ID
     * order.order_detail.pay_info_list[].prepay_time string 预付款时间（拿到prepay_id的时间）
     * order.order_detail.pay_info_list[].transaction_id string 支付ID
     * order.order_detail.pay_info_list[].pay_time string 付款时间（拿到transaction_id的时间）
     * -->
     * 枚举-status
     * 枚举值 描述
     * 10 待付款
     * 11 收银台支付完成（自动流转，对商家来说和10同等对待即可）
     * 20 待发货
     * 30 待收货
     * 100 完成
     * 200 全部商品售后之后，订单取消
     * 250 用户主动取消/待付款超时取消/商家取消
     */
    public function get($openid, $order_id = "", $out_order_id = "")
    {
        $params = array();
        if (!empty($order_id)) {
            $params['order_id'] = $order_id;
        }
        if (!empty($out_order_id)) {
            $params['out_order_id'] = $out_order_id;
        }
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 按照推广员获取订单
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/get_order_list_by_finder.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/order/get_list_by_finder?access_token=xxxxxxxxx
     * 请求参数
     * {
     * "start_pay_time": "2020-03-25 12:05:25",
     * "end_pay_time": "2020-04-25 12:05:25",
     * "promoter_id":"PROMOTER_ID",
     * "promoter_openid": "OPENID",
     * "page": 1,
     * "page_size": 10
     * }
     * 回包示例
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "orders":[
     * {
     * "order_id":123455,
     * "out_order_id":"xxxxx",
     * "status":20,
     * "path":"/pages/order.html?out_order_id=xxxxx",
     * "order_detail":{
     * "promotion_info":{
     * "finder_nickname":"FINDER_NICKNAME",
     * "promoter_id":"PROMOTER_ID",
     * "promoter_openid": "OPENID"
     * },
     * "product_infos":[
     * {
     * "out_product_id":"12345",
     * "out_sku_id":"23456",
     * "product_cnt":10,
     * "sale_price":200,
     * "path":"pages/productDetail/productDetail?productId=2176180",
     * "title":"标题",
     * "head_image":"http://img10.360buyimg.com/n1/s450x450_jfs/t1/85865/39/13611/488083/5e590a40E4bdf69c0/55c9bf645ea2b727.jpg",
     * "real_price":200
     * }
     * ],
     * "pay_info":{
     * "pay_method":"微信支付",
     * "prepay_id":"42526234625",
     * "prepay_time":"2020-03-25 14:04:25",
     * "transaction_id":"131456479687",
     * "pay_time":"2020-03-25 14:05:25",
     * "pay_method_type":0
     * },
     * "price_info":{
     * "order_price":1600,
     * "freight":500,
     * "discounted_price":1000,
     * "additional_price":100,
     * "additional_remarks":"税费"
     * },
     * "delivery_detail":{
     * "delivery_type":1,
     * "finish_all_delivery":1,
     * "delivery_list":[
     * {
     * "waybill_id":"SFXXXX",
     * "delivery_id":"SF"
     * }
     * ]
     * }
     * }
     * }
     * ],
     * "total_num":20
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * start_pay_time string 否 订单支付时间的开始时间
     * end_pay_time string 否 订单支付时间的结束时间
     * promoter_id string 否 推广员唯一ID,与promoter_openid二选一
     * promoter_openid string 否 推广员openid，与promoter_id二选一
     * page number 是 第几页（最小填1）
     * page_size number 是 每页数量(不超过100)
     * 回包参数说明
     * 参数 类型 说明
     * errcode string 错误码
     * errmsg string 错误信息
     * orders[].order_id number(uint64) 交易组件平台订单ID
     * orders[].out_order_id string 商家自定义订单ID
     * orders[].status number 订单状态
     * orders[].path string 商家小程序该订单的页面path，用于微信侧订单中心跳转
     * orders[].order_detail.promotion_info.finder_nickname string 推广员视频号昵称
     * orders[].order_detail.promotion_info.promoter_id string 推广员唯一ID
     * orders[].order_detail.promotion_info.promoter_openid string 推广员openid ｜
     * orders[].order_detail.product_infos[].out_product_id string 商家自定义商品ID
     * orders[].order_detail.product_infos[].out_sku_id string 商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
     * orders[].order_detail.product_infos[].product_cnt number 购买的数量
     * orders[].order_detail.product_infos[].sale_price number 生成这次订单时商品的售卖价（单位：分），可以跟上传商品接口的价格不一致
     * orders[].order_detail.product_infos[].real_price number 扣除优惠后单件sku的均摊价格（单位：分），如果没优惠则与sale_price一致
     * orders[].order_detail.product_infos[].path number 绑定的小程序商品路径
     * orders[].order_detail.product_infos[].head_image number 生成订单时商品的头图
     * orders[].order_detail.product_infos[].title number 生成订单时商品的标题
     * orders[].order_detail.pay_info.pay_method_type number 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
     * orders[].order_detail.pay_info.prepay_id string 预支付ID
     * orders[].order_detail.pay_info.prepay_time string 预付款时间（拿到prepay_id的时间）
     * orders[].order_detail.pay_info.transaction_id string 支付ID
     * orders[].order_detail.pay_info.pay_time string 付款时间（拿到transaction_id的时间）
     * orders[].order_detail.price_info.freight number 运费（单位：分）
     * orders[].order_detail.price_info.order_price number 该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
     * orders[].order_detail.price_info.discounted_price number 优惠金额（单位：分）
     * orders[].order_detail.price_info.additional_price number 附加金额（单位：分）
     * orders[].order_detail.price_info.additional_remarks string 附加金额备注
     * orders[].order_detail.delivery_detail.delivery_type number 发货类型
     * orders[].order_detail.delivery_detail.finish_all_delivery number 是否发货完成
     * orders[].order_detail.delivery_detail.delivery_list[].delivery_id string 快递公司ID，通过获取快递公司列表获取
     * orders[].order_detail.delivery_detail.delivery_list[].waybill_id string 快递单号
     * total_num number 订单总数
     */
    public function getListByFinder($page = 1, $page_size = 100, $promoter_id = "", $promoter_openid = "", $start_pay_time = "", $end_pay_time = "")
    {
        $params = array();
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        if (!empty($promoter_id)) {
            $params['promoter_id'] = $promoter_id;
        }
        if (!empty($promoter_openid)) {
            $params['promoter_openid'] = $promoter_openid;
        }
        if (!empty($start_pay_time)) {
            $params['start_pay_time'] = $start_pay_time;
        }
        if (!empty($end_pay_time)) {
            $params['end_pay_time'] = $end_pay_time;
        }

        $rst = $this->_request->post($this->_url . 'get_list_by_finder', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 按照分享员获取订单
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/get_order_list_by_sharer.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/order/get_list_by_sharer?access_token=xxxxxxxxx
     * 请求参数
     * {
     * "start_pay_time": "2020-03-25 12:05:25",
     * "end_pay_time": "2020-04-25 12:05:25",
     * "sharer_openid":"OPENID",//分享者的openid
     * "page": 1,
     * "page_size": 10
     * }
     * 回包示例
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "orders":[
     * {
     * "order_id":123455,
     * "out_order_id":"xxxxx",
     * "status":20,
     * "path":"/pages/order.html?out_order_id=xxxxx",
     * "order_detail":{
     * "promotion_info":{
     * "finder_nickname":"FINDER_NICKNAME",
     * "sharer_openid":"OPENID",
     * "live_start_time":"2020-04-25 12:05:25"
     * },
     * "product_infos":[
     * {
     * "out_product_id":"12345",
     * "out_sku_id":"23456",
     * "product_cnt":10,
     * "sale_price":200,
     * "path":"pages/productDetail/productDetail?productId=2176180",
     * "title":"标题",
     * "head_image":"http://img10.360buyimg.com/n1/s450x450_jfs/t1/85865/39/13611/488083/5e590a40E4bdf69c0/55c9bf645ea2b727.jpg",
     * "real_price":200
     * }
     * ],
     * "pay_info":{
     * "pay_method":"微信支付",
     * "prepay_id":"42526234625",
     * "prepay_time":"2020-03-25 14:04:25",
     * "transaction_id":"131456479687",
     * "pay_time":"2020-03-25 14:05:25",
     * "pay_method_type":0
     * },
     * "price_info":{
     * "order_price":1600,
     * "freight":500,
     * "discounted_price":1000,
     * "additional_price":100,
     * "additional_remarks":"税费"
     * },
     * "delivery_detail":{
     * "delivery_type":1,
     * "finish_all_delivery":1,
     * "delivery_list":[
     * {
     * "waybill_id":"SFXXXX",
     * "delivery_id":"SF"
     * }
     * ]
     * }
     * }
     * }
     * ],
     * "total_num":20
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * start_pay_time string 否 订单支付时间的开始时间
     * end_pay_time string 否 订单支付时间的结束时间
     * sharer_openid string 是 分享员openid
     * page number 是 第几页（最小填1）
     * page_size number 是 每页数量(不超过100)
     * 回包参数说明
     * 参数 类型 说明
     * errcode string 错误码
     * errmsg string 错误信息
     * orders[].order_id number(uint64) 交易组件平台订单ID
     * orders[].out_order_id string 商家自定义订单ID
     * orders[].status number 订单状态
     * orders[].path string 商家小程序该订单的页面path，用于微信侧订单中心跳转
     * orders[].order_detail.promotion_info.finder_nickname string 推广员视频号昵称
     * orders[].order_detail.promotion_info.sharer_openid string 分享者的openid
     * orders[].order_detail.promotion_info.live_start_time string 直播开始时间
     * orders[].order_detail.product_infos[].out_product_id string 商家自定义商品ID
     * orders[].order_detail.product_infos[].out_sku_id string 商家自定义商品skuID，可填空字符串（如果这个product_id下没有sku）
     * orders[].order_detail.product_infos[].product_cnt number 购买的数量
     * orders[].order_detail.product_infos[].sale_price number 生成这次订单时商品的售卖价（单位：分），可以跟上传商品接口的价格不一致
     * orders[].order_detail.product_infos[].real_price number 扣除优惠后单件sku的均摊价格（单位：分），如果没优惠则与sale_price一致
     * orders[].order_detail.product_infos[].path number 绑定的小程序商品路径
     * orders[].order_detail.product_infos[].head_image number 生成订单时商品的头图
     * orders[].order_detail.product_infos[].title number 生成订单时商品的标题
     * orders[].order_detail.pay_info.pay_method_type number 0: 微信支付, 1: 货到付款, 2: 商家会员储蓄卡（默认0）
     * orders[].order_detail.pay_info.prepay_id string 预支付ID
     * orders[].order_detail.pay_info.prepay_time string 预付款时间（拿到prepay_id的时间）
     * orders[].order_detail.pay_info.transaction_id string 支付ID
     * orders[].order_detail.pay_info.pay_time string 付款时间（拿到transaction_id的时间）
     * orders[].order_detail.price_info.freight number 运费（单位：分）
     * orders[].order_detail.price_info.order_price number 该订单最终的实付金额（单位：分），order_price = 商品总价 + freight + additional_price - discounted_price
     * orders[].order_detail.price_info.discounted_price number 优惠金额（单位：分）
     * orders[].order_detail.price_info.additional_price number 附加金额（单位：分）
     * orders[].order_detail.price_info.additional_remarks string 附加金额备注
     * orders[].order_detail.delivery_detail.delivery_type number 发货类型
     * orders[].order_detail.delivery_detail.finish_all_delivery number 是否发货完成
     * orders[].order_detail.delivery_detail.delivery_list[].delivery_id string 快递公司ID，通过获取快递公司列表获取
     * orders[].order_detail.delivery_detail.delivery_list[].waybill_id string 快递单号
     * total_num number 订单总数
     * 分享员功能其他相关接口
     */
    public function getListBySharer($page = 1, $page_size = 100, $sharer_openid = "", $start_pay_time = "", $end_pay_time = "")
    {
        $params = array();
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        $params['sharer_openid'] = $sharer_openid;
        if (!empty($start_pay_time)) {
            $params['start_pay_time'] = $start_pay_time;
        }
        if (!empty($end_pay_time)) {
            $params['end_pay_time'] = $end_pay_time;
        }
        $rst = $this->_request->post($this->_url . 'get_list_by_sharer', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取订单列表
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/get_order_list.html
     * 按商家维度获取订单列表
     *
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/order/get_list?access_token=xxxxxxxxx
     * 请求参数
     * {
     * "page": 1,
     * "page_size": 10,
     * "sort_order": 1,
     * "start_create_time": "yyyy-MM-dd HH:mm:ss",
     * "end_create_time": "yyyy-MM-dd HH:mm:ss"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "total_num": 2,
     * "data": [
     * ...
     * ]
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * page number 是 第x页，大于等于1
     * page_size number 是 每页订单数，上限100
     * sort_order number 是 1:desc, 2:asc
     * start_create_time string 否 起始创建时间
     * end_create_time string 否 最终创建时间
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * orders[] Order[] 订单列表，参考获取订单;
     * total_num number 订单满足条件的总数
     */
    public function getList($page = 1, $page_size = 100, $sort_order = 1, $start_create_time = "", $end_create_time = "")
    {
        $params = array();
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        $params['sort_order'] = $sort_order;
        if (!empty($start_create_time)) {
            $params['start_create_time'] = $start_create_time;
        }
        if (!empty($end_create_time)) {
            $params['end_create_time'] = $end_create_time;
        }
        $rst = $this->_request->post($this->_url . 'get_list', $params);
        return $this->_client->rst($rst);
    }
}
