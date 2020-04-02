<?php

namespace Weixin\Qy\Manager\ExternalContact;

use Weixin\Qy\Client;

/**
 * 客户群列消息发送
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class GroupChat
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取客户群列表
     * 调试工具
     * 该接口用于获取配置过客户群管理的客户群列表。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/list?access_token=ACCESS_TOKEN
     *
     * {
     * "status_filter": 0,
     * "owner_filter": {
     * "userid_list": ["samueldeng"],
     * "partyid_list": [7]
     * },
     * "offset": 0,
     * "limit": 100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * status_filter 否 群状态过滤。
     * 0 - 普通列表
     * 1 - 离职待继承
     * 2 - 离职继承中
     * 3 - 离职继承完成
     *
     * 默认为0
     * owner_filter 否 群主过滤。如果不填，表示获取全部群主的数据
     * userid_list 否 用户ID列表。最多100个
     * partyid_list 否 部门ID列表。最多100个
     * offset 是 分页，偏移量
     * limit 是 分页，预期请求的数据量，取值范围 1 ~ 1000
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "group_chat_list": [{
     * "chat_id": "wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
     * "status": 0
     * }, {
     * "chat_id": "wrOgQhDgAAcwMTB7YmDkbeBsAAAA",
     * "status": 0
     * }]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * group_chat_list 客户群列表
     * chat_id 客户群ID
     * status 客户群状态。
     * 0 - 正常
     * 1 - 跟进人离职
     * 2 - 离职继承中
     * 3 - 离职继承完成
     */
    public function list($status_filter, $owner_filter, $offset = 0, $limit = 1000)
    {
        $params = array();
        $params['status_filter'] = $status_filter;
        $params['owner_filter'] = $owner_filter;
        $params['offset'] = $offset;
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取客户群详情
     * 调试工具
     * 通过客户群ID，获取详情。包括群名、群成员列表、群成员入群时间、入群方式。（客户群是由具有客户群使用权限的成员创建的外部群）
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/get?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * {
     * "chat_id":"wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA"
     * }
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * chat_id 是 客户群ID
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "group_chat": {
     * "chat_id": "wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA",
     * "name": "销售客服群",
     * "owner": "ZhuShengBen",
     * "create_time": 1572505490,
     * "notice" : "文明沟通，拒绝脏话",
     * "member_list": [{
     * "userid": "abel",
     * "type": 1,
     * "join_time": 1572505491,
     * "join_scene": 1
     * }, {
     * "userid": "sam",
     * "type": 1,
     * "join_time": 1572505491,
     * "join_scene": 1
     * }, {
     * "userid": "wmOgQhDgAAuXFJGwbve4g4iXknfOAAAA",
     * "type": 2,
     * "join_time": 1572505491,
     * "join_scene": 1
     * }]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * group_chat 客户群详情
     * chat_id 客户群ID
     * name 群名
     * owner 群主ID
     * create_time 群的创建时间
     * notice 群公告
     * member_list 群成员列表
     * userid 群成员id
     * type 成员类型。
     * 1 - 企业成员
     * 2 - 外部联系人
     * join_time 入群时间
     * join_scene 入群方式。
     * 1 - 由成员邀请入群（直接邀请入群）
     * 2 - 由成员邀请入群（通过邀请链接入群）
     * 3 - 通过扫描群二维码入群
     */
    public function get($chat_id)
    {
        $params = array();
        $params['chat_id'] = $chat_id;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 调试工具
     * 企业可通过此接口，将已离职成员为群主的群，分配给另一个客服成员。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/transfer?access_token=ACCESS_TOKEN
     *
     * {
     * "chat_id_list" : ["wrOgQhDgAAcwMTB7YmDkbeBsgT_AAAA", "wrOgQhDgAAMYQiS5ol9G7gK9JVQUAAAA"],
     * "new_owner" : "zhangsan"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * chat_id_list 是 需要转群主的客户群ID列表。取值范围： 1 ~ 100
     * new_owner 是 新群主ID
     * 注意：：
     *
     * 群主离职了的客户群，才可继承
     * 继承给的新群主，必须是配置了客户联系功能的成员
     * 继承给的新群主，必须有设置实名
     * 继承给的新群主，必须有激活企业微信
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "failed_chat_list": [
     * {
     * "chat_id": "wrOgQhDgAAcwMTB7YmDkbeBsgT_KAAAA",
     * "errcode": 90500,
     * "errmsg": "the owner of this chat is not resigned"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * failed_chat_list 没能成功继承的群
     * failed_chat_list.chat_id 没能成功继承的群ID
     * failed_chat_list.errcode 没能成功继承的群，错误码
     * failed_chat_list.errmsg 没能成功继承的群，错误描述
     */
    public function transfer($chat_id_list, $new_owner)
    {
        $params = array();
        $params['chat_id_list'] = $chat_id_list;
        $params['new_owner'] = $new_owner;
        $rst = $this->_request->post($this->_url . 'transfer', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 调试工具
     * 获取指定日期全天的统计数据。注意，企业微信仅存储60天的数据。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/externalcontact/groupchat/statistic?access_token=ACCESS_TOKEN
     *
     * {
     * "day_begin_time": 1572505490,
     * "owner_filter": {
     * "userid_list": ["zhangsan"],
     * "partyid_list": [7]
     * },
     * "order_by": 2,
     * "order_asc": 0,
     * "offset" : 0,
     * "limit" : 1000
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * day_begin_time 是 开始时间，填当天开始的0分0秒（否则系统自动处理为当天的0分0秒）。取值范围：昨天至前60天
     * owner_filter 否 群主过滤，如果不填，表示获取全部群主的数据
     * userid_list 否 群主ID列表。最多100个
     * partyid_list 否 群主所属部门ID列表。最多100个
     * order_by 否 排序方式。
     * 1 - 新增群的数量
     * 2 - 群总数
     * 3 - 新增群人数
     * 4 - 群总人数
     *
     * 默认为1
     * order_asc 否 是否升序。0-否；1-是。默认降序
     * offset 否 分页，偏移量, 默认为0
     * limit 否 分页，预期请求的数据量，默认为500，取值范围 1 ~ 1000
     * 权限说明:
     *
     * 企业需要使用“客户联系”secret或配置到“可调用应用”列表中的自建应用secret所获取的accesstoken来调用（accesstoken如何获取？）。
     * 暂不支持第三方调用。
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "total": 1,
     * "next_offset": 1,
     * "items": [{
     * "owner": "zhangsan",
     * "data": {
     * "new_chat_cnt": 2,
     * "chat_total": 2,
     * "chat_has_msg": 0,
     * "new_member_cnt": 0,
     * "member_total": 6,
     * "member_has_msg": 0,
     * "msg_total": 0
     * }
     * }]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * total 命中过滤条件的记录总个数
     * next_offset 当前分页的下一个offset。当next_offset和total相等时，说明已经取完所有
     * items 记录列表。表示某个群主所拥有的客户群的统计数据
     * owner 群主ID
     * data 详情
     * new_chat_cnt 新增客户群数量
     * chat_total 截至当天客户群总数量
     * chat_has_msg 截至当天有发过消息的客户群数量
     * new_member_cnt 客户群新增群人数。
     * member_total 截至当天客户群总人数
     * member_has_msg 截至当天有发过消息的群成员数
     * msg_total 截至当天客户群消息总数
     */
    public function statistic($day_begin_time, $owner_filter, $order_by, $order_asc = 0, $offset = 0, $limit = 1000)
    {
        $params = array();
        $params['day_begin_time'] = $day_begin_time;
        $params['owner_filter'] = $owner_filter;
        $params['order_by'] = $order_by;
        $params['order_asc'] = $order_asc;
        $params['offset'] = $offset;
        $params['limit'] = $limit;
        $rst = $this->_request->post($this->_url . 'transfer', $params);
        return $this->_client->rst($rst);
    }
}
