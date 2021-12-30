<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 安全风控
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/safety-control-capability/riskControl.getUserRiskRank.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class RiskControl
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
	 * riskControl.getUserRiskRank
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 根据提交的用户信息数据获取用户的安全等级 risk_rank，无需用户授权。
	 *
	 * 调用方式：
	 *
	 * HTTPS 调用
	 * 云调用
	 *
	 * HTTPS 调用
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/getuserriskrank?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * appid string 是 小程序appid
	 * openid string 是 用户的openid
	 * scene number 是 场景值，0:注册，1:营销作弊
	 * mobile_no string 否 用户手机号
	 * client_ip string 是 用户访问源ip
	 * email_address string 否 用户邮箱地址
	 * extended_info string 否 额外补充信息
	 * is_test boolean 否 false：正式调用，true：测试调用
	 * 返回值
	 * Object
	 * 属性 类型 说明
	 * errcode number 返回码
	 * errmsg string 错误信息
	 * unoin_id number 唯一请求标识，标记单次请求
	 * risk_rank number 用户风险等级
	 * errcode 的合法值
	 *
	 * 值 说明 最低版本
	 * -1 系统繁忙，此时请开发者稍候再试
	 * 0 成功
	 * 40001 token 无效
	 * 40003 openid无效
	 * 40129 场景值错误（目前支持场景0:注册，1:营销作弊）
	 * 43104 appid与openid不匹配
	 * 43302 方法调用错误，请用post方法调用
	 * 44002 传递的参数为空
	 * 47001 传递的参数格式不对
	 * 48001 小程序无该api权限
	 * 61010 用户访问记录超时（用户未在近两小时访问小程序）
	 * 9410009 测试额度已耗尽
	 * 其他 系统错误
	 * risk_rank 的合法值
	 *
	 * 值 说明 最低版本
	 * 0 风险等级0
	 * 1 风险等级1
	 * 2 风险等级2
	 * 3 风险等级3
	 * 4 风险等级4
	 * 请求数据示例
	 * {
	 * "appid":"wx*******",
	 * "openid":"*****",
	 * "scene":1,
	 * "mobile_no":"12345678",
	 * "bank_card_no":"******",
	 * "cert_no":"*******",
	 * "client_ip":"******",
	 * "email_address":"***@qq.com",
	 * "extended_info":""
	 * }
	 * 返回数据示例
	 * {
	 * "errcode":0,
	 * "errmsg":"getuserriskrank succ",
	 * "risk_rank":0,
	 * "unoin_id":123456
	 * }
	 */
	public function getUserRiskRank($appid, $openid, $scene, $mobile_no, $bank_card_no, $cert_no, $client_ip, $email_address, $extended_info, $is_test = false)
	{
		$params = array();
		$params['appid'] = $appid;
		$params['openid'] = $openid;
		$params['scene'] = $scene;
		$params['mobile_no'] = $mobile_no;
		$params['bank_card_no'] = $bank_card_no;
		$params['cert_no'] = $cert_no;
		$params['client_ip'] = $client_ip;
		$params['email_address'] = $email_address;
		$params['extended_info'] = $extended_info;
		$params['is_test'] = $is_test;
		$rst = $this->_request->post($this->_url . 'wxa/getuserriskrank', $params);
		return $this->_client->rst($rst);
	}
}
