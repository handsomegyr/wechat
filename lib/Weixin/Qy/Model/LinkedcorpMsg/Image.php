<?php

namespace Weixin\Qy\Model\LinkedcorpMsg;

/**
 * 图片消息构体
 */
class Image extends \Weixin\Qy\Model\LinkedcorpMsg\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：image
     */
    protected $msgtype = 'image';

    /**
     * media_id 是 图片媒体文件id，可以调用上传临时素材接口获取
     */
    public $media_id = NULL;

    public function __construct($agentid, $media_id)
    {
        $this->agentid = $agentid;
        $this->media_id = $media_id;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->media_id)) {
            $params[$this->msgtype]['media_id'] = $this->media_id;
        }

        return $params;
    }
}
