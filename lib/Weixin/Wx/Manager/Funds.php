<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;
use Weixin\Wx\Manager\Funds\Pay;
use Weixin\Wx\Manager\Funds\Qrcode;

/**
 * 小程序支付管理服务
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/wxafunds/Introduction.html
 *
 * 提现接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/wxafunds/API/funds/submitwithdraw.html
 *
 * 资金接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/wxafunds/API/funds/getorderflow.html
 *
 * 银行信息接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/funds/bank/getbanklist.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class Funds
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/shop/funds/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 支付下单
	 *
	 * @return \Weixin\Wx\Manager\Funds\Pay
	 */
	public function getPayOrder()
	{
		return new Pay($this->_client);
	}

	/**
	 * 提款二维码
	 *
	 * @return \Weixin\Wx\Manager\Funds\Qrcode
	 */
	public function getQrcode()
	{
		return new Qrcode($this->_client);
	}

	/**
	 * 小程序支付管理服务 /提现接口 /发起提现
	 * 发起提现
	 * 接口调用请求说明
	 * 接口强制校验来源IP
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/submitwithdraw?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890",
	 * "amount":1,
	 * "remark":"sss",
	 * "bank_memo":""
	 * }
	 *
	 * 回包示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "OK",
	 * "out_request_no": "xxxxx",
	 * "qrcode_ticket": "xxxxx"
	 * }
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * amount number 是 提现金额（单位：分）
	 * remark string 否 提现备注
	 * bank_memo string 否 银行附言
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * out_request_no string 提现单号
	 * qrcode_ticket string 二维码ticket,可用于获取二维码和查询扫码状态，扫码验证身份提现
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9700101 超出每日只能提现一次的限制
	 */
	public function submitWithdraw($amount, $remark, $bank_memo, $biz_type, $mchid)
	{
		// amount number 是 提现金额（单位：分）
		// remark string 否 提现备注
		// bank_memo string 否 银行附言
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['amount'] = $amount;
		if (! empty($remark)) {
			$params['remark'] = $remark;
		}
		if (! empty($bank_memo)) {
			$params['bank_memo'] = $bank_memo;
		}
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$rst = $this->_request->post($this->_url . 'submitwithdraw', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /提现接口 /获取提现记录详情
	 * 获取提现记录详情
	 * 接口调用请求说明
	 * 接口强制校验来源IP
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getwithdrawdetail?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890",
	 * "out_request_no": "wd13675014323600561372"
	 * }
	 * 回包示例
	 * {
	 * "withdraw_info"{
	 * "amount": 7,
	 * "create_time": 1590733930,
	 * "update_time": 1590773555,
	 * "reason": "",
	 * "remark": "0529日14点31分提现",
	 * "bank_memo": "0529日14点31分提现",
	 * "bank_name": "",
	 * "bank_num": "",
	 * "status": "SUCCESS"
	 * }
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * out_request_no string 是 提现单号
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * withdraw_info Object WithDrawInfo 退款详情信息
	 * Object WithDrawInfo
	 * 参数 类型 说明
	 * amount number 金额
	 * create_time number 创建时间
	 * update_time number 更新时间
	 * reason string 失败原因
	 * remark string 备注
	 * bank_memo string 银行附言
	 * bank_name string 银行名称
	 * bank_num string 银行账户
	 * status string 提现状态,详见WithDrawStatus
	 * WithDrawStatus
	 * 枚举值 说明
	 * BEFORE_SCAN_QRCODE 未扫码
	 * AFTER_SCAN_QRCODE 已扫码
	 * CREATE_SUCCESS 受理成功
	 * SUCCESS 提现成功
	 * FAIL 提现失败
	 * REFUND 提现退票
	 * CLOSE 关单
	 * INIT 业务单已创建
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function getWithdrawDetail($out_request_no, $biz_type, $mchid)
	{
		// out_request_no string 是 提现单号
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['out_request_no'] = $out_request_no;
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$rst = $this->_request->post($this->_url . 'getwithdrawdetail', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /提现接口 /获取提现记录列表
	 * 获取提现记录列表
	 * 接口强制校验来源IP
	 *
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/scanwithdraw?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890",
	 * "page_num": 1,
	 * "page_size": 2
	 * }
	 *
	 * 回包示例
	 * {
	 * "out_request_nos": [
	 * "3163339305837870",
	 * "180687538055"
	 * ],
	 * "total_num": 103
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * page_num number 是 页码，从1开始
	 * page_size number 是 每页大小
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * out_request_nos string列表 提现单号列表
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function scanWithdraw($biz_type, $mchid, $page_num = 1, $page_size = 10)
	{
		// page_num number 是 页码，从1开始
		// page_size number 是 每页大小
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$params['page_num'] = $page_num;
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'scanwithdraw', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /资金接口 /获取资金流水详情
	 * 获取资金流水详情
	 * 接口调用请求说明
	 * 接口强制校验来源IP
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getorderflow?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890",
	 * "funds_flow_id": "1651031426690650"
	 * }
	 *
	 * 回包示例
	 * {
	 * "funds_flow": {
	 * "bookkeeping_time": "2020-08-20 00:08:13",
	 * "funds_flow_id": "4200000586202008206907203418",
	 * "type": "交易",
	 * "flow_type": "收入",
	 * "amount": "0.10",
	 * "balance": "115.12",
	 * "busi_type": "订单",
	 * "request_no": "1768262391135651"
	 * }
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * funds_flow_no string 是 流水单号
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * funds_flow Object FundsFlow 流水详情
	 * Object FundsFlow
	 * FundsFlow字段 类型 描述
	 * bookkeeping_time string 记账时间
	 * type string 资金类型（手续费，退款等）
	 * flow_type string 收支类型，（收入，支出）
	 * amount string 收支金额
	 * balance string 账户余额
	 * busi_type string 业务类型（订单，售后，提现）
	 * request_no string 业务单号（订单号，售后单号，提现单号）
	 * funds_flow_id string 流水id
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function getOrderFlow($funds_flow_no, $biz_type, $mchid)
	{
		// funds_flow_no string 是 流水单号
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['funds_flow_no'] = $funds_flow_no;
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$rst = $this->_request->post($this->_url . 'getorderflow', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /资金接口 /获取资金流水列表
	 * 获取资金流水列表
	 * 接口调用请求说明
	 * 接口强制校验来源IP
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/scanorderflow?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890",
	 * "page_num": 1,
	 * "page_size": 100,
	 * "date":"20211120"
	 * }
	 *
	 * 回包示例
	 * {
	 * "funds_flow_ids": [
	 * "123456789123",
	 * "12345678229"
	 * ],
	 * "total_num":2
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * page_num number 是 页码
	 * page_size number 是 每页数据大小,必须小于等于100
	 * date string 是 日期,格式：20210101
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * funds_flow_ids string列表 流水单号列表
	 * total_num number 总数
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function scanOrderFlow($date, $biz_type, $mchid, $page_num = 1, $page_size = 100)
	{
		// page_num number 是 页码
		// page_size number 是 每页数据大小,必须小于等于100
		// date string 是 日期,格式：20210101
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['date'] = $date;
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$params['page_num'] = $page_num;
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'scanorderflow', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /资金接口 /查询商户余额
	 * 查询商户余额
	 * 接口调用请求说明
	 * 接口强制校验来源IP
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getbalance?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890"
	 * }
	 * 回包示例
	 * {
	 * "balance_info":{
	 * "available_amount":45331,
	 * "pending_amount":7549
	 * }
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * balance_info Object BalanceInfo 余额信息
	 * Object BalanceInfo
	 * 参数 类型 说明
	 * available_amount number 可提现余额
	 * pending_amount number 待结算余额
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 */
	public function getBalance($biz_type, $mchid)
	{
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$rst = $this->_request->post($this->_url . 'getbalance', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /资金接口 /修改结算账户
	 * 修改结算账户
	 * 接口调用请求说明
	 * 接口强制校验来源IP 每天允许修改结算账户的次数为5次，结算账户需要与开店主体一致
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/setbankaccount?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890",
	 * "account_info":{
	 * "bank_account_type" :"ACCOUNT_TYPE_PRIVATE",
	 * "account_bank":"招商银行",
	 * "bank_address_code":"100000",
	 * "account_number":"1234567890"
	 * }
	 * }
	 *
	 * 回包示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "OK"
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * account_info Object AccountInfo 是 账户类型,需要与开店主体一致
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * Object AccountInfo
	 * 参数 类型 是否必填 说明
	 * bank_account_type string 是 账户类型,需要与开店主体一致，详见BankAccountType
	 * account_bank string 是 开户银行（获取开户银行, 搜索银行列表)
	 * bank_address_code string 是 开户银行省市编码（获取城市列表）
	 * bank_branch_id string 否 开户银行联行号(获取支行联号)
	 * bank_name string 否 开户银行全称（若开户银行为“其他银行”，则需二选一填写“开户银行全称（含支行）”或“开户银行联行号”）(获取支行信息))
	 * account_number string 是 银行账号
	 * BankAccountType
	 * 枚举值 说明
	 * ACCOUNT_TYPE_BUSINESS 对公银行账户
	 * ACCOUNT_TYPE_PRIVATE 经营者个人银行卡
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 400 参数错误，请查看错误信息
	 */
	public function setBankAccount(\Weixin\Wx\Model\Funds\AccountInfo $account, $biz_type, $mchid)
	{
		$params = array();
		// account_info Object AccountInfo 是 账户类型,需要与开店主体一致
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params['account_info'] = $account->getParams();
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$rst = $this->_request->post($this->_url . 'setbankaccount', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /资金接口 /查询结算账户
	 * 查询结算账户
	 * 接口调用请求说明
	 * 接口强制校验来源IP
	 *
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getbankaccount?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "biz_type":1,
	 * "mchid":"1234567890"
	 * }
	 *
	 * 回包示例
	 * {
	 * "account_info":{
	 * "bank_account_type" :"ACCOUNT_TYPE_PRIVATE",
	 * "account_bank":"招商银行",
	 * "bank_address_code":"100000",
	 * "account_number":"1234567890"
	 * },
	 * "errcode": 0,
	 * "errmsg": "OK"
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * biz_type number 是 业务类型，填1
	 * mchid string 是 商户号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * account_info Object AccountInfo 结算账户信息
	 * verify_fail_reason string 绑卡失败的原因
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 */
	public function getBankAccount($biz_type, $mchid)
	{
		// biz_type number 是 业务类型，填1
		// mchid string 是 商户号
		$params = array();
		$params['biz_type'] = $biz_type;
		$params['mchid'] = $mchid;
		$rst = $this->_request->post($this->_url . 'getbankaccount', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /银行信息接口 /获取银行列表
	 * 搜索银行列表
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getbanklist?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "offset": 0,
	 * "limit": 10,
	 * "key_words":"招商",
	 * "bank_type":0
	 * }
	 *
	 * 回包示例
	 * {
	 * "data": [
	 * {
	 * "account_bank": "招商银行",
	 * "bank_code": "1000009561",
	 * "bank_id": "1001",
	 * "bank_name": "招商银行",
	 * "bank_type": 1,
	 * "need_branch": false
	 * },
	 * {
	 * "account_bank": "其他银行",
	 * "bank_code": "1000009580",
	 * "bank_id": "1099",
	 * "bank_name": "招商永隆银行",
	 * "bank_type": 1,
	 * "need_branch": true
	 * }
	 * ]
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * offset number 否 偏移量
	 * limit number 否 每页数据大小
	 * key_words string 否 银行关键字
	 * bank_type number 否 银行类型(1:对私银行,2:对公银行; 默认对公)
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * data[].account_bank string 开户银行
	 * data[].bank_code string 银行编码
	 * data[].bank_id number 银行联号
	 * data[].bank_name string 银行名称（不包括支行）
	 * data[].bank_type number 银行类型(1.对公，2.对私)
	 * data[].need_branch string 是否需要填写支行信息
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function getBankList($key_words, $bank_type, $offset = 0, $limit = 100)
	{
		// offset number 否 偏移量
		// limit number 否 每页数据大小
		// key_words string 否 银行关键字
		// bank_type number 否 银行类型(1:对私银行,2:对公银行; 默认对公)
		$params = array();
		if (! empty($key_words)) {
			$params['key_words'] = $key_words;
		}
		if (! empty($bank_type)) {
			$params['bank_type'] = $bank_type;
		}
		$params['offset'] = $offset;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'getbanklist', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /银行信息接口 /根据卡号获取银行信息
	 * 根据卡号查银行信息
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getbankbynum?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "account_number":"621xxxxxxxxxxxxxx"
	 * }
	 *
	 * 回包示例
	 * {
	 * "data": [
	 * {
	 * "bank_code": "1000009561",
	 * "bank_id": "1001",
	 * "bank_name": "招商银行",
	 * "need_branch": false,
	 * "account_bank": "招商银行"
	 * }
	 * ],
	 * "total_count":1
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * account_number string 是 银行卡号
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * total_count number 总数
	 * data[].bank_code string 银行编码
	 * data[].bank_id number 银行联号
	 * data[].bank_name string 银行名称（不包括支行）
	 * data[].branch_id number 支行联号
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function getBankbynum($account_number)
	{
		// account_number string 是 银行卡号
		$params = array();
		$params['account_number'] = $account_number;
		$rst = $this->_request->post($this->_url . 'getbankbynum', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /银行信息接口 /获取大陆银行省份列表
	 * 查询大陆银行省份列表
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getprovince?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * }
	 *
	 * 回包示例
	 * {
	 * "data": [
	 * {
	 * "province_code": 1,
	 * "province_name": "北京市"
	 * },
	 * {
	 * "province_code": 2,
	 * "province_name": "上海市"
	 * },
	 * {
	 * "province_code": 3,
	 * "province_name": "天津市"
	 * },
	 * {
	 * "province_code": 4,
	 * "province_name": "重庆市"
	 * },
	 * {
	 * "province_code": 5,
	 * "province_name": "河北省"
	 * },
	 * {
	 * "province_code": 6,
	 * "province_name": "山西省"
	 * },
	 * {
	 * "province_code": 7,
	 * "province_name": "内蒙古"
	 * },
	 * {
	 * "province_code": 8,
	 * "province_name": "辽宁省"
	 * },
	 * {
	 * "province_code": 9,
	 * "province_name": "吉林省"
	 * },
	 * {
	 * "province_code": 10,
	 * "province_name": "黑龙江省"
	 * },
	 * {
	 * "province_code": 11,
	 * "province_name": "江苏省"
	 * },
	 * {
	 * "province_code": 12,
	 * "province_name": "浙江省"
	 * },
	 * {
	 * "province_code": 13,
	 * "province_name": "安徽省"
	 * },
	 * {
	 * "province_code": 14,
	 * "province_name": "福建省"
	 * },
	 * {
	 * "province_code": 15,
	 * "province_name": "江西省"
	 * },
	 * {
	 * "province_code": 16,
	 * "province_name": "山东省"
	 * },
	 * {
	 * "province_code": 17,
	 * "province_name": "河南省"
	 * },
	 * {
	 * "province_code": 18,
	 * "province_name": "湖北省"
	 * },
	 * {
	 * "province_code": 19,
	 * "province_name": "湖南省"
	 * },
	 * {
	 * "province_code": 20,
	 * "province_name": "广东省"
	 * },
	 * {
	 * "province_code": 21,
	 * "province_name": "广西"
	 * },
	 * {
	 * "province_code": 22,
	 * "province_name": "海南省"
	 * },
	 * {
	 * "province_code": 23,
	 * "province_name": "四川省"
	 * },
	 * {
	 * "province_code": 24,
	 * "province_name": "贵州省"
	 * },
	 * {
	 * "province_code": 25,
	 * "province_name": "云南省"
	 * },
	 * {
	 * "province_code": 26,
	 * "province_name": "西藏"
	 * },
	 * {
	 * "province_code": 27,
	 * "province_name": "陕西省"
	 * },
	 * {
	 * "province_code": 28,
	 * "province_name": "甘肃省"
	 * },
	 * {
	 * "province_code": 29,
	 * "province_name": "宁夏"
	 * },
	 * {
	 * "province_code": 30,
	 * "province_name": "青海省"
	 * },
	 * {
	 * "province_code": 31,
	 * "province_name": "新疆"
	 * }
	 * ],
	 * "total_count": 31
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * data Object ProvinceInfoInfo列表 省份列表
	 * total_count number 总数
	 * Object ProvinceInfoInfo
	 * 参数 类型 说明
	 * province_name string 省份简称
	 * province_code number 省份编码(获取城市列用参数)
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 */
	public function getProvince()
	{
		$params = array();
		$rst = $this->_request->post($this->_url . 'getprovince', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /银行信息接口 /获取城市列表
	 * 查询城市列表
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getcity?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "province_code": 1,
	 * }
	 *
	 * 回包示例
	 * {
	 * "data": [
	 * {
	 * "bank_address_code": "110000",
	 * "city_code": 10,
	 * "city_name": "北京市"
	 * }
	 * ],
	 * "total_count": 1
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * province_code number 是 省份编码
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * data Object CityInfo 列表 银行信息列表
	 * total_count number 总数
	 * CityInfo
	 * 参数 类型 说明
	 * city_name string 城市名称
	 * city_code number 城市编号(获取支行参数)
	 * bank_address_code string 开户银行省市编码
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function getcity($province_code)
	{
		// province_code number 是 省份编码
		$params = array();
		$params['province_code'] = $province_code;
		$rst = $this->_request->post($this->_url . 'getcity', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 小程序支付管理服务 /银行信息接口 /获取支行列表
	 * 查询支行列表
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/funds/getsubbranch?access_token=xxxxxxxxx
	 *
	 * 请求参数示例
	 * {
	 * "bank_code": "1000009501",
	 * "city_code": "571",
	 * "offset": 0,
	 * "limit": 1
	 * }
	 *
	 * 回包示例
	 * {
	 * "account_bank": "其他银行",
	 * "account_bank_code": 1099,
	 * "bank_alias": "浙江网商银行",
	 * "bank_alias_code": "1000009501",
	 * "count": 1,
	 * "data": [
	 * {
	 * "branch_id": "323331000001",
	 * "branch_name": "浙江网商银行股份有限公司"
	 * }
	 * ],
	 * "total_count": 1
	 * }
	 *
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * bank_code string 是 银行编码,通过查询银行信息或者搜索银行信息获取
	 * city_code string 是 城市编号,通过查询城市列表获取
	 * offset number 否 偏移量
	 * limit number 否 限制个数
	 * 回包参数说明
	 * 参数 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * total_count number 总数
	 * count number 当前分页数量
	 * account_bank string 银行名称
	 * account_bank_code string 银行编码
	 * bank_alias string 银行别名
	 * bank_alias_code string 银行别名编码
	 * data[].branch_id number 支行联号
	 * data[].branch_name string 银行全称（含支行）
	 * 返回码
	 * 返回码 错误类型
	 * -1 系统异常
	 * 9710001 暂无数据
	 */
	public function getSubBranch($bank_code, $city_code, $offset = 0, $limit = 100)
	{
		// bank_code string 是 银行编码,通过查询银行信息或者搜索银行信息获取
		// city_code string 是 城市编号,通过查询城市列表获取
		// offset number 否 偏移量
		// limit number 否 限制个数
		$params = array();
		$params['bank_code'] = $bank_code;
		$params['city_code'] = $city_code;
		$params['offset'] = $offset;
		$params['limit'] = $limit;
		$rst = $this->_request->post($this->_url . 'getsubbranch', $params);
		return $this->_client->rst($rst);
	}
}
