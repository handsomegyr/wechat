<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 互联企业消息推送
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class LinkedcorpMessage
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/message/send/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 互联企业的应用支持推送文本、图片、视频、文件、图文等类型。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/linkedcorp/message/send?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * 各个消息类型的具体POST格式参考以下文档。
     *
     * 返回示例：
     *
     * {
     * "errcode" : 0,
     * "errmsg" : "ok",
     * "invaliduser" : ["userid1","userid2","CorpId1/userid1","CorpId2/userid2"], // 不区分大小写，返回的列表都统一转为小写
     * "invalidparty" : ["partyid1","partyid2","LinkedId1/partyid1","LinkedId2/partyid2"],
     * "invalidtag":["tagid1","tagid2"]
     * }
     * 如果部分接收人无权限或不存在，发送仍然执行，但会返回无效的部分（即invaliduser或invalidparty），常见的原因是接收人不在应用的可见范围内。
     */
    public function send(\Weixin\Qy\Model\LinkedcorpMsg\Base $message)
    {
        $params = $message->getParams();
        $rst = $this->_request->post($this->_url . 'send', $params);
        return $this->_client->rst($rst);
    }
}
