<?php

namespace Weixin\Qy\Manager\Oa;

use Weixin\Qy\Client;

/**
 * 日历管理
 * 企业通过日程相关接口，可以很方便的将企业已有系统的会议、日程或提醒，同步到企业微信日历
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Calendar
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/oa/calendar/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建日历
     * 该接口用于通过应用在企业内创建一个日历。
     *
     * 注: 企业微信需要更新到3.0.2及以上版本
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/oa/calendar/add?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "calendar" : {
     * "organizer" : "userid1",
     * "summary" : "test_summary",
     * "color" : "#FF3030",
     * "description" : "test_describe",
     * "shares" : [
     * {
     * "userid" : "userid2"
     * },
     * {
     * "userid" : "userid3"
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * calendar 是 日历信息
     * organizer 是 指定的组织者userid。注意该字段指定后不可更新
     * summary 是 日历标题。1 ~ 128 字符
     * color 是 日历在终端上显示的颜色，RGB颜色编码16进制表示，例如：”#0000FF” 表示纯蓝色
     * description 否 日历描述。0 ~ 512 字符
     * shares 否 日历共享成员列表。最多2000人
     * userid 是 日历共享成员的id
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg" : "ok",
     * "cal_id":"wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误码说明
     * cal_id 日历ID
     */
    public function add(\Weixin\Qy\Model\Oa\Calendar $calendar)
    {
        $params = $calendar->getParams();
        $rst = $this->_request->post($this->_url . 'add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新日历
     * 该接口用于修改指定日历的信息。
     *
     * 注意，更新操作是覆盖式，而不是增量式
     * 企业微信需要更新到3.0.2及以上版本
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/oa/calendar/update?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "calendar" : {
     * "cal_id":"wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA",
     * "summary" : "test_summary",
     * "color" : "#FF3030",
     * "description" : "test_describe_1",
     * "shares" : [
     * {
     * "userid" : "userid1"
     * },
     * {
     * "userid" : "userid2"
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * calendar 是 日历信息
     * cal_id 是 日历ID
     * summary 是 日历标题。1 ~ 128 字符
     * color 是 日历颜色，RGB颜色编码16进制表示，例如：”#0000FF” 表示纯蓝色
     * description 否 日历描述。0 ~ 512 字符
     * shares 否 日历共享成员列表。最多2000人
     * userid 是 日历共享成员的id
     * 注意, 不可更新组织者。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg" : "ok"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误码说明
     */
    public function update(\Weixin\Qy\Model\Oa\Calendar $calendar)
    {
        $params = $calendar->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取日历
     * 该接口用于获取应用在企业内创建的日历信息。
     *
     * 注: 企业微信需要更新到3.0.2及以上版本
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/oa/calendar/get?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "cal_id_list": ["wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA"]
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * cal_id_list 是 日历ID列表，调用创建日历接口后获得。一次最多可获取1000条
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "calendar_list": [
     * {
     * "cal_id": "wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA",
     * "organizer": "userid1",
     * "summary" : "test_summary",
     * "color" : "#FF3030",
     * "description": "test_describe_1",
     * "shares": [
     * {
     * "userid": "userid2"
     * },
     * {
     * "userid": "userid1"
     * }
     * ]
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误码说明
     * calendar_list 日历列表
     * cal_id 日历ID
     * organizer 指定的组织者userid
     * summary 日历标题。1 ~ 128 字符
     * color 日历颜色，RGB颜色编码16进制表示，例如：”#0000FF” 表示纯蓝色
     * description 日历描述。0 ~ 512 字符
     * shares 日历共享成员列表。最多2000人
     * userid 日历共享成员的id
     */
    public function get(array $cal_id_list)
    {
        $params = array();
        $params['cal_id_list'] = $cal_id_list;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除日历
     * 该接口用于删除指定日历。
     *
     * 注: 企业微信需要更新到3.0.2及以上版本
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/oa/calendar/del?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "cal_id":"wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * cal_id 是 日历ID
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg" : "ok"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误码说明
     */
    public function delete($cal_id)
    {
        $params = array();
        $params['cal_id'] = $cal_id;
        $rst = $this->_request->post($this->_url . 'del', $params);
        return $this->_client->rst($rst);
    }
}
