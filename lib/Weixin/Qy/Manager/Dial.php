<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 企业微信公费电话
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Dial
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/dial/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取公费电话拨打记录
     * 调试工具
     * 企业可通过此接口，按时间范围拉取成功接通的公费电话拨打记录。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/dial/get_dial_record?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "start_time": 1536508800,
     * "end_time": 1536940800,
     * "offset": 0,
     * "limit": 100
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * start_time 否 查询的起始时间戳
     * end_time 否 查询的结束时间戳
     * offset 否 分页查询的偏移量
     * limit 否 分页查询的每页大小,默认为100条，如该参数大于100则按100处理
     * 请注意，查询的时间范围为[start_time,end_time]，即前后均为闭区间。在两个参数都指定了的情况下，结束时间不得小于开始时间，开始时间也不得早于当前时间，否则会返回600018错误码(无效的起止时间)。
     * 受限于网络传输，起止时间的最大跨度为30天，如超过30天，则以结束时间为基准向前取30天进行查询。
     * 如果未指定起止时间，则默认查询最近30天范围内数据。
     *
     * 权限说明：
     * 企业需要使用公费电话secret所获取的accesstoken来调用（accesstoken如何获取？）；
     * 暂不支持第三方调用
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "record":[
     * {
     * "call_time":1536508800,
     * "total_duration":10,
     * "call_type":1,
     * "caller":
     * {
     * "userid":"tony",
     * "duration":10
     * },
     * "callee":[
     * {
     * "phone":138000800,
     * "duration":10
     * }
     * ]
     * },
     * {
     * "call_time":1536940800,
     * "total_duration":20,
     * "call_type":2,
     * "caller":
     * {
     * "userid":"tony",
     * "duration":10
     * },
     * "callee":[
     * {
     * "phone":138000800,
     * "duration":5
     * },
     * {
     * "userid":"tom",
     * "duration":5
     * }
     * ]
     * }
     * ]
     * }
     * 返回字段说明：
     *
     * 字段名 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * record.call_time 拨出时间
     * record.total_duration 总通话时长，单位为分钟
     * record.call_type 通话类型，1-单人通话 2-多人通话
     * record.caller.userid 主叫用户的userid
     * record.caller.duration 主叫用户的通话时长
     * record.callee.userid 被叫用户的userid，当被叫用户为企业内用户时返回
     * record.callee.phone 被叫用户的号码，当被叫用户为外部用户时返回
     * 通话类型为单人通话时，总通话时长等于单人通话时长，通话类型为多人通话时，总通话时长等于包括主叫用户在内的每个接入用户的通话时长之和。
     */
    public function getDialRecord($start_time, $end_time, $offset = 0, $limit = 100)
    {
        $params = array();
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;
        $params['offset'] = $offset;
        $params['limit'] = min(abs($limit), 100);
        $rst = $this->_request->post($this->_url . 'get_dial_record', $params);
        return $this->_client->rst($rst);
    }
}
