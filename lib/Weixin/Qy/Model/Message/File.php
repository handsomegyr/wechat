<?php

namespace Weixin\Qy\Model\Message;

/**
 * 文件消息构体
 */
class File extends \Weixin\Qy\Model\Message\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：file
     */
    protected $msgtype = 'file';

    /**
     * media_id 是 文件id，可以调用上传临时素材接口获取
     */
    public $media_id = NULL;

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

        return $params;
    }
}
