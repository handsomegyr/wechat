<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;
use Weixin\Qy\Manager\ExternalContact\GroupChat;
use Weixin\Qy\Manager\ExternalContact\GroupWelcomeTemplate;

/**
 * 外部企业的联系人管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class ExternalContact
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取客户群列消息发送对象
     *
     * @return \Weixin\Qy\Manager\ExternalContact\GroupChat
     */
    public function getGroupChatManager()
    {
        return new GroupChat($this->_client);
    }

    /**
     * 获取群欢迎语素材对象
     *
     * @return \Weixin\Qy\Manager\ExternalContact\GroupWelcomeTemplate
     */
    public function getReimburseManager()
    {
        return new GroupWelcomeTemplate($this->_client);
    }

    /**
     * 获取配置了客户联系功能的成员列表
     * 调试工具
     * 企业和第三方服务商可通过此接口获取配置了客户联系功能的成员列表。
     *
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_follow_user_list?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
     * 第三方应用需拥有“企业客户”权限。
     * 第三方/自建应用只能获取到可见范围内的配置了客户联系功能的成员。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "follow_user":[
     * "zhangsan",
     * "lissi"
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * follow_user 配置了客户联系功能的成员userid列表
     */
    public function getFollowUserList()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'get_follow_user_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 配置客户联系「联系我」方式
     * 企业可以在管理后台-客户联系中配置成员的「联系我」的二维码或者小程序按钮，客户通过扫描二维码或点击小程序上的按钮，即可获取成员联系方式，主动联系到成员。
     * 企业可通过此接口为具有客户联系功能的成员生成专属的「联系我」二维码或者「联系我」按钮。
     * 如果配置的是「联系我」按钮，需要开发者的小程序接入小程序插件。
     *
     * 注意:
     * 通过API添加的「联系我」不会在管理端进行展示，每个企业可通过API最多配置50万个「联系我」。
     * 用户需要妥善存储返回的config_id，config_id丢失可能导致用户无法编辑或删除「联系我」。
     * 临时会话模式不占用「联系我」数量，但每日最多添加10万个，并且仅支持单人。
     * 临时会话模式的二维码，添加好友完成后该二维码即刻失效。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_contact_way?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "type" :1,
     * "scene":1,
     * "style":1,
     * "remark":"渠道客户",
     * "skip_verify":true,
     * "state":"teststate",
     * "user" : ["UserID1", "UserID2", "UserID3"],
     * "party" : [PartyID1, PartyID2],
     * "is_temp":true,
     * "expires_in":86400,
     * "chat_expires_in":86400,
     * "unionid":"oxTWIuGaIt6gTKsQRLau2M0AAAA",
     * "conclusions":
     * {
     * "text":
     * {
     * "content":"文本消息内容"
     * },
     * "image":
     * {
     * "media_id": "MEDIA_ID"
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
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * type 是 联系方式类型,1-单人, 2-多人
     * scene 是 场景，1-在小程序中联系，2-通过二维码联系
     * style 否 在小程序中联系时使用的控件样式，详见附表
     * remark 否 联系方式的备注信息，用于助记，不超过30个字符
     * skip_verify 否 外部客户添加时是否无需验证，默认为true
     * state 否 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值，不超过30个字符
     * user 否 使用该联系方式的用户userID列表，在type为1时为必填，且只能有一个
     * party 否 使用该联系方式的部门id列表，只在type为2时有效
     * is_temp 否 是否临时会话模式，true表示使用临时会话模式，默认为false
     * expires_in 否 临时会话二维码有效期，以秒为单位。该参数仅在is_temp为true时有效，默认7天
     * chat_expires_in 否 临时会话有效期，以秒为单位。该参数仅在is_temp为true时有效，默认为添加好友后24小时
     * unionid 否 可进行临时会话的客户unionid，该参数仅在is_temp为true时有效，如不指定则不进行限制
     * conclusions 否 结束语，会话结束时自动发送给客户，可参考“结束语定义”，仅在is_temp为true时有效
     * 注意，每个联系方式最多配置100个使用成员（包含部门展开后的成员）
     * 当设置为临时会话模式时（即is_temp为true），联系人仅支持配置为单人，暂不支持多人
     * 使用unionid需要调用方（企业或服务商）的企业微信“客户联系”中已绑定微信开发者账户
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "config_id":"42b34949e138eb6e027c123cba77fAAA"　　
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * config_id 新增联系方式的配置id
     */
    public function addContactWay(\Weixin\Qy\Model\ExternalContact\ContactWay $contactWay)
    {
        $params = $contactWay->getParams();
        $rst = $this->_request->post($this->_url . 'add_contact_way', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取企业已配置的「联系我」方式
     * 批量获取企业配置的「联系我」二维码和「联系我」小程序按钮。
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_contact_way?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "config_id":"42b34949e138eb6e027c123cba77fad7"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * config_id 是 联系方式的配置id
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "contact_way":
     * {
     * "config_id":"42b34949e138eb6e027c123cba77fAAA",
     * "type":1,
     * "scene":1,
     * "style":2,
     * "remark":"test remark",
     * "skip_verify":true,
     * "state":"teststate",
     * "qr_code":"http://p.qpic.cn/wwhead/duc2TvpEgSdicZ9RrdUtBkv2UiaA/0",
     * "user" : ["UserID1", "UserID2", "UserID3"],
     * "party" : [PartyID1, PartyID2]，
     * "is_temp":true,
     * "expires_in":86400,
     * "chat_expires_in":86400,
     * "unionid":"oxTWIuGaIt6gTKsQRLau2M0AAAA",
     * "conclusions":
     * {
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
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * config_id 新增联系方式的配置id
     * type 联系方式类型，1-单人，2-多人
     * scene 场景，1-在小程序中联系，2-通过二维码联系
     * is_temp 是否临时会话模式，默认为false，true表示使用临时会话模式
     * remark 联系方式的备注信息，用于助记
     * skip_verify 外部客户添加时是否无需验证
     * state 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值
     * style 小程序中联系按钮的样式，仅在scene为1时返回，详见附录
     * qr_code 联系二维码的URL，仅在scene为2时返回
     * user 使用该联系方式的用户userID列表
     * party 使用该联系方式的部门id列表
     * expires_in 临时会话二维码有效期，以秒为单位
     * chat_expires_in 临时会话有效期，以秒为单位
     * unionid 可进行临时会话的客户unionid
     * conclusions 结束语，可参考“结束语定义”
     */
    public function getContactWay($config_id)
    {
        $params = array();
        $params['config_id'] = $config_id;
        $rst = $this->_request->post($this->_url . 'get_contact_way', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新企业已配置的「联系我」方式
     * 更新企业配置的「联系我」二维码和「联系我」小程序按钮中的信息，如使用人员和备注等。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/update_contact_way?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "config_id":"42b34949e138eb6e027c123cba77fAAA",
     * "remark":"渠道客户",
     * "skip_verify":true,
     * "style":1,
     * "state":"teststate",
     * "user" : ["UserID1", "UserID2", "UserID3"],
     * "party" : [PartyID1, PartyID2],
     * "expires_in":86400,
     * "chat_expires_in":86400，
     * "unionid":"oxTWIuGaIt6gTKsQRLau2M0AAAA",
     * "conclusions":
     * {
     * "text":
     * {
     * "content":"文本消息内容"
     * },
     * "image":
     * {
     * "media_id": "MEDIA_ID"
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
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * config_id 是 企业联系方式的配置id
     * remark 否 联系方式的备注信息，不超过30个字符，将覆盖之前的备注
     * skip_verify 否 外部客户添加时是否无需验证
     * style 否 样式，只针对“在小程序中联系”的配置生效
     * state 否 企业自定义的state参数，用于区分不同的添加渠道，在调用“获取外部联系人详情”时会返回该参数值
     * user 否 使用该联系方式的用户列表，将覆盖原有用户列表
     * party 否 使用该联系方式的部门列表，将覆盖原有部门列表，只在配置的type为2时有效
     * expires_in 否 临时会话二维码有效期，以秒为单位，该参数仅在临时会话模式下有效
     * chat_expires_in 否 临时会话有效期，以秒为单位，该参数仅在临时会话模式下有效
     * unionid 否 可进行临时会话的客户unionid，该参数仅在临时会话模式有效，如不指定则不进行限制
     * conclusions 否 结束语，会话结束时自动发送给客户，可参考“结束语定义”，仅临时会话模式（is_temp为true）可设置
     * 注意：已失效的临时会话联系方式无法进行编辑
     * 当临时会话模式时（即is_temp为true），联系人仅支持配置为单人，暂不支持多人
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function updateContactWay(\Weixin\Qy\Model\ExternalContact\ContactWay $contactWay)
    {
        $params = $contactWay->getParams();
        $rst = $this->_request->post($this->_url . 'update_contact_way', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除企业已配置的「联系我」方式
     * 删除一个已配置的「联系我」二维码或者「联系我」小程序按钮。
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_contact_way?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "config_id":"42b34949e138eb6e027c123cba77fAAA"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * config_id 是 企业联系方式的配置id
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function delelteContactWay($config_id)
    {
        $params = array();
        $params['config_id'] = $config_id;
        $rst = $this->_request->post($this->_url . 'del_contact_way', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 结束临时会话
     * 将指定的企业成员和客户之前的临时会话断开，断开前会自动下发已配置的结束语。
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/close_temp_chat?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "userid":"zhangyisheng",
     * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACHAAA"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 是 企业成员的userid
     * external_userid 是 客户的外部联系人userid
     * 注意：请保证传入的企业成员和客户之间有仍然有效的临时会话, 通过其他方式的添加外部联系人无法通过此接口关闭会话。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * 结束语定义
     * 字段内容：
     *
     * "conclusions":
     * {
     * "text":
     * {
     * "content":"文本消息内容"
     * },
     * "image":
     * {
     * "media_id": "MEDIA_ID",
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
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * text.content 消息文本内容,最长为4000字节
     * image.media_id 图片的media_id
     * image.pic_url 图片的url
     * link.title 图文消息标题，最长为128字节
     * link.picurl 图文消息封面的url
     * link.desc 图文消息的描述，最长为512字节
     * link.url 图文消息的链接
     * miniprogram.title 小程序消息标题，最长为64字节
     * miniprogram.pic_media_id 小程序消息封面的mediaid，封面图建议尺寸为520*416
     * miniprogram.appid 小程序appid，必须是关联到企业的小程序应用
     * miniprogram.page 小程序page路径
     * text、image、link和miniprogram四者不能同时为空；
     * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户;
     * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效;
     * media_id可以通过素材管理接口获得;
     * 构造结束语使用image消息时，只能填写meida_id字段,获取含有image结构的联系我方式时，返回pic_url字段。
     */
    public function closeTempChat($userid, $external_userid)
    {
        $params = array();
        $params['userid'] = $userid;
        $params['external_userid'] = $external_userid;
        $rst = $this->_request->post($this->_url . 'close_temp_chat', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客户列表
     * 调试工具
     * 企业可通过此接口获取指定成员添加的客户列表。客户是指配置了客户联系功能的成员所添加的外部联系人。没有配置客户联系功能的成员，所添加的外部联系人将不会作为客户返回。
     *
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/list?access_token=ACCESS_TOKEN&userid=USERID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 是 企业成员的userid
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）；
     * 第三方应用需拥有“企业客户”权限。
     * 第三方/自建应用只能获取到可见范围内的配置了客户联系功能的成员。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "external_userid":
     * [
     * "woAJ2GCAAAXtWyujaWJHDDGi0mACAAA",
     * "wmqfasd1e1927831291723123109rAAA"
     * ]
     * 　　
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * external_userid 外部联系人的userid列表
     */
    public function list($userid)
    {
        $params = array();
        $params['userid'] = $userid;
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客户详情
     * 调试工具
     * 企业可通过此接口，根据外部联系人的userid（如何获取?），拉取客户详情。
     *
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get?access_token=ACCESS_TOKEN&external_userid=EXTERNAL_USERID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * external_userid 是 外部联系人的userid，注意不是企业成员的帐号
     * 权限说明：
     *
     * 企业需要使用系统应用“客户联系”或配置到“可调用应用”列表中的自建应用的secret所获取的accesstoken来调用（accesstoken如何获取？）；
     * 第三方/自建应用调用时，返回的跟进人follow_user仅包含应用可见范围之内的成员。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "external_contact":
     * {
     * "external_userid":"woAJ2GCAAAXtWyujaWJHDDGi0mACHAAA",
     * "name":"李四",
     * "position":"Mangaer",
     * "avatar":"http://p.qlogo.cn/bizmail/IcsdgagqefergqerhewSdage/0",
     * "corp_name":"腾讯",
     * "corp_full_name":"腾讯科技有限公司",
     * "type":2,
     * "gender":1,
     * "unionid":"ozynqsulJFCZ2z1aYeS8h-nuasdAAA",
     * "external_profile":{
     * "external_attr":[
     * {
     * "type":0,
     * "name":"文本名称",
     * "text":{
     * "value":"文本"
     * }
     * },
     * {
     * "type":1,
     * "name":"网页名称",
     * "web":{
     * "url":"http://www.test.com",
     * "title":"标题"
     * }
     * 　　　　　　　　},
     * 　　　　　　　　{
     * 　　　　　　　　　　"type":2,
     * 　　　　　　　　　　"name":"测试app",
     * 　　　　　　　　　　"miniprogram":{
     * "appid": "wx8bd80126147df384",
     * "pagepath": "/index",
     * "title": "my miniprogram"
     * 　　　　　　　　　　}
     * 　　　　　　　　}
     * 　　　　　　]
     * 　　　　}
     * },
     * "follow_user":
     * [
     * {
     * "userid":"rocky",
     * "remark":"李部长",
     * "description":"对接采购事务",
     * "createtime":1525779812,
     * "tags":[
     * {
     * "group_name":"标签分组名称",
     * "tag_name":"标签名称",
     * "type":1
     * }
     * ],
     * "remark_corp_name":"腾讯科技",
     * "remark_mobiles":[
     * "13800000001",
     * "13000000002"
     * ]
     * },
     * {
     * "userid":"tommy",
     * "remark":"李总",
     * "description":"采购问题咨询",
     * "createtime":1525881637,
     * "state":"外联二维码1"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * external_userid 外部联系人的userid
     * name 外部联系人的名称*
     * avatar 外部联系人头像，第三方不可获取
     * type 外部联系人的类型，1表示该外部联系人是微信用户，2表示该外部联系人是企业微信用户
     * gender 外部联系人性别 0-未知 1-男性 2-女性
     * unionid 外部联系人在微信开放平台的唯一身份标识（微信unionid），通过此字段企业可将外部联系人与公众号/小程序用户关联起来。仅当联系人类型是微信用户，且企业或第三方服务商绑定了微信开发者ID有此字段。查看绑定方法
     * position 外部联系人的职位，如果外部企业或用户选择隐藏职位，则不返回，仅当联系人类型是企业微信用户时有此字段
     * corp_name 外部联系人所在企业的简称，仅当联系人类型是企业微信用户时有此字段
     * corp_full_name 外部联系人所在企业的主体名称，仅当联系人类型是企业微信用户时有此字段
     * external_profile 外部联系人的自定义展示信息，可以有多个字段和多种类型，包括文本，网页和小程序，仅当联系人类型是企业微信用户时有此字段，字段详情见对外属性；
     * follow_user.userid 添加了此外部联系人的企业成员userid
     * follow_user.remark 该成员对此外部联系人的备注
     * follow_user.description 该成员对此外部联系人的描述
     * follow_user.createtime 该成员添加此外部联系人的时间
     * follow_user.tags.group_name 该成员添加此外部联系人所打标签的分组名称（标签功能需要企业微信升级到2.7.5及以上版本）
     * follow_user.tags.tag_name 该成员添加此外部联系人所打标签名称
     * follow_user.tags.type 该成员添加此外部联系人所打标签类型, 1-企业设置, 2-用户自定义
     * follow_user.remark_corp_name 该成员对此客户备注的企业名称
     * follow_user.remark_mobiles 该成员对此客户备注的手机号码，第三方不可获取
     * follow_user.state 该成员添加此客户的渠道，由用户通过创建「联系我」方式指定
     * 如果外部联系人为微信用户，则返回外部联系人的名称为其微信昵称；如果外部联系人为企业微信用户，则会按照以下优先级顺序返回：此外部联系人或管理员设置的昵称、认证的实名和账号名称。
     * 关于返回的unionid，如果是第三方应用调用该接口，则返回的unionid是该第三方服务商所关联的微信开放者帐号下的unionid。也就是说，同一个企业客户，企业自己调用，与第三方服务商调用，所返回的unionid不同；不同的服务商调用，所返回的unionid也不同。
     */
    public function get($external_userid)
    {
        $params = array();
        $params['external_userid'] = $external_userid;
        $rst = $this->_request->get($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改客户备注信息
     * 调试工具
     * 企业可通过此接口修改指定用户添加的客户的备注信息。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/remark?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "userid":"zhangsan",
     * "external_userid":"woAJ2GCAAAd1asdasdjO4wKmE8Aabj9AAA",
     * "remark":"备注信息",
     * "description":"描述信息",
     * "remark_company":"腾讯科技",
     * "remark_mobiles":[
     * "13800000001",
     * "13800000002"
     * ],
     * "remark_pic_mediaid":"MEDIAID"
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 是 企业成员的userid
     * external_userid 是 外部联系人userid
     * remark 否 此用户对外部联系人的备注
     * description 否 此用户对外部联系人的描述
     * remark_company 否 此用户对外部联系人备注的所属公司名称
     * remark_mobiles 否 此用户对外部联系人备注的手机号
     * remark_pic_mediaid 否 备注图片的mediaid，
     * remark_company只在此外部联系人为微信用户时有效。
     * remark，description，remark_company，remark_mobiles和remark_pic_mediaid不可同时为空。
     * 如果填写了remark_mobiles，将会覆盖旧的备注手机号。
     * 如果要清除所有备注手机号,请在remark_mobiles填写一个空字符串(“”)。
     * remark_pic_mediaid可以通过素材管理接口获得。
     *
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 第三方调用时，应用需具有外部联系人管理权限。
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
    public function remark(\Weixin\Qy\Model\ExternalContact\Remark $remark)
    {
        $params = $remark->getParams();
        $rst = $this->_request->post($this->_url . 'remark', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取企业标签库
     * 企业可通过此接口获取企业客户标签详情。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_corp_tag_list?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "tag_id": [
     * "etXXXXXXXXXX",
     * "etYYYYYYYYYY"
     * ]
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tag_id 否 要查询的标签id，如果不填则获取该企业的所有客户标签，目前暂不支持标签组id
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "tag_group": [{
     * "group_id": "TAG_GROUPID1",
     * "group_name": "GOURP_NAME",
     * "create_time": 1557838797,
     * "order": 1,
     * "deleted": false,
     * "tag": [{
     * "id": "TAG_ID1",
     * "name": "NAME1",
     * "create_time": 1557838797,
     * "order": "1",
     * "deleted": false
     * },
     * {
     * "id": "TAG_ID2",
     * "name": "NAME2",
     * "create_time": 1557838797,
     * "order": "2",
     * "deleted": true
     * }
     * ]
     * }]
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * tag_group 标签组列表
     * tag_group.group_id 标签组id
     * tag_group.group_name 标签组名称
     * tag_group.create_time 标签组创建时间
     * tag_group.order 标签组排序的次序值，order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag_group.deleted 标签组是否已经被删除，只在指定tag_id进行查询时返回
     * tag_group.tag 标签组内的标签列表
     * tag_group.tag.id 标签id
     * tag_group.tag.name 标签名称
     * tag_group.tag.create_time 标签创建时间
     * tag_group.tag.order 标签排序的次序值，order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag_group.tag.deleted 标签是否已经被删除，只在指定tag_id进行查询时返回
     */
    public function getCorpTagList(array $tag_id)
    {
        $params = array();
        $params['tag_id'] = $tag_id;
        $rst = $this->_request->post($this->_url . 'get_corp_tag_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 添加企业客户标签
     * 企业可通过此接口向客户标签库中添加新的标签组和标签。
     * 暂不支持第三方调用。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_corp_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "group_id": "GROUP_ID",
     * "group_name": "GROUP_NAME",
     * "order": 1,
     * "tag": [{
     * "name": "TAG_NAME_1",
     * "order": 1
     * },
     * {
     * "name": "TAG_NAME_2",
     * "order": 2
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * group_id 否 标签组id
     * group_name 否 标签组名称，最长为30个字符
     * order 否 标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag.name 是 添加的标签名称，最长为30个字符
     * tag.order 否 标签次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * 注意:
     * 如果要向指定的标签组下添加标签，需要填写group_id参数；如果要创建一个全新的标签组以及标签，则需要通过group_name参数指定新标签组名称，如果填写的groupname已经存在，则会在此标签组下新建标签。
     * 如果填写了group_id参数，则group_name和标签组的order参数会被忽略。
     * 不支持创建空标签组。
     * 标签组内的标签不可同名，如果传入多个同名标签，则只会创建一个。
     *
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "tag_group": {
     * "group_id": "TAG_GROUPID1",
     * "group_name": "GOURP_NAME",
     * "create_time": 1557838797,
     * "order": 1,
     * "tag": [{
     * "id": "TAG_ID1",
     * "name": "NAME1",
     * "create_time": 1557838797,
     * "order": 1
     * },
     * {
     * "id": "TAG_ID2",
     * "name": "NAME2",
     * "create_time": 1557838797,
     * "order": 2
     * }
     * ]
     * }
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * tag_group.group_id 标签组id
     * tag_group.group_name 标签组名称
     * tag_group.create_time 标签组创建时间
     * tag_group.order 标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * tag_group.tag 标签组内的标签列表
     * tag_group.tag.id 新建标签id
     * tag_group.tag.name 新建标签名称
     * tag_group.tag.create_time 标签创建时间
     * tag_group.tag.order 标签次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     */
    public function addCorpTag(\Weixin\Qy\Model\ExternalContact\CorpTag $corpTag)
    {
        $params = $corpTag->getParams();
        $rst = $this->_request->post($this->_url . 'add_corp_tag', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 编辑企业客户标签
     * 企业可通过此接口编辑客户标签/标签组的名称或次序值。
     * 暂不支持第三方调用。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/edit_corp_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "id": "TAG_ID",
     * "name": "NEW_TAG_NAME",
     * "order": 1
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * id 是 标签或标签组的id列表
     * name 否 新的标签或标签组名称，最长为30个字符
     * order 否 标签/标签组的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * 注意:修改后的标签组不能和已有的标签组重名，标签也不能和同一标签组下的其他标签重名。
     *
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
    public function editCorpTag(\Weixin\Qy\Model\ExternalContact\CorpTag $corpTag)
    {
        $params = $corpTag->getParams();
        $rst = $this->_request->post($this->_url . 'edit_corp_tag', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除企业客户标签
     * 企业可通过此接口删除客户标签库中的标签，或删除整个标签组。
     * 暂不支持第三方调用。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/del_corp_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例:
     *
     * {
     * "tag_id": [
     * "TAG_ID_1",
     * "TAG_ID_2"
     * ],
     * "group_id": [
     * "GROUP_ID_1",
     * "GROUP_ID_2"
     * ]
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tag_id 否 标签的id列表
     * group_id 否 标签组的id列表
     * tag_id和group_id不可同时为空。
     * 如果一个标签组下所有的标签均被删除，则标签组会被自动删除。
     *
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
    public function deleteCorpTag($tag_id, $group_id)
    {
        $params = array();
        if (empty($tag_id) && empty($group_id)) {
            throw new \Exception('tag_id和group_id不可同时为空');
        }
        if (!empty($tag_id)) {
            $params['tag_id'] = $tag_id;
        }
        if (!empty($group_id)) {
            $params['group_id'] = $group_id;
        }
        $rst = $this->_request->post($this->_url . 'del_corp_tag', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 编辑客户企业标签
     * 调试工具
     * 企业可通过此接口为指定成员的客户添加上由企业统一配置的标签。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/mark_tag?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "userid":"zhangsan",
     * "external_userid":"woAJ2GCAAAd1NPGHKSD4wKmE8Aabj9AAA",
     * "add_tag":["TAGID1","TAGID2"],
     * "remove_tag":["TAGID3","TAGID4"]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 是 添加外部联系人的userid
     * external_userid 是 外部联系人userid
     * add_tag 否 要标记的标签列表
     * remove_tag 否 要移除的标签列表
     * 请确保external_userid是userid的外部联系人。
     * add_tag和remove_tag不可同时为空。
     * 同一个标签组下现已支持多个标签
     *
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 第三方调用时，应用需具有外部联系人管理权限。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function markTag($userid, $external_userid, $add_tag, $remove_tag)
    {
        $params = array();
        $params['userid'] = $userid;
        $params['external_userid'] = $external_userid;
        if (empty($add_tag) && empty($remove_tag)) {
            throw new \Exception('add_tag和remove_tag不可同时为空');
        }
        if (!empty($add_tag)) {
            $params['add_tag'] = $add_tag;
        }
        if (!empty($remove_tag)) {
            $params['remove_tag'] = $remove_tag;
        }
        $rst = $this->_request->post($this->_url . 'mark_tag', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 添加企业群发消息任务
     * 调试工具
     * 企业可通过此接口添加企业群发消息的任务并通知客服人员发送给相关客户或客户群。（注：企业微信终端需升级到2.7.5版本及以上）
     * 注意：调用该接口并不会直接发送消息给客户/客户群，需要相关的客服人员操作以后才会实际发送（客服人员的企业微信需要升级到2.7.5及以上版本）
     * 同一个企业每个自然月内仅可针对一个客户/客户群发送4条消息，超过限制的用户将会被忽略。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/add_msg_template?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "chat_type":"single",
     * "external_userid": [
     * "woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
     * "wmqfasd1e1927831123109rBAAAA"
     * ],
     * "sender":"zhangsan",
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
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * chat_type 否 群发任务的类型，默认为single，表示发送给客户，group表示发送给客户群
     * external_userid 否 客户的外部联系人id列表，仅在chat_type为single时有效，不可与sender同时为空，最多可传入1万个客户
     * sender 否 发送企业群发消息的成员userid，当类型为发送给客户群时必填
     * text.content 否 消息文本内容，最多4000个字节
     * image.media_id 是 图片的media_id
     * link.title 是 图文消息标题
     * link.picurl 否 图文消息封面的url
     * link.desc 否 图文消息的描述，最多512个字节
     * link.url 是 图文消息的链接
     * miniprogram.title 是 小程序消息标题，最多64个字节
     * miniprogram.pic_media_id 是 小程序消息封面的mediaid，封面图建议尺寸为520*416
     * miniprogram.appid 是 小程序appid，必须是关联到企业的小程序应用
     * miniprogram.page 是 小程序page路径
     * text、image、link和miniprogram四者不能同时为空；
     * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
     * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
     * media_id可以通过素材管理接口获得。
     *
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 自建应用只能给应用可见范围内的成员进行推送。
     * 第三方应用不可调用
     * 当只提供sender参数时，相当于选取了这个成员所有的客户。
     * 注意：2019-8-1之后，取消了 “无法向未回复消息的客户发送企业群发消息” 的限制。
     */
    public function addMsgTemplate(\Weixin\Qy\Model\ExternalContact\MsgTemplate $msgTemplate)
    {
        $params = $msgTemplate->getParams();
        $rst = $this->_request->post($this->_url . 'add_msg_template', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取企业群发消息发送结果
     * 调试工具
     * 企业可通过该接口获取到添加企业群发消息任务的群发发送结果。
     *
     * 请求方式:POST(HTTPS)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_group_msg_result?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "msgid": "msgGCAAAXtWyujaWJHDDGi0mACAAAA"
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * msgid 是 群发消息的id，通过添加企业群发消息模板接口返回
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 第三方应用不可调用。
     * 自建应用调用，只会返回应用可见范围内用户的发送情况。
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "check_status": 1,
     * "detail_list": [
     * {
     * "external_userid": "wmqfasd1e19278asdasAAAA",
     * "userid": "zhangsan",
     * "status": 1,
     * "send_time": 1552536375
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * check_status 模板消息的审核状态 0-审核中 1-审核成功 2-审核失败
     * detail_list.external_userid 外部联系人userid
     * detail_list.userid 企业服务人员的userid
     * detail_list.status 发送状态 0-未发送 1-已发送 2-因客户不是好友导致发送失败 3-因客户已经收到其他群发消息导致发送失败
     * detail_list.send_time 发送时间，发送状态为1时返回
     */
    public function getGroupMsgResult($msgid)
    {
        $params = array();
        $params['msgid'] = $msgid;
        $rst = $this->_request->post($this->_url . 'get_group_msg_result', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送新客户欢迎语
     * 调试工具
     * 企业微信在向企业推送添加外部联系人事件时，会额外返回一个welcome_code，企业以此为凭据调用接口，即可通过成员向新添加的客户发送个性化的欢迎语。
     * 为了保证用户体验以及避免滥用，企业仅可在收到相关事件后20秒内调用，且只可调用一次。
     * 如果企业已经在管理端为相关成员配置了可用的欢迎语，则推送添加外部联系人事件时不会返回welcome_code。
     * 每次添加新客户时可能有多个企业自建应用/第三方应用收到带有welcome_code的回调事件，但仅有最先调用的可以发送成功。后续调用将返回41051（externaluser has started chatting）错误，请用户根据实际使用需求，合理设置应用可见范围，避免冲突。
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/send_welcome_msg?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "welcome_code":"CALLBACK_CODE",
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
     * "appid": "wx8bd80126147dfAAA",
     * "page": "/path/index"
     * }
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * welcome_code 是 通过添加外部联系人事件推送给企业的发送欢迎语的凭证，有效期为20秒
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
     * text、image、link和miniprogram四者不能同时为空；
     * text与另外三者可以同时发送，此时将会以两条消息的形式触达客户
     * image、link和miniprogram只能有一个，如果三者同时填，则按image、link、miniprogram的优先顺序取参，也就是说，如果image与link同时传值，则只有image生效。
     * media_id可以通过素材管理接口获得。
     *
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 第三方应用需要拥有「企业客户」权限，且企业成员处于相关应用的可见范围内。
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function sendWelcomeMsg(\Weixin\Qy\Model\ExternalContact\WelcomeMsg $welcomeMsg)
    {
        $params = $welcomeMsg->getParams();
        $rst = $this->_request->post($this->_url . 'send_welcome_msg', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取离职成员的客户列表
     * 调试工具
     * 企业和第三方可通过此接口，获取所有离职成员的客户列表，并可进一步调用离职成员的外部联系人再分配接口将这些客户重新分配给其他企业成员。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_unassigned_list?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "page_id":0,
     * "page_size":100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * page_id 否 分页查询，要查询页号，从0开始
     * page_size 否 每次返回的最大记录数，默认为1000，最大值为1000
     * 注意:返回数据按离职时间的降序排列，当page_id为1，page_size为100时，表示取第101到第200条记录
     *
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）
     * 第三方应用需拥有“企业客户权限”。
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "info":[
     * {
     * "handover_userid":"zhangsan",
     * "external_userid":"woAJ2GCAAAd4uL12hdfsdasassdDmAAAAA",
     * "dimission_time":1550838571
     * },
     * {
     * "handover_userid":"lisi",
     * "external_userid":"wmAJ2GCAAAzLTI123ghsdfoGZNqqAAAA",
     * "dimission_time":1550661468
     * }
     * ],
     * "is_last":false
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * info.handover_userid 离职成员的userid
     * info.external_userid 外部联系人userid
     * info.dimission_time 成员离职时间
     * is_last 是否是最后一条记录
     */
    public function getUnassignedList($page_id = 0, $page_size = 1000)
    {
        $params = array();
        $params['page_id'] = $page_id;
        $params['page_size'] = $page_size;
        $rst = $this->_request->post($this->_url . 'get_unassigned_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 离职成员的外部联系人再分配
     * 调试工具
     * 企业可通过此接口，将已离职成员的外部联系人分配给另一个成员接替联系。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/transfer?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "external_userid": "woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA",
     * "handover_userid": "zhangsan",
     * "takeover_userid": "lisi"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * external_userid 是 外部联系人的userid，注意不是企业成员的帐号
     * handover_userid 是 离职成员的userid
     * takeover_userid 是 接替成员的userid
     * external_userid必须是handover_userid的客户（即配置了客户联系功能的成员所添加的联系人）。
     *
     * 权限说明：
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 第三方应用需拥有“企业客户权限”。
     * 相关接手的跟进用户必须在此第三方应用或自建应用的可见范围内。
     * 接替成员需要配置了客户联系功能。
     * 接替成员需要在企业微信激活且已经过实名认证。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function transfer($external_userid, $handover_userid, $takeover_userid)
    {
        $params = array();
        $params['external_userid'] = $external_userid;
        $params['handover_userid'] = $handover_userid;
        $params['takeover_userid'] = $takeover_userid;
        $rst = $this->_request->post($this->_url . 'transfer', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取联系客户统计数据
     * 调试工具
     * 企业可通过此接口获取成员联系客户的数据，包括发起申请数、新增客户数、聊天数、发送消息数和删除/拉黑成员的客户数等指标。
     *
     * 请求方式: POST(HTTP)
     *
     * 请求地址:https://qyapi.weixin.qq.com/cgi-bin/externalcontact/get_user_behavior_data?access_token=ACCESS_TOKEN
     *
     * 请求示例
     *
     * {
     * "userid": [
     * "zhangsan",
     * "lisi"
     * ],
     * "partyid":
     * [
     * 1001,
     * 1002
     * ],
     * "start_time":1536508800,
     * "end_time":1536940800
     * }
     * 参数说明:
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * userid 否 用户ID列表
     * partyid 否 部门ID列表
     * start_time 是 数据起始时间
     * end_time 是 数据结束时间
     * userid和partyid不可同时为空;
     * 此接口提供的数据以天为维度，查询的时间范围为[start_time,end_time]，即前后均为闭区间，支持的最大查询跨度为30天；
     * 用户最多可获取最近60天内的数据；
     * 当传入的时间不为0点时间戳时，会向下取整，如传入1554296400(Wed Apr 3 21:00:00 CST 2019)会被自动转换为1554220800（Wed Apr 3 00:00:00 CST 2019）;
     * 如传入多个userid，则表示获取这些成员总体的联系客户数据。
     *
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 第三方应用需拥有“企业客户”权限。
     * 第三方/自建应用调用时传入的userid和partyid要在应用的可见范围内;
     * 返回结果:
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "behavior_data":
     * [
     * {
     * "stat_time":1536508800,
     * "chat_cnt":100,
     * "message_cnt":80,
     * "reply_percentage":60.25,
     * "avg_reply_time":1,
     * "negative_feedback_cnt":0,
     * "new_apply_cnt":6,
     * "new_contact_cnt":5
     * },
     * {
     * "stat_time":1536940800,
     * "chat_cnt":20,
     * "message_cnt":40,
     * "reply_percentage":100,
     * "avg_reply_time":1,
     * "negative_feedback_cnt":0,
     * "new_apply_cnt":6,
     * "new_contact_cnt":5
     * }
     * ]
     * }
     * 参数说明:
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * behavior_data.stat_time 数据日期，为当日0点的时间戳
     * behavior_data.new_apply_cnt 发起申请数，成员通过「搜索手机号」、「扫一扫」、「从微信好友中添加」、「从群聊中添加」、「添加共享、分配给我的客户」、「添加单向、双向删除好友关系的好友」、「从新的联系人推荐中添加」等渠道主动向客户发起的好友申请数量。
     * behavior_data.new_contact_cnt 新增客户数，成员新添加的客户数量。
     * behavior_data.chat_cnt 聊天总数， 成员有主动发送过消息的聊天数，包括单聊和群聊。
     * behavior_data.message_cnt 发送消息数，成员在单聊和群聊中发送的消息总数。
     * behavior_data.reply_percentage 已回复聊天占比，客户主动发起聊天后，成员在一个自然日内有回复过消息的聊天数/客户主动发起的聊天数比例，不包括群聊，仅在确有回复时返回。
     * behavior_data.avg_reply_time 平均首次回复时长，单位为分钟，即客户主动发起聊天后，成员在一个自然日内首次回复的时长间隔为首次回复时长，所有聊天的首次回复总时长/已回复的聊天总数即为平均首次回复时长，不包括群聊，仅在确有回复时返回。
     * behavior_data.negative_feedback_cnt 删除/拉黑成员的客户数，即将成员删除或加入黑名单的客户数。
     */
    public function getUserBehaviorData($userid, $partyid, $start_time, $end_time)
    {
        $params = array();
        $params['userid'] = $userid;
        $params['partyid'] = $partyid;
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;
        $rst = $this->_request->post($this->_url . 'get_user_behavior_data', $params);
        return $this->_client->rst($rst);
    }
}
