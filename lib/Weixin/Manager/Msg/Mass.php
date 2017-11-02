<?php
namespace Weixin\Manager\Msg;

use Weixin\Client;

/**
 * 群发消息接口
 *
 * @author guoyongrong <handsomegyr@126.com>
 *        
 */
class Mass
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/';

    public $is_to_all = false;

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
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendTextByGroup($group_id, $content, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'text';
        $ret['text']['content'] = $content;
        $ret['text']['title'] = $title;
        $ret['text']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送文本消息
     *
     * @param string $group_id            
     * @param string $content            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendTextByTag($tag_id, $content, $is_to_all = false)
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $ret['msgtype'] = 'text';
        $ret['text']['content'] = $content;
        return $this->sendAll($ret);
    }

    /**
     * 发送图片消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendImageByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'image';
        $ret['image']['media_id'] = $media_id;
        $ret['image']['title'] = $title;
        $ret['image']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送图片消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendImageByTag($tag_id, $media_id, $is_to_all = false)
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $ret['msgtype'] = 'image';
        $ret['image']['media_id'] = $media_id;
        return $this->sendAll($ret);
    }

    /**
     * 发送语音消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVoiceByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'voice';
        $ret['voice']['media_id'] = $media_id;
        $ret['voice']['title'] = $title;
        $ret['voice']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送语音消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVoiceByTag($tag_id, $media_id, $is_to_all = false)
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $ret['msgtype'] = 'voice';
        $ret['voice']['media_id'] = $media_id;
        return $this->sendAll($ret);
    }

    /**
     * 发送视频消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVideoByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'mpvideo';
        $ret['mpvideo']['media_id'] = $media_id;
        $ret['mpvideo']['title'] = $title;
        $ret['mpvideo']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送视频消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVideoByTag($tag_id, $media_id, $is_to_all = false)
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $ret['msgtype'] = 'mpvideo';
        $ret['mpvideo']['media_id'] = $media_id;
        return $this->sendAll($ret);
    }

    /**
     * 发送图文消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendGraphTextByGroup($group_id, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        $ret['mpnews']['title'] = $title;
        $ret['mpnews']['description'] = $description;
        return $this->sendAll($ret);
    }

    /**
     * 发送图文消息
     *
     * @param string $group_id            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendGraphTextByTag($tag_id, $media_id, $is_to_all = false, $send_ignore_reprint = 1)
    {
        $ret = array();
        $ret['filter']['tag_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        $ret['send_ignore_reprint'] = $send_ignore_reprint;
        
        return $this->sendAll($ret);
    }

    /**
     * 发送卡券消息
     *
     * @param string $group_id            
     * @param string $card_id            
     * @param array $card_ext            
     * @return array
     */
    public function sendWxcardByGroup($group_id, $card_id, array $card_ext = array())
    {
        $ret = array();
        $ret['filter']['group_id'] = $group_id;
        if (! empty($this->is_to_all)) {
            $ret['filter']['is_to_all'] = $this->is_to_all;
        }
        $ret['msgtype'] = 'wxcard';
        $ret['wxcard']['card_id'] = $card_id;
        if (! empty($card_ext)) {
            $ret['wxcard']['card_ext'] = json_encode($card_ext);
        }
        return $this->sendAll($ret);
    }

    /**
     * 根据标签发送卡券消息
     *
     * @param string $group_id            
     * @param string $card_id            
     * @param array $card_ext            
     * @return array
     */
    public function sendWxcardByTag($tag_id, $card_id, array $card_ext = array(), $is_to_all = false)
    {
        $ret = array();
        $ret['filter']['group_id'] = $tag_id;
        $ret['filter']['is_to_all'] = $is_to_all;
        $ret['msgtype'] = 'wxcard';
        $ret['wxcard']['card_id'] = $card_id;
        if (! empty($card_ext)) {
            $ret['wxcard']['card_ext'] = json_encode($card_ext);
        }
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
     * @return array
     */
    public function sendTextByOpenid(array $toUsers, $content, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'text';
        $ret['text']['content'] = $content;
        $ret['text']['title'] = $title;
        $ret['text']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送图片消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendImageByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'image';
        $ret['image']['media_id'] = $media_id;
        $ret['image']['title'] = $title;
        $ret['image']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送语音消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVoiceByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'voice';
        $ret['voice']['media_id'] = $media_id;
        $ret['voice']['title'] = $title;
        $ret['voice']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送视频消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendVideoByOpenid(array $toUsers, $media_id, $title = "", $description = "")
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'mpvideo';
        $ret['mpvideo']['media_id'] = $media_id;
        $ret['mpvideo']['title'] = $title;
        $ret['mpvideo']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送图文消息
     *
     * @param array $toUsers            
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     * @return array
     */
    public function sendGraphTextByOpenid(array $toUsers, $media_id, $title = "", $description = "", $send_ignore_reprint = 1)
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        $ret['mpnews']['title'] = $title;
        $ret['mpnews']['description'] = $description;
        $ret['send_ignore_reprint'] = $send_ignore_reprint;
        return $this->send($ret);
    }

    /**
     * 发送卡券消息
     *
     * @param array $toUsers            
     * @param string $card_id            
     * @param array $card_ext            
     * @return array
     */
    public function sendWxcardByOpenid(array $toUsers, $card_id, array $card_ext = array())
    {
        $ret = array();
        $ret['touser'] = $toUsers;
        $ret['msgtype'] = 'wxcard';
        $ret['wxcard']['card_id'] = $card_id;
        if (! empty($card_ext)) {
            $ret['wxcard']['card_ext'] = json_encode($card_ext);
        }
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
}
