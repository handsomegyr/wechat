<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 小程序发货信息管理服务
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/order-shipping/order-shipping.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class OrderShipping
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
	 * 一、发货信息录入接口
	 * 用户交易后，默认资金将会进入冻结状态，开发者在发货后，需要在小程序平台录入相关发货信息，平台会将发货信息以消息的形式推送给购买的微信用户。
	 *
	 * 如果你已经录入发货信息，在用户尚未确认收货的情况下可以通过该接口修改发货信息，但一个支付单只能更新一次发货信息，请谨慎操作。
	 *
	 * 如暂时没有完成相关API的对接开发工作，你也可以登陆小程序的后台，通过发货信息管理页面手动录入发货信息。
	 *
	 * 注意事项
	 * 根据指定的订单单号类型，采用不同参数给指定订单上传物流信息：
	 *
	 * (1). 商户侧单号形式（枚举值1），通过下单商户号和商户侧单号确定一笔订单
	 *
	 * (2). 微信支付单号形式（枚举值2），通过微信支付单号确定一笔订单
	 *
	 * 发货模式根据具体发货情况选择：
	 *
	 * (1). 统一发货（枚举值1），一笔订单统一发货，只有一个物流单号。
	 *
	 * (2). 分拆发货（枚举值2），一笔订单分拆发货，包括多个物流单号。
	 *
	 * 物流公司编码，参见获取运力 id 列表get_delivery_list。
	 *
	 * 上传时间，用于标识请求的先后顺序，如果要更新物流信息，上传时间必须比之前的请求更新，请按照 RFC 3339 格式填写。
	 *
	 * 分拆发货仅支持使用物流快递发货，一笔支付单最多分拆成 10 个包裹。
	 *
	 * 以下情况将视为重新发货，每笔支付单仅有一次重新发货机会。
	 *
	 * (1). 对已完成发货的支付单再次调用该 API。
	 *
	 * (2). 使用该 API 修改发货模式或物流模式。
	 *
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/upload_shipping_info?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * order_key object 是 订单，需要上传物流信息的订单
	 * logistics_type number 是 物流模式，发货方式枚举值：1、实体物流配送采用快递公司进行实体物流配送形式 2、同城配送 3、虚拟商品，虚拟商品，例如话费充值，点卡等，无实体配送形式 4、用户自提
	 * delivery_mode number 是 发货模式，发货模式枚举值：1、UNIFIED_DELIVERY（统一发货）2、SPLIT_DELIVERY（分拆发货） 示例值: UNIFIED_DELIVERY
	 * is_all_delivered boolean 否 分拆发货模式时必填，用于标识分拆发货模式下是否已全部发货完成，只有全部发货完成的情况下才会向用户推送发货完成通知。示例值: true/false
	 * shipping_list array<object> 是 物流信息列表，发货物流单列表，支持统一发货（单个物流单）和分拆发货（多个物流单）两种模式，多重性: [1, 10]
	 * upload_time string 是 上传时间，用于标识请求的先后顺序 示例值: `2022-12-15T13:29:35.120+08:00`
	 * payer object 是 支付者，支付者信息
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "order_key": {
	 * "order_number_type": 2,
	 * "transaction_id": "fake-transid-20221214190427-1"
	 * },
	 * "delivery_mode": 1,
	 * "logistics_type": 1,
	 * "shipping_list": [
	 * {
	 * "tracking_no": "fake-trackingno-2022121419042711",
	 * "express_company": "STO",
	 * "item_desc": "微信气泡狗集线器*1",
	 * "contact": {
	 * "consignor_contact": "+86-177****1234"
	 * }
	 * }
	 * ],
	 * "upload_time": "2022-12-15T13:29:35.120+08:00",
	 * "payer": {
	 * "openid": "ogqztkPsejM9MQAFfwCQSCi4oNg3"
	 * }
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 10060001 支付单不存在 请检查微信支付单号形式下 transaction_id 字段或商户侧单号形式下 mchid、out_trade_no 字段是否有误
	 * 10060002 支付单已完成发货，无法继续发货 请检查支付单发货情况
	 * 10060003 支付单已使用重新发货机会 支付单处于已发货状态时调用该API视为重新发货，仅可重新发货一次，请检查支付单发货情况
	 * 10060004 支付单处于不可发货的状态 请检查支付单状态
	 * 10060005 物流类型有误 按照文档中物流类型枚举填写该字段
	 * 10060006 非快递发货时不允许分拆发货 非快递发货时不允许分拆发货，请检查请求参数
	 * 10060007 分拆发货模式下必须填写 is_all_delivered 字段 请检查请求参数中的 is_all_delivered 字段
	 * 10060008 商品描述 item_desc 字段不能为空 用于发货信息录入场景时商品描述字段不能为空
	 * 10060009 商品描述 item_desc 字段太长 请检查商品描述字段
	 * 10060012 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060014 参数错误 根据错误原因描述修改参数
	 * 10060019 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060020 该笔支付单在没有任何商品描述的情况下不允许完成发货 请补充商品描述 item_desc
	 * 10060023 发货信息未更新 支付单信息不变
	 * 10060024 物流信息列表太长 支付单物流信息列表长度不可大于 10
	 * 10060025 物流公司编码太长 请检查物流公司编码是否有误
	 * 10060026 物流单号太长 请检查物流单号是否有误
	 * 10060031 该笔支付单不属于 openid 所指定的用户 请检查支付单号或 openid 是否有误
	 * 268485216 上传时间非法，请按照 RFC 3339 格式填写 上传时间必须满足 RFC 3339 格式，如 2022-12-15T13:29:35.120+08:00
	 * 268485224 发货模式非法 按照文档中发货模式枚举设置该字段
	 * 268485195 微信支付单号形式下 transaction_id 字段不能为空 微信支付单号形式下 transaction_id 字段必须设置
	 * 268485196 商户侧单号形式下 mchid 字段不能为空 商户侧单号形式下 mchid 字段必须设置
	 * 268485197 商户侧单号形式下 out_trade_no 字段不能为空 商户侧单号形式下 out_trade_no 字段必须设置
	 * 268485194 订单单号类型非法 按照文档中订单单号类型枚举填写该字段
	 * 268485228 统一发货模式下，物流信息列表长度必须为 1 统一发货模式下，物流信息列表长度必须为 1
	 * 268485226 物流单号不能为空 物流快递发货时物流单号必须填写
	 * 268485227 物流公司编码不能为空 物流快递发货时物流公司编码必须填写
	 */
	public function uploadShippingInfo(\Weixin\Wx\Model\OrderShipping $orderShipping)
	{
		$params = $orderShipping->getParams();
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/upload_shipping_info', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 二、发货信息合单录入接口
	 * 用户交易后，默认资金将会进入冻结状态，开发者在发货后，需要在小程序平台录入相关发货信息，平台会将发货信息以消息的形式推送给购买的微信用户。
	 *
	 * 如果你已经录入发货信息，在用户尚未确认收货的情况下可以通过该接口修改发货信息，但一个支付单只能更新一次发货信息，请谨慎操作。
	 *
	 * 如暂时没有完成相关API的对接开发工作，你也可以登陆小程序的后台，通过发货信息录入页面手动录入发货信息。
	 *
	 * 注意事项
	 * 根据指定的订单单号类型，采用不同参数给指定订单上传物流信息，注意子单和主单的订单单号类型必须一致：
	 *
	 * (1). 商户侧单号形式（枚举值1），通过下单商户号和商户侧单号确定一笔订单
	 *
	 * (2). 微信支付单号形式（枚举值2），通过微信支付单号确定一笔订单
	 *
	 * 发货模式根据具体发货情况选择：
	 *
	 * (1). 统一发货（枚举值1），一笔订单统一发货，只有一个物流单号。
	 *
	 * (2). 分拆发货（枚举值2），一笔订单分拆发货，包括多个物流单号。
	 *
	 * 物流公司编码，参见获取运力 id 列表get_delivery_list。
	 *
	 * 上传时间，用于标识请求的先后顺序，如果要更新物流信息，上传时间必须比之前的请求更新，请按照RFC 3339格式填写。
	 *
	 * 分拆发货仅支持使用物流快递发货，一笔支付单最多分拆成 10 个包裹。
	 *
	 * 以下情况将视为重新发货，每笔支付单仅有一次重新发货机会。 (1). 对已完成发货的支付单再次调用该 API。
	 *
	 * (2). 使用该 API 修改发货模式或物流模式。
	 *
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/upload_combined_shipping_info?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken 或者 authorizer_access_token
	 * order_key object 是 合单订单，需要上传物流详情的合单订单，根据订单类型二选一
	 * sub_orders array<object> 否 子单物流详情
	 * upload_time string 是 上传时间，用于标识请求的先后顺序 示例值: `2022-12-15T13:29:35.120+08:00`
	 * payer object 是 支付者，支付者信息
	 * 属性 类型 必填 说明
	 * openid string 是 用户标识，用户在商户appid下的唯一标识。 下单前需获取到用户的Openid 示例值: oUpF8uMuAJO_M2pxb1Q9zNjWeS6o 字符字节限制: [1, 128]
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "order_key": {
	 * "order_number_type": 1,
	 * "mchid": "fake-mchid-123",
	 * "out_trade_no": "fake-tradeno-20221214190427-0"
	 * },
	 * "sub_orders": [
	 * {
	 * "order_key": {
	 * "order_number_type": 1,
	 * "mchid": "fake-mchid-123",
	 * "out_trade_no": "fake-tradeno-20221214190427-01"
	 * },
	 * "delivery_mode": 2,
	 * "logistics_type": 1,
	 * "is_all_delivered": true,
	 * "shipping_list": [
	 * {
	 * "tracking_no": "fake-trackingno-202212141904271",
	 * "express_company": "YD",
	 * "item_desc": "微信气泡狗零钱包*1",
	 * "contact": {
	 * "consignor_contact": "021-**34-12"
	 * }
	 * },
	 * {
	 * "tracking_no": "fake-trackingno-202212141904272",
	 * "express_company": "DHL",
	 * "item_desc": "微信黄脸布艺胸针*1；微信气泡狗零钱包*1",
	 * "contact": {
	 * "consignor_contact": "021-**34-12"
	 * }
	 * }
	 * ]
	 * },
	 * {
	 * "order_key": {
	 * "order_number_type": 1,
	 * "mchid": "fake-mchid-321",
	 * "out_trade_no": "fake-tradeno-20221214190427-02"
	 * },
	 * "delivery_mode": 1,
	 * "logistics_type": 1,
	 * "shipping_list": [
	 * {
	 * "tracking_no": "fake-trackingno-202212141904273",
	 * "express_company": "YTO",
	 * "item_desc": "微信气泡狗双面钥匙扣*1",
	 * "contact": {
	 * "receiver_contact": "+86-123****4321"
	 * }
	 * }
	 * ]
	 * }
	 * ],
	 * "upload_time": "2022-12-15T13:29:35.120+08:00",
	 * "payer": {
	 * "openid": "ogqztkPsejM9MQAFfwCQSCi4oNg3"
	 * }
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 10060001 支付单不存在 请检查微信支付单号形式下 transaction_id 字段或商户侧单号形式下 mchid、out_trade_no 字段是否有误
	 * 10060002 支付单已完成发货，无法继续发货 请检查支付单发货情况
	 * 10060003 支付单已使用重新发货机会 支付单处于已发货状态时调用该API视为重新发货，仅可重新发货一次，请检查支付单发货情况
	 * 10060004 支付单处于不可发货的状态 请检查支付单状态
	 * 10060005 物流类型有误 按照文档中物流类型枚举填写该字段
	 * 10060006 非快递发货时不允许分拆发货 非快递发货时不允许分拆发货，请检查请求参数
	 * 10060007 分拆发货模式下必须填写 is_all_delivered 字段 请检查请求参数中的 is_all_delivered 字段
	 * 10060008 商品描述 item_desc 字段不能为空 用于发货信息录入场景时商品描述字段不能为空
	 * 10060009 商品描述 item_desc 字段太长 请检查商品描述字段
	 * 10060012 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060013 子单单号重复 sub_orders 列表中不可含有重复子单单号，请检查
	 * 10060014 参数错误 根据错误原因描述修改参数
	 * 10060019 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060020 该笔支付单在没有任何商品描述的情况下不允许完成发货 请补充商品描述 item_desc
	 * 10060023 发货信息未更新 支付单信息不变
	 * 10060024 物流信息列表太长 支付单物流信息列表长度不可大于 10
	 * 10060025 物流公司编码太长 请检查物流公司编码是否有误
	 * 10060026 物流单号太长 请检查物流单号是否有误
	 * 10060031 该笔支付单不属于 openid 所指定的用户 请检查支付单号或 openid 是否有误
	 * 268485216 上传时间非法，请按照 RFC 3339 格式填写 上传时间必须满足 RFC 3339 格式，如 2022-12-15T13:29:35.120+08:00
	 * 268485224 发货模式非法 按照文档中发货模式枚举设置该字段
	 * 268485253 主单的订单单号类型与子单的单号类型不一致 主单的订单单号类型与子单的单号类型必须一致
	 * 268485195 微信支付单号形式下 transaction_id 字段不能为空 微信支付单号形式下 transaction_id 字段必须设置
	 * 268485196 商户侧单号形式下 mchid 字段不能为空 商户侧单号形式下 mchid 字段必须设置
	 * 268485197 商户侧单号形式下 out_trade_no 字段不能为空 商户侧单号形式下 out_trade_no 字段必须设置
	 * 268485194 订单单号类型非法 按照文档中订单单号类型枚举填写该字段
	 * 268485228 统一发货模式下，物流信息列表长度必须为 1 统一发货模式下，物流信息列表长度必须为 1
	 * 268485226 物流单号不能为空 物流快递发货时物流单号必须填写
	 * 268485227 物流公司编码不能为空 物流快递发货时物流公司编码必须填写
	 */
	public function uploadCombinedShippingInfo(\Weixin\Wx\Model\OrderShippingCombined $orderShippingCombined)
	{
		$params = $orderShippingCombined->getParams();
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/upload_combined_shipping_info', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 三、查询订单发货状态
	 * 你可以通过交易单号或商户号+商户单号来查询该支付单的发货状态。
	 *
	 * 注意事项
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/get_order?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * transaction_id string 否 原支付交易对应的微信订单号。
	 * merchant_id string 否 支付下单商户的商户号，由微信支付生成并下发。
	 * sub_merchant_id string 否 二级商户号。
	 * merchant_trade_no string 否 商户系统内部订单号，只能是数字、大小写字母`_-*`且在同一个商户号下唯一。
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码。
	 * errmsg string 错误原因。
	 * order object 支付单信息。
	 * 属性 类型 说明
	 * transaction_id string 原支付交易对应的微信订单号。
	 * merchant_id string 支付下单商户的商户号，由微信支付生成并下发。
	 * sub_merchant_id string 二级商户号。
	 * merchant_trade_no string 商户系统内部订单号，只能是数字、大小写字母`_-*`且在同一个商户号下唯一。
	 * description string 以分号连接的该支付单的所有商品描述，当超过120字时自动截断并以 “...” 结尾。
	 * paid_amount number 支付单实际支付金额，整型，单位：分钱。
	 * openid string 支付者openid。
	 * trade_create_time number 交易创建时间，时间戳形式。
	 * pay_time number 支付时间，时间戳形式。
	 * order_state number 订单状态枚举：(1) 待发货；(2) 已发货；(3) 确认收货；(4) 交易完成；(5) 已退款；(6) 资金待结算。
	 * in_complaint boolean 是否处在交易纠纷中。
	 * shipping object 发货信息。
	 * 属性 类型 说明
	 * delivery_mode number 发货模式，发货模式枚举值：1、UNIFIED_DELIVERY（统一发货）2、SPLIT_DELIVERY（分拆发货） 示例值: UNIFIED_DELIVERY
	 * logistics_type number 物流模式，发货方式枚举值：1、实体物流配送采用快递公司进行实体物流配送形式 2、同城配送 3、虚拟商品，虚拟商品，例如话费充值，点卡等，无实体配送形式 4、用户自提
	 * finish_shipping boolean 是否已完成全部发货。
	 * goods_desc string 在小程序后台发货信息录入页录入的商品描述。
	 * finish_shipping_count number 已完成全部发货的次数，未完成时为 0，完成时为 1，重新发货并完成后为 2。
	 * shipping_list array<object> 物流信息列表，发货物流单列表，支持统一发货（单个物流单）和分拆发货（多个物流单）两种模式。
	 * 属性 类型 说明
	 * tracking_no string 物流单号，示例值: "323244567777"。
	 * express_company string 同城配送公司名或物流公司编码，快递公司ID，参见「获取运力 id 列表get_delivery_list」 示例值: "DHL"。
	 * goods_desc string 使用上传物流信息 API 录入的该物流信息的商品描述。
	 * upload_time number 该物流信息的上传时间，时间戳形式。
	 * contact object 联系方式。
	 * 属性 类型 说明
	 * consignor_contact string 寄件人联系方式。
	 * receiver_contact string 收件人联系方式。
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "transaction_id": "fake-transid-20221209132531-44",
	 * "merchant_id": "fake-mchid-123",
	 * "merchant_trade_no": "fake-tradeno-20221209132531-44"
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "order": {
	 * "transaction_id": "fake-transid-20221209132531-44",
	 * "merchant_trade_no": "fake-tradeno-20221209132531-44",
	 * "merchant_id": "fake-mchid-123",
	 * "sub_merchant_id": "",
	 * "description": "🍌*1",
	 * "paid_amount": 916,
	 * "openid": "ogqztkPsejM9MQAFfwCQSCi4oNg3",
	 * "trade_create_time": 1670563533,
	 * "pay_time": 1670563533,
	 * "in_complaint": false,
	 * "order_state": 2,
	 * "shipping": {
	 * "delivery_mode": 1,
	 * "logistics_type": 1,
	 * "finish_shipping": true,
	 * "finish_shipping_count": 1,
	 * "goods_desc": "🍌*1",
	 * "shipping_list": [
	 * {
	 * "tracking_no": "JT1234567890",
	 * "express_company": "JTSD",
	 * "upload_time": 1670832735
	 * }
	 * ]
	 * }
	 * }
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 10060001 支付单不存在 请检查微信支付单号形式下transaction_id字段或商户侧单号形式下mchid、out_trade_no字段是否有误
	 * 10060012 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060014 请求参数非法 请检查微信支付单号形式下 transaction_id 字段是否已填写，或商户侧单号形式下merchant_id、merchant_trade_no字段是否已填写
	 */
	public function getOrder($transaction_id, $merchant_id, $sub_merchant_id, $merchant_trade_no)
	{
		// transaction_id string 否 原支付交易对应的微信订单号。
		// merchant_id string 否 支付下单商户的商户号，由微信支付生成并下发。
		// sub_merchant_id string 否 二级商户号。
		// merchant_trade_no string 否 商户系统内部订单号，只能是数字、大小写字母`_-*`且在同一个商户号下唯一。
		$params = array();
		if (! empty($transaction_id)) {
			$params['transaction_id'] = $transaction_id;
		}
		if (! empty($merchant_id)) {
			$params['merchant_id'] = $merchant_id;
		}
		if (! empty($sub_merchant_id)) {
			$params['sub_merchant_id'] = $sub_merchant_id;
		}
		if (! empty($merchant_trade_no)) {
			$params['merchant_trade_no'] = $merchant_trade_no;
		}
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/get_order', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 四、查询订单列表
	 * 你可以通过支付时间、支付者openid或订单状态来查询订单列表。
	 *
	 * 注意事项
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/get_order_list?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * pay_time_range object 否 支付时间所属范围。
	 * 属性 类型 必填 说明
	 * begin_time number 否 起始时间，时间戳形式，不填则视为从0开始。
	 * end_time number 否 结束时间（含），时间戳形式，不填则视为32位无符号整型的最大值。
	 * order_state number 否 订单状态枚举：(1) 待发货；(2) 已发货；(3) 确认收货；(4) 交易完成；(5) 已退款；(6) 资金待结算。
	 * openid string 否 支付者openid。
	 * last_index string 否 翻页时使用，获取第一页时不用传入，如果查询结果中 has_more 字段为 true，则传入该次查询结果中返回的 last_index 字段可获取下一页。
	 * page_size number 否 翻页时使用，返回列表的长度，默认为100。
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码。
	 * errmsg string 错误原因。
	 * last_index string 翻页时使用。
	 * has_more boolean 是否还有更多支付单。
	 * order_list array<object> 支付单信息列表。
	 * 属性 类型 说明
	 * transaction_id string 原支付交易对应的微信订单号。
	 * merchant_id string 支付下单商户的商户号，由微信支付生成并下发。
	 * sub_merchant_id string 二级商户号。
	 * merchant_trade_no string 商户系统内部订单号，只能是数字、大小写字母`_-*`且在同一个商户号下唯一。
	 * description string 以分号连接的该支付单的所有商品描述，当超过120字时自动截断并以 “...” 结尾。
	 * paid_amount number 支付单实际支付金额，整型，单位：分钱。
	 * openid string 支付者openid。
	 * trade_create_time number 交易创建时间，时间戳形式。
	 * pay_time number 支付时间，时间戳形式。
	 * order_state number 订单状态枚举：(1) 待发货；(2) 已发货；(3) 确认收货；(4) 交易完成；(5) 已退款；(6) 资金待结算。
	 * in_complaint boolean 是否处在交易纠纷中。
	 * shipping object 发货信息。
	 * 属性 类型 说明
	 * delivery_mode number 发货模式，发货模式枚举值：1、UNIFIED_DELIVERY（统一发货）2、SPLIT_DELIVERY（分拆发货） 示例值: UNIFIED_DELIVERY
	 * logistics_type number 物流模式，发货方式枚举值：1、实体物流配送采用快递公司进行实体物流配送形式 2、同城配送 3、虚拟商品，虚拟商品，例如话费充值，点卡等，无实体配送形式 4、用户自提
	 * finish_shipping boolean 是否已完成全部发货。
	 * goods_desc string 在小程序后台发货信息录入页录入的商品描述。
	 * finish_shipping_count number 已完成全部发货的次数，未完成时为 0，完成时为 1，重新发货并完成后为 2。
	 * shipping_list array<object> 物流信息列表，发货物流单列表，支持统一发货（单个物流单）和分拆发货（多个物流单）两种模式。
	 * 属性 类型 说明
	 * tracking_no string 物流单号，示例值: "323244567777"。
	 * express_company string 同城配送公司名或物流公司编码，快递公司ID，参见「获取运力 id 列表get_delivery_list」 示例值: "DHL"。
	 * goods_desc string 使用上传物流信息 API 录入的该物流信息的商品描述。
	 * upload_time number 该物流信息的上传时间，时间戳形式。
	 * contact object 联系方式。
	 * 属性 类型 说明
	 * consignor_contact string 寄件人联系方式。
	 * receiver_contact string 收件人联系方式。
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "pay_time_range": {
	 * "begin_time": 1670563531,
	 * "end_time": 1670563531
	 * },
	 * "page_size": 2
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "order_list": [
	 * {
	 * "transaction_id": "fake-transid-20221209132531-0",
	 * "merchant_trade_no": "fake-tradeno-20221209132531-0",
	 * "merchant_id": "fake-mchid-123",
	 * "sub_merchant_id": "",
	 * "description": "",
	 * "paid_amount": 4353,
	 * "openid": "ogqztkPsejM9MQAFfwCQSCi4oNg3",
	 * "trade_create_time": 1670563531,
	 * "pay_time": 1670563531,
	 * "order_state": 1,
	 * "in_complaint": false,
	 * "shipping": {}
	 * },
	 * {
	 * "transaction_id": "fake-transid-20221209132531-1",
	 * "merchant_trade_no": "fake-tradeno-20221209132531-1",
	 * "merchant_id": "fake-mchid-123",
	 * "sub_merchant_id": "",
	 * "description": "",
	 * "paid_amount": 29767,
	 * "openid": "ogqztkPsejM9MQAFfwCQSCi4oNg3",
	 * "trade_create_time": 1670563531,
	 * "pay_time": 1670563531,
	 * "order_state": 1,
	 * "in_complaint": false,
	 * "shipping": {}
	 * }
	 * ],
	 * "last_index": "092dd3cecbc6926301",
	 * "has_more": true
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 10060001 支付单不存在 请检查微信支付单号形式下transaction_id字段或商户侧单号形式下mchid、out_trade_no字段是否有误
	 * 10060011 last_index不合法 请检查last_index字段是否有误。
	 * 10060012 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060014 请求参数非法 请检查微信支付单号形式下 transaction_id 字段是否已填写，或商户侧单号形式下merchant_id、merchant_trade_no字段是否已填写
	 */
	public function getOrderList(\Weixin\Wx\Model\OrderShippingQuery $query, $last_index = "", $page_size = 100)
	{
		$params = $query->getParams();

		// last_index string 否 翻页时使用，获取第一页时不用传入，如果查询结果中 has_more 字段为 true，则传入该次查询结果中返回的 last_index 字段可获取下一页。
		// page_size number 否 翻页时使用，返回列表的长度，默认为100。
		if (! empty($last_index)) {
			$params['last_index'] = $last_index;
		}
		$params['page_size'] = $page_size;

		$rst = $this->_request->post($this->_url . 'wxa/sec/order/get_order_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 五、确认收货提醒接口
	 * 如你已经从你的快递物流服务方获知到用户已经签收相关商品，可以通过该接口提醒用户及时确认收货，以提高资金结算效率，每个订单仅可调用一次。
	 *
	 * 注意事项
	 * 通过交易单号或商户号+商户单号来指定订单。
	 * 只有物流类型为物流快递时才能进行提醒。
	 * 签收时间由商户传入，在给用户发送提醒消息时会显示签收时间，签收时间必须在发货时间之后。
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/notify_confirm_receive?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * transaction_id string 否 原支付交易对应的微信订单号
	 * merchant_id string 否 支付下单商户的商户号，由微信支付生成并下发
	 * sub_merchant_id string 否 二级商户号
	 * merchant_trade_no string 否 商户系统内部订单号，只能是数字、大小写字母_-*且在同一个商户号下唯一
	 * received_time number 是 快递签收时间，时间戳形式。
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "transaction_id": "fake-transid-20221209132531-44",
	 * "merchant_id": "fake-mchid-123",
	 * "merchant_trade_no": "fake-tradeno-20221209132531-44",
	 * "received_time": 1670829139
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 10060001 支付单不存在 请检查微信支付单号形式下transaction_id字段或商户侧单号形式下mchid、out_trade_no字段是否有误
	 * 10060012 系统错误 系统繁忙，此时请开发者稍候再试
	 * 10060014 请求参数非法 请检查微信支付单号形式下 transaction_id 字段是否已填写，或商户侧单号形式下merchant_id、merchant_trade_no字段是否已填写
	 * 10060028 支付单不是已发货状态 请检查支付单状态
	 * 10060029 签收时间非法 请检查签收时间是否在发货时间之后
	 * 10060030 支付单已使用提醒收货机会 不可再提醒收货
	 * 10060032 只有物流快递发货时允许提醒用户确认收货 请检查支付单物流类型
	 */
	public function notifyConfirmReceive($transaction_id, $merchant_id, $sub_merchant_id, $merchant_trade_no, $received_time)
	{

		// transaction_id string 否 原支付交易对应的微信订单号
		// merchant_id string 否 支付下单商户的商户号，由微信支付生成并下发
		// sub_merchant_id string 否 二级商户号
		// merchant_trade_no string 否 商户系统内部订单号，只能是数字、大小写字母_-*且在同一个商户号下唯一
		// received_time number 是 快递签收时间，时间戳形式。
		$params = array();
		if (! empty($transaction_id)) {
			$params['transaction_id'] = $transaction_id;
		}
		if (! empty($merchant_id)) {
			$params['merchant_id'] = $merchant_id;
		}
		if (! empty($sub_merchant_id)) {
			$params['sub_merchant_id'] = $sub_merchant_id;
		}
		if (! empty($merchant_trade_no)) {
			$params['merchant_trade_no'] = $merchant_trade_no;
		}
		$params['received_time'] = $received_time;
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/notify_confirm_receive', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 六、消息跳转路径设置接口
	 * 如你已经在小程序内接入平台提供的确认收货组件，可以通过该接口设置发货消息及确认收货消息的跳转动作，用户点击发货消息时会直接进入你的小程序订单列表页面或详情页面进行确认收货，进一步优化用户体验。
	 *
	 * 注意事项
	 * 如设置为空路径或小程序中不存在的路径，将仍然跳转平台默认的确认收货页面，不会进入你的小程序。
	 *
	 * 平台会在路径后面增加支付单的 transaction_id、merchant_id、merchant_trade_no 作为query参数，如果存在二级商户号则还会再增加 sub_merchant_id 参数,开发者可以在小程序中通过onLaunch等方式获取。
	 *
	 * 如你需要在path中携带自定义的query参数，请注意与上面的参数进行区分。
	 *
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/set_msg_jump_path?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * path string 是 商户自定义跳转路径。
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "path": "pages/order/detail"
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 */
	public function setMsgJumpPath($path)
	{
		// path string 是 商户自定义跳转路径。
		$params = array();
		$params['path'] = $path;
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/set_msg_jump_path', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 七、查询小程序是否已开通发货信息管理服务
	 * 功能描述
	 * 调用该接口可查询小程序账号是否已开通小程序发货信息管理服务（已开通的小程序，可接入发货信息管理服务API进行发货管理）。
	 *
	 * 注意事项
	 * 服务商被授权了 18 或 142 权限集时才能进行查询。
	 *
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/is_trade_managed?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * appid string 是 待查询小程序的 appid，非服务商调用时仅能查询本账号
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * is_trade_managed boolean 是否已开通小程序发货信息管理服务
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "appid": "wx0123456789abcdef"
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "is_trade_managed": true
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 61003 服务商未被授权 请检查小程序是否已授权18或142权限集。
	 * 61004 客户端ip未授权 请检查调用端ip是否在服务商ip白名单中。
	 * 61011 服务商不合法 请检查access_token是否有误
	 * 40013 appid非法 请检查appid是否有误
	 * 40097 请求参数非法 请检查appid是否已填写
	 * 44990 达到频控上限 系统繁忙，此时请开发者稍候再试
	 */
	public function isTradeManaged($appid)
	{
		// appid string 是 待查询小程序的 appid，非服务商调用时仅能查询本账号
		$params = array();
		$params['appid'] = $appid;
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/is_trade_managed', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 八、查询小程序是否已完成交易结算管理确认
	 * 功能描述
	 * 调用该接口可查询小程序账号是否已完成交易结算管理确认（即对小程序已关联的所有商户号都完成了订单管理授权或解绑）。已完成订单管理授权的商户号，产生的订单均需要通过发货信息管理服务进行发货。
	 *
	 * 注意事项
	 * 服务商被授权了 18 或 142 权限集时才能进行查询。
	 *
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/is_trade_management_confirmation_completed?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken或者authorizer_access_token
	 * appid string 是 待查询小程序的 appid，非服务商调用时仅能查询本账号
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * completed boolean 是否已完成交易结算管理确认
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "appid": "wx0123456789abcdef"
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "completed": true
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 61003 服务商未被授权 请检查小程序是否已授权18或142权限集。
	 * 61004 客户端ip未授权 请检查调用端ip是否在服务商ip白名单中。
	 * 61011 服务商不合法 请检查access_token是否有误
	 * 40013 appid非法 请检查appid是否有误
	 * 40097 请求参数非法 请检查appid是否已填写
	 * 44990 达到频控上限 系统繁忙，此时请开发者稍候再试
	 */
	public function isTradeManagementConfirmationCompleted($appid)
	{
		// appid string 是 待查询小程序的 appid，非服务商调用时仅能查询本账号
		$params = array();
		$params['appid'] = $appid;
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/is_trade_management_confirmation_completed', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 十、特殊发货报备
	 * 功能描述
	 * 调用该接口可以对未发货的订单进行特殊发货报备，适用于预售商品订单和测试订单。发货时效超过15天的订单需报备为预售商品订单，报备后用户将收到预计发货时间的通知。测试订单报备后无需发货，资金会在一段时间内自动退回给用户。
	 *
	 * 注意事项
	 * 通过微信支付单号或商户单号来指定订单。
	 * 预售商品订单预计发货时间必须在订单支付时间的15天后，不得超过330天。
	 * 调用方式
	 * HTTPS 调用
	 * POST https://api.weixin.qq.com/wxa/sec/order/opspecialorder?access_token=ACCESS_TOKEN
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：142
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * order_id string 是 需要特殊发货报备的订单号，可传入微信支付单号或商户单号
	 * type number 是 特殊发货报备类型，1为预售商品订单，2为测试订单
	 * delay_to number 否 预计发货时间的unix时间戳，type为1时必填，type为2可省略
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误原因
	 * 调用示例
	 * 请求数据示例
	 * {
	 * "order_id": "123456",
	 * "type": 1,
	 * "delay_to": 1752035828
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok"
	 * }
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * -1 system error 系统繁忙，此时请开发者稍候再试
	 * 268546000 type非法 请检查type
	 * 268546001 delay_to非法 请检查delay_to参数
	 * 268546002 账户不存在这个待发货单号 请检查单号是否有误
	 */
	public function opSpecialOrder($order_id, $type, $delay_to)
	{
		// order_id string 是 需要特殊发货报备的订单号，可传入微信支付单号或商户单号
		// type number 是 特殊发货报备类型，1为预售商品订单，2为测试订单
		// delay_to number 否 预计发货时间的unix时间戳，type为1时必填，type为2可省略
		$params = array();
		$params['order_id'] = $order_id;
		$params['type'] = $type;
		$params['delay_to'] = $delay_to;
		$rst = $this->_request->post($this->_url . 'wxa/sec/order/opspecialorder', $params);
		return $this->_client->rst($rst);
	}
}
