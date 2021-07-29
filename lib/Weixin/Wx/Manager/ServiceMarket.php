<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 服务市场
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/service-market/serviceMarket.invokeService.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class ServiceMarket
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
	 * serviceMarket.invokeService
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 调用服务平台提供的服务
	 *
	 * 调用方式：
	 *
	 * HTTPS 调用
	 * 云调用
	 *
	 * HTTPS 调用
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/servicemarket?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * service string 是 服务 ID
	 * api string 是 接口名
	 * data string 是 服务提供方接口定义的 JSON 格式的数据
	 * client_msg_id string 是 随机字符串 ID，调用方请求的唯一标识
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * data string 回包信息
	 * 请求数据示例
	 * {
	 * "service" : "wx79ac3de8be320b71",
	 * "api" : "OcrAllInOne",
	 * "data" : {
	 * "img_url": "http://mmbiz.qpic.cn/mmbiz_jpg/7UFjuNbYxibu66xSqsQqKcuoGBZM77HIyibdiczeWibdMeA2XMt5oibWVQMgDibriazJSOibLqZxcO6DVVcZMxDKgeAtbQ/0",
	 * "data_type": 3,
	 * "ocr_type": 1
	 * },
	 * "client_msg_id" : "id123"
	 * }
	 * 返回数据示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "data": "{\"idcard_res\":{\"type\":0,\"name\":{\"text\":\"abc\",\"pos\"…0312500}}},\"image_width\":480,\"image_height\":304}}"
	 * }
	 */
	public function invokeService($service, $api, array $data, $client_msg_id)
	{
		$params = array();
		$params['service'] = $service;
		$params['api'] = $api;
		$params['data'] = $data;
		$params['client_msg_id'] = $client_msg_id;
		$rst = $this->_request->post($this->_url . 'wxa/servicemarket', $params);
		return $this->_client->rst($rst);
	}
}
