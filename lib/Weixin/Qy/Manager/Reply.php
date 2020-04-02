<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 被动回复消息
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Reply
{

    private $_client;

    private $_to;

    private $_from;

    private $_length = 140;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_from = $this->_client->getFromUserName();
        $this->_to = $this->_client->getToUserName();
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
     * @return number
     */
    public function setLength()
    {
        return $this->_length;
    }

    /**
     * 回复文本消息
     *
     * @param string $content            
     * @return string
     */
    public function replyText($content)
    {
        $time = time();
        return "
		<xml>
		<ToUserName><![CDATA[{$this->_to}]]></ToUserName>
		<FromUserName><![CDATA[{$this->_from}]]></FromUserName>
		<CreateTime>{$time}</CreateTime>
		<MsgType><![CDATA[text]]></MsgType>
		<Content><![CDATA[{$content}]]></Content>
		</xml>";
    }

    /**
     * 回复图片消息
     *
     * @param string $media_id            
     * @return string
     */
    public function replyImage($media_id)
    {
        $time = time();
        return "
		<xml>
		<ToUserName><![CDATA[{$this->_to}]]></ToUserName>
		<FromUserName><![CDATA[{$this->_from}]]></FromUserName>
		<CreateTime>{$time}</CreateTime>
		<MsgType><![CDATA[image]]></MsgType>
		<Image>
		<MediaId><![CDATA[{$media_id}]]></MediaId>
		</Image>
		</xml>";
    }

    /**
     * 回复音频消息
     *
     * @param string $media_id            
     * @return string
     */
    public function replyVoice($media_id)
    {
        $time = time();
        return "
		<xml>
		<ToUserName><![CDATA[{$this->_to}]]></ToUserName>
		<FromUserName><![CDATA[{$this->_from}]]></FromUserName>
		<CreateTime>{$time}</CreateTime>
		<MsgType><![CDATA[voice]]></MsgType>
		<Voice>
		<MediaId><![CDATA[{$media_id}]]></MediaId>
		</Voice>
		</xml>";
    }

    /**
     * 回复视频消息
     *
     * @param string $title            
     * @param string $description            
     * @param string $media_id            
     * @return string
     */
    public function replyVideo($title, $description, $media_id)
    {
        $time = time();
        return "
        <xml>
        <ToUserName><![CDATA[{$this->_to}]]></ToUserName>
        <FromUserName><![CDATA[{$this->_from}]]></FromUserName>
        <CreateTime>{$time}</CreateTime>
        <MsgType><![CDATA[video]]></MsgType>
        <Video>
        <MediaId><![CDATA[{$media_id}]]></MediaId>
        <Title><![CDATA[{$title}]]></Title>
        <Description><![CDATA[{$description}]]></Description>
        </Video>
        </xml>";
    }

    /**
     * 回复图文信息
     *
     * @param array $articles
     *            子元素
     *            $articles[] = $article
     *            子元素结构
     *            $article['title']
     *            $article['description']
     *            $article['picurl'] 图片链接，支持JPG、PNG格式，较好的效果为大图640*320，小图80*80
     *            $article['url']
     *            
     * @return string
     */
    public function replyGraphText(array $articles)
    {
        $time = time();
        if (!is_array($articles) || count($articles) == 0)
            return '';
        $items = '';
        // $articles = array_slice($articles, 0, 10);
        $articleCount = count($articles);
        foreach ($articles as $article) {
            if (mb_strlen($article['description'], 'utf-8') > $this->_length) {
                $article['description'] = mb_substr($article['description'], 0, $this->getLength(), 'utf-8') . '……';
            }
            $items .= "
		 	<item>
		 	<Title><![CDATA[{$article['title']}]]></Title>
		 	<Description><![CDATA[{$article['description']}]]></Description>
		 	<PicUrl><![CDATA[{$article['picurl']}]]></PicUrl>
		 	<Url><![CDATA[{$article['url']}]]></Url>
		 	</item>";
        }
        return "
		<xml>
 		<ToUserName><![CDATA[{$this->_to}]]></ToUserName>
 		<FromUserName><![CDATA[{$this->_from}]]></FromUserName>
 		<CreateTime>{$time}</CreateTime>
 		<MsgType><![CDATA[news]]></MsgType>
 		<ArticleCount>{$articleCount}</ArticleCount>
 		<Articles>{$items}</Articles>
 		</xml>";
    }
}
