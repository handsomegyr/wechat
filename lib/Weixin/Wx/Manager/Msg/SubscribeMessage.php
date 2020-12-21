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
     * miniprogram_state string 否 跳转小程序类型：developer为开发版；trial为体验版；formal为正式版；默认为正式版
     * lang string 否 进入小程序查看”的语言类型，支持zh_CN(简体中文)、en_US(英文)、zh_HK(繁体中文)、zh_TW(繁体中文)，默认为zh_CN返回值
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
    public function send($touser, $template_id, $data, $page = "", $miniprogram_state = '', $lang = "")
    {
        $params = array();
        $params['touser'] = $touser;
        $params['template_id'] = $template_id;
        $params['data'] = $data;
        if (!empty($page)) {
            $params['page'] = $page;
        }
        if (!empty($miniprogram_state)) {
            $params['miniprogram_state'] = $miniprogram_state;
        }
        if (!empty($lang)) {
            $params['lang'] = $lang;
        }
        $rst = $this->_request->post($this->_url . 'message/subscribe/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * subscribeMessage.getTemplateList
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 获取当前帐号下的个人模板列表
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * GET https://api.weixin.qq.com/wxaapi/newtmpl/gettemplate?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data Array.<Object> 个人模板列表
     * data 的结构
     *
     * 属性 类型 说明
     * priTmplId string 添加至帐号下的模板 id，发送小程序订阅消息时所需
     * title string 模版标题
     * content string 模版内容
     * example string 模板内容示例
     * type number 模版类型，2 为一次性订阅，3 为长期订阅
     * 响应示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": [
     * {
     * "priTmplId": "9Aw5ZV1j9xdWTFEkqCpZ7mIBbSC34khK55OtzUPl0rU",
     * "title": "报名结果通知",
     * "content": "会议时间:{{date2.DATA}}\n会议地点:{{thing1.DATA}}\n",
     * "example": "会议时间:2016年8月8日\n会议地点:TIT会议室\n",
     * "type": 2
     * }
     * ]
     * }
     */
    public function getTemplateList()
    {
        $params = array();
        $rst = $this->_request->get('https://api.weixin.qq.com/wxaapi/newtmpl/gettemplate', $params);
        return $this->_client->rst($rst);
    }

    /**
     * subscribeMessage.getPubTemplateTitleList
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 获取帐号所属类目下的公共模板标题
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * GET https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatetitles?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * ids string 是 类目 id，多个用逗号隔开
     * start number 是 用于分页，表示从 start 开始。从 0 开始计数。
     * limit number 是 用于分页，表示拉取 limit 条记录。最大为 30。
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * count number 模版标题列表总数
     * data Array.<Object> 模板标题列表
     * errcode 的合法值
     *
     * 值 说明 最低版本
     * 200016 start 参数错误
     * 200017 limit 参数错误
     * 200018 类目 ids 缺失
     * 200019 类目 ids 不合法
     * data 的结构
     *
     * 属性 类型 说明
     * tid number 模版标题 id
     * title string 模版标题
     * type number 模版类型，2 为一次性订阅，3 为长期订阅
     * categoryId number 模版所属类目 id
     * 请求示例
     * 参数在 URL 的 query 里面，如下： https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatetitles?access_token=ACCESS_TOKEN&ids="2,616"&start=0&limit=1
     *
     * {
     * "ids": "2,616",
     * "start": 0,
     * "limit": 1
     * }
     * 响应示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "count": 55,
     * "data": [
     * {
     * "tid": 99,
     * "title": "付款成功通知",
     * "type": 2,
     * "categoryId": "616"
     * }
     * ]
     * }
     */
    public function getPubTemplateTitleList($ids, $start = 0, $limit = 30)
    {
        $params = array();
        $params['ids'] = $ids;
        $params['start'] = $start;
        $params['limit'] = $limit;
        $rst = $this->_request->get('https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatetitles', $params);
        return $this->_client->rst($rst);
    }

    /**
     * subscribeMessage.getPubTemplateKeyWordsById
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 获取模板标题下的关键词列表
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * GET https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatekeywords?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * tid string 是 模板标题 id，可通过接口获取
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * count number 模版标题列表总数
     * data Array.<Object> 关键词列表
     * data 的结构
     *
     * 属性 类型 说明
     * kid number 关键词 id，选用模板时需要
     * name string 关键词内容
     * example string 关键词内容对应的示例
     * rule string 参数类型
     * 请求示例
     * 参数在 URL 的 query 里面，如下： https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatekeywords?access_token=ACCESS_TOKEN&tid=99
     *
     * {
     * "tid": "99"
     * }
     * 响应示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": [
     * {
     * "kid": 1,
     * "name": "物品名称",
     * "example": "名称",
     * "rule": "thing"
     * }
     * ]
     * }
     */
    public function getPubTemplateKeyWordsById($tid)
    {
        $params = array();
        $params['tid'] = $tid;
        $rst = $this->_request->get('https://api.weixin.qq.com/wxaapi/newtmpl/getpubtemplatekeywords', $params);
        return $this->_client->rst($rst);
    }

    /**
     * subscribeMessage.getCategory
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 获取小程序账号的类目
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * GET https://api.weixin.qq.com/wxaapi/newtmpl/getcategory?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * 返回的 JSON 数据包
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data Array.<Object> 类目列表
     * data 的结构
     *
     * 属性 类型 说明
     * id number 类目id，查询公共库模版时需要
     * name string 类目的中文名
     * 响应示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": [
     * {
     * "id": 616,
     * "name": "公交"
     * }
     * ]
     * }
     */
    public function getCategory()
    {
        $params = array();
        $rst = $this->_request->get('https://api.weixin.qq.com/wxaapi/newtmpl/getcategory', $params);
        return $this->_client->rst($rst);
    }

    /**
     * subscribeMessage.deleteTemplate
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 删除帐号下的个人模板
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * POST https://api.weixin.qq.com/wxaapi/newtmpl/deltemplate?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * priTmplId string 是 要删除的模板id
     * 返回的 JSON 数据包
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * 请求示例
     * 请在 HTTP RequestHeader 中 设置如下字段：content-type: application/json;
     *
     * {
     * "priTmplId": "wDYzYZVxobJivW9oMpSCpuvACOfJXQIoKUm0PY397Tc"
     * }
     * 响应示例
     * {
     * "errmsg": "ok",
     * "errcode": 0
     * }
     */
    public function deleteTemplate($priTmplId)
    {
        $params = array();
        $params['priTmplId'] = $priTmplId;
        $rst = $this->_request->post('https://api.weixin.qq.com/wxaapi/newtmpl/deltemplate', $params);
        return $this->_client->rst($rst);
    }

    /**
     * subscribeMessage.addTemplate
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 组合模板并添加至帐号下的个人模板库
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * POST https://api.weixin.qq.com/wxaapi/newtmpl/addtemplate?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * tid string 是 模板标题 id，可通过接口获取，也可登录小程序后台查看获取
     * kidList Array.<number> 是 开发者自行组合好的模板关键词列表，关键词顺序可以自由搭配（例如 [3,5,4] 或 [4,5,3]），最多支持5个，最少2个关键词组合
     * sceneDesc string 否 服务场景描述，15个字以内
     * 返回值
     * Object
     * 返回的 JSON 数据包
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * priTmplId string 添加至帐号下的模板id，发送小程序订阅消息时所需
     * errcode 的合法值
     *
     * 值 说明 最低版本
     * 200014 模版 tid 参数错误
     * 200020 关键词列表 kidList 参数错误
     * 200021 场景描述 sceneDesc 参数错误
     * 200011 此账号已被封禁，无法操作
     * 200013 此模版已被封禁，无法选用
     * 200012 个人模版数已达上限，上限25个
     * 请求示例
     * 请在 HTTP RequestHeader 中 设置如下字段：content-type: application/json;
     *
     * {
     * "tid":"401",
     * "kidList":[1,2],
     * "sceneDesc": "测试数据"
     * }
     * 响应示例
     * {
     * "errmsg": "ok",
     * "errcode": 0,
     * "priTmplId": "9Aw5ZV1j9xdWTFEkqCpZ7jWySL7aGN6rQom4gXINfJs"
     * }
     */
    public function addTemplate($tid, array $kidList, $sceneDesc)
    {
        $params = array();
        $params['tid'] = $tid;
        $params['kidList'] = $kidList;
        $params['sceneDesc'] = $sceneDesc;
        $rst = $this->_request->post('https://api.weixin.qq.com/wxaapi/newtmpl/addtemplate', $params);
        return $this->_client->rst($rst);
    }
}
