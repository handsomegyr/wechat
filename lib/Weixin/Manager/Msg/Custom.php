<?php

namespace Weixin\Manager\Msg;

use Weixin\Client;

/**
 * 发送消息-----发送客服消息接口
 * 当用户主动发消息给公众号的时候，
 * 微信将会把消息数据推送给开发者，
 * 开发者在一段时间内（目前为48小时）可以调用客服消息接口，
 * 通过POST一个JSON数据包来发送消息给普通用户，
 * 在48小时内不限制发送次数。
 * 此接口主要用于客服等有人工消息处理环节的功能，
 * 方便开发者为用户提供更加优质的服务。
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Custom
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/';

    private $_client;

    private $_length = 140;

    private $_kf_account = "";

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取文字长度
     *
     * @return number
     */
    public function getLength()
    {
        return $this->_length;
    }

    /**
     * 设定图文消息的最大显示文字长度，超过省略
     *
     * @return \Weixin\Manager\Msg\Custom
     */
    public function setLength($len)
    {
        $this->_length = $len;
        return $this;
    }

    /**
     * 设定客服帐号
     *
     * @return \Weixin\Manager\Msg\Custom
     */
    public function setKfAccount($kf_account)
    {
        $this->_kf_account = $kf_account;
        return $this;
    }

    /**
     * 发送
     *
     * @param array $params            
     * @throws Exception
     * @return array
     */
    public function send(array $params)
    {
        if (!empty($this->_kf_account)) {
            // 如果需要以某个客服帐号来发消息（在微信6.0.2及以上版本中显示自定义头像），则需在JSON数据包的后半部分加入customservice参数
            $params['customservice'] = array(
                "kf_account" => $this->_kf_account
            );
        }
        $rst = $this->_request->post($this->_url . 'message/custom/send', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 发送文本消息
     *
     * @param string $toUser            
     * @param string $content            
     * @return string
     */
    public function sendText($toUser, $content)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'text';
        $ret['text']['content'] = $content;
        return $this->send($ret);
    }

    /**
     * 发送图片消息
     *
     * @param string $toUser            
     * @param string $media_id            
     * @return string
     */
    public function sendImage($toUser, $media_id)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'image';
        $ret['image']['media_id'] = $media_id;
        return $this->send($ret);
    }

    /**
     * 发送语音消息
     *
     * @param string $toUser            
     * @param string $media_id            
     * @return string
     */
    public function sendVoice($toUser, $media_id)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'voice';
        $ret['voice']['media_id'] = $media_id;
        return $this->send($ret);
    }

    /**
     * 发送视频消息
     *
     * @param string $toUser            
     * @param string $media_id            
     * @param string $thumb_media_id            
     * @param string $title            
     * @param string $description            
     * @return string
     */
    public function sendVideo($toUser, $media_id, $thumb_media_id, $title, $description)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'video';
        $ret['video']['media_id'] = $media_id;
        $ret['video']['thumb_media_id'] = $thumb_media_id;
        $ret['video']['title'] = $title;
        $ret['video']['description'] = $description;
        return $this->send($ret);
    }

    /**
     * 发送音乐消息
     *
     * @param string $toUser            
     * @param string $title            
     * @param string $description            
     * @param string $musicurl            
     * @param string $hqmusicurl            
     * @param string $thumb_media_id            
     * @return string
     */
    public function sendMusic($toUser, $title, $description, $musicurl, $hqmusicurl, $thumb_media_id)
    {
        $hqmusicurl = $hqmusicurl == '' ? $musicurl : $hqmusicurl;
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'music';
        $ret['music']['title'] = $title;
        $ret['music']['description'] = $description;
        $ret['music']['musicurl'] = $musicurl;
        $ret['music']['hqmusicurl'] = $hqmusicurl;
        $ret['music']['thumb_media_id'] = $thumb_media_id;
        return $this->send($ret);
    }

    /**
     * 发送图文消息（点击跳转到外链） 图文消息条数限制在1条以内，注意，如果图文数超过1，则将会返回错误码45008。
     *
     * @param string $toUser            
     * @param string $articles            
     * @return string
     */
    public function sendGraphText($toUser, array $articles)
    {
        if (!is_array($articles) || count($articles) == 0)
            return '';
        $items = array();
        $articles = array_slice($articles, 0, 1); // 图文消息条数限制在1条以内。
        $articleCount = count($articles);
        foreach ($articles as $article) {
            if (mb_strlen($article['description'], 'utf-8') > $this->_length) {
                $article['description'] = mb_substr($article['description'], 0, $this->getLength(), 'utf-8') . '……';
            }
            $items[] = array(
                'title' => $article['title'],
                'description' => $article['description'],
                'url' => $article['url'],
                'picurl' => $article['picurl']
            );
        }
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'news';
        $ret['news']['articles'] = $items;
        return $this->send($ret);
    }

    /**
     * 发送图文消息（点击跳转到图文消息页面） 图文消息条数限制在1条以内，注意，如果图文数超过1，则将会返回错误码45008。
     *
     * {
     * "touser":"OPENID",
     * "msgtype":"mpnews",
     * "mpnews":
     * {
     * "media_id":"MEDIA_ID"
     * }
     * }
     */
    public function sendMpNews($toUser, $media_id)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'mpnews';
        $ret['mpnews']['media_id'] = $media_id;
        return $this->send($ret);
    }

    /**
     * 发送图文消息（点击跳转到图文消息页面）使用通过 “发布” 系列接口得到的 article_id
     *
     * {
     * "touser":"OPENID",
     * "msgtype":"mpnewsarticle",
     * "mpnewsarticle":
     * {
     * "article_id":"article_id"
     * }
     * }
     */
    public function sendMpNewsArticle($toUser, $article_id)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'mpnewsarticle';
        $ret['mpnewsarticle']['article_id'] = $article_id;
        return $this->send($ret);
    }

    /**
     * 发送菜单消息
     *
     * {
     * "touser": "OPENID"
     * "msgtype": "msgmenu",
     * "msgmenu": {
     * "head_content": "您对本次服务是否满意呢? "
     * "list": [
     * {
     * "id": "101",
     * "content": "满意"
     * },
     * {
     * "id": "102",
     * "content": "不满意"
     * }
     * ],
     * "tail_content": "欢迎再次光临"
     * }
     * }
     * 按照上述例子，用户会看到这样的菜单消息：
     *
     * “您对本次服务是否满意呢？
     *
     * 满意
     *
     * 不满意”
     *
     * 其中，“满意”和“不满意”是可点击的，当用户点击后，微信会发送一条XML消息到开发者服务器
     */
    public function sendMsgMenu($toUser, $msgmenu)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'msgmenu';
        $ret['msgmenu'] = $msgmenu;
        return $this->send($ret);
    }

    /**
     * 发送卡券消息
     * 特别注意客服消息接口投放卡券仅支持非自定义Code码的卡券。
     *
     * @param string $toUser            
     * @param string $card_id            
     * @param array $card_ext            
     * @return string
     */
    public function sendWxcard($toUser, $card_id, array $card_ext = array())
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'wxcard';
        $ret['wxcard']['card_id'] = $card_id;
        if (!empty($card_ext)) {
            $ret['wxcard']['card_ext'] = json_encode($card_ext);
        }
        return $this->send($ret);
    }

    /**
     * 发送小程序卡片（要求小程序与公众号已关联）
     * 客户端效果如下图：
     *
     * 接口调用示例：
     * {
     * "touser":"OPENID",
     * "msgtype":"miniprogrampage",
     * "miniprogrampage":
     * {
     * "title":"title",
     * "appid":"appid",
     * "pagepath":"pagepath",
     * "thumb_media_id":"thumb_media_id"
     * }
     * }
     */
    public function sendMiniProgramPage($toUser, $title, $appid, $pagepath, $thumb_media_id)
    {
        $ret = array();
        $ret['touser'] = $toUser;
        $ret['msgtype'] = 'miniprogrampage';
        $ret['miniprogrampage']['title'] = $title;
        $ret['miniprogrampage']['appid'] = $appid;
        $ret['miniprogrampage']['pagepath'] = $pagepath;
        $ret['miniprogrampage']['thumb_media_id'] = $thumb_media_id;
        return $this->send($ret);
    }

    /**
     * 客服输入状态
     * 开发者可通过调用“客服输入状态”接口，返回客服当前输入状态给用户。
     * 微信客户端效果图如下：
     *
     * 此接口需要客服消息接口权限。
     * 1. 如果不满足发送客服消息的触发条件，则无法下发输入状态。
     * 2. 下发输入状态，需要客服之前30秒内跟用户有过消息交互。
     * 3. 在输入状态中（持续15s），不可重复下发输入态。
     * 4. 在输入状态中，如果向用户下发消息，会同时取消输入状态。
     * 接口调用请求说明
     *
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/message/custom/typing?access_token=ACCESS_TOKEN
     * JSON数据包如下：
     *
     * { "touser":"OPENID", "command":"Typing"}
     * 预期返回：
     *
     * { "errcode":0, "errmsg":"ok"}
     * 参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * touser 是 普通用户（openid）
     * command 是 "Typing"：对用户下发“正在输入"状态 "CancelTyping"：取消对用户的”正在输入"状态
     * 返回码说明
     *
     * 参数 说明
     * 45072 command字段取值不对
     * 45080 下发输入状态，需要之前30秒内跟用户有过消息交互
     * 45081 已经在输入状态，不可重复下发
     */
    public function typing($touser, $command = 'Typing')
    {
        $params = array();
        $params['touser'] = $touser;
        if (empty($command)) {
            $command = 'Typing';
        }
        $params['command'] = $command;

        $rst = $this->_request->post($this->_url . 'message/custom/typing', $params);
        return $this->_client->rst($rst);
    }
}
