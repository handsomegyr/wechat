<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 发送消息到群聊会话
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Appchat
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/appchat/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建群聊会话
     * 调试工具
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/appchat/create?access_token=ACCESS_TOKEN
     *
     * 请求包体:
     *
     * {
     * "name" : "NAME",
     * "owner" : "userid1",
     * "userlist" : ["userid1", "userid2", "userid3"],
     * "chatid" : "CHATID"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * name 否 群聊名，最多50个utf8字符，超过将截断
     * owner 否 指定群主的id。如果不指定，系统会随机从userlist中选一人作为群主
     * userlist 是 群成员id列表。至少2人，至多500人
     * chatid 否 群聊的唯一标志，不能与已有的群重复；字符串类型，最长32个字符。只允许字符0-9及字母a-zA-Z。如果不填，系统会随机生成群id
     * 限制说明：
     * 只允许企业自建应用调用，且应用的可见范围必须是根部门；
     * 群成员人数不可超过管理端配置的“群成员人数上限”，且最大不可超过500人；
     * 每企业创建群数不可超过1000/天；
     *
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "chatid" : "CHATID"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * chatid 群聊的唯一标志
     * 注意：刚创建的群，如果没有下发消息，在企业微信不会出现该群。
     */
    public function create(\Weixin\Qy\Model\Appchat $appchat)
    {
        $params = $appchat->getParams();
        $rst = $this->_request->post($this->_url . 'create', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 修改群聊会话
     * 调试工具
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/appchat/update?access_token=ACCESS_TOKEN
     *
     * 请求包体:
     *
     * {
     * "chatid" : "CHATID",
     * "name" : "NAME",
     * "owner" : "userid2",
     * "add_user_list" : ["userid1", "userid2", "userid3"],
     * "del_user_list" : ["userid3", "userid4"]
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * chatid 是 群聊id
     * name 否 新的群聊名。若不需更新，请忽略此参数。最多50个utf8字符，超过将截断
     * owner 否 新群主的id。若不需更新，请忽略此参数
     * add_user_list 否 添加成员的id列表
     * del_user_list 否 踢出成员的id列表
     * 限制说明：
     * 只允许企业自建应用调用，且应用的可见范围必须是根部门；
     * chatid所代表的群必须是该应用所创建；
     * 群成员人数不可超过500人；
     * 每企业变更群的次数不可超过100/小时；
     *
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function update(\Weixin\Qy\Model\Appchat $appchat)
    {
        $params = $appchat->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取群聊会话
     * 调试工具
     * 请求方式： GET（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/appchat/get?access_token=ACCESS_TOKEN&chatid=CHATID
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * chatid 是 群聊id
     * 权限说明：
     * 只允许企业自建应用调用，且应用的可见范围必须是根部门；
     * chatid所代表的群必须是该应用所创建；
     * 第三方不可调用。
     *
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok"
     * "chat_info" : {
     * "chatid" : "CHATID",
     * "name" : "NAME",
     * "owner" : "userid2",
     * "userlist" : ["userid1", "userid2", "userid3"]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * chat_info 群聊信息
     * chatid 群聊唯一标志
     * name 群聊名
     * owner 群主id
     * userlist 群成员id列表
     */
    public function get($chatid)
    {
        $params = array();
        $params['chatid'] = $chatid;
        $rst = $this->_request->get($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 应用推送消息
     * 调试工具
     * 接口定义
     * 消息类型
     * 文本消息
     * 图片消息
     * 语音消息
     * 视频消息
     * 文件消息
     * 文本卡片消息
     * 图文消息
     * 图文消息（mpnews）
     * markdown消息
     * 接口定义
     * 应用支持推送文本、图片、视频、文件、图文等类型。
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/appchat/send?access_token=ACCESS_TOKEN
     *
     * 请求包体:
     *
     * 各个消息类型的具体POST格式参考后面消息类型说明
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * 限制说明：
     * 只允许企业自建应用调用，且应用的可见范围必须是根部门；
     * chatid所代表的群必须是该应用所创建；
     * 每企业消息发送量不可超过2万人次/分，不可超过20万人次/小时（若群有100人，每发一次消息算100人次）；
     * 每个成员在群中收到的应用消息不可超过200条/分，1万条/天，超过会被丢弃（接口不会报错）；
     *
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * }
     */
    public function send(\Weixin\Qy\Model\AppchatMsg\Base $message)
    {
        $params = $message->getParams();
        $rst = $this->_request->post($this->_url . 'send', $params);
        return $this->_client->rst($rst);
    }
}
