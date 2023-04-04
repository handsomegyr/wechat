<?php

namespace Weixin\Manager;

use Weixin\Client;

/**
 * openAPI接口
 * https://developers.weixin.qq.com/doc/offiaccount/openApi/clear_quota.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class OpenApi
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
     * openApi管理 /清空api的调用quota
     * 清空api的调用quota
     * 本接口用于清空公众号/小程序/第三方平台等接口的每日调用接口次数。
     *
     * 使用过程中如遇到问题，可在开放平台服务商专区发帖交流。
     *
     * 注意事项
     * 1、如果要清空公众号的接口的quota，则需要用公众号的access_token；如果要清空小程序的接口的quota，则需要用小程序的access_token；如果要清空第三方平台的接口的quota，则需要用第三方平台的component_access_token
     *
     * 2、如果是第三方服务商代公众号或者小程序清除quota，则需要用authorizer_access_token
     *
     * 3、每个帐号每月共10次清零操作机会，清零生效一次即用掉一次机会；第三方帮助公众号/小程序调用时，实际上是在消耗公众号/小程序自身的quota
     *
     * 4、由于指标计算方法或统计时间差异，实时调用量数据可能会出现误差，一般在1%以内
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/clear_quota?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token string 是 依据需要查询的接口属于的账号类型不同而使用不同的token，详情查看注上述注意事项
     * appid string 是 要被清空的账号的appid
     * 请求示例:
     *
     * {
     * "appid":"wx448f04719cd48f69"
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode Number 返回码
     * errmsg String 错误信息
     * 返回结果示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 返回码说明
     * 返回码 errmsg 说明
     * 0 ok 查询成功
     * 48006 forbid to clear quota because of reaching the limit 一个月10次的机会用完了
     * 40013 invalid appid appid写错了；或者填入的appid与access_token代表的账号的appid不一致
     * 其他错误码 请查看全局错误码
     */
    public function clearQuota($appid)
    {
        $params = array();
        $params['appid'] = $appid;
        $rst = $this->_request->post($this->_url . 'clear_quota', $params);
        return $this->_client->rst($rst);
    }

    /**
     * openApi管理 /查询openAPI调用quota
     * 查询openAPI调用quota
     * 本接口用于查询公众号/小程序/第三方平台等接口的每日调用接口的额度以及调用次数。
     *
     * 使用过程中如遇到问题，可在开放平台服务商专区发帖交流。
     *
     * 注意事项
     * 1、如果查询的api属于公众号的接口，则需要用公众号的access_token；如果查询的api属于小程序的接口，则需要用小程序的access_token；如果查询的接口属于第三方平台的接口，则需要用第三方平台的component_access_token；否则会出现76022报错。
     *
     * 2、如果是第三方服务商代公众号或者小程序查询公众号或者小程序的api，则需要用authorizer_access_token
     *
     * 3、每个接口都有调用次数限制，请开发者合理调用接口
     *
     * 4、”/xxx/sns/xxx“这类接口不支持使用该接口，会出现76022报错。
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/openapi/quota/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token string 是 依据需要查询的接口属于的账号类型不同而使用不同的token，详情查看注上述注意事项
     * cgi_path string 是 api的请求地址，例如"/cgi-bin/message/custom/send";不要前缀“https://api.weixin.qq.com” ，也不要漏了"/",否则都会76003的报错
     * 请求示例:
     *
     * {
     * "cgi_path":"/wxa/gettemplatedraftlist"
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode Number 返回码
     * errmsg String 错误信息
     * quota object quota详情
     * quota结构体
     * 参数 类型 说明
     * daily_limit Number 当天该账号可调用该接口的次数
     * used Number 当天已经调用的次数
     * remain Number 当天剩余调用次数
     * 返回结果示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * “quota”:{
     * "daily_limit": 0,
     * "used": 0,
     * "remain": 0}
     * }
     * 返回码说明
     * 返回码 errmsg 说明
     * 0 ok 查询成功
     * 76021 cgi_path not found, please check cgi_path填错了
     * 76022 could not use this cgi_path，no permission 当前调用接口使用的token与api所属账号不符，详情可看注意事项的说明
     * 其他错误码 请查看全局错误码
     */
    public function getQuota($cgi_path)
    {
        $params = array();
        $params['cgi_path'] = $cgi_path;
        $rst = $this->_request->post($this->_url . 'openapi/quota/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * openApi管理 /查询rid信息
     * 查询rid信息
     * 本接口用于查询调用公众号/小程序/第三方平台等接口报错返回的rid详情信息，辅助开发者高效定位问题。
     * 注意事项
     * 1、由于查询rid信息属于开发者私密行为，因此仅支持同账号的查询。举个例子，rid=1111，是小程序账号A调用某接口出现的报错，那么则需要使用小程序账号A的access_token调用当前接口查询rid=1111的详情信息，如果使用小程序账号B的身份查询，则出现报错，错误码为xxx。公众号、第三方平台账号的接口同理。
     *
     * 2、如果是第三方服务商代公众号或者小程序查询公众号或者小程序的api返回的rid，则使用同一账号的authorizer_access_token调用即可
     *
     * 3、rid的有效期只有7天，即只可查询最近7天的rid，查询超过7天的rid会出现报错，错误码为76001
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/openapi/rid/get?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token string 是 依据需要查询的接口属于的账号类型不同而使用不同的token，详情查看注上述注意事项
     * rid string 是 调用接口报错返回的rid
     * 请求示例:
     *
     * {
     * "rid":"61725984-6126f6f9-040f19c4"
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode Number 返回码
     * errmsg String 错误信息
     * request object 该rid对应的请求详情
     * request结构体
     * 参数 类型 说明
     * invoke_time timestamp 发起请求的时间戳
     * cost_in_ms Number 请求毫秒级耗时
     * request_url String 请求的URL参数
     * request_body String post请求的请求参数
     * response_body String 接口请求返回参数
     * client_ip String 接口请求的客户端ip
     * 返回结果示例：
     *
     *
     * {"errcode":0,
     * "errmsg":"ok",
     * "request":{
     * "invoke_time":1635156704,
     * "cost_in_ms":30,
     * "request_url":"access_token=50_Im7xxxx",
     * "request_body":"",
     * "response_body":"{\"errcode\":45009,\"errmsg\":\"reach max api daily quota limit rid: 617682e0-09059ac5-34a8e2ea\"}",
     * "client_ip": "113.xx.70.51"
     *
     * }
     *
     * }
     *
     * 返回码说明
     * 返回码 errmsg 说明
     * 0 ok 查询成功
     * 76001 rid not found rid不存在
     * 76002 rid is error rid为空或者格式错误
     * 76003 could not query this rid,no permission 当前账号无权查询该rid，该rid属于其他账号调用所产生
     * 76004 rid time is error rid过期，仅支持持续7天内的rid
     * 其他错误码 请查看全局错误码
     */
    public function getRid($rid)
    {
        $params = array();
        $params['rid'] = $rid;
        $rst = $this->_request->post($this->_url . 'openapi/rid/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * openApi管理 /使用 AppSecret 重置 API 调用次数
     * 使用AppSecret重置 API 调用次数
     * 接口说明
     * 接口英文名
     * clearQuotaByAppSecret
     *
     * 功能描述
     * 本接口用于清空公众号/小程序等接口的每日调用接口次数
     *
     * 注意事项
     * 1、该接口通过appsecret调用，解决了accesss_token耗尽无法调用重置 API 调用次数的情况
     *
     * 2、每个帐号每月使用重置 API 调用次数 与本接口共10次清零操作机会，清零生效一次即用掉一次机会；
     *
     * 3、由于指标计算方法或统计时间差异，实时调用量数据可能会出现误差，一般在1%以内
     *
     * 4、该接口仅支持POST调用
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/cgi-bin/clear_quota/v2
     *
     * 请求参数
     * 属性 类型 必填 说明
     * appid string 是 要被清空的公众号账号的appid
     * appsecret string 是 唯一凭证密钥，即 AppSecret，获取方式同 appid
     * 返回参数
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * 调用示例
     * 示例说明: post请求
     *
     * 请求数据示例
     *
     * POST https://api.weixin.qq.com/cgi-bin/clear_quota/v2?appid=wx888888888888&appsecret=xxxxxxxxxxxxxxxxxxxxxxxx
     *
     * 返回数据示例
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40013 invalid appid 不合法的 AppID ，请开发者检查 AppID 的正确性，避免异常字符，注意大小写
     * 41004 appsecret missing 缺少 secret 参数
     * 41002 appid missing 缺少 appid 参数
     * 48006 forbid to clear quota because of reaching the limit api 禁止清零调用次数，因为清零次数达到上限
     */
    public function clearQuotaV2($appid, $appsecret)
    {
        $params = array();
        $params['appid'] = $appid;
        $params['appsecret'] = $appsecret;
        $rst = $this->_request->post($this->_url . "/clear_quota/v2?appid={$appid}&appsecret={$appsecret}", $params);
        return $this->_client->rst($rst);
    }
}
