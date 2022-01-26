<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 优惠券接口
 *
 * @author guoyongrong
 *        
 */
class Coupon
{

	// 接口地址
	private $_url = 'https://api.weixin.qq.com/shop/coupon/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 商家确认回调领券事件
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/confirm.html
	 * 为防止未接入领券能力时导入优惠券，造成优惠券无法领取的问题，接入前需先确认回调领券事件。
	 *
	 * 必须先调用该API接通领券功能之后，才能调用创建优惠券等其他API。
	 *
	 * 注意
	 * 为防止回调冲突，造成优惠券领取出错，所以最终回调地址，以最晚确认回调领券事件的地址为准。
	 *
	 * 接口调用请求说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/confirm?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 回调请求逻辑
	 * 微信收到API请求后，会主动回调商家固定信息的领券事件，商家需返回下文所示结果以确认，否则无法调用优惠券其他API。
	 *
	 * 回调请求参数示例
	 * 以商家设置的数据格式（json或xml）为准，这里以xml为例
	 *
	 * <xml>
	 * <ToUserName>gh_abcdefg</ToUserName>
	 * <FromUserName>oABCD</FromUserName>
	 * <CreateTime>1627747200</CreateTime>
	 * <MsgType>event</MsgType>
	 * <Event>open_product_receive_coupon</Event>
	 * <out_coupon_id>test_coupon</out_coupon_id>
	 * <request_id>test_coupon_request_id</request_id>
	 * </xml>
	 * 回调回包示例
	 * 以商家设置的数据格式（json或xml）为准，这里以xml为例
	 *
	 * <xml>
	 * <out_user_coupon_id>test_coupon_user_coupon_id</out_user_coupon_id>
	 * <request_id>test_coupon_request_id</request_id>
	 * <ret_code>0</ret_code>
	 * <out_coupon_id>test_coupon</out_coupon_id>
	 * </xml>
	 * 回调请求参数说明
	 * 参数 类型 说明
	 * ToUserName string 商家小程序名称
	 * FromUserName string 微信团队的 OpenID(固定值)
	 * CreateTime number 事件时间,Unix时间戳,单位为秒
	 * MsgType string 消息类型,固定为 event
	 * Event string 事件类型,本接口固定为 open_product_receive_coupon
	 * out_coupon_id string 商家端优惠券ID,商家确认固定为 test_coupon
	 * request_id string 请求唯一ID,商家确认固定为 test_coupon_request_id
	 * 回调回包参数说明
	 * 参数 类型 说明
	 * ret_code number 0：成功
	 * out_user_coupon_id string 商家侧用户优惠券ID,商家确认固定为 test_coupon_user_coupon_id
	 * out_coupon_id string 商家侧优惠券ID,商家确认固定为 test_coupon
	 * request_id string 请求唯一ID,商家确认固定为 test_coupon_request_id
	 */
	public function confirm()
	{
		$params = array();
		$rst = $this->_request->post($this->_url . 'confirm', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 添加优惠券
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/add?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "coupon": {
	 * "out_coupon_id": "coupon_id_1",
	 * "type": 101,
	 * "promote_type": 4,
	 * "coupon_info": {
	 * "name": "示例优惠券",
	 * "promote_info": {
	 * "promote_type": 4, // 视频号
	 * "finder": {
	 * "nickname": "视频号昵称"
	 * }
	 * },
	 * "discount_info": {
	 * "discount_condition": {
	 * "product_cnt": 2,
	 * "product_price": 5000,
	 * "out_product_ids": [
	 * "product_id_3",
	 * "product_id_4"
	 * ],
	 * "tradein_info": {
	 * "out_product_id": "product_id_5",
	 * "price": 10000
	 * },
	 * "buyget_info": {
	 * "buy_out_product_id": "product_id_1",
	 * "buy_product_cnt": 3,
	 * "get_out_product_id": "product_id_2",
	 * "get_product_cnt": 2131241242
	 * }
	 * },
	 * "discount_num": 9800,
	 * "discount_fee": 6400
	 * },
	 * "receive_info": {
	 * "start_time": 1625451250,
	 * "end_time": 1625454250,
	 * "limit_num_one_person": 10,
	 * "total_num": 100
	 * },
	 * "valid_info": {
	 * "valid_type": 1, // 1：商品指定时间区间，2：生效天数，3：生效秒数
	 * "valid_day_num": 10,
	 * "valid_second": 3600,
	 * "start_time": 1625451250,
	 * "end_time": 1625464250
	 * }
	 * }
	 * }
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * coupon.out_coupon_id string 商家侧优惠券ID
	 * coupon.type number 优惠券类型
	 * coupon.promote_type number 优惠券推广类型
	 * coupon.coupon_info.name string 优惠券名
	 * coupon.coupon_info.promote_info.promote_type number 优惠券推广类型
	 * coupon.coupon_info.promote_info.finder.nickname string 推广视频号昵称
	 * coupon.coupon_info.discount_info.discount_condition.product_cnt number 折扣条件所需的商品数
	 * coupon.coupon_info.discount_info.discount_condition.product_price number 折扣条件所需满足的金额
	 * coupon.coupon_info.discount_info.discount_condition.out_product_ids string array 指定商品商家侧ID，商品券必需
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.out_product_id string 换购商品商家侧ID，换购券必需
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.price number 需要支付的金额，单位分，换购券必需
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_out_product_id string 购买商品商家侧ID，买赠券必需
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_product_cnt number 购买商品数，买赠券必需
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_out_product_id string 赠送商品商家侧ID，买赠券必需
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_product_cnt number 赠送商品数，买赠券必需
	 * coupon.coupon_info.discount_info.discount_num number 折扣数,比如5.1折,则填5100,折扣券必需
	 * coupon.coupon_info.discount_info.discount_fee number 减金额,单位为分，直减券必需
	 * coupon.coupon_info.receive_info.start_time number 领取开始时间
	 * coupon.coupon_info.receive_info.end_time number 领取结束时间
	 * coupon.coupon_info.receive_info.limit_num_one_person number 领张数
	 * coupon.coupon_info.receive_info.total_num number 总发放量
	 * coupon.coupon_info.valid_info.valid_type number 有效期类型,1:商品指定时间区间,2:生效天数,3:生效秒数
	 * coupon.coupon_info.valid_info.valid_day_num number 生效天数，有效期类型为2时必需
	 * coupon.coupon_info.valid_info.valid_second number 生效秒数，有效期类型为3时必需
	 * coupon.coupon_info.valid_info.start_time number 生效开始时间，有效期类型为1时必需
	 * coupon.coupon_info.valid_info.end_time number 生效结束时间，有效期类型为1时必需
	 * 枚举-type
	 * 枚举值 描述
	 * 1 商品条件折扣券
	 * 2 商品满减券
	 * 3 商品统一折扣券
	 * 4 商品直减券
	 * 5 商品换购券
	 * 6 商品买赠券
	 * 101 店铺条件折扣券
	 * 102 店铺满减券
	 * 103 店铺统一折扣券
	 * 104 店铺直减券
	 * 枚举-promote_type
	 * 枚举值 描述
	 * 4 视频号直播
	 */
	public function add(\Weixin\Wx\Model\Shop\Coupon $coupon)
	{
		$params = array();
		$params['coupon'] = $coupon->getParams();
		$rst = $this->_request->post($this->_url . 'add', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取优惠券信息
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/get_coupon.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/get?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "out_coupon_id": "out_coupon_id_1"
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0, // 返回码
	 * "result": {
	 * "coupon": {
	 * "out_coupon_id": "coupon_id_1", // 优惠券ID
	 * "type": 101,
	 * "promote_type": 4,
	 * "coupon_info": {
	 * "name": "示例优惠券",
	 * "promote_info": {
	 * "promote_type": 4,
	 * "finder": {
	 * "nickname": "视频号昵称"
	 * }
	 * },
	 * "discount_info": {
	 * "discount_condition": {
	 * "product_cnt": 2, // 优惠券类型为商品券时
	 * "product_price": 5000,
	 * "out_product_ids": ["product_id_3", "product_id_4"], // 优惠券类型为商品券时
	 * "tradein_info": { // 优惠券类型为买赠券时
	 * "out_product_id": "product_id_5",
	 * "price": 10000
	 * },
	 * "buyget_info": { // 优惠券类型为换购券时
	 * "buy_out_product_id": "product_id_1",
	 * "buy_product_cnt": 3,
	 * "get_out_product_id": "product_id_2",
	 * "get_product_cnt": 5
	 * }
	 * },
	 * "discount_num": 9800, // 折扣券
	 * "discount_fee": 6400 // 满减券、直减券
	 * },
	 * "receive_info": {
	 * "start_time": 1625451250, //领取开始时间
	 * "end_time": 1625454250, //领取结束时间
	 * "limit_num_one_person": 10, //限领张数，由小程序保证限领
	 * "total_num": 100 //总发放量
	 * },
	 * "valid_info": {
	 * "valid_type": 1, //有效期类型
	 * "valid_day_num": 10, //生效天数
	 * "valid_second": 3600, //生效秒数
	 * "start_time": 1625451250, //有效开始时间
	 * "end_time": 1625464250 //有效结束时间
	 * }
	 * },
	 * "status": 1, // 优惠券状态
	 * "create_time": 1625454641,
	 * "update_time": 1625454641,
	 * "appid": "wx9e20708660a0991b"
	 * }
	 * }
	 * }
	 * 请求参数说明
	 * 参数 类型 是否必填 说明
	 * out_coupon_id string 是 优惠券id
	 * 回包参数说明
	 * 参数 类型 说明
	 * coupon.out_coupon_id string 商家侧优惠券ID
	 * coupon.type number 优惠券类型
	 * coupon.promote_type number 优惠券推广类型
	 * coupon.coupon_info.name string 优惠券名
	 * coupon.coupon_info.promote_info.promote_type number 优惠券推广类型
	 * coupon.coupon_info.promote_info.finder.nickname string 推广视频号昵称
	 * coupon.coupon_info.discount_info.discount_condition.product_cnt number 折扣条件所需的商品数
	 * coupon.coupon_info.discount_info.discount_condition.product_price number 折扣条件所需满足的金额
	 * coupon.coupon_info.discount_info.discount_condition.out_product_ids string array 指定商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.out_product_id string 换购商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.price number 需要支付的金额，单位分
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_out_product_id string 购买商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_product_cnt number 购买商品数
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_out_product_id string 赠送商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_product_cnt number 赠送商品数
	 * coupon.coupon_info.discount_info.discount_num number 折扣数,比如5.1折,则为5100
	 * coupon.coupon_info.discount_info.discount_fee number 减金额,单位为分
	 * coupon.coupon_info.receive_info.start_time number 领取开始时间
	 * coupon.coupon_info.receive_info.end_time number 领取结束时间
	 * coupon.coupon_info.receive_info.limit_num_one_person number 领张数
	 * coupon.coupon_info.receive_info.total_num number 总发放量
	 * coupon.coupon_info.valid_info.valid_type number 有效期类型,1:商品指定时间区间,2:生效天数,3:生效秒数
	 * coupon.coupon_info.valid_info.valid_day_num number 生效天数
	 * coupon.coupon_info.valid_info.valid_second number 生效秒数
	 * coupon.coupon_info.valid_info.start_time number 生效开始时间
	 * coupon.coupon_info.valid_info.end_time number 生效结束时间
	 * coupon.status number 优惠券状态
	 * coupon.create_time number 创建时间
	 * coupon.update_time number 更新时间
	 */
	public function get($out_coupon_id)
	{
		$params = array();
		$params['out_coupon_id'] = $out_coupon_id;
		$rst = $this->_request->post($this->_url . 'get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取优惠券列表
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/get_coupon_list.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/get_list?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "page_size": 3,
	 * "offset": 2
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0,
	 * "total_num": 10,
	 * "result_list": [{
	 * "coupon": {
	 * "out_coupon_id": "out_coupon_id_3",
	 * "type": 101,
	 * "promote_type": 4,
	 * "coupon_info": {
	 * "name": "测试3",
	 * "promote_info": {
	 * "promote_type": 4,
	 * "finder": {}
	 * },
	 * "receive_info": {
	 * "total_num": 100
	 * },
	 * "ext_info": {
	 * "valid_time": 1625226181
	 * }
	 * },
	 * "status": 0,
	 * "create_time": 1625218450,
	 * "update_time": 1625238573,
	 * "appid": "wx9e20708660a0991b"
	 * },
	 * "coupon_stock": {
	 * "out_coupon_id": "out_coupon_id_3",
	 * "stock_info": {
	 * "issued_num": 99,
	 * "receive_num": 1
	 * },
	 * "create_time": 1625226181,
	 * "update_time": 1625237877,
	 * "appid": "wx9e20708660a0991b"
	 * }
	 * }, {
	 * "coupon": {
	 * "out_coupon_id": "out_coupon_id_4",
	 * "type": 101,
	 * "promote_type": 4,
	 * "coupon_info": {
	 * "name": "测试4",
	 * "promote_info": {
	 * "promote_type": 4,
	 * "finder": {}
	 * },
	 * "receive_info": {
	 * "total_num": 1000
	 * }
	 * },
	 * "status": 1,
	 * "create_time": 1625239595,
	 * "update_time": 1625239595,
	 * "appid": "wx9e20708660a0991b"
	 * }
	 * }, {
	 * "coupon": {
	 * "out_coupon_id": "coupon_id_1",
	 * "type": 101,
	 * "promote_type": 4,
	 * "coupon_info": {
	 * "name": "示例优惠券",
	 * "promote_info": {
	 * "promote_type": 4,
	 * "finder": {
	 * "nickname": "视频号昵称"
	 * }
	 * },
	 * "discount_info": {
	 * "discount_condition": {
	 * "product_cnt": 2,
	 * "product_price": 5000,
	 * "out_product_ids": ["product_id_3", "product_id_4"],
	 * "tradein_info": {
	 * "out_product_id": "product_id_5",
	 * "price": 10000
	 * },
	 * "buyget_info": {
	 * "buy_out_product_id": "product_id_1",
	 * "buy_product_cnt": 3,
	 * "get_out_product_id": "product_id_2",
	 * "get_product_cnt": 2131241242
	 * }
	 * },
	 * "discount_num": 9800,
	 * "discount_fee": 6400
	 * },
	 * "receive_info": {
	 * "start_time": 1625451250,
	 * "end_time": 1625454250,
	 * "limit_num_one_person": 10,
	 * "total_num": 100
	 * },
	 * "valid_info": {
	 * "valid_type": 1,
	 * "valid_day_num": 10,
	 * "valid_second": 3600,
	 * "start_time": 1625451250,
	 * "end_time": 1625464250
	 * },
	 * "ext_info": {
	 * "valid_time": 1625473652
	 * }
	 * },
	 * "status": 2,
	 * "create_time": 1625454641,
	 * "update_time": 1625473652,
	 * "appid": "wx9e20708660a0991b"
	 * },
	 * "coupon_stock": {
	 * "out_coupon_id": "coupon_id_1",
	 * "stock_info": {
	 * "issued_num": 99,
	 * "receive_num": 1
	 * },
	 * "create_time": 1625473652,
	 * "update_time": 1625474308,
	 * "appid": "wx9e20708660a0991b"
	 * }
	 * }]
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * page_size number 页大小,最大为200
	 * offset number 偏移量,从0开始
	 * 回包参数说明
	 * 参数 类型 说明
	 * total_num number 总量
	 * coupon.out_coupon_id string 商家侧优惠券ID
	 * coupon.type number 优惠券类型
	 * coupon.promote_type number 优惠券推广类型
	 * coupon.coupon_info.name string 优惠券名
	 * coupon.coupon_info.promote_info.promote_type number 优惠券推广类型
	 * coupon.coupon_info.promote_info.finder.nickname string 推广视频号昵称
	 * coupon.coupon_info.discount_info.discount_condition.product_cnt number 商品数
	 * coupon.coupon_info.discount_info.discount_condition.product_price number 商品金额
	 * coupon.coupon_info.discount_info.discount_condition.out_product_ids string array 指定商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.out_product_id string 换购商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.price number 需要支付的金额，单位分
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_out_product_id string 购买商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_product_cnt number 购买商品数
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_out_product_id string 赠送商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_product_cnt number 赠送商品数
	 * coupon.coupon_info.discount_info.discount_num number 折扣数,比如5.1折,则为5100
	 * coupon.coupon_info.discount_info.discount_fee number 减金额,单位为分
	 * coupon.coupon_info.receive_info.start_time number 领取开始时间
	 * coupon.coupon_info.receive_info.end_time number 领取结束时间
	 * coupon.coupon_info.receive_info.limit_num_one_person number 领张数
	 * coupon.coupon_info.receive_info.total_num number 总发放量
	 * coupon.coupon_info.valid_info.valid_type number 有效期类型,1:商品指定时间区间,2:生效天数,3:生效秒数
	 * coupon.coupon_info.valid_info.valid_day_num number 生效天数
	 * coupon.coupon_info.valid_info.valid_second number 生效秒数
	 * coupon.coupon_info.valid_info.start_time number 生效开始时间
	 * coupon.coupon_info.valid_info.end_time number 生效结束时间
	 * coupon.status number 优惠券状态
	 * coupon.create_time number 创建时间
	 * coupon.update_time number 更新时间
	 * coupon.coupon_stock.out_coupon_id string 商家侧优惠券ID
	 * coupon.coupon_stock.stock_info.issued_num number 优惠券库存剩余量
	 * coupon.coupon_stock.stock_info.receive_num number 优惠卷发放量
	 * coupon.coupon_stock.create_time number 创建时间
	 * coupon.coupon_stock.update_time number 更新时间
	 */
	public function getList($offset = 0, $page_size = 200)
	{
		$params = array();
		$params['offset'] = $offset;
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'get_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新优惠券信息
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/update_coupon.html
	 * 当且仅当优惠券状态为1时可更新。
	 *
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/update?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "coupon": {
	 * "out_coupon_id": "coupon_id_1",
	 * "type": 101,
	 * "promote_type": 4,
	 * "coupon_info": {
	 * "name": "示例优惠券",
	 * "promote_info": {
	 * "promote_type": 4,
	 * "finder": {
	 * "nickname": "视频号昵称"
	 * }
	 * },
	 * "discount_info": {
	 * "discount_condition": {
	 * "product_cnt": 2,
	 * "product_price": 5000,
	 * "out_product_ids": ["product_id_3", "product_id_4"],
	 * "tradein_info": {
	 * "out_product_id": "product_id_5",
	 * "price": 10000
	 * },
	 * "buyget_info": {
	 * "buy_out_product_id": "product_id_1",
	 * "buy_product_cnt": 3,
	 * "get_out_product_id": "product_id_2",
	 * "get_product_cnt": 2131241242
	 * }
	 * },
	 * "discount_num": 9800,
	 * "discount_fee": 6400
	 * },
	 * "receive_info": {
	 * "start_time": 1625451250,
	 * "end_time": 1625454250,
	 * "limit_num_one_person": 10,
	 * "total_num": 100
	 * },
	 * "valid_info": {
	 * "valid_type": 1,
	 * "valid_day_num": 10,
	 * "valid_second": 3600,
	 * "start_time": 1625451250,
	 * "end_time": 1625464250
	 * }
	 * }
	 * }
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * coupon.out_coupon_id string 商家侧优惠券ID
	 * coupon.type number 优惠券类型
	 * coupon.promote_type number 优惠券推广类型
	 * coupon.coupon_info.name string 优惠券名
	 * coupon.coupon_info.promote_info.promote_type number 优惠券推广类型
	 * coupon.coupon_info.promote_info.finder.nickname string 推广视频号昵称
	 * coupon.coupon_info.discount_info.discount_condition.product_cnt number 折扣条件所需的商品数
	 * coupon.coupon_info.discount_info.discount_condition.product_price number 折扣条件所需满足的金额
	 * coupon.coupon_info.discount_info.discount_condition.out_product_ids string array 指定商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.out_product_id string 换购商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.tradein_info.price number 需要支付的金额，单位分
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_out_product_id string 购买商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.buy_product_cnt number 购买商品数
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_out_product_id string 赠送商品商家侧ID
	 * coupon.coupon_info.discount_info.discount_condition.buyget_info.get_product_cnt number 赠送商品数
	 * coupon.coupon_info.discount_info.discount_num number 折扣数,比如5.1折,则填5100
	 * coupon.coupon_info.discount_info.discount_fee number 减金额,单位为分
	 * coupon.coupon_info.receive_info.start_time number 领取开始时间
	 * coupon.coupon_info.receive_info.end_time number 领取结束时间
	 * coupon.coupon_info.receive_info.limit_num_one_person number 限领张数
	 * coupon.coupon_info.receive_info.total_num number 总发放量
	 * coupon.coupon_info.valid_info.valid_type number 有效期类型,1:商品指定时间区间,2:生效天数,3:生效秒数
	 * coupon.coupon_info.valid_info.valid_day_num number 生效天数，有效期类型为2时必需
	 * coupon.coupon_info.valid_info.valid_second number 生效秒数，有效期类型为3时必需
	 * coupon.coupon_info.valid_info.start_time number 生效开始时间，有效期类型为1时必需
	 * coupon.coupon_info.valid_info.end_time number 生效结束时间，有效期类型为1时必需
	 * coupon.status number 优惠券状态
	 */
	public function update(\Weixin\Wx\Model\Shop\Coupon $coupon)
	{
		$params = array();
		$params['coupon'] = $coupon->getParams();
		$rst = $this->_request->post($this->_url . 'update', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新优惠券状态
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/update_coupon_status.html
	 * 优惠券初始状态为1，更新为2后不可回退为1。状态3、4只可由状态2更新。
	 *
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/update_status?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "out_coupon_id": "12345678",
	 * "status": 2
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 枚举-status
	 * 枚举值 说明
	 * 1 未生效，编辑中
	 * 2 生效
	 * 3 已过期
	 * 4 已作废
	 */
	public function updateStatus($out_coupon_id, $status)
	{
		$params = array();
		$params['out_coupon_id'] = $out_coupon_id;
		$params['status'] = $status;
		$rst = $this->_request->post($this->_url . 'update_status', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新优惠券库存
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/update_coupon_stock.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/update_coupon_stock?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "coupon_stock": {
	 * "out_coupon_id": "coupon_id_1",
	 * "stock_info": {
	 * "issued_num": 60,
	 * "receive_num": 40
	 * }
	 * }
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * coupon_stock.out_coupon_id string 优惠券商家侧ID
	 * coupon_stock.stock_info.issued_num number 优惠券剩余量
	 * coupon_stock.stock_info.receive_num number 优惠券发放量
	 */
	public function updateCouponStock(\Weixin\Wx\Model\Shop\CouponStock $coupon_stock)
	{
		$params = array();
		$params['coupon_stock'] = $coupon_stock->getParams();
		$rst = $this->_request->post($this->_url . 'update_coupon_stock', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 添加用户优惠券
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/add_usercoupon.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/add_user_coupon?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "openid": "oIJ9d5Ad4JMhbybqJ3_J73LkR_Io",
	 * "user_coupon": {
	 * "out_user_coupon_id": "user_coupon_id_1",
	 * "out_coupon_id": "coupon_id_1",
	 * "status": 100
	 * },
	 * "recv_time": 1628147893
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * openid string openid
	 * user_coupon.out_user_coupon_id string 商家侧用户优惠券ID
	 * user_coupon.out_coupon_id string 商家侧优惠券ID
	 * user_coupon.status number 用户优惠券状态
	 * recv_time number 领取时间
	 * 枚举-status
	 * 枚举值 说明
	 * 100 生效中
	 * 101 已过期
	 * 102 已经使用
	 */
	public function addUserCoupon($openid, \Weixin\Wx\Model\Shop\UserCoupon $user_coupon, $recv_time)
	{
		$params = array();
		$params['openid'] = $openid;
		$params['user_coupon'] = $user_coupon->getParams();
		$params['recv_time'] = $recv_time;
		$rst = $this->_request->post($this->_url . 'add_user_coupon', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 获取用户优惠券列表
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/get_usercoupon_list.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/get_usercoupon_list?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "page_size": 2,
	 * "offset": 1,
	 * "openid": "oIJ9d5Ad4JMhbybqJ3_J73LkR_Io"
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0,
	 * "total_num": 3,
	 * "result_list": [{
	 * "out_user_coupon_id": "out_user_coupon_id_1",
	 * "openid": "oIJ9d5Ad4JMhbybqJ3_J73LkR_Io",
	 * "out_coupon_id": "coupon_id_1",
	 * "status": 100,
	 * "create_time": 1625474308,
	 * "update_time": 1625474308,
	 * "end_time": 1625464250,
	 * "ext_info": {},
	 * "start_time": 1625451250
	 * }, {
	 * "out_user_coupon_id": "out_user_coupon_id_2",
	 * "openid": "oIJ9d5Ad4JMhbybqJ3_J73LkR_Io",
	 * "out_coupon_id": "out_coupon_id_3",
	 * "status": 102,
	 * "create_time": 1625237877,
	 * "update_time": 1625237997,
	 * "end_time": 0,
	 * "ext_info": {
	 * "use_time": 1625237997
	 * },
	 * "start_time": 0
	 * }]
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * page_size number 页大小,最大为200
	 * offset number 偏移量,从0开始
	 * 回包参数说明
	 * 参数 类型 说明
	 * total_num number 总量
	 * result_list.out_user_coupon_id string 商家侧用户优惠券ID
	 * result_list.openid string openid
	 * result_list.out_coupon_id string 商家侧优惠券ID
	 * result_list.status number 用户优惠券状态
	 * result_list.create_time number 用户优惠券创建时间
	 * result_list.update_time number 用户优惠券更新时间
	 * result_list.start_time number 用户优惠券有效开始时间
	 * result_list.end_time number 用户优惠券有效结束时间
	 * result_list.ext_info.use_time number 核销时间
	 */
	public function getUsercouponList($openid, $offset = 0, $page_size = 200)
	{
		$params = array();
		$params['openid'] = $openid;
		$params['offset'] = $offset;
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'get_usercoupon_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新用户优惠券
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/update_usercoupon.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/update_user_coupon?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "openid": "oIJ9d5Ad4JMhbybqJ3_J73LkR_Io",
	 * “user_coupon”：{
	 * "out_user_coupon_id": "out_user_coupon_id_1",
	 * "out_coupon_id": "out_coupon_id_3",
	 * "ext_info": {
	 * "use_time": 1628139497
	 * }
	 * },
	 * "recv_time": 1628147893
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 请求参数说明
	 * 参数 类型 说明
	 * openid string openid
	 * user_coupon.out_user_coupon_id string 商家侧用户优惠券ID
	 * user_coupon.out_coupon_id string 商家侧优惠券ID
	 * user_coupon.ext_info.use_time number 用户优惠券核销时间（未核销不填）
	 * recv_time number 领取时间
	 */
	public function updateUserCoupon($openid, \Weixin\Wx\Model\Shop\UserCoupon $user_coupon, $recv_time)
	{
		$params = array();
		$params['openid'] = $openid;
		$params['user_coupon'] = $user_coupon->getParams();
		$params['recv_time'] = $recv_time;
		$rst = $this->_request->post($this->_url . 'update_user_coupon', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 更新用户优惠券状态
	 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/coupon/update_usercoupon_status.html
	 * 接口调用说明
	 * http请求方式：POST
	 * https://api.weixin.qq.com/shop/coupon/update_usercoupon_status?access_token=xxxxxxxxx
	 * 请求参数示例
	 * {
	 * "openid": "oIJ9d5Ad4JMhbybqJ3_J73LkR_Io",
	 * "out_coupon_id": "coupon_id_1",
	 * "out_user_coupon_id": "user_coupon_id_1",
	 * "status": 102
	 * }
	 * 回包示例
	 * {
	 * "errcode": 0
	 * }
	 * 枚举-status
	 * 枚举值 说明
	 * 100 生效中
	 * 101 已过期
	 * 102 已经使用
	 */
	public function updateUsercouponStatus($openid, $out_coupon_id, $out_user_coupon_id, $status)
	{
		$params = array();
		$params['openid'] = $openid;
		$params['out_coupon_id'] = $out_coupon_id;
		$params['out_user_coupon_id'] = $out_user_coupon_id;
		$params['status'] = $status;
		$rst = $this->_request->post($this->_url . 'update_usercoupon_status', $params);
		return $this->_client->rst($rst);
	}
}
