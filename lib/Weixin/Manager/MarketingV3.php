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
     */
    public function createBusifavorStocks(Stock $stockInfo)
    {
        $params = $stockInfo->getParams();
        $rst = $this->_request->post($this->_url . 'busifavor/stocks', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询商家券详情API
最新更新时间：2020.07.24 版本说明


商户可通过该接口查询已创建的商家券批次详情信息。

接口说明
适用对象： 直连商户

请求URL：https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/{stock_id}

请求方式：GET


path 指该参数为路径参数

query 指该参数需在请求URL传参

body 指该参数需在请求JSON传参


请求参数
参数名	变量	类型[长度限制]	必填	描述
批次号	stock_id	string[1,20]	是	path 微信为每个商家券批次分配的唯一ID 
示例值：1212
请求示例
URL

https://api.mch.weixin.qq.com/v3/marketing/busifavor/stocks/1212
返回参数
参数名	变量	类型[长度限制]	必填	描述
商家券批次名称	stock_name	string[1,21]	是	批次名称，字数上限为21个，一个中文汉字/英文字母/数字均占用一个字数。 
示例值：8月1日活动券
批次归属商户号	belong_merchant	string[8,15]	是	批次归属于哪个商户。 
示例值：10000022
批次备注	comment	string[1,20]	否	仅配置商户可见，用于自定义信息。字数上限为20个，一个中文汉字/英文字母/数字均占用一个字数。 
示例值：活动使用
适用商品范围	goods_name	string[1,15]	是	用来描述批次在哪些商品可用，会显示在微信卡包中。字数上限为15个，一个中文汉字/英文字母/数字均占用一个字数。 
示例值：xxx商品使用
批次类型	stock_type	string[1,16]	是	批次类型 
NORMAL：固定面额满减券批次 
DISCOUNT：折扣券批次 
EXCHANGE：换购券批次 
示例值：NORMAL
+核销规则	coupon_use_rule	object	是	券核销相关规则
+发放规则	stock_send_rule	object	是	券发放相关规则
+自定义入口	custom_entrance	object	否	卡详情页面，可选择多种入口引导用户。
+样式信息	display_pattern_info	object	否	创建批次时的样式信息。
批次状态	stock_state	string[1,128]	是	批次状态
UNAUDIT：审核中
RUNNING：运行中
STOPED：已停止
PAUSED：暂停发放
示例值：RUNNING

券code模式	coupon_code_mode	string[1,128]	是	枚举值： 
WECHATPAY_MODE：系统分配券code。 
MERCHANT_API：商户发放时接口指定券code。 
MERCHANT_UPLOAD：商户上传自定义code，发券时系统随机选取上传的券code。 
示例值：WECHATPAY_MODE
批次号	stock_id	string[1,20]	是	微信为每个商家券批次分配的唯一ID。 
示例值：1212
+券code数量	coupon_code_count	object	否	当且仅当coupon_code_mode（券code模式）为MERCHANT_UPLOAD（商户上传自定义code）模式时，返回该字段，返回内容为商户上传code的数量信息。
+事件通知配置	notify_config	object	否	query事件回调通知商户的配置。
+批次发放情况	send_count_information	object	否	query批次发放情况
     */
    public function infoBusifavorStocks($stock_id)
    {
        $params = array();
        $rst = $this->_request->get($this->_url . "busifavor/stocks/{$stock_id}", $params);
        return $this->_client->rst($rst);
    }
}
