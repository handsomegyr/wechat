<?php

/**
 * 获取微信服务端使用的accessToken
 * https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_access_token.html
 * https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/getStableAccessToken.html
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Token;

class Server
{
    private $_appid = null;
    private $_secret = null;
    private $_request;
    public function __construct($appid, $secret)
    {
        $this->_appid = $appid;
        $this->_secret = $secret;
        $this->_request = new \Weixin\Http\Request(\uniqid(), true, "");
    }

    /**
     * 开始开发 /获取 Access token
     * access_token是公众号的全局唯一接口调用凭据，公众号调用各接口时都需使用access_token。开发者需要进行妥善保存。access_token的存储至少要保留512个字符空间。access_token的有效期目前为2个小时，需定时刷新，重复获取将导致上次获取的access_token失效。
     *
     * 公众平台的API调用所需的access_token的使用及生成方式说明：
     *
     * 1、建议公众号开发者使用中控服务器统一获取和刷新access_token，其他业务逻辑服务器所使用的access_token均来自于该中控服务器，不应该各自去刷新，否则容易造成冲突，导致access_token覆盖而影响业务；
     *
     * 2、目前access_token的有效期通过返回的expires_in来传达，目前是7200秒之内的值。中控服务器需要根据这个有效时间提前去刷新新access_token。在刷新过程中，中控服务器可对外继续输出的老access_token，此时公众平台后台会保证在5分钟内，新老access_token都可用，这保证了第三方业务的平滑过渡；
     *
     * 3、access_token的有效时间可能会在未来有调整，所以中控服务器不仅需要内部定时主动刷新，还需要提供被动刷新access_token的接口，这样便于业务服务器在API调用获知access_token已超时的情况下，可以触发access_token的刷新流程。
     *
     * 4、对于可能存在风险的调用，在开发者进行获取 access_token调用时进入风险调用确认流程，需要用户管理员确认后才可以成功获取。具体流程为：
     *
     * 开发者通过某IP发起调用->平台返回错误码[89503]并同时下发模板消息给公众号管理员->公众号管理员确认该IP可以调用->开发者使用该IP再次发起调用->调用成功。
     *
     * 如公众号管理员第一次拒绝该IP调用，用户在1个小时内将无法使用该IP再次发起调用，如公众号管理员多次拒绝该IP调用，该IP将可能长期无法发起调用。平台建议开发者在发起调用前主动与管理员沟通确认调用需求，或请求管理员开启IP白名单功能并将该IP加入IP白名单列表。
     *
     * 公众号和小程序均可以使用AppID和AppSecret调用本接口来获取access_token。AppID和AppSecret可在“微信公众平台-开发-基本配置”页中获得（需要已经成为开发者，且帐号没有异常状态）。**调用接口时，请登录“微信公众平台-开发-基本配置”提前将服务器IP地址添加到IP白名单中，点击查看设置方法，否则将无法调用成功。**小程序无需配置IP白名单。
     *
     * 接口调用请求说明
     *
     * https请求方式: GET https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET
     *
     * 参数说明
     *
     * 参数 是否必须 说明
     * grant_type 是 获取access_token填写client_credential
     * appid 是 第三方用户唯一凭证
     * secret 是 第三方用户唯一凭证密钥，即appsecret
     * 返回说明
     *
     * 正常情况下，微信会返回下述JSON数据包给公众号：
     *
     * {"access_token":"ACCESS_TOKEN","expires_in":7200}
     * 参数说明
     *
     * 参数 说明
     * access_token 获取到的凭证
     * expires_in 凭证有效时间，单位：秒
     * 错误时微信会返回错误码等信息，JSON数据包示例如下（该示例为AppID无效错误）:
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     * 返回码说明
     *
     * 返回码 说明
     * -1 系统繁忙，此时请开发者稍候再试
     * 0 请求成功
     * 40001 AppSecret错误或者AppSecret不属于这个公众号，请开发者确认AppSecret的正确性
     * 40002 请确保grant_type字段值为client_credential
     * 40164 调用接口的IP地址不在白名单中，请在接口IP白名单中进行设置。
     * 89503 此IP调用需要管理员确认,请联系管理员
     * 89501 此IP正在等待管理员确认,请联系管理员
     * 89506 24小时内该IP被管理员拒绝调用两次，24小时内不可再使用该IP调用
     * 89507 1小时内该IP被管理员拒绝调用一次，1小时内不可再使用该IP调用
     */
    public function getAccessToken()
    {
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid={$this->_appid}&secret={$this->_secret}";
        return json_decode(file_get_contents($url), true);
    }

    /**
     * 开始开发 /获取 Stable Access token
     * 获取稳定版接口调用凭据
     * 接口说明
     * 接口英文名
     * getStableAccessToken
     *
     * 功能描述
     * 获取公众号全局后台接口调用凭据，有效期最长为7200s，开发者需要进行妥善保存；
     * 有两种调用模式: 1. 普通模式，access_token 有效期内重复调用该接口不会更新 access_token，绝大部分场景下使用该模式；2. 强制刷新模式，会导致上次获取的 access_token 失效，并返回新的 access_token；
     * 该接口调用频率限制为 1万次 每分钟，每天限制调用 50w 次；
     * 与获取Access token获取的调用凭证完全隔离，互不影响。该接口仅支持 POST JSON 形式的调用；
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/cgi-bin/stable_token
     *
     * 请求参数
     * 属性 类型 必填 说明
     * grant_type string 是 填写 client_credential
     * appid string 是 账号唯一凭证，即 AppID，可在「微信公众平台 - 设置 - 开发设置」页中获得。（需要已经成为开发者，且帐号没有异常状态）
     * secret string 是 帐号唯一凭证密钥，即 AppSecret，获取方式同 appid
     * force_refresh boolean 否 默认使用 false。1. force_refresh = false 时为普通调用模式，access_token 有效期内重复调用该接口不会更新 access_token；2. 当force_refresh = true 时为强制刷新模式，会导致上次获取的 access_token 失效，并返回新的 access_token
     * 返回参数
     * 属性 类型 说明
     * access_token string 获取到的凭证
     * expires_in number 凭证有效时间，单位：秒。目前是7200秒之内的值。
     * 其他说明
     * access_token 的存储与更新
     * access_token 的存储空间至少要保留 512 个字符；
     * 建议开发者仅在access_token 泄漏时使用强制刷新模式，该模式限制每天20次。考虑到数据安全，连续使用该模式时，请保证调用时间隔至少为30s，否则不会刷新；
     * 在普通模式调用下，平台会提前5分钟更新access_token，即在有效期倒计时5分钟内发起调用会获取新的access_token。在新旧access_token交接之际，平台会保证在5分钟内，新旧access_token都可用，这保证了用户业务的平滑过渡； 根据此特性可知，任意时刻发起调用获取到的 access_token 有效期至少为 5 分钟，即expires_in >= 300；
     * 最佳实践
     * 在使用获取Access token时，平台建议开发者使用中控服务来统一获取和刷新access_token。有此成熟方案的开发者依然可以复用方案并通过普通模式来调用本接口，另外请将发起接口调用的时机设置为上次获取到的access_token有效期倒计时5分钟之内即可；
     * 根据以上特性，为减少其他开发者构建中控服务的开发成本，在普通调用模式下，平台建议开发者将每次获取的access_token 在本地建立中心化存储使用，无须考虑并行调用接口时导致意外情况发生，仅须保证至少每5分钟发起一次调用并覆盖本地存储。同时，该方案也支持各业务独立部署使用，即无须中心化存储也可以保证服务正常运行；
     * access_token 泄漏紧急处理
     * 使用强制刷新模式以间隔30s发起两次调用可将已经泄漏的 access_token立即失效，同时正常的业务请求可能会返回错误码40001(access_token 过期)，请妥善使用该策略。其次，需要立即排查泄漏原因，加以修正，必要时可以考虑重置 appsecret；
     * 调用示例
     * 示例说明: 普通模式，获取当前有效调用凭证
     *
     * 请求数据示例
     * POST https://api.weixin.qq.com/cgi-bin/stable_token
     * 请求示例1（不传递force_refresh，默认值为false）:
     *
     * {
     * "grant_type": "client_credential",
     * "appid": "APPID",
     * "secret": "APPSECRET"
     * }
     * 请求示例2（设置force_refresh为false）:
     *
     * {
     * "grant_type": "client_credential",
     * "appid": "APPID",
     * "secret": "APPSECRET",
     * "force_refresh": false
     * }
     * 返回数据示例
     * 返回示例1:
     *
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200
     * }
     * 返回示例2:
     *
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":345
     * }
     * 示例说明: 强制刷新模式，慎用，连续使用需要至少间隔30s
     *
     * 请求数据示例
     * POST https://api.weixin.qq.com/cgi-bin/stable_token
     * {
     * "grant_type": "client_credential",
     * "appid": "APPID",
     * "secret": "APPSECRET",
     * "force_refresh": true
     * }
     * 返回数据示例
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200
     * }
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 0 ok ok
     * 40002 invalid grant_type 不合法的凭证类型
     * 40013 invalid appid 不合法的 AppID ，请开发者检查 AppID 的正确性，避免异常字符，注意大小写
     * 40125 invalid appsecret 无效的appsecret，请检查appsecret的正确性
     * 40164 invalid ip not in whitelist 将ip添加到ip白名单列表即可
     * 41002 appid missing 缺少 appid 参数
     * 41004 appsecret missing 缺少 secret 参数
     * 43002 require POST method 需要 POST 请求
     * 45009 reach max api daily quota limit 调用超过天级别频率限制。可调用clear_quota接口恢复调用额度。
     * 45011 api minute-quota reach limit mustslower retry next minute API 调用太频繁，请稍候再试
     * 89503 此次调用需要管理员确认，请耐心等候
     * 89506 该IP调用求请求已被公众号管理员拒绝，请24小时后再试，建议调用前与管理员沟通确认
     * 89507 该IP调用求请求已被公众号管理员拒绝，请1小时后再试，建议调用前与管理员沟通确认
     */
    public function getStableAccessToken($force_refresh = false)
    {
        $params = array();
        $params['grant_type'] = "client_credential";
        $params['appid'] = $this->_appid;
        $params['secret'] = $this->_secret;
        $params['force_refresh'] = $force_refresh;
        $rst = $this->_request->post("https://api.weixin.qq.com/cgi-bin/stable_token", $params);
        return $rst;
    }
    public function __destruct()
    {
    }
}
