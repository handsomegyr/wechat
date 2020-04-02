<?php

namespace Weixin\Qy\Model\ExternalContact\Conclusion;

/**
 * 小程序消息构体
 */
class Miniprogram extends \Weixin\Model\Base
{

    /**
     * miniprogram.title 小程序消息标题，最长为64字节
     */
    public $title = NULL;

    /**
     * miniprogram.pic_media_id 小程序消息封面的mediaid，封面图建议尺寸为520*416
     */
    public $pic_media_id = NULL;

    /**
     * miniprogram.appid 小程序appid，必须是关联到企业的小程序应用
     */
    public $appid = NULL;

    /**
     * miniprogram.page 小程序page路径
     */
    public $page = NULL;

    public function __construct($title, $pic_media_id, $appid, $page)
    {
        $this->title = $title;
        $this->pic_media_id = $pic_media_id;
        $this->appid = $appid;
        $this->page = $page;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->pic_media_id)) {
            $params['pic_media_id'] = $this->pic_media_id;
        }
        if ($this->isNotNull($this->appid)) {
            $params['appid'] = $this->appid;
        }
        if ($this->isNotNull($this->page)) {
            $params['page'] = $this->page;
        }

        return $params;
    }
}
