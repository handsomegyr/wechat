<?php

namespace Weixin\Wx\Manager\Msg;

use Weixin\Client;

/**
 * 订阅消息
 *
 * @author guoyongrong
 *        
 */
class SubscribeMessage
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 发送订阅消息
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/message/subscribe/send?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * touser string 是 接收者（用户）的 openid
     * template_id string 是 所需下发的订阅模板id
     * page string 否 点击模板卡片后的跳转页面，仅限本小程序内的页面。支持带参数,（示例index?foo=bar）。该字段不填则模板无跳转。
     * data Object 是 模板内容，格式形如 { "key1": { "value": any }, "key2": { "value": any } }
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * errcode 的合法值
     *
     * 值 说明 最低版本
     * 40003 touser字段openid为空或者不正确
     * 40037 订阅模板id为空不正确
     * 43101 用户拒绝接受消息，如果用户之前曾经订阅过，则表示用户取消了订阅关系
     * 47003 模板参数不准确，可能为空或者不满足规则，errmsg会提示具体是哪个字段出错
     * 41030 page路径不正确，需要保证在现网版本小程序中存在，与app.json保持一致
     * 请求示例
     * {
     * "touser": "OPENID",
     * "template_id": "TEMPLATE_ID",
     * "page": "index",
     * "data": {
     * "number01": {
     * "value": "339208499"
     * },
     * "date01": {
     * "value": "2015年01月05日"
     * },
     * "site01": {
     * "value": "TIT创意园"
     * } ,
     * "site02": {
     * "value": "广州市新港中路397号"
     * }
     * }
     * }
     * 订阅消息参数值内容限制说明
     * 参数类别 参数说明 参数值限制 说明
     * thing.DATA 事物 20个以内字符 可汉字、数字、字母或符号组合
     * number.DATA 数字 32位以内数字 只能数字，可带小数
     * letter.DATA 字母 32位以内字母 只能字母
     * symbol.DATA 符号 5位以内符号 只能符号
     * character_string.DATA 字符串 32位以内数字、字母或符号 可数字、字母或符号组合
     * time.DATA 时间 24小时制时间格式（支持+年月日） 例如：15:01，或：2019年10月1日 15:01
     * date.DATA 日期 年月日格式（支持+24小时制时间） 例如：2019年10月1日，或：2019年10月1日 15:01
     * amount.DATA 金额 1个币种符号+10位以内纯数字，可带小数，结尾可带“元” 可带小数
     * phone_number.DATA 电话 17位以内，数字、符号 电话号码，例：+86-0766-66888866
     * car_number.DATA 车牌 8位以内，第一位与最后一位可为汉字，其余为字母或数字 车牌号码：粤A8Z888挂
     * name.DATA 姓名 10个以内纯汉字或20个以内纯字母或符号 中文名10个汉字内；纯英文名20个字母内；中文和字母混合按中文名算，10个字内
     * phrase.DATA 汉字 5个以内汉字 5个以内纯汉字，例如：配送中
     * 符号表示除中文、英文、数字外的常见符号，不能带有换行等控制字符。 时间格式支持HH:MM:SS或者HH:MM。 日期包含年月日，为y年m月d日，y年m月、m月d日格式，或者用‘-’、‘/’、‘.’符号连接，如2018-01-01，2018/01/01，2018.01.01，2018-01，01-01。 每个模板参数都会以类型为前缀，例如第一个数字模板参数为number01.DATA，第二个为number02.DATA
     *
     * 例如，模板的内容为
     *
     * 姓名: {{name01.DATA}}
     * 金额: {{amount01.DATA}}
     * 行程: {{thing01.DATA}}
     * 日期: {{date01.DATA}}
     * 则对应的json为
     *
     * {
     * "touser": "OPENID",
     * "template_id": "TEMPLATE_ID",
     * "page": "index",
     * "data": {
     * "name01": {
     * "value": "某某"
     * },
     * "amount01": {
     * "value": "￥100"
     * },
     * "thing01": {
     * "value": "广州至北京"
     * } ,
     * "date01": {
     * "value": "2018-01-01"
     * }
     * }
     * }
     */
    public function send($touser, $template_id, $data, $page = "")
    {
        $params = array();
        $params['touser'] = $touser;
        $params['template_id'] = $template_id;
        $params['data'] = $data;
        if (!empty($page)) {
            $params['page'] = $page;
        }
        $rst = $this->_request->post($this->_url . 'message/subscribe/send', $params);
        return $this->_client->rst($rst);
    }
}
