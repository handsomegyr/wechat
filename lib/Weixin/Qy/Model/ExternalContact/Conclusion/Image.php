<?php

namespace Weixin\Qy\Model\ExternalContact\Conclusion;

/**
 * 图片内容构体
 */
class Image extends \Weixin\Model\Base
{

    /**
     * image.media_id 图片的media_id
     */
    public $media_id = NULL;

    /**
     * image.pic_url 图片的url
     */
    public $pic_url = NULL;

    public function __construct($media_id, $pic_url)
    {
        $this->media_id = $media_id;
        $this->pic_url = $pic_url;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->media_id)) {
            $params['media_id'] = $this->media_id;
        }
        if ($this->isNotNull($this->content)) {
            $params['pic_url'] = $this->pic_url;
        }
        return $params;
    }
}
