<?php

namespace Weixin\Qy\Manager\ExternalContact;

use Weixin\Qy\Client;

/**
 * 群欢迎语素材管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class GroupWelcomeTemplate
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 添加群欢迎语素材
     * 企业可通过此API向企业的群欢迎语素材库中添加素材。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/add?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "text": {
     * "content":"亲爱的%NICKNAME%用户，你好"
     * },
     * "image": {
     * "media_id": "MEDIA_ID"
     * },
     * "link": {
     * "title": "消息标题",
     * "picurl": "https://example.pic.com/path",
     * "desc": "消息描述",
     * "url": "https://example.link.com/path"
     * },
     * "miniprogram": {
     * "title": "消息标题",
     * "pic_media_id": "MEDIA_ID",
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * text.content 否 消息文本内容,最长为3000字节
     * image.media_id 是 图片的media_id
     * link.title 是 图文消息标题，最长为128字节
     * link.picurl 否 图文消息封面的url
     * link.desc 否 图文消息的描述，最长为512字节
     * link.url 是 图文消息的链接
     * miniprogram.title 是 小程序消息标题，最长为64字节
     * miniprogram.pic_media_id 是 小程序消息封面的mediaid，封面图建议尺寸为520*416
     * miniprogram.appid 是 小程序appid，必须是关联到企业的小程序应用
     * miniprogram.page 是 小程序page路径
     * text中支持配置多个%NICKNAME%(大小写敏感)形式的欢迎语，当配置了欢迎语占位符后，发送给客户时会自动替换为客户的昵称;
     * text、image、link和miniprogram四者不能同时为空；
     * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
     * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
     * media_id可以通过素材管理接口获得。
     *
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "template_id": "msgXXXXXX"
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * template_id 欢迎语素材id
     */
    public function add(\Weixin\Qy\Model\ExternalContact\GroupWelcomeTemplate $groupWelcomeTemplate)
    {
        $params = $groupWelcomeTemplate->getParams();
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 编辑群欢迎语素材
     * 企业可通过此API编辑欢迎语素材库中的素材。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/edit?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "template_id":"msgXXXXXXX",
     * "text": {
     * "content":"文本消息内容"
     * },
     * "image": {
     * "media_id": "MEDIA_ID"
     * },
     * "link": {
     * "title": "消息标题",
     * "picurl": "https://example.pic.com/path",
     * "desc": "消息描述",
     * "url": "https://example.link.com/path"
     * },
     * "miniprogram": {
     * "title": "消息标题",
     * "pic_media_id": "MEDIA_ID",
     * "appid": "wx8bd80126147df384",
     * "page": "/path/index"
     * }
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * template_id 是 欢迎语素材id
     * text.content 否 消息文本内容,最长为4000字节
     * image.media_id 是 图片的media_id
     * link.title 是 图文消息标题，最长为128字节
     * link.picurl 否 图文消息封面的url
     * link.desc 否 图文消息的描述，最长为512字节
     * link.url 是 图文消息的链接
     * miniprogram.title 是 小程序消息标题，最长为64字节
     * miniprogram.pic_media_id 是 小程序消息封面的mediaid，封面图建议尺寸为520*416
     * miniprogram.appid 是 小程序appid，必须是关联到企业的小程序应用
     * miniprogram.page 是 小程序page路径
     * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
     * media_id可以通过素材管理接口获得。
     *
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function edit(\Weixin\Qy\Model\ExternalContact\GroupWelcomeTemplate $groupWelcomeTemplate)
    {
        $params = $groupWelcomeTemplate->getParams();
        $rst = $this->_request->post($this->_url . 'edit', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取群欢迎语素材
     * 企业可通过此API获取群欢迎语素材。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/get?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "template_id":"msgXXXXXXX"
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * template_id 是 群欢迎语的素材id
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "text":
     * {
     * "content":"文本消息内容"
     * },
     * "image":
     * {
     * "pic_url": "http://p.qpic.cn/pic_wework/XXXXX"
     * },
     * "link":
     * {
     * "title": "消息标题",
     * "picurl": "https://example.pic.com/path",
     * "desc": "消息描述",
     * "url": "https://example.link.com/path"
     * },
     * "miniprogram":
     * {
     * "title": "消息标题",
     * "pic_media_id": "MEDIA_ID",
     * "appid": "wx8bd80126147df384",
     * "page": "/path/index"
     * }
     * }
     * 注意：image、link和miniprogram仅会返回一个。
     *
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * text.content 消息文本内容
     * image.pic_url 图片的url
     * link.title 图文消息标题
     * link.picurl 图文消息封面的url
     * link.desc 图文消息的描述
     * link.url 图文消息的链接
     * miniprogram.title 小程序消息标题
     * miniprogram.pic_media_id 小程序消息封面的mediaid
     * miniprogram.appid 小程序appid
     * miniprogram.page 小程序page路径
     */
    public function get($template_id)
    {
        $params = array();
        $params['template_id'] = $template_id;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除群欢迎语素材
     * 企业可通过此API删除群欢迎语素材。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/group_welcome_template/del?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "template_id":"msgXXXXXXX"
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * template_id 是 群欢迎语的素材id
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function delete($template_id)
    {
        $params = array();
        $params['template_id'] = $template_id;
        $rst = $this->_request->post($this->_url . 'del', $params);
        return $this->_client->rst($rst);
    }
}
