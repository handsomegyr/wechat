<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 应用管理
 * https://work.weixin.qq.com/api/doc/90000/90135/90226
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Agent
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/agent/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取应用
     * 调试工具
     * 获取指定的应用详情
     * 获取access_token对应的应用列表
     * 获取指定的应用详情
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/get?access_token=ACCESS_TOKEN&agentid=AGENTID
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 应用id
     * 权限说明：
     * 企业仅可获取当前凭证对应的应用；第三方仅可获取被授权的应用。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "agentid": 1000005,
     * "name": "HR助手",
     * "square_logo_url": "https://p.qlogo.cn/bizmail/FicwmI50icF8GH9ib7rUAYR5kicLTgP265naVFQKnleqSlRhiaBx7QA9u7Q/0",
     * "description": "HR服务与员工自助平台",
     * "allow_userinfos": {
     * "user": [
     * {"userid": "zhangshan"},
     * {"userid": "lisi"}
     * ]
     * },
     * "allow_partys": {
     * "partyid": [1]
     * },
     * "allow_tags": {
     * "tagid": [1,2,3]
     * },
     * "close": 0,
     * "redirect_domain": "open.work.weixin.qq.com",
     * "report_location_flag": 0,
     * "isreportenter": 0,
     * "home_url": "https://open.work.weixin.qq.com"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 出错返回码，为0表示成功，非0表示调用失败
     * errmsg 返回码提示语
     * agentid 企业应用id
     * name 企业应用名称
     * square_logo_url 企业应用方形头像
     * description 企业应用详情
     * allow_userinfos 企业应用可见范围（人员），其中包括userid
     * allow_partys 企业应用可见范围（部门）
     * allow_tags 企业应用可见范围（标签）
     * close 企业应用是否被停用
     * redirect_domain 企业应用可信域名
     * report_location_flag 企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
     * isreportenter 是否上报用户进入应用事件。0：不接收；1：接收
     * home_url 应用主页url
     */
    public function get($agentid)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $rst = $this->_request->get($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取access_token对应的应用列表
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/list?access_token=ACCESS_TOKEN
     *
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * 权限说明：
     * 企业仅可获取当前凭证对应的应用；第三方仅可获取被授权的应用。
     *
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok" ,
     * "agentlist":[
     * {
     * "agentid": 1000005,
     * "name": "HR助手",
     * "square_logo_url": "https://p.qlogo.cn/bizmail/FicwmI50icF8GH9ib7rUAYR5kicLTgP265naVFQKnleqSlRhiaBx7QA9u7Q/0"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 类型 说明
     * errcode Integer 出错返回码，为0表示成功，非0表示调用失败
     * errmsg String 返回码提示语
     * agentlist AgentItemArray 当前凭证可访问的应用列表
     * AgentItem 结构：
     *
     * 参数 类型 说明
     * agentid Integer 企业应用id
     * name String 企业应用名称
     * square_logo_url String 企业应用方形头像url
     */
    public function list()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置应用
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/agent/set?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "agentid": 1000005,
     * "report_location_flag": 0,
     * "logo_mediaid": "j5Y8X5yocspvBHcgXMSS6z1Cn9RQKREEJr4ecgLHi4YHOYP-plvom-yD9zNI0vEl",
     * "name": "财经助手",
     * "description": "内部财经服务平台",
     * "redirect_domain": "open.work.weixin.qq.com",
     * "isreportenter": 0,
     * "home_url": "https://open.work.weixin.qq.com"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 企业应用的id
     * report_location_flag 否 企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
     * logo_mediaid 否 企业应用头像的mediaid，通过素材管理接口上传图片获得mediaid，上传后会自动裁剪成方形和圆形两个头像
     * name 否 企业应用名称，长度不超过32个utf8字符
     * description 否 企业应用详情，长度为4至120个utf8字符
     * redirect_domain 否 企业应用可信域名。注意：域名需通过所有权校验，否则jssdk功能将受限，此时返回错误码85005
     * isreportenter 否 是否上报用户进入应用事件。0：不接收；1：接收。
     * home_url 否 应用主页url。url必须以http或者https开头（为了提高安全性，建议使用https）。
     * 权限说明：
     * 仅企业可调用，可设置当前凭证对应的应用；第三方不可调用。
     *
     * 返回结果 ：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     */
    public function set(\Weixin\Qy\Model\Agent $agent)
    {
        $params = $agent->getParams();
        $rst = $this->_request->post($this->_url . 'set', $params);
        return $this->_client->rst($rst);
    }
}
