<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * URL Scheme
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/url-scheme/urlscheme.generate.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Urlscheme
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * URL Scheme /generate
     * urlscheme.generate
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 获取小程序 scheme 码，适用于短信、邮件、外部网页、微信内等拉起小程序的业务场景。通过该接口，可以选择生成到期失效和永久有效的小程序码，目前仅针对国内非个人主体的小程序开放，详见获取 URL scheme。
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * POST https://api.weixin.qq.com/wxa/generatescheme?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token string 是 接口调用凭证
     * jump_wxa Object 否 跳转到的目标小程序信息。
     * is_expire boolean false 否 生成的 scheme 码类型，到期失效：true，永久有效：false。
     * expire_type number 0 否 到期失效的 scheme 码失效类型，失效时间：0，失效间隔天数：1
     * expire_time number 否 到期失效的 scheme 码的失效时间，为 Unix 时间戳。生成的到期失效 scheme 码在该时间前有效。最长有效期为1年。生成到期失效的scheme时必填。
     * expire_interval number 否 到期失效的 scheme 码的失效间隔天数。生成的到期失效 scheme 码在该间隔时间到达前有效。最长间隔天数为365天。is_expire 为 true 且 expire_type 为 1 时必填
     * jump_wxa 的结构
     *
     * 属性 类型 默认值 必填 说明
     * path string 是 通过 scheme 码进入的小程序页面路径，必须是已经发布的小程序存在的页面，不可携带 query。path 为空时会跳转小程序主页。
     * query string 是 通过 scheme 码进入小程序时的 query，最大1024个字符，只支持数字，大小写英文以及部分特殊字符：!#$&'()*+,/:;=?@-._~
     * 返回值
     * openlink
     * 生成的小程序 scheme 码
     *
     * 异常返回
     * Object
     * JSON
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * errcode 的合法值
     *
     * 值 说明 最低版本
     * 40002 暂无生成权限
     * 40013 生成权限被封禁
     * 85079 小程序未发布
     * 40165 参数path填写错误
     * 40212 参数query填写错误
     * 85401 参数expire_time填写错误，时间间隔大于1分钟且小于1年
     * 44990 生成Scheme频率过快（超过100次/秒）
     * 85400 长期有效Scheme达到生成上限10万
     * 45009 单天生成Scheme数量超过上限50万
     * 返回值说明
     * 如果调用成功，会直接返回生成的小程序 scheme 码。如果请求失败，会返回 JSON 格式的数据。
     *
     * 示例
     * 请求
     *
     * {
     * "jump_wxa":
     * {
     * "path": "/pages/publishHomework/publishHomework",
     * "query": ""
     * },
     * "is_expire":true,
     * "expire_time":1606737600
     * }
     * 返回
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "openlink": Scheme,
     * }
     */
    public function generate(\Weixin\Wx\Model\JumpWxa $jump_wxa, $is_expire, $expire_type, $expire_time, $expire_interval)
    {
        $params = array();
        $params['jump_wxa'] = $jump_wxa->getParams();
        $params['is_expire'] = $is_expire;
        $params['expire_type'] = $expire_type;
        $params['expire_time'] = $expire_time;
        $params['expire_interval'] = $expire_interval;
        $rst = $this->_request->post($this->_url . 'wxa/generatescheme', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询 scheme 码
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * queryScheme
     *
     * 功能描述
     * 该接口用于查询小程序 scheme 码，及长期有效 quota。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/wxa/queryscheme?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和 HTTPS 调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.urlscheme.query
     *
     * 第三方调用
     * 调用方式以及出入参和 HTTPS 相同，仅是调用的 token 不同
     *
     * 该接口所属的权限集 id 为：88、115
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * scheme string 是 小程序 scheme 码
     * 返回参数
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * scheme_info object scheme 配置
     * 属性 类型 说明
     * appid string 小程序 appid
     * path string 小程序页面路径
     * query string 小程序页面query
     * create_time number 创建时间，为 Unix 时间戳
     * expire_time number 到期失效时间，为 Unix 时间戳，0 表示永久生效
     * env_version string 要打开的小程序版本。正式版为"release"，体验版为"trial"，开发版为"develop"
     * scheme_quota object quota 配置
     * 属性 类型 说明
     * long_time_used number 长期有效 scheme 已生成次数
     * long_time_limit number 长期有效 scheme 生成次数上限
     * 调用示例
     * 示例说明: HTTPS请求示例
     *
     * 请求数据示例
     *
     * {
     * "scheme": "weixin://dl/business/?t=XTSkBZlzqmn"
     * }
     *
     * 返回数据示例
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "scheme_info": {
     * "appid": "appid",
     * "path": "",
     * "query": "",
     * "create_time": 611928113,
     * "expire_time": 0,
     * "env_version": "release"
     * },
     * "scheme_quota": {
     * "long_time_used": 100,
     * "long_time_limit": 100000
     * }
     * }
     */
    public function query($scheme)
    {
        $params = array();
        $params['scheme'] = $scheme;
        $rst = $this->_request->post($this->_url . 'wxa/queryscheme', $params);
        return $this->_client->rst($rst);
    }
}
