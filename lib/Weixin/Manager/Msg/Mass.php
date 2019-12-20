<?php
namespace Weixin\Manager\Msg;

use Weixin\Client;

/**
 * 群发消息接口
 *
 * @author guoyongrong <handsomegyr@126.com>
 *        
 *         二、群发接口新增 send_ignore_reprint 参数
 *        
 *         群发接口新增 send_ignore_reprint 参数，开发者可以对群发接口的 send_ignore_reprint 参数进行设置，指定待群发的文章被判定为转载时，是否继续群发。
 *        
 *         当 send_ignore_reprint 参数设置为1时，文章被判定为转载时，且原创文允许转载时，将继续进行群发操作。
 *        
 *         当 send_ignore_reprint 参数设置为0时，文章被判定为转载时，将停止群发操作。
 *        
 *         send_ignore_reprint 默认为0。
 *        
 *         群发操作的相关返回码，可以参考全局返回码说明文档。
 *        
 *         使用 clientmsgid 参数，避免重复推送
 *         一、群发接口新增 clientmsgid 参数，开发者调用群发接口时可以主动设置 clientmsgid 参数，避免重复推送。
 *        
 *         群发时，微信后台将对 24 小时内的群发记录进行检查，如果该 clientmsgid 已经存在一条群发记录，则会拒绝本次群发请求，返回已存在的群发msgid，开发者可以调用“查询群发消息发送状态”接口查看该条群发的状态。
 *        
 *         二、新增返回码
 *        
 *         返回码 结果
 *         45065 相同 clientmsgid 已存在群发记录，返回数据中带有已存在的群发任务的 msgid
 *         45066 相同 clientmsgid 重试速度过快，请间隔1分钟重试
 *         45067 clientmsgid 长度超过限制
 *         三、接口示例及参数描述
 *        
 *         {
 *         "filter":{
 *         "is_to_all":false,
 *         "tag_id":2
 *         },
 *         "mpnews":{
 *         "media_id":"123dsdajkasd231jhksad"
 *         },
 *         "msgtype":"mpnews",
 *         "send_ignore_reprint":0,
 *         "clientmsgid":"send_tag_2"
 *         }
 *         参数说明
 *        
 *         参数 是否必须 说明
 *         clientmsgid 否 开发者侧群发msgid，长度限制64字节，如不填，则后台默认以群发范围和群发内容的摘要值做为clientmsgid
 *         返回说明
 *        
 *         clientmsgid 冲突时的返回示例： {
 *         "errcode":45065,
 *         "errmsg":"clientmsgid exist",
 *         "msg_id":123456
 *         }
 *        
 *        
 */
