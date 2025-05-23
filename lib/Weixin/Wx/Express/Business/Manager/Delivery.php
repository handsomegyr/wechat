<?php

namespace Weixin\Wx\Express\Business\Manager;

use Weixin\Client;

/**
 * 快递公司管理API
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/express/express-by-business/getAllDelivery.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Delivery
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/cgi-bin/express/business/delivery/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 物流助手 /小程序使用 /获取支持的快递公司列表
	 * 获取支持的快递公司列表
	 * 调试工具
	 *
	 * 接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 接口说明
	 * 接口英文名
	 * getAllDelivery
	 *
	 * 功能描述
	 * 该接口用于获取支持的快递公司列表。
	 *
	 * 调用方式
	 * HTTPS 调用
	 *
	 * GET https://api.weixin.qq.com/cgi-bin/express/business/delivery/getall?access_token=ACCESS_TOKEN
	 *
	 * 云调用
	 * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
	 *
	 * 接口方法为: openapi.logistics.getAllDelivery
	 *
	 * 第三方调用
	 * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
	 *
	 * 该接口所属的权限集id为：45、71
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
	 * 返回参数
	 * 属性 类型 说明
	 * count number 快递公司数量
	 * data array<object> 快递公司信息列表
	 * 属性 类型 说明
	 * delivery_id string 快递公司 ID
	 * delivery_name string 快递公司名称
	 * can_use_cash number 是否支持散单, 1表示支持
	 * can_get_quota number 是否支持查询面单余额, 1表示支持
	 * service_type array<object> 支持的服务类型
	 * 属性 类型 说明
	 * service_type number service_type
	 * service_name string 服务类型名称
	 * cash_biz_id string 散单对应的bizid，当can_use_cash=1时有效
	 * 调用示例
	 * 示例说明: HTTPS调用
	 *
	 * 请求数据示例
	 *
	 * GET https://api.weixin.qq.com/cgi-bin/express/business/delivery/getall?access_token=ACCESS_TOKEN
	 *
	 * 返回数据示例
	 *
	 * {
	 * "count": 7,
	 * "data": [
	 * {
	 * "delivery_id": "BEST",
	 * "delivery_name": "百世快递"
	 * },
	 * {
	 * "delivery_id": "EMS",
	 * "delivery_name": "中国邮政速递物流"
	 * },
	 * {
	 * "delivery_id": "PJ",
	 * "delivery_name": "品骏物流"
	 * },
	 * {
	 * "delivery_id": "SF",
	 * "delivery_name": "顺丰速运"
	 * },
	 * {
	 * "delivery_id": "YTO",
	 * "delivery_name": "圆通速递"
	 * },
	 * {
	 * "delivery_id": "YUNDA",
	 * "delivery_name": "韵达快递"
	 * },
	 * {
	 * "delivery_id": "ZTO",
	 * "delivery_name": "中通快递"
	 * }
	 * ]
	 * }
	 *
	 * 示例说明: 云函数调用
	 *
	 * 请求数据示例
	 *
	 * const cloud = require('wx-server-sdk')
	 * cloud.init({
	 * env: cloud.DYNAMIC_CURRENT_ENV,
	 * })
	 * exports.main = async (event, context) => {
	 * try {
	 * const result = await cloud.openapi.logistics.getAllDelivery({})
	 * return result
	 * } catch (err) {
	 * return err
	 * }
	 * }
	 *
	 * 返回数据示例
	 *
	 * {
	 * "count": 7,
	 * "data": [
	 * {
	 * "deliveryId": "BEST",
	 * "deliveryName": "百世快递"
	 * },
	 * {
	 * "deliveryId": "EMS",
	 * "deliveryName": "中国邮政速递物流"
	 * },
	 * {
	 * "deliveryId": "PJ",
	 * "deliveryName": "品骏物流"
	 * },
	 * {
	 * "deliveryId": "SF",
	 * "deliveryName": "顺丰速运"
	 * },
	 * {
	 * "deliveryId": "YTO",
	 * "deliveryName": "圆通速递"
	 * },
	 * {
	 * "deliveryId": "YUNDA",
	 * "deliveryName": "韵达快递"
	 * },
	 * {
	 * "deliveryId": "ZTO",
	 * "deliveryName": "中通快递"
	 * }
	 * ],
	 * "errMsg": "openapi.logistics.getAllDelivery:ok"
	 * }
	 *
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
	 */
	public function getAll()
	{
		$params = array();
		$rst = $this->_request->get($this->_url . 'getall', $params);
		return $this->_client->rst($rst);
	}
}
