<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 发送应用消息
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Message
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/message/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 发送应用支持推送文本、图片、视频、文件、图文等类型。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * 各个消息类型的具体POST格式请阅后续“消息类型”部分。
     * 如果有在管理端对应用设置“在微工作台中始终进入主页”，应用在微信端只能接收到文本消息，并且文本消息的长度限制为20字节，超过20字节会被截断。同时其他消息类型也会转换为文本消息，提示用户到企业微信查看。
     * 支持id转译，将userid/部门id转成对应的用户名/部门名，目前仅文本/文本卡片/图文/图文（mpnews）这四种消息类型的部分字段支持。具体支持的范围和语法，请查看附录id转译说明。
     * 支持重复消息检查，当指定 "enable_duplicate_check": 1开启: 表示在一定时间间隔内，同样内容（请求json）的消息，不会重复收到；时间间隔可通过duplicate_check_interval指定，默认1800秒。
     *
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "invaliduser" : "userid1|userid2",
     * "invalidparty" : "partyid1|partyid2",
     * "invalidtag": "tagid1|tagid2"
     * }
     * 如果部分接收人无权限或不存在，发送仍然执行，但会返回无效的部分（即invaliduser或invalidparty或invalidtag），常见的原因是接收人不在应用的可见范围内。
     * 如果全部接收人无权限或不存在，则本次调用返回失败，errcode为81013。
     * 返回包中的userid，不区分大小写，统一转为小写
     */
    public function send(\Weixin\Qy\Model\Message\Base $message)
    {
        $params = $message->getParams();
        $rst = $this->_request->post($this->_url . 'send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新任务卡片消息状态
     * 调试工具
     * 接口定义
     * 应用可以发送任务卡片消息，发送之后可再通过接口更新用户任务卡片消息的选择状态。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/message/update_taskcard?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * 请求示例：
     *
     * {
     * "userids" : ["userid1","userid2"],
     * "agentid" : 1,
     * "task_id": "taskid122",
     * "clicked_key": "btn_key123"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * userids 是 企业的成员ID列表（消息接收者，最多支持1000个）。
     * agentid 是 应用的agentid
     * task_id 是 发送任务卡片消息时指定的task_id
     * clicked_key 是 设置指定的按钮为选择状态，需要与发送消息时指定的btn:key一致
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "invaliduser" : ["userid1","userid2"], // 不区分大小写，返回的列表都统一转为小写
     * }
     * 如果部分指定的用户无权限或不存在，更新仍然执行，但会返回无效的部分（即invaliduser），常见的原因是用户不在应用的可见范围内或者不在消息的接收范围内。
     */
    public function updateTaskcard(array $userids, $agentid, $task_id, $clicked_key)
    {
        $params = array();
        $params['userids'] = $userids;
        $params['agentid'] = $agentid;
        $params['task_id'] = $task_id;
        $params['clicked_key'] = $clicked_key;
        $rst = $this->_request->post($this->_url . 'update_taskcard', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询应用消息发送统计
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/message/get_statistics?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "time_type": 0
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * time_type 否 查询哪天的数据，0：当天；1：昨天。默认为0。
     * 权限说明：
     * 无
     *
     * 返回结果 ：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "statistics": [
     * {
     * "agentid": 1000002,
     * "app_name": "应用1",
     * "count": 101
     * }，
     * {
     * "agentid": 1000003,
     * "app_name": "应用2",
     * "count": 102
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * statistics.agentid 应用id
     * statistics.app_name 应用名
     * statistics.count 发消息成功人次
     */
    public function getStatistics($time_type = 0)
    {
        $params = array();
        $params['time_type'] = $time_type;
        $rst = $this->_request->post($this->_url . 'get_statistics', $params);
        return $this->_client->rst($rst);
    }
}