class Mass
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 根据分组进行群发
     *
     * @param array $params            
     * @throws Exception
     * @return array
     */
    public function sendAll($params)
    {
        $rst = $this->_request->post($this->_url . 'message/mass/sendall', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送文本消息
     *
     * @param string $group_id            
     * @param string $content            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendTextByGroup($group_id, $content, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $params = $this->buildParamsByMsgType('text', $content, "", "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送文本消息
     *
     * @param string $group_id            
     * @param string $content            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendTextByTag($tag_id, $content, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('text', $content, "", "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        return $this->sendAll($ret);
    }

    /**
     * 发送图片消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendImageByGroup($group_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $params = $this->buildParamsByMsgType('image', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送图片消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendImageByTag($tag_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('image', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 发送语音消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendVoiceByGroup($group_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('voice', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送语音消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendVoiceByTag($tag_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('voice', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 发送视频消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendVideoByGroup($group_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('mpvideo', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 发送视频消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendVideoByTag($tag_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('mpvideo', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 发送图文消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendGraphTextByGroup($group_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('mpnews', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 发送图文消息
     *
     * @param string $tag_id            
     * @param string $media_id            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendGraphTextByTag($tag_id, $media_id, $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('mpnews', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 发送卡券消息
     *
     * @param string $group_id            
     * @param string $card_id            
     * @param array $card_ext            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendWxcardByGroup($group_id, $card_id, array $card_ext = array(), $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('wxcard', "", "", $card_id, $card_ext, $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送卡券消息
     *
     * @param string $group_id            
     * @param string $card_id            
     * @param array $card_ext            
     * @param boolean $is_to_all            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendWxcardByTag($tag_id, $card_id, array $card_ext = array(), $is_to_all = false, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['filter']['group_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        
        $params = $this->buildParamsByMsgType('wxcard', "", "", $card_id, $card_ext, $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->sendAll($ret);
    }

    /**
     * 根据OpenID列表群发
     *
     * @param array $params            
     * @throws Exception
     * @return array
     */
    public function send($params)
    {
        $rst = $this->_request->post($this->_url . 'message/mass/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送文本消息
     *
     * @param array $toUsers            
     * @param string $content            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendTextByOpenid(array $toUsers, $content, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        
        $params = $this->buildParamsByMsgType('text', $content, "", "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        return $this->send($ret);
    }

    /**
     * 发送图片消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendImageByOpenid(array $toUsers, $media_id, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $params = $this->buildParamsByMsgType('image', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->send($ret);
    }

    /**
     * 发送语音消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendVoiceByOpenid(array $toUsers, $media_id, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        
        $params = $this->buildParamsByMsgType('voice', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->send($ret);
    }

    /**
     * 发送视频消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendVideoByOpenid(array $toUsers, $media_id, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        
        $params = $this->buildParamsByMsgType('mpvideo', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->send($ret);
    }

    /**
     * 发送图文消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendGraphTextByOpenid(array $toUsers, $media_id, $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $params = $this->buildParamsByMsgType('mpnews', "", $media_id, "", array(), $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        return $this->send($ret);
    }

    /**
     * 发送卡券消息
     *
     * @param array $toUsers            
     * @param string $card_id            
     * @param array $card_ext            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function sendWxcardByOpenid(array $toUsers, $card_id, array $card_ext = array(), $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = '')
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        
        $params = $this->buildParamsByMsgType('wxcard', "", "", $card_id, $card_ext, $title, $description, $send_ignore_reprint, $clientmsgid);
        $ret = array_merge($ret, $params);
        
        return $this->send($ret);
    }

    /**
     * 删除群发
     *
     * @param string $msgid            
     * @return array
     */
    public function delete($msgid)
    {
        $ret = array();
        $ret['msgid'] = $msgid;
        $rst = $this->_request->post($this->_url . "message/mass/delete", $ret);
        return $this->_client->rst($rst);
    }

    /**
     * 预览文本消息
     *
     * @param string $touser            
     * @param string $content            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function previewText($touser, $content, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $touser;
        
        $params = $this->buildParamsByMsgType('text', $content, "", "", array(), $title, $description);
        $ret = array_merge($ret, $params);
        return $this->preview($ret);
    }

    /**
     * 预览图片消息
     *
     * @param string $touser            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function previewImage($touser, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $touser;
        $params = $this->buildParamsByMsgType('image', "", $media_id, "", array(), $title, $description);
        $ret = array_merge($ret, $params);
        
        return $this->preview($ret);
    }

    /**
     * 预览语音消息
     *
     * @param string $touser            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function previewVoice($touser, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $touser;
        
        $params = $this->buildParamsByMsgType('voice', "", $media_id, "", array(), $title, $description);
        $ret = array_merge($ret, $params);
        
        return $this->preview($ret);
    }

    /**
     * 预览视频消息
     *
     * @param string $touser            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function previewVideo($touser, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $touser;
        
        $params = $this->buildParamsByMsgType('mpvideo', "", $media_id, "", array(), $title, $description);
        $ret = array_merge($ret, $params);
        
        return $this->preview($ret);
    }

    /**
     * 预览图文消息
     *
     * @param string $touser            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @param number $send_ignore_reprint            
     * @param string $clientmsgid            
     * @return array
     */
    public function previewGraphText($touser, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $touser;
        $params = $this->buildParamsByMsgType('mpnews', "", $media_id, "", array(), $title, $description);
        $ret = array_merge($ret, $params);
        return $this->preview($ret);
    }

    /**
     * 预览卡券消息
     *
     * @param string $touser            
     * @param string $card_id            
     * @param array $card_ext            
     * @return array
     */
    public function previewWxcard($touser, $card_id, array $card_ext = array(), $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $touser;
        
        $params = $this->buildParamsByMsgType('wxcard', "", "", $card_id, $card_ext, $title, $description);
        $ret = array_merge($ret, $params);
        
        return $this->preview($ret);
    }

    /**
     * 预览接口【订阅号与服务号认证后均可用】
     * 开发者可通过该接口发送消息给指定用户，在手机端查看消息的样式和排版。
     *
     * @param array $params            
     * @return array
     */
    public function preview($params)
    {
        $rst = $this->_request->post($this->_url . "message/mass/preview", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 查询群发消息发送状态【订阅号与服务号认证后均可用】
     *
     * @param array $params            
     * @return array
     */
    public function get($msg_id)
    {
        $params = [
            "msg_id" => $msg_id
        ];
        $rst = $this->_request->post($this->_url . "message/mass/get", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 控制群发速度
     * 开发者可以使用限速接口来控制群发速度。
     *
     * 获取群发速度
     *
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/message/mass/speed/get?access_token=ACCESS_TOKEN
     * 返回说明 正常情况下的返回结果为：
     *
     * {
     * "speed":3,
     * "realspeed":15
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * speed 是 群发速度的级别
     * realspeed 是 群发速度的真实值 单位：万/分钟
     */
    public function speedGet()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . "message/mass/speed/get", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置群发速度
     *
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/message/mass/speed/set?access_token=ACCESS_TOKEN
     * 请求示例
     *
     * {
     * "speed":1
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * speed 是 群发速度的级别
     * 群发速度的级别，是一个0到4的整数，数字越大表示群发速度越慢。
     *
     * speed 与 realspeed 的关系如下：
     *
     * speed realspeed
     * 0 80w/分钟
     * 1 60w/分钟
     * 2 45w/分钟
     * 3 30w/分钟
     * 4 10w/分钟
     * 返回码说明
     *
     * 返回码 说明
     * 45083 设置的 speed 参数不在0到4的范围内
     * 45084 没有设置 speed 参数
     */
    public function speedSet($speed)
    {
        $params = array(
            'speed' => $speed
        );
        $rst = $this->_request->post($this->_url . "message/mass/speed/set", $params);
        return $this->_client->rst($rst);
    }

    protected function buildParamsByMsgType($msgtype, $content, $media_id, $card_id, array $card_ext = array(), $title = "", $description = "", $send_ignore_reprint = 0, $clientmsgid = "")
    {
        $params = array();
        $params['msgtype'] = $msgtype;
        // 文本
        if ($msgtype == 'text') {
            $params[$msgtype]['content'] = $content;
        }        

        // 图片
        elseif ($msgtype == 'image') {
            $params[$msgtype]['media_id'] = $media_id;
        }        

        // 语音/音频
        elseif ($msgtype == 'voice') {
            $params[$msgtype]['media_id'] = $media_id;
        }        

        // 视频
        elseif ($msgtype == 'mpvideo') {
            $params[$msgtype]['media_id'] = $media_id;
        }        

        // 图文
        elseif ($msgtype == 'mpnews') {
            $params[$msgtype]['media_id'] = $media_id;
        }        

        // 卡券
        elseif ($msgtype == 'wxcard') {
            $params[$msgtype]['card_id'] = $card_id;
            if (! empty($card_ext)) {
                $params[$msgtype]['card_ext'] = json_encode($card_ext);
            }
        }
        
        if (! empty($title)) {
            $params[$msgtype]['title'] = $title;
        }
        if (! empty($description)) {
            $params[$msgtype]['description'] = $description;
        }
        if (empty($send_ignore_reprint)) {
            $ret['send_ignore_reprint'] = $send_ignore_reprint;
        }
        if (! empty($clientmsgid)) {
            $ret['clientmsgid'] = $clientmsgid;
        }
        
        return $params;
    }
}
