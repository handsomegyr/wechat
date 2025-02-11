<?php

namespace Weixin\Channels\Ec\Manager\League;

use Weixin\Client;
use Weixin\Channels\Ec\Model\League\Headsupplier\TimeRange;

/**
 * 联盟带货机构管理API
 * https://developers.weixin.qq.com/doc/channels/API/leagueheadsupplier/addwindow.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Headsupplier
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/channels/ec/league/headsupplier/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 联盟带货机构API /机构合作达人管理 /添加机构商品到橱窗
	 * 添加团长商品到橱窗
	 * 接口说明
	 * 可通过该接口添加团长商品到橱窗
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/window/add?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 否 团长appid
	 * finder_id string 否 视频号finder_id，未填openfinderid时必填，后续废弃
	 * openfinderid string 是 视频号openfinderid
	 * product_id number(uint64) 是 团长商品ID
	 * is_hide_for_window bool 否 是否需要在个人橱窗页隐藏 (默认为false)
	 * 请求参数示例
	 * {
	 * "appid": "app1234",
	 * "finder_id": "sph1234",
	 * "openfinderid": "xxxxx",
	 * "product_id": 1234
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
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 * 10024001 不合法的finder_id
	 * 10024003 不合法的appid
	 * 10024009 不合法的product_id
	 * 10024010 橱窗操作失败
	 * 10024011 未获得橱窗授权
	 * 10024021 橱窗上架商品失败
	 */
	public function windowAdd($appid, $finder_id, $openfinderid, $product_id, $is_hide_for_window = false)
	{
		$params = array();
		if (! empty($appid)) {
			$params['appid'] = $appid;
		}
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		$params['openfinderid'] = $openfinderid;
		$params['product_id'] = $product_id;
		$params['is_hide_for_window'] = $is_hide_for_window;
		$rst = $this->_request->post($this->_url . 'window/add', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构合作达人管理 /查询橱窗上机构商品列表
	 * 查询橱窗上团长商品列表
	 * 接口说明
	 * 可通过该接口查询橱窗上团长商品列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/window/getall?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 否 团长appid
	 * finder_id string 否 视频号finder_id,未填openfinderid时必填，后续废弃
	 * openfinderid string 是 视频号openfinderid
	 * offset number(uint32) 是 起始位置（从0开始）
	 * page_size number(uint32) 否 每页数量(默认100, 最大500)
	 * need_total_num bool 否 是否需要返回橱窗上团长商品总数，默认为false
	 * 请求参数示例
	 * {
	 * "appid": "app1234",
	 * "finder_id": "sph1234",
	 * "offset": 0,
	 * "page_size": 100,
	 * "need_total_num": true
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * list object ItemKey 商品概要列表，结构体详情请参考ItemKey
	 * next_offset number 下一页的位置
	 * have_more bool 后面是否还有商品
	 * total_num number 商品总数
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "list": [
	 * {
	 * "appid": "test1",
	 * "product_id": 12345
	 * },
	 * {
	 * "appid": "test2",
	 * "product_id": 12346
	 * }
	 * ],
	 * "next_offset": 100,
	 * "have_more": true,
	 * "total_num": 369
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发者检查请求参数是否正确
	 * 10024001 不合法的finder_id
	 * 10024003 不合法的appid
	 * 10024009 不合法的product_id
	 * 10024010 橱窗操作失败
	 * 10024011 未获得橱窗授权
	 * 结构体
	 * ItemKey
	 * 商品概要
	 *
	 * 参数 类型 描述
	 * appid string 团长appid
	 * product_id number(uint64) 团长商品ID
	 */
	public function windowGetall($appid, $finder_id, $openfinderid, $offset = 0, $page_size = 500, $need_total_num = false)
	{
		$params = array();
		if (! empty($appid)) {
			$params['appid'] = $appid;
		}
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		$params['openfinderid'] = $openfinderid;
		$params['offset'] = $offset;
		$params['page_size'] = $page_size;
		$params['need_total_num'] = $need_total_num;
		$rst = $this->_request->post($this->_url . 'window/getall', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构合作达人管理 /从橱窗移除机构商品
	 * 从橱窗移除团长商品
	 * 接口说明
	 * 可通过该接口从橱窗移除团长商品
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/window/remove?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 否 团长appid
	 * finder_id string 否 视频号finder_id，未填openfinderid时必填，后续废弃
	 * openfinderid string 是 视频号openfinderid
	 * product_id number(uint64) 是 团长商品ID，可从获取联盟商品推广列表接口中获取
	 * 请求参数示例
	 * {
	 * "appid": "app1234",
	 * "finder_id": "sph1234",
	 * "product_id": 1234
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
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 * 10024001 不合法的finder_id
	 * 10024003 不合法的appid
	 * 10024009 不合法的product_id
	 * 10024010 橱窗操作失败
	 */
	public function windowRemove($appid, $finder_id, $openfinderid, $product_id)
	{
		$params = array();
		if (! empty($appid)) {
			$params['appid'] = $appid;
		}
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		$params['openfinderid'] = $openfinderid;
		$params['product_id'] = $product_id;
		$rst = $this->_request->post($this->_url . 'window/remove', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构合作达人管理 /查询橱窗上机构商品详情
	 * 查询橱窗上团长商品详情
	 * 接口说明
	 * 可通过该接口查询橱窗上团长商品详情
	 *
	 * 启用新多级类目树提示：旧的类目树固定为三级类目结构，新的类目树为多级类目结构，过渡期间，新旧类目树兼容使用，请开发者尽快切换到新多级类目树。其中差异请参阅“新旧类目树差异”。此接口新增 cats_v2 字段支持新类目树，详见参数。
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/window/getdetail?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 否 团长appid
	 * finder_id string 否 视频号finder_id，未填openfinderid时必填，后续废弃
	 * openfinderid string 是 视频号openfinderid
	 * product_id number(uint64) 是 团长商品ID，可从获取联盟商品推广列表接口中获取
	 * 请求参数示例
	 * {
	 * "appid": "app1234",
	 * "finder_id": "sph1234",
	 * "product_id": 1234
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * product_detail object Item 商品所有信息，结构体详情请参考Item
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "product_detail": {
	 * "appid": "test",
	 * "product_id": 12345,
	 * "product_info": {
	 * "title": "test_title",
	 * "sub_title": "",
	 * "head_imgs": [
	 * "https://test.com/0"
	 * ],
	 * "desc_info": {
	 * "imgs": [
	 * "https://test.com/0"
	 * ],
	 * "desc": ""
	 * },
	 * "cats": [
	 * {
	 * "cat_id": "1421"
	 * },
	 * {
	 * "cat_id": "1443"
	 * },
	 * {
	 * "cat_id": "1452"
	 * }
	 * ],
	 * "cats_v2": [
	 * {
	 * "cat_id": "1421"
	 * },
	 * {
	 * "cat_id": "1443"
	 * },
	 * {
	 * "cat_id": "1452"
	 * },
	 * {
	 * "cat_id": "1476"
	 * }
	 * ],
	 * "product_promotion_link": "v1=HAOHK025pGFF8tBx69zbwNpU473uiTNa5MOHrs_Hknqa_-Cjk9IbBHMHeKh5rSnIrQ"
	 * }
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 2 该商品已移除
	 * 3 该商品已永久删除
	 * 10024000 参数错误
	 * 10024001 不合法的finder_id
	 * 10024003 不合法的appid
	 * 10024009 不合法的product_id
	 * 10024010 橱窗操作失败
	 * 10024020 橱窗不存在该商品
	 * 结构体
	 * Item
	 * 商品所有信息
	 *
	 * 参数 类型 描述
	 * appid string(uint64) 所属小店appid
	 * product_id string(uint64) 商品id
	 * product_info object ProductInfo 商品内容，结构体详情请参考ProductInfo
	 * ProductInfo
	 * 商品内容
	 *
	 * 参数 类型 描述
	 * title string 标题
	 * sub_title string 副标题。如果添加时没录入，回包可能不包含该字段
	 * head_imgs array string 主图，多张，列表，最多9张，每张不超过2MB
	 * desc_info object DescInfo 商品详情信息，如商品详情图片，商品详情文字，结构体详情请参考DescInfo
	 * cats Array <object CatInfo> 类目信息，结构体详情请参考CatInfo
	 * cats_v2 Array <object CatInfo> 新类目树--类目信息，结构体详情请参考CatInfo
	 * product_promotion_link string 用于在小程序跳转小店场景添加商品时传递跟佣信息
	 * DescInfo
	 * 商品详情信息
	 *
	 * 参数 类型 描述
	 * imgs string array 商品详情图片(最多20张)。如果添加时没录入，回包可能不包含该字段
	 * desc string 商品详情文字。如果添加时没录入，回包可能不包含该字段
	 * CatInfo
	 * 类目信息
	 *
	 * 参数 类型 描述
	 * cat_id string(uint64) 类目id
	 */
	public function windowGetDetail($appid, $finder_id, $openfinderid, $product_id)
	{
		$params = array();
		if (! empty($appid)) {
			$params['appid'] = $appid;
		}
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		$params['openfinderid'] = $openfinderid;
		$params['product_id'] = $product_id;
		$rst = $this->_request->post($this->_url . 'window/getdetail', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /机构合作达人管理 /获取达人橱窗授权链接
	 * 获取达人橱窗授权链接
	 * 接口说明
	 * 可通过该接口获取达人橱窗授权链接
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/windowauth/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * finder_id string 是 视频号finder_id【和 openid 二选一】
	 * openid string 是 小程序用户openid，需在团长端绑定小程序【和 finder_id 二选一】
	 * 请求参数示例
	 * {
	 * "finder_id": "sph1234"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * auth_info object AuthInfo 授权链接信息
	 * auth_info.auth_url string 授权链接
	 * auth_info.auth_wxa_path string 授权路径
	 * auth_info.auth_wxa_appid string appid
	 * auth_info.auth_wxa_username string 小程序name
	 * openfinderid string 视频号openfinderid
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "auth_info": {
	 * "auth_url": "https://channels.weixin.qq.com/miniprogram/live-commerce/auth?authkey=0_1234",
	 * "auth_wxa_username": "gh_bebad552f050",
	 * "auth_wxa_appid": "wx2cea70df4257bba8",
	 * "auth_wxa_path": "/pages/partner/auth?scene=thirdapp&authkey=0_1234"
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发人员检查传参是否正确
	 * 10024001 不合法的finder_id
	 * 10024002 达人已同意授权无需重复申请授权
	 * 10024014 该用户不存在对应视频号
	 * 10024018 未绑定小程序
	 * 10024019 不合法的openid
	 */
	public function windowauthGet($finder_id, $openid)
	{
		$params = array();
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		if (! empty($openid)) {
			$params['openid'] = $openid;
		}
		$rst = $this->_request->post($this->_url . 'windowauth/get', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /机构合作达人管理 /获取达人橱窗授权状态
	 * 获取达人橱窗授权状态
	 * 接口说明
	 * 可通过该接口获取达人橱窗授权状态
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/windowauth/status/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * finder_id string 否 视频号finder_id，登录视频号助手可以获取，未填openfinderid时必填，后续废弃。
	 * openfinderid string 是 视频号openfinderid
	 * 请求参数示例
	 * {
	 * "finder_id": "sph1234"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * window_auth_status number 是否授权，0: 未授权, 1: 已授权
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "window_auth_status": 1,
	 * }
	 * 错误码
	 * 错误码 错误信息
	 * 公共错误码 -
	 * 10024000 参数错误
	 * 10024001 不合法的finder_id
	 */
	public function windowauthStatusGet($finder_id, $openfinderid)
	{
		$params = array();
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		$params['openfinderid'] = $openfinderid;
		$rst = $this->_request->post($this->_url . 'windowauth/status/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /获取机构账户余额
	 * 获取团长账户余额
	 * 接口说明
	 * 可通过该接口获取账户余额
	 *
	 * 注意事项
	 * 调用接口时传空的json串即可。
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/funds/balance/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 无请求参数
	 *
	 * 请求参数示例
	 * {
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * available_amount number 可提现余额（分）
	 * pending_amount number 待结算余额（分）
	 * 返回参数示例
	 * {
	 * "available_amount":45331,
	 * "pending_amount":7549,
	 * "errmsg": "ok",
	 * "errcode": 0
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 */
	public function fundsBalanceGet()
	{
		$params = array();
		$rst = $this->_request->post($this->_url . 'funds/balance/get', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /机构数据 /获取资金流水详情
	 * 获取资金流水详情
	 * 接口说明
	 * 可通过该接口获取获取资金流水详情
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/funds/flowdetail/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * flow_id string 是 流水id
	 * 请求参数示例
	 * {
	 * "flow_id": "123455"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * funds_flow FundsFlowInfo 流水信息，结构体详情请参考FundsFlowInfo
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "funds_flow": {
	 * "flow_id": "123455",
	 * "funds_type": 2,
	 * "amount": 4,
	 * "balance": 139,
	 * "bookkeeping_time": "2023-02-11 15:45:39",
	 * "remark": "分账",
	 * "order_id": "123455678"
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 * 10024008 不存在该流水
	 * 结构体
	 * FundsFlowInfo
	 * 流水信息
	 *
	 * 参数 类型 描述
	 * flow_id string 流水id
	 * funds_type number 资金类型，1：提现，2：分账
	 * amount number 流水金额 单位：分
	 * balance number 余额 单位：分
	 * bookkeeping_time string 记账时间
	 * remark string 备注
	 * order_id string 关联订单号
	 * withdraw_id string 关联提现单号
	 */
	public function fundsFlowdetailGet($flow_id)
	{
		$params = array();
		$params['flow_id'] = $flow_id;
		$rst = $this->_request->post($this->_url . 'funds/flowdetail/get', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /机构数据 /获取资金流水列表
	 * 获取资金流水列表
	 * 接口说明
	 * 可通过该接口获取资金流水列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/funds/flowlist/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * page number 否 页码，从1开始
	 * page_size number 否 页数，不填默认为10
	 * funds_type number 否 资金类型, 1：提现，2：分账
	 * start_time number 否 流水产生的开始时间，uinx时间戳(即格林威治时间1970年01月01日00时00分00秒(北京时间1970年01月01日08时00分00秒起至现在的总秒数)
	 * end_time number 否 流水产生的结束时间，unix时间戳(即格林威治时间1970年01月01日00时00分00秒(北京时间1970年01月01日08时00分00秒起至现在的总秒数)
	 * next_key string 否 分页参数，翻页时写入上一页返回的next_key(page为上一页加一，并且page_size与上一页相同的时候才生效)，page * page_size >= 5000时必填
	 * 请求参数示例
	 * {
	 * "page_size": 2
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * flow_ids Array 流水单号列表
	 * has_more bool 是否还有下一页
	 * next_key string 分页参数，深翻页时使用
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "flow_ids": [
	 * "123243",
	 * "123124134"
	 * ],
	 * "has_more": true,
	 * "next_key": "CImf4J0GENq46tOEhuIR"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function fundsFlowlistGet($page = 1, $page_size = 10, $funds_type = 0, $start_time = 0, $end_time = 0, $next_key = "")
	{
		$params = array();
		$params['page'] = $page;
		$params['page_size'] = $page_size;
		if (! empty($funds_type)) {
			$params['funds_type'] = $funds_type;
		}
		if (! empty($start_time)) {
			$params['start_time'] = $start_time;
		}
		if (! empty($end_time)) {
			$params['end_time'] = $end_time;
		}
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$rst = $this->_request->post($this->_url . 'funds/flowlist/get', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /机构数据 /获取合作商品详情
	 * 获取合作商品详情
	 * 接口说明
	 * 可通过该接口获取商品详情
	 *
	 * 启用新多级类目树提示：旧的类目树固定为三级类目结构，新的类目树为多级类目结构，过渡期间，新旧类目树兼容使用，请开发者尽快切换到新多级类目树。其中差异请参阅“新旧类目树差异”。此接口新增 cats_v2 字段支持新类目树，详见参数。
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/item/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 是 团长商品 所属小店appid
	 * product_id string(uint64) 是 商品id
	 * 请求参数示例
	 * {
	 * "product_id": 12345,
	 * "appid": "test"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * item object Item 商品详情，结构体详情请参考Item结构体
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "item": {
	 * "appid": "test",
	 * "product_id": 12345,
	 * "product_info": {
	 * "title": "test_title",
	 * "sub_title": "",
	 * "head_imgs": [
	 * "https://test.com/0"
	 * ],
	 * "desc_info": {
	 * "imgs": [
	 * "https://test.com/0"
	 * ],
	 * "desc": ""
	 * },
	 * "cats": [
	 * {
	 * "cat_id": "1421"
	 * },
	 * {
	 * "cat_id": "1443"
	 * },
	 * {
	 * "cat_id": "1452"
	 * }
	 * ],
	 * "cats_v2": [
	 * {
	 * "cat_id": "1421"
	 * },
	 * {
	 * "cat_id": "1443"
	 * },
	 * {
	 * "cat_id": "1452"
	 * },
	 * {
	 * "cat_id": "1476"
	 * }
	 * ],
	 * "express_info": {
	 * "send_time": "",
	 * "address_info": {
	 * "postal_code": "",
	 * "province_name": "",
	 * "city_name": "",
	 * "county_name": ""
	 * },
	 * "shipping_method": "NO_FREE"
	 * },
	 * "skus": [
	 * {
	 * "sku_id": "670813472",
	 * "thumb_img": "",
	 * "sale_price": 500,
	 * "stock_num": 998,
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
	 * ]
	 * }
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发人员检查传递参数是否正确
	 * 10024003 不合法的appid
	 * 10024004 不存在该商品
	 * 结构体
	 * Item
	 * 商品所有信息
	 *
	 * 参数 类型 描述
	 * appid string(uint64) 所属小店appid
	 * product_id string(uint64) 商品id
	 * product_info object ProductInfo 商品信息，结构体详情请参考ProductInfo
	 * commission_info object CommissionInfo 跟佣信息，结构体详情请参考CommissionInfo
	 * ProductInfo
	 * 商品内容
	 *
	 * 参数 类型 描述
	 * title string 标题
	 * sub_title string 副标题。如果添加时没录入，回包可能不包含该字段
	 * head_imgs string array 主图,多张,列表,最多9张,每张不超过2MB
	 * desc_info object DescInfo 商详信息，结构体详情请参考DescInfo
	 * cats Array<object CatInfo> 类目信息，结构体详情请参考CatInfo
	 * cats_v2 Array <object CatInfo> 新类目树--类目信息，结构体详情请参考CatInfo
	 * express_info object ExpressInfo 快递信息，结构体详情请参考ExpressInfo
	 * skus Array<object SkuInfo> sku信息，结构体详情请参考SkuInfo
	 * is_hidden bool 商品是否在商品列表页对外隐藏
	 * DescInfo
	 * 商品详情信息
	 *
	 * 参数 类型 描述
	 * imgs string array 商品详情图片(最多20张)。如果添加时没录入，回包可能不包含该字段
	 * desc string 商品详情文字。如果添加时没录入，回包可能不包含该字段
	 * CatInfo
	 * 类目信息
	 *
	 * 参数 类型 描述
	 * cat_id string(uint64) 类目id
	 * cat_name string 类目名称
	 * ExpressInfo
	 * 快递信息
	 *
	 * 参数 类型 描述
	 * send_time string 发货时间期限
	 * address_info object AddressInfo 发货地址，结构体详情请参考AddressInfo
	 * shipping_method string 计费方式：FREE：包邮CONDITION_FREE：条件包邮NO_FREE：不包邮
	 * AddressInfo
	 * 发货地址
	 *
	 * 参数 类型 描述
	 * postal_code string 邮编
	 * province_name string 国标收货地址第一级地址
	 * city_name string 国标收货地址第二级地址
	 * county_name string 国标收货地址第三级地址
	 * SkuInfo
	 * sku信息
	 *
	 * 参数 类型 描述
	 * sku_id string(uint64) skuID
	 * thumb_img string sku小图。如果添加时没录入，回包可能不包含该字段
	 * sale_price number 售卖价格，以分为单位
	 * stock_num number sku库存
	 * sku_attrs[].attr_key string 属性键key（属性自定义用）
	 * sku_attrs[].attr_value string 属性值value（属性自定义用），参数规则如下：
	 * ● 当获取类目信息接口中返回的type：为 select_many，
	 * attr_value的格式：多个选项用分号;隔开
	 * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
	 * ● 当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
	 * attr_value格式：数值 单位，用单个空格隔开
	 * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
	 * ● 当获取类目信息接口中返回的type：为 integer/decimal4
	 * attr_value 的格式：字符串形式的数字
	 * sku_deliver_info object SkuDeliverInfo 预售信息，结构体详情请参考SkuDeliverInfo
	 * SkuDeliverInfo
	 * 预售信息
	 *
	 * 参数 类型 描述
	 * stock_type number sku库存情况。0:现货（默认），1:全款预售。部分类目支持全款预售，具体参考文档获取类目信息中的字段attr.pre_sale
	 * full_payment_presale_delivery_type number sku发货节点，该字段仅对stock_type=1有效。0:付款后n天发货，1:预售结束后n天发货
	 * presale_begin_time number sku预售周期开始时间，秒级时间戳，该字段仅对delivery_type=1有效。
	 * presale_end_time number sku预售周期结束时间，秒级时间戳，该字段仅对delivery_type=1有效。
	 * full_payment_presale_delivery_time number sku发货时效，即付款后/预售结束后{full_payment_presale_delivery_time}天内发货，该字段仅对stock_type=1时有效。
	 * CommissionInfo
	 * 跟佣信息
	 *
	 * 参数 类型 描述
	 * status number 商品带货状态 ，枚举值详情请参考ItemStatus
	 * service_ratio number 服务费率[0, 1000000]
	 * ratio number 佣金费率[0, 1000000]
	 * start_time number 时间戳，合作开始时间
	 * end_time number 时间戳，合作结束时间
	 * link string 带货链接，团长商品状态上架中返回
	 * audit_info object AuditInfo 待审核信息，结构体详情请参考AuditInfo
	 * normal_commission_info object NormalCommissionInfo 该商品普通推广下的佣金信息，团长商品上架中且普通推广上架中有效，结构体详情请参考NormalCommissionInfo
	 * AuditInfo
	 * 待审核信息
	 *
	 * 参数 类型 描述
	 * service_ratio number 服务费率[0, 1000000]
	 * ratio number 佣金费率[0, 1000000]
	 * start_time number 时间戳，合作开始时间
	 * end_time number 时间戳，合作结束时间
	 * NormalCommissionInfo
	 * 商品普通推广下的佣金信息
	 *
	 * 参数 类型 描述
	 * ratio number 佣金费率[0, 1000000]
	 * 枚举值
	 * ItemStatus
	 * 商品带货状态
	 *
	 * 枚举值 描述
	 * 1 已上架推广
	 * 2 已下架推广
	 * 5 已清退
	 */
	public function itemGet($appid, $product_id)
	{
		$params = array();
		$params['appid'] = $appid;
		$params['product_id'] = $product_id;
		$rst = $this->_request->post($this->_url . 'item/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /获取合作商品列表
	 * 获取合作商品列表
	 * 接口说明
	 * 可通过该接口获取商品列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/item/list/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 否 团长商品 所属小店appid
	 * page_size number 是 单页商品数（不超过30）
	 * next_key string 否 由上次请求返回，顺序翻页时需要传入, 会从上次返回的结果往后翻一页
	 * 请求参数示例
	 * {
	 * "page_size": 2
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * list[].product_id string(uint64) 商品id
	 * list[].appid string(uint64) 所属小店appid
	 * next_key string 本次翻页的上下文，用于顺序翻页请求
	 * has_more bool 是否还有剩余商品
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "list": [
	 * {
	 * "appid": "test",
	 * "product_id": "12345"
	 * },
	 * {
	 * "appid": "test",
	 * "product_id": "123456"
	 * }
	 * ],
	 * "has_more": true
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 * 10024003 不合法的appid
	 */
	public function itemListGet($appid, $page_size = 30, $next_key = "")
	{
		$params = array();
		if (! empty($appid)) {
			$params['appid'] = $appid;
		}
		$params['page_size'] = $page_size;
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$rst = $this->_request->post($this->_url . 'item/list/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /获取佣金单详情
	 * 获取佣金单详情
	 * 接口说明
	 * 可通过该接口获取佣金单详情
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/order/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * order_id string 是 订单号，可从获取佣金单列表接口获得
	 * sku_id string(uint64) 是 商品skuid，可从获取佣金单列表接口获得
	 * 请求参数示例
	 * {
	 * "order_id": "123",
	 * "sku_id": "12345"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * commssion_order object CommissionOrder 佣金单结构，结构体详情请参考CommissionOrder
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "commssion_order": {
	 * "order_id": "123",
	 * "sku_id": "12345",
	 * "create_time": 1675855175,
	 * "update_time": 1675855217,
	 * "status": 20,
	 * "order_detail": {
	 * "shop_info": {
	 * "appid": "wxxxx"
	 * },
	 * "product_info": {
	 * "product_id": "12345",
	 * "thumb_img": "https://test.com/0",
	 * "title": "test_123",
	 * "actual_payment": 100
	 * },
	 * "order_info": {
	 * "order_status": 20
	 * },
	 * "commission_info": {
	 * "finder_info": {
	 * "nickname": "finder",
	 * "ratio": 100000,
	 * "amount": 10
	 * },
	 * "service_ratio": 300000,
	 * "service_amount": 30
	 * }
	 * }
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发人员检查传递参数是否正确
	 * 10024006 不存在该佣金单
	 * 结构体
	 * CommissionOrder
	 * 佣金单结构
	 *
	 * 参数 类型 描述
	 * order_id string 订单号
	 * sku_id number 商品skuid
	 * create_time number 秒级时间戳
	 * update_time number 秒级时间戳
	 * status number 佣金单状态，枚举值详情请参考CommissionOrderStatus
	 * order_detail object OrderDetail 订单详情，结构体详情请参考OrderDetail
	 * OrderDetail
	 * 订单详情
	 *
	 * 参数 类型 描述
	 * shop_info object BizInfo 小店商家信息，结构体详情请参考BizInfo
	 * product_info object ProductInfo 佣金单商品信息，结构体详情请参考ProductInfo
	 * order_info object OrderInfo 订单信息，结构体详情请参考OrderInfo
	 * commission_info object CommissionInfo 分佣信息，结构体详情请参考CommissionInfo
	 * BizInfo
	 * 小店商家信息
	 *
	 * 参数 类型 描述
	 * appid string(uint64) 所属小店appid
	 * ProductInfo
	 * 佣金单商品信息
	 *
	 * 参数 类型 描述
	 * product_id string(uint64) 商品id
	 * thumb_img string sku小图
	 * actual_payment number 可分佣金额
	 * title string 商品标题
	 * OrderInfo
	 * 订单信息
	 *
	 * 参数 类型 描述
	 * status number 订单状态，，枚举值详情请参考OrderStatus
	 * CommissionInfo
	 * 分佣信息
	 *
	 * 参数 类型 描述
	 * finder_info object FinderInfo 带货达人信息，结构体详情请参考FinderInfo
	 * service_ratio number 服务费率[0, 1000000]
	 * service_amount number 服务费金额
	 * profit_sharding_suc_time number 服务费结算时间
	 * FinderInfo
	 * 带货达人信息
	 *
	 * 参数 类型 描述
	 * nickname string 达人昵称
	 * ratio number 佣金率[0, 1000000]
	 * amount number 佣金
	 * openfinderid string 视频号openfinderid
	 * 枚举值
	 * OrderStatus
	 * 订单状态
	 *
	 * 枚举值 描述
	 * 10 待付款
	 * 20 待发货
	 * 21 部分发货
	 * 30 待收货
	 * 100 完成
	 * 200 全部商品售后之后，订单取消
	 * 250 未付款用户主动取消或超时未付款订单自动取消
	 * CommissionOrderStatus
	 * 佣金单状态
	 *
	 * 枚举值 描述
	 * 20 未结算
	 * 100 已结算
	 * 200 取消结算
	 */
	public function orderGet($order_id, $sku_id)
	{
		$params = array();
		$params['order_id'] = $order_id;
		$params['sku_id'] = $sku_id;
		$rst = $this->_request->post($this->_url . 'order/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /获取佣金单列表
	 * 获取佣金单列表
	 * 接口说明
	 * 可通过该接口获取佣金单列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/order/list/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 否 佣金单所属小店appid
	 * finder_id string 否 视频号finder_id
	 * openfinderid string 否 视频号openfinderid
	 * create_time_range object TimeRange 否 佣金单创建时间范围，填了佣金单更新时间范围则不填该时间，结构体详情请参考TimeRange
	 * update_time_range object TimeRange 否 佣金单更新时间范围，填了佣金单创建时间范围则不填该时间，结构体详情请参考TimeRange
	 * order_id string 否 订单ID，填此参数后其他过滤参数无效
	 * page_size number 是 单页佣金单数（不超过30）
	 * next_key string 否 由上次请求返回，顺序翻页时需要传入, 会从上次返回的结果往后翻一页
	 * sharer_appid string 否 用于查询推客，或者达人平台产生的订单数据
	 * 请求参数示例
	 * {
	 * "page_size": 1,
	 * "create_time_range": {
	 * "start_time": 1676375581,
	 * "end_time": 1676375754
	 * }
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * list[].order_id string 商品id
	 * list[].sku_id number skuid
	 * next_key string 本次翻页的上下文，用于顺序翻页请求
	 * has_more bool 是否还有剩余商品
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "list": [
	 * {
	 * "order_id": "123",
	 * "sku_id": "1234"
	 * }
	 * ],
	 * "has_more": true
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发人员检查传递参数是否正确
	 * 10024001 不合法的finder_id
	 * 10024003 不合法的appid
	 * 结构体
	 * TimeRange
	 * 时间范围
	 *
	 * 参数 类型 是否必填 描述
	 * start_time number 否 开始时间，秒级时间戳
	 * end_time number 否 结束时间，秒级时间戳
	 */
	public function orderListGet($appid, $finder_id, $openfinderid, TimeRange $create_time_range = null, TimeRange $update_time_range = null, $order_id = "", $page_size = 30, $next_key = "", $sharer_appid = "")
	{
		$params = array();
		if (! empty($appid)) {
			$params['appid'] = $appid;
		}
		if (! empty($finder_id)) {
			$params['finder_id'] = $finder_id;
		}
		if (! empty($openfinderid)) {
			$params['openfinderid'] = $openfinderid;
		}
		if (! empty($create_time_range)) {
			$params['create_time_range'] = $create_time_range->getParams();
		}
		if (! empty($update_time_range)) {
			$params['update_time_range'] = $update_time_range->getParams();
		}
		if (! empty($order_id)) {
			$params['order_id'] = $order_id;
		}
		$params['page_size'] = $page_size;
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		$rst = $this->_request->post($this->_url . 'order/list/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /获取合作小店详情
	 * 获取合作小店详情
	 * 接口说明
	 * 可通过该接口获取合作小店详情
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/shop/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * page_size number 是 获取小店数量（不超过30）
	 * 请求参数示例
	 * {
	 * "appid": "wxtest123"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * shop_list ShopDetail 小店详情，结构体详情请参考ShopDetail
	 * next_key string 本次翻页的上下文，用于顺序翻页请求
	 * has_more bool 是否还有剩余小店
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "shop_detail": {
	 * "base_info": {
	 * "appid": "wxtest1234",
	 * "headimg_url": "headimg_url_test",
	 * "nickname": "test1234"
	 * },
	 * "data_info": {
	 * "gmv": 1850,
	 * "product_number": 2,
	 * "settle_amount": 39,
	 * "unsettle_amount": 119,
	 * "product_number_today": 0,
	 * "product_number_sold_today": 0
	 * },
	 * "status": 2,
	 * "approved_time" : 100
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发人员检查传递参数是否正确
	 * 10024007 与商家无关联关系
	 * 结构体
	 * ShopDetail
	 * 小店详情
	 *
	 * 参数 类型 描述
	 * base_info BizBaseInfo 小店基础信息，结构体详情请参考BizBaseInfo
	 * data_info ShopDataInfo 小店数据信息 ，结构体详情请参考ShopDataInfo
	 * status number 合作状态Status，枚举值详情请参考Status
	 * approved_time number 开始合作时间戳
	 * BizBaseInfo
	 * 小店基础信息
	 *
	 * 参数 类型 描述
	 * appid string 小店appid
	 * headimg_url string 小店头像
	 * nickname string 小店昵称
	 * ShopDataInfo
	 * 小店数据信息
	 *
	 * 参数 类型 描述
	 * gmv number 合作动销GMV，单位：分
	 * product_number number 历史合作商品数
	 * settle_amount number 已结算服务费，单位：分
	 * unsettle_amount number 预计待结算服务费，单位：分
	 * product_number_today number 今日新增合作商品数
	 * product_number_sold_today number 今日动销商品数
	 * 枚举值
	 * Status
	 * 合作状态
	 *
	 * 枚举值 描述
	 * 1 邀请中
	 * 2 已接受邀请
	 * 3 已拒绝邀请
	 * 4 取消邀请
	 * 5 取消合作
	 */
	public function shopGet($page_size = 30)
	{
		$params = array();
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'shop/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /获取合作小店列表
	 * 获取合作小店列表
	 * 接口说明
	 * 可通过该接口获取小店列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/shop/list/get?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * page_size number 是 获取小店数量（不超过30）
	 * next_key string 否 由上次请求返回，顺序翻页时需要传入, 会从上次返回的结果往后翻一页
	 * 请求参数示例
	 * {
	 * "page_size": 1
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * shop_list ShopDetail 小店详情，结构体详情请参考ShopDetail
	 * next_key string 本次翻页的上下文，用于顺序翻页请求
	 * has_more bool 是否还有剩余小店
	 * 返回参数示例
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "shop_list": [
	 * {
	 * "base_info": {
	 * "appid": "wxtest1234",
	 * "headimg_url": "headimg_url_test",
	 * "nickname": "test1234"
	 * },
	 * "status": 2
	 * }
	 * ]
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误，请开发人员检查传递参数是否正确
	 * 结构体
	 * ShopDetail
	 * 小店详情
	 *
	 * 参数 类型 描述
	 * base_info BizBaseInfo 小店基础信息，结构体详情请参考BizBaseInfo
	 * status number 合作状态Status，枚举值详情请参考Status
	 * BizBaseInfo
	 * 小店基础信息
	 *
	 * 参数 类型 描述
	 * appid string 小店appid
	 * headimg_url string 小店头像
	 * nickname string 小店昵称
	 * 枚举值
	 * Status
	 * 合作状态
	 *
	 * 枚举值 描述
	 * 1 邀请中
	 * 2 已接受邀请
	 * 3 已拒绝邀请
	 * 4 取消邀请
	 * 5 取消合作
	 */
	public function shopListGet($page_size = 30, $next_key = "")
	{
		$params = array();
		$params['page_size'] = $page_size;
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$rst = $this->_request->post($this->_url . 'shop/list/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /机构数据 /机构商品添加和管理
	 * 团长商品添加和管理
	 * 接口说明
	 * 可通过该接口操作商家提交的商品
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/league/headsupplier/item/upd?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * appid string 是 团长商品 所属小店appid
	 * product_id string(uint64) 是 商品id
	 * type number 是 操作类型, 1: 添加商品，3: 隐藏商品，4: 取消隐藏
	 * 请求参数示例
	 * {
	 * "product_id": 12345,
	 * "appid": "test",
	 * "type": 1
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
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 * 10024003 不合法的appid
	 * 10024004 不存在该商品
	 * 10024015 该商品不在审核中
	 */
	public function itemUpd($appid, $product_id, $type)
	{
		$params = array();
		$params['appid'] = $appid;
		$params['product_id'] = $product_id;
		$params['type'] = $type;
		$rst = $this->_request->post($this->_url . 'item/upd', $params);
		return $this->_client->rst($rst);
	}
}
