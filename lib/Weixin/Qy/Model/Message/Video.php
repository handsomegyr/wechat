<?php

namespace Weixin\Qy\Model\Message;

/**
 * 视频消息构体
 */
class Video extends \Weixin\Qy\Model\Message\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：video
     */
    protected $msgtype = 'video';

    /**
     * media_id 是 视频媒体文件id，可以调用上传临时素材接口获取
     */
    public $media_id = NULL;

    /**
     * title 否 视频消息的标题，不超过128个字节，超过会自动截断
     */
    public $title = NULL;

    /**
     * description 否 视频消息的描述，不超过512个字节，超过会自动截断
     */
    public $description = NULL;

    public function __construct($agentid, $media_id, $touser = '@all')
    {
        $this->agentid = $agentid;
        $this->media_id = $media_id;
        $this->touser = $touser;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->media_id)) {
            $params[$this->msgtype]['media_id'] = $this->media_id;
        }
        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->description)) {
            $params[$this->msgtype]['description'] = $this->description;
        }

        return $params;
    }
}
