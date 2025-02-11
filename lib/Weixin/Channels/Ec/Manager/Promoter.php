<?php

namespace Weixin\Channels\Ec\Manager;

use Weixin\Client;
use Weixin\Channels\Ec\Model\Promoter\Category;
use Weixin\Channels\Ec\Model\Promoter\SpuItemCondition;

/**
 * 推客带货管理API
 * https://developers.weixin.qq.com/doc/channels/API/leagueheadsupplier/promotion/sharer/getpromoterregisterandbindstatus.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Promoter
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/channels/ec/promoter/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * 联盟带货机构API /推客带货 /推客账号相关 /获取推客的注册和绑定状态
	 * 获取推客的注册状态，以及和机构的绑定状态
	 * 接口说明
	 * 可通过该接口，可获取到当前推客，在推客平台上的注册状态，以及和当前机构的绑定状态
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_promoter_register_and_bind_status?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_openid string 否 推客在小程序中的 openid，和 sharer_appid 二选一
	 * sharer_appid string 否 推客在微信电商平台注册的身份标识，和 sharer_openid 二选一
	 * is_simple_register bool 是 是否走简易版本注册【当走简易版本注册时，可以不要求推客开通商户号，但分佣只能走机构自己分佣；如果不走简易注册流程时，要求推客开通商户号作为收款账户，可以平台分佣】
	 * 请求参数示例
	 * {
	 * "sharer_openid": "openid",
	 * "is_simple_register": true
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * bind_status number 和机构的绑定状态，0：未绑定 1：已绑定
	 * register_status number 当前推客的注册状态：0：未注册 1：注册中，还未完成 2：已完成注册 3:用户未支付实名，需要把微信先支付实名才能继续注册
	 * register_business_type string register_status等于 0 或者 1时，调用注册流程时，openBusinessView需要的businessType
	 * register_query_string string 注册时需要的queryString参数
	 * bind_business_type string bind_status等于0时，调用绑定流程时，openBusinessView需要的businessType
	 * bind_query_string string 绑定时需要的queryString参数
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "bind_status": 0,
	 * "register_status":1,
	 * "register_business_type":"",
	 * "register_query_string":"",
	 * "bind_business_type":"",
	 * "bind_query_string":""
	 * }
	 * 调用openbusinesstype为注册时的示例：
	 *
	 * wx.openBusinessView(
	 * {
	 * businessType: 'CreatorApplyments',
	 * queryString: '',
	 * extraData: ｛
	 * commissionType: number,
	 * commissionRatio: number,
	 * headSupplierAppid： xxx
	 * }
	 * }
	 * )
	 * headSupplierAppid为机构的appid内容 commissionType为分佣类型，0代表平台分佣，1代表机构自己分佣 commissionRatio为分佣比例，如果为平台分佣，值的范围为 100000 - 900000，代表了【10%，90%】，如果是平台分佣，设置成 0 就好
	 *
	 * 调用openbusinesstype为绑定时的示例：
	 *
	 * wx.openBusinessView(
	 * {
	 * businessType: 'CreatorApplyments',
	 * queryString: '',
	 * extraData: ｛
	 * commissionType: number,
	 * commissionRatio: number,
	 * headSupplierAppid： xxx
	 * }
	 * }
	 * )
	 * headSupplierAppid为机构的appid内容 commissionType为分佣类型，0代表平台分佣，1代表机构自己分佣 commissionRatio为分佣比例，如果为平台分佣，值的范围为 100000 - 900000，代表了【10%，90%】，如果是平台分佣，设置成 0 就好
	 *
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getPromoterRegisterAndBindStatus($sharer_openid, $sharer_appid, $is_simple_register)
	{
		$params = array();
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		$params['is_simple_register'] = $is_simple_register;
		$rst = $this->_request->post($this->_url . 'get_promoter_register_and_bind_status', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /推客账号相关 /设置推客的分佣模式和分佣比例
	 * 设置推客的的分佣类型和比例信息
	 * 接口说明
	 * 可通过该接口，可设置推客的的分佣类型和比例信息
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/set_sharer_commission_info?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_appid string 是 推客在微信电商平台注册的身份标识
	 * commission_type string 是 分佣类型【 0：平台分佣， 1:机构自己分佣】
	 * commission_ratio string 是 平台分佣时的分佣比例，范围为【100000 - 900000】，代表【10%-90%】
	 * 请求参数示例
	 * {
	 * "sharer_appid": "",
	 * "commission_type":1,
	 * "commission_ratio": 10
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function setSharerCommissionInfo($sharer_appid, $commission_type, $commission_ratio)
	{
		$params = array();
		$params['sharer_appid'] = $sharer_appid;
		$params['commission_type'] = $commission_type;
		$params['commission_ratio'] = $commission_ratio;
		$rst = $this->_request->post($this->_url . 'set_sharer_commission_info', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /推客账号相关 /获取已经绑定的推客信息
	 * 获取机构绑定的推客信息
	 * 接口说明
	 * 可通过该接口，可获取当前机构绑定的推客信息
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_bind_sharer_list?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_openid string 否 查询某个推客，传入推客的小程序openid
	 * sharer_appid string 否 查询某个推客，传入推客的appid
	 * next_key string 是 分页参数，第一页为空，后面返回前面一页返回的数据
	 * page_size number 是 一页获取多少个推客，最大 20
	 * 请求参数示例
	 * {
	 * "next_key": "",
	 * "page_size": 10,
	 * "sharer_appid":"",
	 * "sharer_openid":""
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * next_key number 和机构的绑定状态，0：未绑定 1：已绑定
	 * sharer_info_list array object SharerInfo 推客的绑定参数列表
	 * 结构体
	 * SharerInfo
	 * 绑定的推客内容
	 *
	 * 参数 类型 描述
	 * sharer_appid string 推客的 appid
	 * bind_time number 绑定时间戳
	 * commission_ratio number 分佣比例
	 * commission_type number 分佣类型【0：平台分佣 1：机构分佣】
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "sharer_info_list": [
	 * {
	 * "sharer_appid": "推客的 appid 内容",
	 * "bind_time": 1624082155,
	 * "commission_ratio":10000,
	 * "commission_type": 1
	 * }
	 * ],
	 * "next_key":""
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getBindSharerList($sharer_openid, $sharer_appid, $next_key = "", $page_size = 20)
	{
		$params = array();
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'get_bind_sharer_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /设置推客单个商品的分佣比例
	 * 设置推客的单个商品的分佣比例信息
	 * 接口说明
	 * 可通过该接口，可设置推客的单个商品的分佣比例信息
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/set_sharer_product_commission_info?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_appid string 是 推客在微信电商平台注册的身份标识
	 * product_id number 是 要设置的商品 id
	 * commission_ratio string 是 平台分佣时的分佣比例，范围为【100000 - 900000】，代表【10%-90%】
	 * 请求参数示例
	 * {
	 * "sharer_appid": "",
	 * "product_id":1,
	 * "commission_ratio": 10
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function setSharerProductCommissionInfo($sharer_appid, $product_id, $commission_ratio)
	{
		$params = array();
		$params['sharer_appid'] = $sharer_appid;
		$params['product_id'] = $product_id;
		$params['commission_ratio'] = $commission_ratio;
		$rst = $this->_request->post($this->_url . 'set_sharer_product_commission_info', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /获取设置的推客单个商品的分佣比例
	 * 获取推客的某个商品的推广分佣比例
	 * 接口说明
	 * 通过该接口，可获取到推客的某个商品的推广分佣比例
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_sharer_product_commission_info?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_appid string 是 推客在微信电商平台注册的身份标识
	 * product_id number 是 要设置的商品 id
	 * 请求参数示例
	 * {
	 * "sharer_appid": "",
	 * "product_id":1
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * commission_ratio string 分佣比例，范围为【100000 - 900000】，代表【10%-90%】
	 * is_set bool 是否设置了这个商品的佣金率
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "is_set": true,
	 * "commission_ratio": 10
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getSharerProductCommissionInfo($sharer_appid, $product_id)
	{
		$params = array();
		$params['sharer_appid'] = $sharer_appid;
		$params['product_id'] = $product_id;
		$rst = $this->_request->post($this->_url . 'get_sharer_product_commission_info', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /获取可以推广的商品列表
	 * 获取可推广的商品id列表
	 * 接口说明
	 * 可通过该接口，可获取可推广的商品id列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_promote_product_list?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * plan_type number 是 商品的计划类型 1：定向计划 2：公开计划
	 * spu_item_condition object SpuItemCondition 否 商品查询条件，结构体详情请参考SpuItemCondition结构体
	 * category object Category 否 商品类目查询条件，定向计划不支持。结构体详情请参考Category结构体
	 * keyword string 否 搜索关键词
	 * next_key string 是 分页参数，第一页为空，后面返回前面一页返回的数据
	 * page_size number 是 一页获取多少个商品，最大 20
	 * 结构体
	 * SpuItemCondition
	 * 商品查询条件
	 *
	 * 参数 类型 描述
	 * selling_price_range object Range 售卖价区间，单位是分。结构体详情请参考Range结构体
	 * monthly_sales_range object Range 月销量区间，结构体详情请参考Range结构体
	 * flags string array 保障标，0-7天无理由；1-运费险；2-品牌（已废弃）；3-放心买；4-损坏包退；5-假一赔三；6-先用后付；7-包邮；
	 * service_fee_rate_range object Range 服务费率区间，单位是10万分之。结构体详情请参考Range结构体
	 * commission_rate_range object Range 佣金率区间，单位是10万分之。结构体详情请参考Range结构体
	 * promote_time_range object Range 推广时间范围，结构体详情请参考Range结构体
	 * Range
	 * 范围
	 *
	 * 参数 类型 描述
	 * min string 区间最小值
	 * max string 区间最大值
	 * Category
	 * 商品类目查询条件
	 *
	 * 目前大部分情况只有一级类目，请求时填一级即可。
	 *
	 * 参数 类型 描述
	 * category_id string 商品类目
	 * category_name string 商品类目名称，可填空
	 * category_ids_1 string array 一级类目列表
	 * category_ids_2 string array 二级类目列表
	 * category_ids_3 string array 三级类目列表
	 * 商品类目查询参考
	 *
	 * 请求时只需将列数组中的一个元素填入category即可。
	 *
	 * {
	 * "categorys": [
	 * {
	 * "category_id": 11099070301657575487,
	 * "category_ids_1": [7339,502043,7419,6625],
	 * "category_name": "食品生鲜"
	 * },
	 * {
	 * "category_id": 16579416177373560313,
	 * "category_ids_1": [6033,1653,6831,7378,6932],
	 * "category_name": "服饰鞋包"
	 * },
	 * {
	 * "category_id": 17007902228422672609,
	 * "category_ids_1": [1001,6870],
	 * "category_name": "个护美妆"
	 * },
	 * {
	 * "category_id": 12377324634086192020,
	 * "category_ids_1": [135835],
	 * "category_name": "图书"
	 * },
	 * {
	 * "category_id": 8261345894708739273,
	 * "category_ids_1": [1142,1421,1453,1208,6153,6472,1069,1247],
	 * "category_name": "家清日用"
	 * },
	 * {
	 * "category_id": 12379480883574690382,
	 * "category_ids_1": [530004,376707,1804,442005,1701,381003,128209,6263,377078,378228,530032,7363,378136,429008,6706],
	 * "category_name": "其他"
	 * }
	 * ]
	 * }
	 * 请求参数示例
	 * // 原请求同样适用，不填则默认不设置任何条件查询所有商品列表
	 * {
	 * "next_key": "",
	 * "page_size": 10,
	 * "plan_type":1
	 * }
	 *
	 * // 搜索示例
	 * {
	 * "next_key": "",
	 * "page_size": 10,
	 * "plan_type":1,
	 * "category": {
	 * "category_id": "8261345894708739273",
	 * "category_ids_1": ["1142","1421","1453","1208","6153","6472","1069","1247"],
	 * "category_name": "家清日用"
	 * },
	 * "keyword": "纸巾",
	 * "spu_item_condition": {
	 * "commission_rate_range": {
	 * "max": "100000",
	 * "min": "0"
	 * }
	 * }
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * next_key string 分页参数
	 * product_list array object ProductInfo 商品列表
	 * 结构体
	 * ProductInfo
	 * 绑定的推客内容
	 *
	 * 参数 类型 描述
	 * product_id number 商品 id
	 * shop_appid string 商品所属店铺 appid
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "product_list":[
	 * {
	 * "product_id": 1,
	 * "shop_appid": "SHOPAPPID"
	 * }
	 * ],
	 * "next_key": "PAGECONTEXT"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getPromoteProductList($plan_type, SpuItemCondition $spu_item_condition = null, Category $category = null, $keyword = "", $next_key = "", $page_size = 20)
	{
		$params = array();
		$params['plan_type'] = $plan_type;
		if (! empty($spu_item_condition)) {
			$params['spu_item_condition'] = $spu_item_condition->getParams();
		}
		if (! empty($category)) {
			$params['category'] = $category->getParams();
		}
		if (! empty($keyword)) {
			$params['keyword'] = $keyword;
		}
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'get_promote_product_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /获取可以推广的商品详情
	 * 获取合作商品详情
	 * 接口说明
	 * 可通过该接口获取推客商品的商品详情
	 *
	 * 启用新多级类目树提示：旧的类目树固定为三级类目结构，新的类目树为多级类目结构，过渡期间，新旧类目树兼容使用，请开发者尽快切换到新多级类目树。其中差异请参阅“新旧类目树差异”。此接口新增 cats_v2 字段支持新类目树，详见参数。
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_promote_product_detail?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * shop_appid string 是 团长商品 所属小店appid
	 * product_id number 是 商品id
	 * plan_type number 是 商品的计划类型 1：定向计划 2：公开计划
	 * get_available_coupon boolean 否 填true返回商品可用的机构券
	 * 请求参数示例
	 * {
	 * "shop_appid":"SHOPAPPID",
	 * "product_id": 1,
	 * "plan_type": 1,
	 * "get_available_coupon": false
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * item object Item 商品详情，结构体详情请参考Item结构体
	 * publish_coupons array object Coupon 商品可用的公开机构券，结构体详情请参考Coupon结构体
	 * cooperative_coupons array object Coupon 商品可用的定向机构券，结构体详情请参考Coupon结构体
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "product": {
	 * "shop_appid": "test",
	 * "product_id": 12345,
	 * "product_promotion_link": "",
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
	 * "cats_v2": [{
	 * "cat_id": "1421"
	 * }],
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
	 * "extra_service": {
	 * "seven_day_return": 0,
	 * "pay_after_use": 0,
	 * "freight_insurance": 0,
	 * "fake_one_pay_three": 0,
	 * "damage_guarantee": 0
	 * },
	 * "statistical_data": {
	 * "good_ratio": 0,
	 * "sales_in_30_days": 1
	 * },
	 * "skus": [{
	 * "sku_id": "670813472",
	 * "thumb_img": "",
	 * "sale_price": 500,
	 * "stock_num": 998,
	 * "sku_attrs": [{
	 * "attr_key": "产地",
	 * "attr_value": "四川成都"
	 * }]
	 * }]
	 * },
	 * "commission_info": {
	 * "status": 1,
	 * "service_ratio": 1,
	 * "start_time": 1,
	 * "end_time": 1,
	 * "normal_commission_info": {
	 * "ratio": 1
	 * }
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
	 * product
	 * 商品所有信息
	 *
	 * 参数 类型 描述
	 * shop_appid string 所属小店appid
	 * product_id string(uint64) 商品id
	 * product_promotion_link string 商品卡片透传参数【注意：内嵌商品卡片时一定要传，不然会归因失败】
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
	 * skus Array<object SkuInfo> sku信息，结构体详情请参考SkuInfo
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
	 * cat_name string 类目名称
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
	 * start_time number 时间戳，合作开始时间
	 * end_time number 时间戳，合作结束时间
	 * Coupon
	 * 券信息
	 *
	 * 参数 类型 描述
	 * coupon_id string 券的 id
	 * 枚举值
	 * ItemStatus
	 * 商品带货状态
	 *
	 * 枚举值 描述
	 * 1 已上架推广
	 * 2 已下架推广
	 * 5 已清退
	 */
	public function getPromoteProductDetail($shop_appid, $product_id, $plan_type, $get_available_coupon = false)
	{
		$params = array();
		$params['shop_appid'] = $shop_appid;
		$params['product_id'] = $product_id;
		$params['plan_type'] = $plan_type;
		$params['get_available_coupon'] = $get_available_coupon;
		$rst = $this->_request->post($this->_url . 'get_promote_product_detail', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /获取某个推客某个商品的推广短链
	 * 获取推客对某个商品的推广短链
	 * 接口说明
	 * 可通过该接口，可获取到推客对某个商品的推广短链
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_product_promotion_link_info?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_appid string 否 推客 appid，和sharer_openid二选一
	 * sharer_openid string 否 推客在小程序中的openid，和sharer_appid二选一
	 * product_id number 否 商品 id，如果使用该参数，需要传入shop_appid
	 * shop_appid string 否 商品所属店铺 appid
	 * product_short_link string 否 商品短链，和 product_id 二选一
	 * 请求参数示例
	 * {
	 * "sharer_appid": "appid",
	 * "product_id": 10,
	 * "shop_appid":"appid"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * short_link string 推广短链
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "short_link": "short_link"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getProductPromotionLinkInfo($sharer_appid, $sharer_openid, $product_id, $shop_appid, $product_short_link)
	{
		$params = array();
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($product_id)) {
			$params['product_id'] = $product_id;
		}
		if (! empty($shop_appid)) {
			$params['shop_appid'] = $shop_appid;
		}
		if (! empty($product_short_link)) {
			$params['product_short_link'] = $product_short_link;
		}
		$rst = $this->_request->post($this->_url . 'get_product_promotion_link_info', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /获取某个推客某个商品的推广二维码
	 * 获取推客对某个商品的推广二维码
	 * 接口说明
	 * 可通过该接口，可获取到推客对某个商品的推广二维码
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_product_promotion_qrcode_info?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_appid string 否 推客 appid，和sharer_openid二选一
	 * sharer_openid string 否 推客在小程序中的openid，和sharer_appid二选一
	 * product_id number 否 商品 id，如果使用该参数，需要传入shop_appid
	 * shop_appid string 否 商品所属店铺 appid
	 * product_short_link string 否 商品短链，和 product_id 二选一
	 * 请求参数示例
	 * {
	 * "sharer_appid": "appid",
	 * "product_id": 10,
	 * "shop_appid":"appid"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * qrcode_url string 推广二维码
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "qrcode_url": "url"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getProductPromotionQrcodeInfo($sharer_appid, $sharer_openid, $product_id, $shop_appid, $product_short_link)
	{
		$params = array();
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($product_id)) {
			$params['product_id'] = $product_id;
		}
		if (! empty($shop_appid)) {
			$params['shop_appid'] = $shop_appid;
		}
		if (! empty($product_short_link)) {
			$params['product_short_link'] = $product_short_link;
		}
		$rst = $this->_request->post($this->_url . 'get_product_promotion_qrcode_info', $params);
		return $this->_client->rst($rst);
	}
	/**
	 * 联盟带货机构API /推客带货 /推客商品推广相关 /获取某个推客某个商品的内嵌小程序商品卡片的推广参数
	 * 获取某个推客某个商品的内嵌商品卡片product_promotion_link
	 * 接口说明
	 * 可通过该接口，获取某个推客某个商品的内嵌商品卡片product_promotion_link，长期有效
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_promoter_single_product_promotion_info?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * sharer_appid string 否 推客 appid，和sharer_openid二选一
	 * sharer_openid string 否 推客在小程序中的openid，和sharer_appid二选一
	 * product_id number 否 商品 id，如果使用该参数，需要传入shop_appid
	 * shop_appid string 否 商品所属店铺 appid
	 * product_short_link string 否 商品短链，和 product_id 二选一
	 * 请求参数示例
	 * {
	 * "sharer_appid": "appid",
	 * "product_id": 10,
	 * "shop_appid":"appid"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * product_promotion_link string 内嵌商品卡片的推广参数
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "product_short_link": "link"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getPromoterSingleProductPromotionInfo($sharer_appid, $sharer_openid, $product_id, $shop_appid, $product_short_link)
	{
		$params = array();
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($product_id)) {
			$params['product_id'] = $product_id;
		}
		if (! empty($shop_appid)) {
			$params['shop_appid'] = $shop_appid;
		}
		if (! empty($product_short_link)) {
			$params['product_short_link'] = $product_short_link;
		}
		$rst = $this->_request->post($this->_url . 'get_promoter_single_product_promotion_info', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /机构券推广相关 /获取公开机构券
	 * 获取公开券ID列表
	 * 接口说明
	 * 可通过该接口，可获取公开券ID列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_public_coupon_list?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * shop_appid string 否 店铺id，填了只返回属于该店铺的券
	 * next_key string 是 分页参数，第一页为空，后面返回前面一页返回的数据
	 * page_size number 是 券数量，不能超过 200
	 * 请求参数示例
	 * {
	 * "shop_appid": "需要过滤的店铺appid",
	 * "next_key": "NEXT_KEY",
	 * "page_size": 20
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * next_key string 分页参数，第一页为空，后面请求返回上一次请求返回的 next_key
	 * has_more bool 是否还有更多，如果返回为true，表示
	 * coupons array object Coupon 推客的绑定参数列表
	 * 结构体
	 * Coupon
	 * 券信息
	 *
	 * 参数 类型 描述
	 * coupon_id string 券的 id
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "next_key": "NEW_NEXT_KEY",
	 * "coupons": [
	 * {
	 * "coupon_id": "COUPON_ID"
	 * }
	 * ],
	 * "has_more": true
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getPublicCouponList($shop_appid, $next_key = "", $page_size = 200)
	{
		$params = array();
		if (! empty($shop_appid)) {
			$params['shop_appid'] = $shop_appid;
		}
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'get_public_coupon_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /机构券推广相关 /获取定向机构券
	 * 获取定向券ID列表
	 * 接口说明
	 * 可通过该接口，可获取定向券ID列表
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_cooperative_coupon_list?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * shop_appid string 否 店铺id，填了只返回属于该店铺的券
	 * next_key string 是 分页参数，第一页为空，后面返回前面一页返回的数据
	 * page_size number 是 券数量，不能超过 200
	 * 请求参数示例
	 * {
	 * "shop_appid": "需要过滤的店铺appid",
	 * "next_key": "NEXT_KEY",
	 * "page_size": 20
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * next_key string 分页参数，第一页为空，后面请求返回上一次请求返回的 next_key
	 * has_more bool 是否还有更多，如果返回为true，表示
	 * coupons array object Coupon 推客的绑定参数列表
	 * 结构体
	 * Coupon
	 * 券信息
	 *
	 * 参数 类型 描述
	 * coupon_id string 券的 id
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "next_key": "NEW_NEXT_KEY",
	 * "coupons": [
	 * {
	 * "coupon_id": "COUPON_ID"
	 * }
	 * ],
	 * "has_more": true
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getCooperativeCouponList($shop_appid, $next_key, $page_size = 200)
	{
		$params = array();
		if (! empty($shop_appid)) {
			$params['shop_appid'] = $shop_appid;
		}
		if (! empty($next_key)) {
			$params['next_key'] = $next_key;
		}
		$params['page_size'] = $page_size;
		$rst = $this->_request->post($this->_url . 'get_cooperative_coupon_list', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /机构券推广相关 /获取机构券详情
	 * 获取券ID对应的详情内容
	 * 接口说明
	 * 可通过该接口，可获取券ID对应的详情内容
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_coupon_detail?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * coupon_id string 是 券id
	 * 请求参数示例
	 * {
	 * "coupon_id": "COUPON_ID"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * next_key string 分页参数，第一页为空，后面请求返回上一次请求返回的 next_key
	 * has_more bool 是否还有更多，如果返回为true，表示
	 * coupon array object coupon 推客的绑定参数列表
	 * 结构体
	 * coupon
	 * 券信息
	 *
	 * 参数 类型 描述
	 * coupon_id string 券的 id
	 * coupon_id string 优惠券ID
	 * shop_appid string 优惠券所属店铺id
	 * type number 优惠券类型，枚举值详情请参考type
	 * status number 优惠券状态
	 * create_time number 优惠券创建时间
	 * update_time number 优惠券更新时间
	 * coupon_info.name string 优惠券名称
	 * coupon_info.valid_info.valid_type number 优惠券有效期类型，枚举值详情请参考valid_type
	 * coupon_info.valid_info.valid_day_num number 优惠券有效天数，valid_type=2时才有意义
	 * coupon_info.valid_info.start_time number 优惠券有效期开始时间，valid_type=1时才有意义
	 * coupon_info.valid_info.end_time number 优惠券有效期结束时间，valid_type=1时才有意义
	 * stock_info.issued_num number 优惠券剩余量
	 * stock_info.receive_num number 优惠券领用但未使用量
	 * stock_info.used_num number 优惠券已用量
	 * coupon_info.discount_info.discount_num number 优惠券折扣数 * 1000, 例如 5.1折-> 5100
	 * coupon_info.discount_info.discount_fee number 优惠券减少金额, 单位分, 例如0.5元-> 50
	 * coupon_info.discount_info.discount_condition.product_cnt number 优惠券使用条件, 满 x 件商品可用
	 * coupon_info.discount_info.discount_condition.product_price number 优惠券使用条件, 价格满 x 可用，单位分
	 * coupon_info.discount_info.discount_condition.product_ids[] string array 优惠券使用条件, 指定商品 id 可用
	 * coupon_info.ext_info.invalid_time number 优惠券失效时间
	 * coupon_info.ext_info.valid_time number 优惠券有效时间
	 * coupon_info.receive_info.end_time number 优惠券领用结束时间
	 * coupon_info.receive_info.limit_num_one_person number 单人限领张数
	 * coupon_info.receive_info.start_time number 优惠券领用开始时间
	 * coupon_info.receive_info.total_num number 优惠券领用总数
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "coupon": {
	 * "coupon_id": "111111111",
	 * "type": 103,
	 * "status": 5,
	 * "create_time": 1594885385,
	 * "update_time": 1594886327,
	 * "coupon_info": {
	 * "name": "scs",
	 * "discount_info": {
	 * "discount_num": 9900
	 * },
	 * "receive_info": {
	 * "end_time": 1673110742,
	 * "limit_num_one_person": 1,
	 * "start_time": 1673110742,
	 * "total_num": 100
	 * },
	 * "valid_info": {
	 * "valid_type": 1,
	 * "valid_day_num": 0,
	 * "start_time": 1594828800,
	 * "end_time": 1595433600
	 * }
	 * },
	 * "stock_info": {
	 * "issued_num": 95,
	 * "receive_num": 3,
	 * "used_num": 2
	 * }
	 * }
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getCouponDetail($coupon_id)
	{
		$params = array();
		$params['coupon_id'] = $coupon_id;
		$rst = $this->_request->post($this->_url . 'get_coupon_detail', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /机构券推广相关 /获取机构券的推广短链
	 * 获取某个券ID对应的推广短链
	 * 接口说明
	 * 可通过该接口，可获取某个券ID对应的推广短链
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_coupon_short_link?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * coupon_id string 是 券id
	 * sharer_openid string 和sharer_appid二选一，两个都不填时生成只带机构参数的券短链 推客在当前小程序的 openid
	 * sharer_appid string 和sharer_openid二选一，两个都不传时生成只带机构参数的券短链，都传时优先取此参数 推客的 appid
	 * 请求参数示例
	 * {
	 * "coupon_id": "COUPON_ID",
	 * "sharer_openid": "推客的当前小程序openid",
	 * "sharer_appid":"推客的appid"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * short_link string 短链
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "short_link": "SHORTLINK"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getCouponShortLink($coupon_id, $sharer_openid, $sharer_appid)
	{
		$params = array();
		$params['coupon_id'] = $coupon_id;
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		$rst = $this->_request->post($this->_url . 'get_coupon_short_link', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 联盟带货机构API /推客带货 /机构券推广相关 /获取机构券的推广二维码
	 * 获取某个券ID对应的推广二维码
	 * 接口说明
	 * 可通过该接口，可获取某个券ID对应的推广二维码
	 *
	 * 接口调用请求说明
	 * POST https://api.weixin.qq.com/channels/ec/promoter/get_coupon_qr_code?access_token=ACCESS_TOKEN
	 * 请求参数说明
	 * 参数 类型 是否必填 描述
	 * coupon_id string 是 券id
	 * sharer_openid string 和sharer_appid二选一，两个都不填时生成只带机构参数的券短链 推客在当前小程序的 openid
	 * sharer_appid string 和sharer_openid二选一，两个都不传时生成只带机构参数的券短链，都传时优先取此参数 推客的 appid
	 * 请求参数示例
	 * {
	 * "coupon_id": "COUPON_ID",
	 * "sharer_openid": "推客的当前小程序openid",
	 * "sharer_appid":"推客的appid"
	 * }
	 * 返回参数说明
	 * 参数 类型 描述
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * qr_code string 二维码
	 * 返回参数示例
	 * {
	 * "errcode": "0",
	 * "errmsg": "ok",
	 * "qr_code": "SHORTLINK"
	 * }
	 * 错误码
	 * 错误码 错误描述
	 * 公共错误码 -
	 * 10024000 参数错误
	 */
	public function getCouponQrCode($coupon_id, $sharer_openid, $sharer_appid)
	{
		$params = array();
		$params['coupon_id'] = $coupon_id;
		if (! empty($sharer_openid)) {
			$params['sharer_openid'] = $sharer_openid;
		}
		if (! empty($sharer_appid)) {
			$params['sharer_appid'] = $sharer_appid;
		}
		$rst = $this->_request->post($this->_url . 'get_coupon_qr_code', $params);
		return $this->_client->rst($rst);
	}
}
