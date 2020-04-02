<?php

namespace Weixin\Qy\Model\Message;

/**
 * 任务卡片消息构体
 */
class TaskCard extends \Weixin\Qy\Model\Message\Base
{

    /**
     * msgtype 是 消息类型，此时固定为：taskcard
     */
    protected $msgtype = 'taskcard';

    /**
     * title 是 标题，不超过128个字节，超过会自动截断（支持id转译）
     */
    public $title = NULL;

    /**
     * description 是 描述，不超过512个字节，超过会自动截断（支持id转译）
     */
    public $description = NULL;

    /**
     * url 否 点击后跳转的链接。最长2048字节，请确保包含了协议头(http/https)
     */
    public $url = NULL;

    /**
     * task_id 是 任务id，同一个应用发送的任务卡片消息的任务id不能重复，只能由数字、字母和“_-@”组成，最长支持128字节
     */
    public $task_id = NULL;

    /**
     * btn 是 按钮列表，按钮个数为1~2个。
     */
    public $btn = NULL;

    public function __construct($agentid, $title, $description, $task_id, array $btn, $touser = '@all')
    {
        $this->agentid = $agentid;
        $this->title = $title;
        $this->description = $description;
        $this->task_id = $task_id;
        $this->btn = $btn;
        $this->touser = $touser;
    }

    public function getParams()
    {
        $params = parent::getParams();

        if ($this->isNotNull($this->title)) {
            $params[$this->msgtype]['title'] = $this->title;
        }
        if ($this->isNotNull($this->description)) {
            $params[$this->msgtype]['description'] = $this->description;
        }
        if ($this->isNotNull($this->url)) {
            $params[$this->msgtype]['url'] = $this->url;
        }
        if ($this->isNotNull($this->task_id)) {
            $params[$this->msgtype]['task_id'] = $this->task_id;
        }
        if (!empty($this->btn)) {
            foreach ($this->btn as $item) {
                $params[$this->msgtype]['btn'][] = $item->getParams();
            }
        }

        return $params;
    }
}
