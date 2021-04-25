<?php

namespace Weixin\Manager;

use Weixin\Client;
use Weixin\Model\Busifavor\Stock;

/**
 * 营销工具
 * https://pay.weixin.qq.com/wiki/doc/apiv3/apis/chapter9_2_1.shtml
 *
 * @author guoyongrong <handsomegyr@gmail.com>
 */
class MarketingV3
{

    // 接口地址
    private $_url = 'https://api.mch.weixin.qq.com/v3/marketing/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建商家券API
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks
     *
     * 请求方式：POST
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 商家券批次名称 stock_name string[1,21] 是 body 批次名称，字数上限为21个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：8月1日活动券
     * 批次归属商户号 belong_merchant string[8,15] 是 body 批次归属于哪个商户。
     * 示例值：10000022
     * 批次备注 comment string[1,20] 否 body 仅配置商户可见，用于自定义信息。字数上限为20个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：活动使用
     * 适用商品范围 goods_name string[1,15] 是 body 用来描述批次在哪些商品可用，会显示在微信卡包中。字数上限为15个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：xxx商品使用
     * 批次类型 stock_type string[1,32] 是 body 批次类型
     * NORMAL：固定面额满减券批次
     * DISCOUNT：折扣券批次
     * EXCHANGE：换购券批次
     * 示例值：NORMAL
     * +核销规则 coupon_use_rule object 是 body 券核销相关规则
     * +发放规则 stock_send_rule object 是 body 券发放相关规则
     * 商户请求单号 out_request_no string[1,128] 是 body 商户创建批次凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性。
     * 示例值：100002322019090134234sfdf
     * +自定义入口 custom_entrance object 否 body 卡详情页面，可选择多种入口引导用户。
     * +样式信息 display_pattern_info object 否 body 创建批次时的样式信息。
     * 券code模式 coupon_code_mode string[1,128] 是 body 枚举值：
     * WECHATPAY_MODE：系统分配券code。（固定22位纯数字）
     * MERCHANT_API：商户发放时接口指定券code。
     * MERCHANT_UPLOAD：商户上传自定义code，发券时系统随机选取上传的券code。
     * 示例值：WECHATPAY_MODE
     * +事件通知配置 notify_config object 否 body 事件回调通知商户的配置。
     * 是否允许营销补贴 subsidy bool 否 body 该批次发放的券是否允许进行补差，默认为false
     * 示例值：false
     *
     * 请求示例
     * JSON
     *
     * {
     * "stock_name":"8月1日活动券",
     * "belong_merchant":"10000098",
     * "comment": "活动使用",
     * "goods_name": "填写代金券可适用的商品或服务",
     * "stock_type": "NORMAL",
     * "coupon_use_rule": {
     * "coupon_available_time": {
     * "available_begin_time": "2015-05-20T13:29:35+08:00",
     * "available_end_time": "2015-05-20T13:29:35+08:00",
     * "available_day_after_receive": 3,
     * "wait_days_after_receive":7,
     * "available_week": {
     * "week_day": [
     * 1,
     * 2
     * ],
     * "available_day_time": [
     * {
     * "begin_time": 3600,
     * "end_time": 86399
     * }
     * ]
     * },
     * "irregulary_avaliable_time": [
     * {
     * "begin_time": "2015-05-20T13:29:35+08:00",
     * "end_time": "2015-05-20T13:29:35+08:00"
     * }
     * ]
     * },
     * "fixed_normal_coupon": {
     * "discount_amount": 5,
     * "transaction_minimum": 100
     * },
     * "use_method": "OFF_LINE",
     * "mini_programs_appid":"wx23232232323",
     * "mini_programs_path":"/path/index/index"
     * },
     * "stock_send_rule": {
     * "max_coupons": 100,
     * "max_coupons_per_user": 5,
     * "max_coupons_by_day": 100,
     * "natural_person_limit": false,
     * "prevent_api_abuse": false,
     * "transferable": false,
     * "shareable": false
     * },
     * "out_request_no": "100002322019090134234sfdf",
     * "custom_entrance": {
     * "mini_programs_info": {
     * "mini_programs_appid": "wx234545656765876",
     * "mini_programs_path": "/path/index/index",
     * "entrance_words": "欢迎选购",
     * "guiding_words": "获取更多优惠"
     * },
     * "appid": "wx324345hgfhfghfg",
     * "hall_id": "233455656",
     * "store_id": "233554655"
     * },
     * "display_pattern_info": {
     * "description": "xxx门店可用",
     * "merchant_logo_url": "https://xxx",
     * "merchant_name": "微信支付",
     * "background_color": "Color020",
     * "coupon_image_url": "https://qpic.cn/xxx"
     * },
     * "coupon_code_mode": "WECHATPAY_MODE"
     * }
     *
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 微信为每个商家券批次分配的唯一ID。
     * 示例值：98065001
     * 创建时间 create_time string[1,32] 是 创建时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * {
     * "stock_id": "98065001",
     * "create_time": "2015-05-20T13:29:35+08:00"
     * }
     *
     * 跳转小程序带参数说明
     * 如果商家券配置了跳转小程序的入口（包括立即使用以及自定义入口），跳转链接会带有批次号、openid以及加密的code，解密方式可参考解密说明。
     *
     *
     *
     * /path/index/index.html?stock_id=128695000000007&openid=o7tgX0RiTlJo9IXVVfemjFSlFMo4&nonce=B9Jr9gtzMSs7&associate=COUPON_CODE&ciphertext=nmARA5zbjlL%2FaCiKN7S3h1z%2FGhmCfNW9IGQHX6XqTR3zYzQ43sQ%3D
     *
     * 解密说明
     * 通过以下步骤，可对加密的数据进行解密：
     *
     * 1、用商户平台上设置的APIv3密钥【微信商户平台—>账户设置—>API安全—>设置APIv3密钥】，记为key。
     * 2、从跳转路径中取得参数nonce、associate和密文ciphertext；
     * 3、使用urldecode对ciphertext进行解码，得到strUrlDecodeText；
     * 4、使用base64对strUrlDecodeText进行解码，得到strBase64DecodeText；
     * 5、使用key、nonce和associate，对数据密文strBase64DecodeText进行解密，得到的字符串即为coupon_code。
     *
     * 注： AEAD_AES_256_GCM算法的接口细节，请参考rfc5116。微信支付使用的密钥key长度为32个字节，随机串nonce长度12个字节，associated当前为固定值"COUPON_CODE"。
     */
    public function createBusifavorStocks(Stock $stockInfo)
    {
        $params = $stockInfo->getParams();
        $rst = $this->_request->post($this->_url . 'busifavor/stocks', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询商家券详情API
     * 最新更新时间：2020.07.24 版本说明
     *
     *
     * 商户可通过该接口查询已创建的商家券批次详情信息。
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/{stock_id}
     *
     * 请求方式：GET
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 path 微信为每个商家券批次分配的唯一ID
     * 示例值：1212
     * 请求示例
     * URL
     *
     * https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/1212
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 商家券批次名称 stock_name string[1,21] 是 批次名称，字数上限为21个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：8月1日活动券
     * 批次归属商户号 belong_merchant string[8,15] 是 批次归属于哪个商户。
     * 示例值：10000022
     * 批次备注 comment string[1,20] 否 仅配置商户可见，用于自定义信息。字数上限为20个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：活动使用
     * 适用商品范围 goods_name string[1,15] 是 用来描述批次在哪些商品可用，会显示在微信卡包中。字数上限为15个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：xxx商品使用
     * 批次类型 stock_type string[1,16] 是 批次类型
     * NORMAL：固定面额满减券批次
     * DISCOUNT：折扣券批次
     * EXCHANGE：换购券批次
     * 示例值：NORMAL
     * +核销规则 coupon_use_rule object 是 券核销相关规则
     * +发放规则 stock_send_rule object 是 券发放相关规则
     * +自定义入口 custom_entrance object 否 卡详情页面，可选择多种入口引导用户。
     * +样式信息 display_pattern_info object 否 创建批次时的样式信息。
     * 批次状态 stock_state string[1,128] 是 批次状态
     * UNAUDIT：审核中
     * RUNNING：运行中
     * STOPED：已停止
     * PAUSED：暂停发放
     * 示例值：RUNNING
     *
     * 券code模式 coupon_code_mode string[1,128] 是 枚举值：
     * WECHATPAY_MODE：系统分配券code。
     * MERCHANT_API：商户发放时接口指定券code。
     * MERCHANT_UPLOAD：商户上传自定义code，发券时系统随机选取上传的券code。
     * 示例值：WECHATPAY_MODE
     * 批次号 stock_id string[1,20] 是 微信为每个商家券批次分配的唯一ID。
     * 示例值：1212
     * +券code数量 coupon_code_count object 否 当且仅当coupon_code_mode（券code模式）为MERCHANT_UPLOAD（商户上传自定义code）模式时，返回该字段，返回内容为商户上传code的数量信息。
     * +事件通知配置 notify_config object 否 query事件回调通知商户的配置。
     * +批次发放情况 send_count_information object 否 query批次发放情况
     *
     * 返回示例
     * 正常示例
     *
     * {
     * "stock_name": "8月1日活动券",
     * "belong_merchant": "10000022",
     * "comment": "xxx店使用",
     * "goods_name": "xxx商品使用",
     * "stock_type": "NORMAL",
     * "coupon_use_rule": {
     * "coupon_available_time": {
     * "available_begin_time": "2015-05-20T13:29:35+08:00",
     * "available_end_time": "2015-05-20T13:29:35+08:00",
     * "available_day_after_receive": 3,
     * "available_week": {
     * "week_day": [
     * "1",
     * "2"
     * ],
     * "available_day_time": [
     * {
     * "begin_time": 3600,
     * "end_time": 86399
     * }
     * ]
     * },
     * "irregulary_avaliable_time": [
     * {
     * "begin_time": "2015-05-20T13:29:35+08:00",
     * "end_time": "2015-05-20T13:29:35+08:00"
     * }
     * ]
     * },
     * "fixed_normal_coupon": {
     * "discount_amount": 5,
     * "transaction_minimum": 100
     * },
     * "use_method": "OFF_LINE",
     * "mini_programs_appid": "wx23232232323",
     * "mini_programs_path": "/path/index/index"
     * },
     * "stock_send_rule": {
     * "max_amount": 100000,
     * "max_coupons": 100,
     * "max_coupons_per_user": 5,
     * "max_amount_by_day": 1000,
     * "max_coupons_by_day": 100,
     * "natural_person_limit": false,
     * "prevent_api_abuse": false,
     * "transferable": false,
     * "shareable": false
     * },
     * "custom_entrance": {
     * "mini_programs_info": {
     * "mini_programs_appid": "wx234545656765876",
     * "mini_programs_path": "/path/index/index",
     * "entrance_words": "欢迎选购",
     * "guiding_words": "获取更多优惠"
     * },
     * "appid": "wx324345hgfhfghfg",
     * "hall_id": "233455656",
     * "store_id": "233554655"
     * },
     * "display_pattern_info": {
     * "description": "xxx门店可用",
     * "merchant_logo_url": "https://xxx",
     * "merchant_name": "微信支付",
     * "background_color": "Color020",
     * "coupon_image_url": "https://qpic.cn/xxx"
     * },
     * "stock_state": "RUNNING",
     * "coupon_code_mode": "MERCHANT_UPLOAD",
     * "stock_id": "1212",
     * "coupon_code_count": {
     * "total_count": 100,
     * "available_count": 50
     * }
     * }
     */
    public function busifavorStocksInfo($stock_id)
    {
        $params = array();
        $rst = $this->_request->get($this->_url . "busifavor/stocks/{$stock_id}", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 核销用户券API
     * 最新更新时间：2019.08.20 版本说明
     *
     *
     * 在用户满足优惠门槛后，商户可通过该接口核销用户微信卡包中具体某一张商家券。
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/coupons/use
     *
     * 请求方式：POST
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 券code coupon_code string[1,32] 是 body 券的唯一标识。 示例值：sxxe34343434
     * 批次号 stock_id string[1,20] 否 body 微信为每个商家券批次分配的唯一ID，批次券Code模式是MERCHANT_API或者MERCHANT_UPLOAD时，核销时必须填写批次号示例值：100088
     * 公众账号ID appid string[1,32] 是 body 支持传入与当前调用接口商户号有绑定关系的appid。支持小程序appid与公众号appid。核销接口返回的openid会在该传入appid下进行计算获得。 示例值：wx1234567889999
     * 请求核销时间 use_time string[1,32] 是 body 商户请求核销用户券的时间。 遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。示例值：2015-05-20T13:29:35+08:00
     * 核销请求单据号 use_request_no string[1,32] 是 body 每次核销请求的唯一标识，商户需保证唯一。 示例值：1002600620019090123143254435
     * 用户标识 openid string[1,128] 否 body 用户的唯一标识，做安全校验使用，非必填。 示例值：xsd3434454567676
     * 请求示例
     * JSON
     *
     * {
     * "coupon_code": "sxxe34343434",
     * "stock_id": "100088",
     * "appid": "wx1234567889999",
     * "use_time": "2015-05-20T13:29:35+08:00",
     * "use_request_no": "1002600620019090123143254435",
     * "openid": "xsd3434454567676"
     * }
     *
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 微信为每个商家券批次分配的唯一ID
     * 示例值： 100088
     * 用户标识 openid string[1,128] 是 用户在公众号内的唯一身份标识。
     * 示例值：dsadas34345454545
     * 系统核销券成功的时间 wechatpay_use_time string[1,32] 是 系统成功核销券的时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "stock_id": "100088",
     * "openid": "dsadas34345454545",
     * "wechatpay_use_time": "2015-05-20T13:29:35+08:00"
     * }
     */
    public function busifavorCouponsUse($coupon_code, $stock_id, $appid, $use_time, $use_request_no, $openid)
    {
        $params = array();
        $params['coupon_code'] = $coupon_code;
        $params['stock_id'] = $stock_id;
        $params['appid'] = $appid;
        $params['use_time'] = $use_time;
        $params['use_request_no'] = $use_request_no;
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . "busifavor/coupons/use", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 根据过滤条件查询用户券API
     * 最新更新时间：2020.07.24 版本说明
     *
     *
     * 商户自定义筛选条件（如创建商户号、归属商户号、发放商户号等），查询指定微信用户卡包中满足对应条件的所有商家券信息。
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/users/{openid}/coupons
     *
     * 请求方式：GET
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 用户标识 openid string[1,128] 是 path Openid信息，用户在appid下的唯一标识。
     * 示例值：2323dfsdf342342
     * 公众账号ID appid string[1,32] 是 query 支持传入与当前调用接口商户号有绑定关系的appid。支持小程序appid与公众号appid。
     * 示例值：wx233544546545989
     * 批次号 stock_id string[1,20] 否 query 微信为每个商家券批次分配的唯一ID，是否指定批次号查询。
     * 示例值：9865000
     * 券状态 coupon_state string[1,16] 否
     * query 券状态
     *
     * 枚举值：
     * SENDED：可用
     * USED：已核销
     * EXPIRED：已过期
     * 示例值：SENDED
     *
     * 创建批次的商户号 creator_merchant string[1,32] 否 query 批次创建方商户号
     * 示例值：1000000001
     * 批次归属商户号 belong_merchant string[8,15] 否 query 批次归属商户号
     * 示例值：1000000002
     * 批次发放商户号 sender_merchant string[1,32] 否 query 批次发放商户号
     * 示例值：1000000003
     * 分页页码 offset int 否 query 分页页码
     * 示例值：0
     * 分页大小 limit int 否 query 分页大小
     * 示例值：20
     * 请求示例
     * URL
     *
     * https://api.mch.weixin.qq.com/v3/marketing/busifavor/users/2323dfsdf342342/coupons?appid=wx233544546545989&stock_id=9865000&coupon_state=USED&creator_merchant=1000000001&offset=0&limit=20
     *
     * 返回参数
     * 说明：为提升API性能，返回参数中“结果集>样式信息>使用须知（description）”字段内容将不再返回，即查询结果不再返回使用须知，改动将于2020年7月8日12:00生效。如您业务中需要使用该字段，建议使用“查询用户单张券详情API”
     *
     * 参数名 变量 类型[长度限制] 必填 描述
     * +结果集 data array 是 结果集
     * 总数量 total_count int 是 总数量
     * 示例值： 100
     * 分页页码 offset int 是 分页页码
     * 示例值：1
     * 分页大小 limit int 是 分页大小
     * 示例值：10
     *
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "data": [
     * {
     * "belong_merchant": "100000222",
     * "stock_name": "商家券",
     * "comment": "xxx可用",
     * "goods_name": "xxx商品可用",
     * "stock_type": "NORMAL",
     * "transferable": false,
     * "shareable": "false",
     * "coupon_state": "SENDED",
     * "display_pattern_info": {
     * "merchant_logo_url": "https://xxx",
     * "merchant_name": "微信支付",
     * "background_color": "Color020",
     * "coupon_image_url": "https://qpic.cn/xxx"
     * },
     * "coupon_use_rule": {
     * "coupon_available_time": {
     * "available_begin_time": "2015-05-20T13:29:35+08:00",
     * "available_end_time": "2015-05-20T13:29:35+08:00",
     * "available_day_after_receive": 3,
     * "available_week": {
     * "week_day": [
     * "1",
     * "2"
     * ],
     * "available_day_time": [
     * {
     * "begin_time": 3600,
     * "end_time": 86399
     * }
     * ]
     * },
     * "irregulary_avaliable_time": [
     * {
     * "begin_time": "2015-05-20T13:29:35+08:00",
     * "end_time": "2015-05-20T13:29:35+08:00"
     * }
     * ]
     * },
     * "fixed_normal_coupon": {
     * "discount_amount": 5,
     * "transaction_minimum": 100
     * },
     * "use_method": "OFF_LINE",
     * "mini_programs_appid": "wx23232232323",
     * "mini_programs_path": "/path/index/index"
     * },
     * "custom_entrance": {
     * "mini_programs_info": {
     * "mini_programs_appid": "wx234545656765876",
     * "mini_programs_path": "/path/index/index",
     * "entrance_words": "欢迎选购",
     * "guiding_words": "获取更多优惠"
     * },
     * "appid": "wx324345hgfhfghfg",
     * "hall_id": "233455656",
     * "store_id": "233554655"
     * },
     * "coupon_code": "123446565767",
     * "stock_id": "1002323",
     * "available_start_time": "2019-12-30T13:29:35+08:00",
     * "expire_time": "2019-12-31T13:29:35+08:00",
     * "receive_time": "2019-12-30T13:29:35+08:00",
     * "send_request_no": "MCHSEND202003101234",
     * "use_request_no": "MCHSEND202003101234",
     * "use_time": "2019-12-30T13:29:35+08:00"
     * }
     * ],
     * "total_count": 100,
     * "limit": 10,
     * "offset": 1
     * }
     */
    public function busifavorUsersCoupons($openid, $appid, $stock_id, $coupon_state, $creator_merchant, $belong_merchant, $sender_merchant, $offset, $limit)
    {
        $params = array();
        $params['appid'] = $appid;
        $params['stock_id'] = $stock_id;
        $params['coupon_state'] = $coupon_state;
        $params['creator_merchant'] = $creator_merchant;
        $params['belong_merchant'] = $belong_merchant;
        $params['sender_merchant'] = $sender_merchant;
        $params['offset'] = $offset;
        $params['limit'] = $limit;
        $rst = $this->_request->get($this->_url . "busifavor/users/{$openid}/coupons", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询用户单张券详情API
     * 最新更新时间：2020.07.24 版本说明
     *
     *
     * 服务商可通过该接口查询微信用户卡包中某一张商家券的详情信息。
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/users/{openid}/coupons/{coupon_code}/appids/{appid}
     *
     * 请求方式：GET
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 券code coupon_code string[1,32] 是 path 券的唯一标识。
     * 示例值：123446565767
     * 公众账号ID appid string[1,32] 是 path 支持传入与当前调用接口商户号有绑定关系的appid。支持小程序appid与公众号appid。
     * 示例值：wx233544546545989
     * 用户标识 openid string[1,128] 是 path Openid信息，用户在appid下的唯一标识。
     * 示例值：2323dfsdf342342
     * 请求示例
     * URL
     *
     * https://api.mch.weixin.qq.com/v3/marketing/busifavor/users/2323dfsdf342342/coupons/123446565767/appids/wx233544546545989
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次归属商户号 belong_merchant string[8,15] 是 批次归属于哪个商户。
     * 示例值：10000022
     * 商家券批次名称 stock_name string[1,21] 是 批次名称，字数上限为21个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：商家券
     * 批次备注 comment string[1,20] 否 仅配置商户可见，用于自定义信息。字数上限为20个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：xxx可用
     * 适用商品范围 goods_name string[1,15] 是 适用商品范围，字数上限为15个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：xxx商品可用
     * 批次类型 stock_type string[1,128] 是 批次类型
     * NORMAL：固定面额满减券批次
     * DISCOUNT：折扣券批次
     * EXCHANGE：换购券批次
     * 示例值：NORMAL
     * 是否允许转赠 transferable bool 否 不填默认否，枚举值：
     * true：是
     * false：否
     * 该字段暂未开放
     * 示例值：false
     * 是否允许分享领券链接 shareable bool 否 不填默认否，枚举值：
     * true：是
     * false：否
     * 该字段暂未开放
     * 示例值：false
     * 券状态 coupon_state string[1,16] 否
     * 商家券状态
     *
     * 枚举值：
     * SENDED：可用
     * USED：已核销
     * EXPIRED：已过期
     * 示例值：SENDED
     *
     * +样式信息 display_pattern_info object 否 商家券详细信息
     * +券核销规则 coupon_use_rule 券核销规则 是 券核销相关规则
     * +自定义入口 custom_entrance object 否 卡详情页面，可选择多种入口引导用户。
     * 券code coupon_code string[1,32] 否 券的唯一标识。
     * 示例值：123446565767
     * 批次号 stock_id string[1,20] 否 微信为每个商家券批次分配的唯一ID，是否指定批次号查询。
     * 示例值：1002323
     * 券可使用开始时间 available_start_time string[1,32] 是 1、用户领取到该张券实际可使用的开始时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 2、若券批次设置为领取后可用，则开始时间即为券的领取时间；若券批次设置为领取后第X天可用，则开始时间为券领取时间后第X天00:00:00可用。
     * 示例值：2019-12-30T13:29:35+08:00
     * 券过期时间 expire_time string[1,32] 是 用户领取到该张券的过期时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 券领券时间 receive_time string[1,32] 是 用户领取到该张券的时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 发券请求单号 send_request_no string[1,32] 是 发券时传入的唯一凭证
     * 示例值: MCHSEND202003101234
     * 核销请求单号 use_request_no string[1,32] 否 核销时传入的唯一凭证（如券已被核销，将返回此字段）
     * 示例值: MCHUSE202003101234
     * 券核销时间 use_time string[1,32] 否 券被核销的时间（如券已被核销，将返回此字段）；遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "belong_merchant": "100000222",
     * "stock_name": "商家券",
     * "comment": "xxx可用",
     * "goods_name": "xxx商品可用",
     * "stock_type": "NORMAL",
     * "transferable": false,
     * "shareable": false,
     * "coupon_state": "SENDED",
     * "display_pattern_info": {
     * "description": "xxx门店可用",
     * "merchant_logo_url": "https://xxx",
     * "merchant_name": "微信支付",
     * "background_color": "Color020",
     * "coupon_image_url": "https://qpic.cn/xxx"
     * },
     * "coupon_use_rule": {
     * "coupon_available_time": {
     * "available_begin_time": "2015-05-20T13:29:35+08:00",
     * "available_end_time": "2015-05-20T13:29:35+08:00",
     * "available_day_after_receive": 3,
     * "available_week": {
     * "week_day": [
     * "1",
     * "2"
     * ],
     * "available_day_time": [
     * {
     * "begin_time": 3600,
     * "end_time": 86399
     * }
     * ]
     * },
     * "irregulary_avaliable_time": [
     * {
     * "begin_time": "2015-05-20T13:29:35+08:00",
     * "end_time": "2015-05-20T13:29:35+08:00"
     * }
     * ]
     * },
     * "fixed_normal_coupon": {
     * "discount_amount": 5,
     * "transaction_minimum": 100
     * },
     * "use_method": "OFF_LINE",
     * "mini_programs_appid": "wx23232232323",
     * "mini_programs_path": "/path/index/index"
     * },
     * "custom_entrance": {
     * "mini_programs_info": {
     * "mini_programs_appid": "wx234545656765876",
     * "mini_programs_path": "/path/index/index",
     * "entrance_words": "欢迎选购",
     * "guiding_words": "获取更多优惠"
     * },
     * "appid": "wx324345hgfhfghfg",
     * "hall_id": "233455656",
     * "store_id": "233554655"
     * },
     * "coupon_code": "123446565767",
     * "stock_id": "1002323",
     * "available_start_time": "2019-12-30T13:29:35+08:00",
     * "expire_time": "2019-12-31T13:29:35+08:00",
     * "receive_time": "2019-12-30T13:29:35+08:00"
     * "send_request_no": "MCHSEND202003101234"
     * "use_request_no": "MCHSEND202003101234"
     * "use_time": "2019-12-30T13:29:35+08:00"
     * }
     */
    public function busifavorUsersCouponsAppids($openid, $coupon_code, $appid)
    {
        $params = array();
        $rst = $this->_request->get($this->_url . "busifavor/users/{$openid}/coupons/{$coupon_code}/appids/{$appid}", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 上传预存code API
     * 最新更新时间：2019.11.8 版本说明
     *
     *
     * 商家券的Code码可由微信后台随机分配，同时支持商户自定义。如商家已有自己的优惠券系统，可直接使用自定义模式。即商家预先向微信支付上传券Code，当券在发放时，微信支付自动从已导入的Code中随机取值（不能指定），派发给用户。
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/{stock_id}/couponcodes
     *
     * 请求方式：POST
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 path 微信为每个商家券批次分配的唯一ID
     * 示例值：98065001
     * 券code列表 coupon_code_list array 否 body 商户上传的券code列表，code允许包含的字符有0-9、a-z、A-Z、-、_、\、/、=、|。
     * 特殊规则：单个券code长度为【1，32】，条目个数限制为【1，200】。
     * 示例值：ABC9588200，ABC9588201
     * 请求业务单据号 upload_request_no string[1,128] 是 body 商户上传code的凭据号，商户侧需保持唯一性。
     * 示例值：100002322019090134234sfdf
     * 请求示例
     * JSON
     *
     * {
     * "coupon_code_list": [
     * "ABC9588200",
     * "ABC9588201"
     * ],
     * "upload_request_no": "100002322019090134234sfdf"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 微信为每个商家券批次分配的唯一ID。
     * 示例值：98065001
     * 去重后上传code总数 total_count uint64 是 本次上传操作，去重后实际上传的code数目。
     * 示例值：500
     * 上传成功code个数 success_count uint64 是 本次上传操作上传成功个数。
     * 示例值：20
     * 上传成功的code列表 success_codes array
     * 否 本次新增上传成功的code信息。
     * 特殊规则：单个券code长度为【1，32】，条目个数限制为【1，200】。
     * 示例值：MMAA12345
     * 上传成功时间 success_time string[1,32] 是 上传操作完成时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 上传失败code个数 fail_count uint64 否 本次上传操作上传失败的code数。
     * 示例值：10
     * +上传失败的code及原因 fail_codes array 否 本次导入失败的code信息，请参照错误信息，修改后重试。
     * 已存在的code列表 exist_codes array 否 历史已存在的code列表，本次不会重复导入。
     * 特殊规则：单个券code长度为【1，32】，条目个数限制为【1，200】。
     * 示例值：ABCD2345
     * 本次请求中重复的code列表 duplicate_codes array 否 本次重复导入的code会被自动过滤，仅保留一个做导入，如满足要求则成功；如不满足要求，则失败；请参照报错提示修改重试。
     * 特殊规则：单个券code长度为【1，32】，条目个数限制为【1，200】。
     * 示例值：AACC2345
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "stock_id": "98065001",
     * "total_count": 500,
     * "success_count": 20,
     * "success_codes": [
     * "MMAA12345"
     * ],
     * "success_time": "2015-05-20T13:29:35+08:00",
     * "fail_count": 10,
     * "fail_codes": [
     * {
     * "coupon_code": "ABCD23456",
     * "code": "LENGTH_LIMIT",
     * "message": "长度超过最大值32位"
     * }
     * ],
     * "exist_codes": [
     * "ABCD2345"
     * ],
     * "duplicate_codes": [
     * "AACC2345"
     * ]
     * }
     */
    public function busifavorStocksCouponcodes($stock_id, array $coupon_code_list, $upload_request_no)
    {
        $params = array();
        $params['coupon_code_list'] = $coupon_code_list;
        $params['upload_request_no'] = $upload_request_no;
        $rst = $this->_request->post($this->_url . "busifavor/stocks/{$stock_id}/couponcodes", $params);
        return $this->_client->rst($rst);
    }
    /**
     * 设置商家券事件通知地址API
     * 最新更新时间：2019.12.20 版本说明
     *
     *
     * 用于设置接收商家券相关事件通知的URL，可接收商家券相关的事件通知、包括发放通知等。需要设置接收通知的URL，并在商户平台开通营销事件推送的能力，即可接收到相关通知。
     *
     *
     * 营销事件推送：点击开通产品权限。 由商家券批次创建方登录Pay平台，操作开通
     *
     * 注意：
     * • 仅可以收到由商户自己创建的批次相关的通知
     *
     * • 需要设置apiv3密钥，否则无法收到回调。
     *
     * • 如果需要领券回调中的参数openid。需要创券时候传入notify_appid参数。
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/callbacks
     *
     * 请求方式：POST
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 商户号 mchid string[8,15] 否 body 微信支付商户的商户号，由微信支付生成并下发，不填默认查询调用方商户的通知URL。
     * 示例值：10000098
     * 通知URL地址 notify_url string[10,256] 是 body 商户提供的用于接收商家券事件通知的url地址，必须支持https。
     * 示例值：https://pay.weixin.qq.com
     * 请求示例
     * JSON
     *
     * {
     * "mchid": "10000098",
     * "notify_url": "https://pay.weixin.qq.com"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 修改时间 update_time string[1,32] 否 修改时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 通知URL地址 notify_url string[10,256] 是 商户提供的用于接收商家券事件通知的url地址，必须支持https。
     * 示例值：https://pay.weixin.qq.com
     * 商户号 mchid string[8,15] 是 微信支付商户的商户号，由微信支付生成并下发。
     * 示例值：10000098
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "update_time": "2019-05-20T13:29:35+08:00",
     * "notify_url": "https://pay.weixin.qq.com",
     * "mchid": "10000098"
     * }
     */
    public function busifavorCallbacks($mchid, $notify_url)
    {
        $params = array();
        $params['mchid'] = $mchid;
        $params['notify_url'] = $notify_url;
        $rst = $this->_request->post($this->_url . "busifavor/callbacks", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询商家券事件通知地址API
     * 最新更新时间：2019.12.20 版本说明
     *
     *
     * 通过调用此接口可查询设置的通知URL。
     *
     * 注意：
     * • 仅可以查询由请求商户号设置的商家券通知url
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/callbacks
     *
     * 请求方式：GET
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 商户号 mchid string[8,15] 否 query 微信支付商户的商户号，由微信支付生成并下发，不填默认查询调用方商户的通知URL。
     * 示例值：10000098
     * 请求示例
     * URL
     *
     * https://api.mch.weixin.qq.com/v3/marketing/busifavor/callbacks?mchid=10000098
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 通知URL地址 notify_url string[10,256] 是 商户提供的用于接收商家券事件通知的url地址，必须支持https。
     * 示例值：https://pay.weixin.qq.com
     * 商户号 mchid string[8,15] 是 微信支付商户的商户号，由微信支付生成并下发。
     * 示例值：10000098
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "mchid": "10000098",
     * "notify_url": "https://pay.weixin.qq.com"
     * }
     */
    public function busifavorCallbacksInfo($mchid)
    {
        $params = array();
        $params['mchid'] = $mchid;
        $rst = $this->_request->get($this->_url . "busifavor/callbacks", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 关联订单信息API
     * 最新更新时间：2020.06.10 版本说明
     *
     *
     * 将有效态（未核销）的商家券与订单信息关联，用于后续参与摇奖&返佣激励等操作的统计。
     *
     * 注意：
     * • 仅对有关联订单需求的券进行该操作
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL： https://api.mch.weixin.qq.com/v3/marketing/busifavor/coupons/associate
     *
     * 请求方式： POST
     *
     * 接口频率： 500QPS
     *
     * 前置条件： 已为用户发券，且调用查询接口查到用户的券code、批次ID等信息
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 body 微信为每个商家券批次分配的唯一ID，对于商户自定义code的批次，关联请求必须填写批次号
     * 示例值：100088
     * 券code coupon_code string[1,32] 是 body 券的唯一标识
     * 示例值：sxxe34343434
     * 关联的商户订单号 out_trade_no string[1,128] 是 body 微信支付下单时的商户订单号，欲与该商家券关联的微信支付
     * 示例值：MCH_102233445
     * 商户请求单号 out_request_no string[1,128] 是 body 商户创建批次凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性，可包含英文字母，数字，｜，_，*，-等内容，不允许出现其他不合法符号。
     * 示例值：1002600620019090123143254435
     * 请求示例
     * JSON
     *
     * {
     * "coupon_code" : "sxxe34343434",
     * "out_trade_no" : "MCH_102233445",
     * "stock_id" : "100088",
     * "out_request_no" : "1002600620019090123143254435"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 关联成功时间 wechatpay_associate_time string[1,32] 是 系统关联券成功的时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "wechatpay_associate_time" : "2015-05-20T13:29:35+08:00"
     * }
     */
    public function busifavorCouponsAssociate($stock_id, $coupon_code, $out_trade_no, $out_request_no)
    {
        $params = array();
        $params['stock_id'] = $stock_id;
        $params['coupon_code'] = $coupon_code;
        $params['out_trade_no'] = $out_trade_no;
        $params['out_request_no'] = $out_request_no;
        $rst = $this->_request->post($this->_url . "busifavor/coupons/associate", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 取消关联订单信息API
     * 最新更新时间：2020.06.10 版本说明
     *
     *
     * 取消商家券与订单信息的关联关系
     *
     * 注意：
     * • 建议取消前调用查询接口，查到当前关联的商户单号并确认后，再进行取消操作
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL： https://api.mch.weixin.qq.com/v3/marketing/busifavor/coupons/disassociate
     *
     * 请求方式： POST
     *
     * 接口频率： 500QPS
     *
     * 前置条件： 已调用关联接口为券创建过关联关系
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数需在请求URL传参
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 body微信为每个商家券批次分配的唯一ID， 对于商户自定义code的批次，关联请求必须填写批次号
     * 示例值：100088
     * 券code coupon_code string[1,32] 是 body 券的唯一标识
     * 示例值：sxxe34343434
     * 关联的商户订单号 out_trade_no string[1,128] 是 body 微信支付下单时的商户订单号，欲与该商家券关联的微信支付
     * 示例值：MCH_102233445
     * 商户请求单号 out_request_no string[1,128] 是 body 商户创建批次凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性，可包含英文字母，数字，｜，_，*，-等内容，不允许出现其他不合法符号。
     * 示例值：1002600620019090123143254435
     * 请求示例
     * JSON
     *
     * {
     * "coupon_code" : "213dsadfsa",
     * "out_trade_no" : "treads8a9f980",
     * "stock_id" : "100088",
     * "out_request_no" : "fdsafdsafdsa231321"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 取消关联成功时间 wechatpay_disassociate_time string[1,32] 是 系统成功取消商家券与订单信息关联关系的时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2015-05-20T13:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * > 200 Response
     * {
     * "wechatpay_disassociate_time" : "2015-05-20T13:29:35+08:00"
     * }
     */
    public function busifavorCouponsDisassociate($stock_id, $coupon_code, $out_trade_no, $out_request_no)
    {
        $params = array();
        $params['stock_id'] = $stock_id;
        $params['coupon_code'] = $coupon_code;
        $params['out_trade_no'] = $out_trade_no;
        $params['out_request_no'] = $out_request_no;
        $rst = $this->_request->post($this->_url . "busifavor/coupons/disassociate", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改批次预算API
     * 最新更新时间：2020.11.04 版本说明
     *
     *
     * 商户可以通过该接口修改批次单天发放上限数量或者批次最大发放数量
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/{stock_id}/budget
     *
     * 请求方式：Patch
     *
     * 前置条件： 已创建商家券批次，且修改时间位于有效期结束时间前
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数为URL参数
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 path批次号
     * 示例值：98065001
     * 目标批次最大发放个数 target_max_coupons int 二选一 body批次最大发放个数
     * 示例值：3000
     * 目标单天发放上限个数 target_max_coupons_by_day int body单天发放上限个数
     * 示例值：500
     * 当前批次最大发放个数 current_max_coupons int 否 body当前批次最大发放个数，当传入target_max_coupons大于0时，current_max_coupons必传
     * 示例值：500
     * 当前单天发放上限个数 current_max_coupons_by_day int 否 body当前单天发放上限个数 ，当传入target_max_coupons_by_day大于0时，current_max_coupons_by_day必填
     * 示例值：300
     * 修改预算请求单据号 modify_budget_request_no string[1,128] 是 body修改预算请求单据号
     * 示例值：1002600620019090123143254436
     * 请求示例
     * JSON
     *
     * {
     * "target_max_coupons": 3000,
     * "current_max_coupons": 500,
     * "modify_budget_request_no": "1002600620019090123143254436"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次当前最大发放个数 max_coupons int 是 批次最大发放个数
     * 示例值：300
     * 当前单天发放上限个数 max_coupons_by_day int 否 当前单天发放上限个数
     * 示例值：100
     * 返回示例
     * 正常示例
     *
     * {
     * "max_coupons": 300,
     * "max_coupons_by_day": 100
     * }
     */
    public function busifavorStocksBudget($stock_id, $target_max_coupons, $target_max_coupons_by_day, $current_max_coupons, $current_max_coupons_by_day, $modify_budget_request_no)
    {
        $params = array();
        $params['target_max_coupons'] = $target_max_coupons;
        $params['target_max_coupons_by_day'] = $target_max_coupons_by_day;
        $params['current_max_coupons'] = $current_max_coupons;
        $params['current_max_coupons_by_day'] = $current_max_coupons_by_day;
        $params['modify_budget_request_no'] = $modify_budget_request_no;
        $rst = $this->_request->patch($this->_url . "busifavor/stocks/{$stock_id}/budget", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改商家券基本信息API
     * 最新更新时间：2020.11.04 版本说明
     *
     *
     * 商户可以通过该接口修改商家券基本信息
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/{stock_id}
     *
     * 请求方式：Patch
     *
     * 前置条件： 已创建商家券批次，且修改时间位于有效期结束时间前
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数为URL参数
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 批次号 stock_id string[1,20] 是 path批次号
     * 示例值：101156451224
     * +自定义入口 custom_entrance object 否 body卡详情页面，可选择多种入口引导用户
     * 商家券批次名称 stock_name string[1,21] 否 body批次名称，字数上限为21个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：8月1日活动券
     * 批次备注 comment string[1,20] 否 body仅配置商户可见，用于自定义信息。字数上限为20个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：活动使用
     * 适用商品范围 goods_name string[1,15] 否 body用来描述批次在哪些商品可用，会显示在微信卡包中。字数上限为15个，一个中文汉字/英文字母/数字均占用一个字数。
     * 示例值：xxx商品使用
     * 商户请求单号 out_request_no string[1,128] 是 body商户修改批次凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性。
     * 示例值：6122352020010133287985742
     * +样式信息 display_pattern_info object 否 body创建批次时的样式信息。
     * +核销规则 coupon_use_rule object 否 body券核销相关规则
     * +发放规则 stock_send_rule object 否 body券发放相关规则
     * +事件通知配置 notify_config object 否 body事件回调通知商户的配置
     * 请求示例
     * JSON
     *
     * {
     * "custom_entrance": {
     * "mini_programs_info": {
     * "mini_programs_appid": "wx234545656765876",
     * "mini_programs_path": "/path/index/index",
     * "entrance_words": "欢迎选购",
     * "guiding_words": "获取更多优惠"
     * },
     * "appid": "wx324345hgfhfghfg",
     * "hall_id": "233455656",
     * "code_display_mode": "BARCODE"
     * },
     * "stock_name": "8月1日活动券",
     * "comment": "活动使用",
     * "goods_name": "xxx商品使用",
     * "out_request_no": "6122352020010133287985742",
     * "display_pattern_info": {
     * "description": "xxx门店可用",
     * "merchant_logo_url": "https://xxx",
     * "merchant_name": "微信支付",
     * "background_color": "xxxxx",
     * "coupon_image_url": "图片cdn地址"
     * },
     * "coupon_use_rule": {
     * "use_method": "OFF_LINE",
     * "mini_programs_appid": "wx23232232323",
     * "mini_programs_path": "/path/index/index"
     * },
     * "stock_send_rule": {
     * "natural_person_limit": false,
     * "prevent_api_abuse": false
     * },
     * "notify_config": {
     * "notify_appid": "wx23232232323"
     * }
     * }
     * 返回参数
     *
     * 处理成功，应答无内容
     *
     * 返回示例
     * 正常示例
     *
     * 204
     * 处理成功，应答无内容
     */
    public function busifavorStocksUpdate(Stock $stockInfo)
    {
        $stock_id = $stockInfo->stock_id;
        $params = $stockInfo->getParams();
        $rst = $this->_request->patch($this->_url . "busifavor/stocks/{$stock_id}", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 申请退券API
     * 最新更新时间：2020.11.04 版本说明
     *
     *
     * 商户可以通过该接口为已核销的券申请退券
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/coupons/return
     *
     * 请求方式：POST
     *
     * 前置条件：券的状态为USED
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数为URL参数
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 券code coupon_code string[1,20] 是 body券的唯一标识
     * 示例值：sxxe34343434
     * 批次号 stock_id string[1,32] 是 body券的所属批次号
     * 示例值：1234567891
     * 退券请求单据号 return_request_no string[1, 128] 是 body每次退券请求的唯一标识，商户需保证唯一
     * 示例值：1002600620019090123143254436
     * 请求示例
     * JSON
     *
     * {
     * "coupon_code": "sxxe34343434",
     * "stock_id": "1234567891",
     * "return_request_no": "1002600620019090123143254436"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 微信退券成功的时间 wechatpay_return_time string[1,32] 是 微信退券成功的时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     *
     * 示例值：2020-05-20T13:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * {
     * "wechatpay_return_time": "2020-05-20T13:29:35.120+08:00"
     * }
     */
    public function busifavorCouponsReturn($coupon_code, $stock_id, $return_request_no)
    {
        $params = array();
        $params['coupon_code'] = $coupon_code;
        $params['stock_id'] = $stock_id;
        $params['return_request_no'] = $return_request_no;
        $rst = $this->_request->post($this->_url . "busifavor/coupons/return", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 使券失效API
     * 最新更新时间：2020.11.04 版本说明
     *
     *
     * 商户可以通过该接口将可用券进行失效处理，券失效后无法再被核销
     *
     * 接口说明
     * 适用对象： 直连商户
     *
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/coupons/deactivate
     *
     * 请求方式：POST
     *
     * 前置条件：券的状态为SENDED
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数为URL参数
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 券code coupon_code string[1,32] 是 body券的唯一标识
     * 示例值：sxxe34343434
     * 批次号 stock_id string[1,20] 是 body券的所属批次号
     * 示例值：1234567891
     * 失效请求单据号 deactivate_request_no string[1, 128] 是 body每次失效请求的唯一标识，商户需保证唯一
     * 示例值：1002600620019090123143254436
     * 失效原因 deactivate_reason string[1, 64] 否 body商户失效券的原因
     * 示例值：此券使用时间设置错误
     * 请求示例
     * JSON
     *
     * {
     * "coupon_code": "sxxe34343434",
     * "stock_id": "1234567891",
     * "deactivate_request_no": "1002600620019090123143254436",
     * "deactivate_reason": "此券使用时间设置错误"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 券成功失效的时间 wechatpay_deactivate_time string[1,32] 是 系统券成功失效的时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。
     *
     * 示例值：2020-05-20T13:29:35.08:00
     * 返回示例
     * 正常示例
     *
     * {
     * "wechatpay_deactivate_time": "2020-05-20T13:29:35.120+08:00"
     * }
     */
    public function busifavorCouponsDeactivate($coupon_code, $stock_id, $deactivate_request_no, $deactivate_reason)
    {
        $params = array();
        $params['coupon_code'] = $coupon_code;
        $params['stock_id'] = $stock_id;
        $params['deactivate_request_no'] = $deactivate_request_no;
        $params['deactivate_reason'] = $deactivate_reason;
        $rst = $this->_request->post($this->_url . "busifavor/coupons/deactivate", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 营销补差付款API
     * 最新更新时间：2021.04.13 版本说明
     *
     *
     * 给核销了商家券的商户做营销资金补差
     *
     * 接口说明
     * 适用对象：直连商户
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/subsidy/pay-receipts
     *
     * 请求方式：POST
     *
     * 前置条件：商家必须核销了商家券且发起了微信支付收款
     *
     * 是否支持幂等：是
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数为URL参数
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 商家券批次号 stock_id string[1, 20] 是 body由微信支付生成，调用创建商家券API成功时返回的唯一批次ID 仅支持“满减券”，“换购券”批次不支持
     * 示例值：128888000000001
     * 商家券Code coupon_code string[1, 128] 是 body券的唯一标识。
     * 在WECHATPAY_MODE的券Code模式下，商家券Code是由微信支付生成的唯一ID；
     * 在MERCHANT_UPLOAD、MERCHANT_API的券Code模式下，商家券Code是由商户上传或指定，在批次下保证唯一；
     * 示例值：ABCD12345678
     * 微信支付订单号 transaction_id string[28, 32] 是 body微信支付下单支付成功返回的订单号
     * 示例值：4200000913202101152566792388
     * 营销补差扣款商户号 payer_merchant string[1, 32] 是 body营销补差扣款商户号
     * 示例值：1900000001
     * 营销补差入账商户号 payee_merchant string[1, 32] 是 body营销补差入账商户号
     * 示例值：1900000002
     * 补差付款金额 amount int 是 body单位为分，单笔订单补差金额不得超过券的优惠金额，最高补差金额为5000元 > 券的优惠金额定义：
     * 满减券：满减金额即为优惠金额
     * 换购券：不支持
     * 示例值：100
     * 补差付款描述 description string[1, 1024] 是 body付款备注描述，查询的时候原样带回
     * 示例值：20210115DESCRIPTION
     * 业务请求唯一单号 out_subsidy_no string[1, 128] 是 body商户侧需保证唯一性。可包含英文字母，数字，｜，_，*，-等内容，不允许出现其他不合法符号
     * 示例值：subsidy-abcd-12345678
     * 请求示例
     * JSON
     *
     * {
     * "stock_id": "128888000000001",
     * "coupon_code": "ABCD12345678",
     * "transaction_id": "4200000913202101152566792388",
     * "payer_merchant": "1900000001",
     * "payee_merchant": "1900000002",
     * "amount": 100,
     * "description": "20210115DESCRIPTION",
     * "out_subsidy_no": "subsidy-abcd-12345678"
     * }
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 补差付款单号 subsidy_receipt_id string[28, 32] 是 补差付款唯一单号，由微信支付生成，仅在补差付款成功后有返回
     * 示例值：1120200119165100000000000001
     * 商家券批次号 stock_id string[1, 20] 是 由微信支付生成，调用创建商家券API成功时返回的唯一批次ID
     * 示例值：128888000000001
     * 商家券Code coupon_code string[1, 128] 是 券的唯一标识
     * 示例值：ABCD12345678
     * 微信支付订单号 transaction_id string[28, 32] 是 微信支付下单支付成功返回的订单号
     * 示例值：4200000913202101152566792388
     * 营销补差扣款商户号 payer_merchant string[1, 32] 是 营销补差扣款商户号
     * 示例值：1900000001
     * 营销补差入账商户号 payee_merchant string[1, 32] 是 营销补差入账商户号
     * 示例值：1900000002
     * 补差付款金额 amount int 是 单位为分，单笔订单补差金额不得超过券的优惠金额，最高补差金额为5000元 > 券的优惠金额定义：
     * 满减券：满减金额即为优惠金额
     * 换购券：不支持
     * 示例值：100
     * 补差付款描述 description string[1, 1024] 是 付款备注描述，查询的时候原样带回
     * 示例值：20210115DESCRIPTION
     * 补差付款单据状态 status string[1, 32] 是 补差付款单据状态
     * ACCEPTED：受理成功
     * SUCCESS：补差补款成功
     * FAIL：补差付款失败
     * RETURNING：补差回退中
     * PARTIAL_RETURN：补差部分回退
     * FULL_RETURN：补差全额回退
     * 示例值：SUCCESS
     * 补差付款失败原因 fail_reason string[1, 1024] 否 仅在补差付款失败时，返回告知对应失败的原因
     * INSUFFICIENT_BALANCE：扣款商户余额不足
     * NOT_INCOMESPLIT_ORDER：非分账订单
     * EXCEED_SUBSIDY_AMOUNT_QUOTA：超出订单补差总额限制
     * EXCEED_SUBSIDY_COUNT_QUOTA：超出订单补差总数限制
     * OTHER：其他原因
     * 示例值：INSUFFICIENT_BALANCE
     * 补差付款完成时间 success_time string[28, 32] 否 仅在补差付款成功时，返回完成时间。遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2021-01-20T10:29:35+08:00
     * 业务请求唯一单号 out_subsidy_no string[1, 128] 是 商户侧需保证唯一性。可包含英文字母，数字，｜，_，*，-等内容，不允许出现其他不合法符号
     * 示例值：subsidy-abcd-12345678
     * 补差付款发起时间 create_time string[28, 32] 否 补差付款单据创建时间。遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。
     * 示例值：2021-01-20T10:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * {
     * "subsidy_receipt_id": "1120200119165100000000000001",
     * "stock_id": "128888000000001",
     * "coupon_code": "ABCD12345678",
     * "transaction_id": "4200000913202101152566792388",
     * "payer_merchant": "1900000001",
     * "payee_merchant": "1900000002",
     * "amount": 100,
     * "description": "20210115DESCRIPTION",
     * "status": "SUCCESS",
     * "success_time": "2021-01-20T10:29:35.120+08:00",
     * "out_subsidy_no": "subsidy-abcd-12345678",
     * "create_time": "2021-01-20T10:29:35.120+08:00"
     * }
     */
    public function busifavorSubsidyPayreceipts($stock_id, $coupon_code, $transaction_id, $payer_merchant, $payee_merchant, $amount, $description, $out_subsidy_no)
    {
        $params = array();
        $params['stock_id'] = $stock_id;
        $params['coupon_code'] = $coupon_code;
        $params['transaction_id'] = $transaction_id;
        $params['payer_merchant'] = $payer_merchant;
        $params['payee_merchant'] = $payee_merchant;
        $params['amount'] = $amount;
        $params['description'] = $description;
        $params['out_subsidy_no'] = $out_subsidy_no;
        $rst = $this->_request->post($this->_url . "busifavor/subsidy/pay-receipts", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询营销补差付款单详情API
     * 最新更新时间：2021.04.13 版本说明
     *
     *
     * 查询商家券营销补差付款单详情
     *
     * 接口说明
     * 适用对象：直连商户
     * 请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/subsidy/pay-receipts/{subsidy_receipt_id}
     *
     * 请求方式：GET
     *
     *
     * path 指该参数为路径参数
     *
     * query 指该参数为URL参数
     *
     * body 指该参数需在请求JSON传参
     *
     *
     * 请求参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 补差付款单号 subsidy_receipt_id string[28, 32] 是 path补差付款唯一单号，由微信支付生成，仅在补差付款成功后有返回
     * 示例值：1120200119165100000000000001
     * 请求示例
     * URL
     *
     * https://api.mch.weixin.qq.com/v3/marketing/busifavor/subsidy/pay-receipts/1120200119165100000000000001
     * 返回参数
     * 参数名 变量 类型[长度限制] 必填 描述
     * 补差付款单号 subsidy_receipt_id string[28, 32] 是 补差付款唯一单号，由微信支付生成，仅在补差付款成功后有返回
     * 示例值：1120200119165100000000000001
     * 商家券批次号 stock_id string[1, 20] 是 由微信支付生成，调用创建商家券API成功时返回的唯一批次ID
     * 示例值：128888000000001
     * 商家券Code coupon_code string[1, 128] 是 券的唯一标识
     * 示例值：ABCD12345678
     * 微信支付订单号 transaction_id string[28, 32] 是 微信支付下单支付成功返回的订单号
     * 示例值：4200000913202101152566792388
     * 营销补差扣款商户号 payer_merchant string[1, 32] 是 营销补差扣款商户号
     * 示例值：1900000001
     * 营销补差入账商户号 payee_merchant string[1, 32] 是 营销补差入账商户号
     * 示例值：1900000002
     * 补差付款金额 amount int 是 单位为分，单笔订单补差金额不得超过券的优惠金额，最高补差金额为5000元 > 券的优惠金额定义：
     * 满减券：满减金额即为优惠金额
     * 换购券：不支持
     * 示例值：100
     * 补差付款描述 description string[1, 1024] 是 付款备注描述，查询的时候原样带回
     * 示例值：20210115DESCRIPTION
     * 补差付款单据状态 status string[1, 32] 是 补差付款单据状态：
     * ACCEPTED：受理成功
     * SUCCESS：补差补款成功
     * FAIL：补差付款失败
     * RETURNING：补差回退中
     * PARTIAL_RETURN：补差部分回退
     * FULL_RETURN：补差全额回退
     * 示例值：SUCCESS
     * 补差付款失败原因 fail_reason string[1, 1024] 否 仅在补差付款失败时，返回告知对应失败的原因：
     * INSUFFICIENT_BALANCE：扣款商户余额不足
     * NOT_INCOMESPLIT_ORDER：非分账订单
     * EXCEED_SUBSIDY_AMOUNT_QUOTA：超出订单补差总额限制
     * EXCEED_SUBSIDY_COUNT_QUOTA：超出订单补差总数限制
     * OTHER：其他原因
     * 示例值：INSUFFICIENT_BALANCE
     * 补差付款完成时间 success_time string[28, 32] 否 仅在补差付款成功时，返回完成时间。遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。 示例值：2021-01-20T10:29:35+08:00
     * 业务请求唯一单号 out_subsidy_no string[1, 128] 是 商户侧需保证唯一性。可包含英文字母，数字，｜，_，*，-等内容，不允许出现其他不合法符号 示例值：subsidy-abcd-12345678
     * 补差付款发起时间 create_time string[28, 32] 否 补差付款单据创建时间。遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35.+08:00表示，北京时间2015年5月20日 13点29分35秒。 示例值：2021-01-20T10:29:35+08:00
     * 返回示例
     * 正常示例
     *
     * {
     * "subsidy_receipt_id": "1120200119165100000000000001",
     * "stock_id": "128888000000001",
     * "coupon_code": "ABCD12345678",
     * "transaction_id": "4200000913202101152566792388",
     * "payer_merchant": "1900000001",
     * "payee_merchant": "1900000002",
     * "amount": 100,
     * "description": "20210115DESCRIPTION",
     * "status": "SUCCESS",
     * "success_time": "2021-01-20T10:29:35.120+08:00",
     * "out_subsidy_no": "subsidy-abcd-12345678",
     * "create_time": "2021-01-20T10:29:35.120+08:00"
     * }
     */
    public function busifavorSubsidyPayreceiptsInfo($subsidy_receipt_id)
    {
        $params = array();
        $rst = $this->_request->get($this->_url . "busifavor/subsidy/pay-receipts/{$subsidy_receipt_id}", $params);
        return $this->_client->rst($rst);
    }
}
