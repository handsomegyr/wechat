<?php

namespace Weixin\Qy\Model\Oa;

/**
 * 群聊会话构体
 */
class Calendar extends \Weixin\Model\Base
{

    /**
     * cal_id 是 日历ID
     */
    public $cal_id = NULL;

    /**
     * organizer 是 指定的组织者userid。注意该字段指定后不可更新
     */
    public $organizer = NULL;

    /**
     * summary 是 日历标题。1 ~ 128 字符
     */
    public $summary = NULL;

    /**
     * color 是 日历在终端上显示的颜色，RGB颜色编码16进制表示，例如：”#0000FF” 表示纯蓝色
     */
    public $color = NULL;

    /**
     * description 否 日历描述。0 ~ 512 字符
     */
    public $description = NULL;

    /**
     * shares 否 日历共享成员列表。最多2000人
     */
    public $shares = NULL;

    /**
     * userid 是 日历共享成员的id
     */
    public $userid = NULL;

    public function __construct($organizer, $summary, $color, $userid)
    {
        $this->organizer = $organizer;
        $this->summary = $summary;
        $this->color = $color;
        $this->userid = $userid;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->cal_id)) {
            $params['cal_id'] = $this->cal_id;
        }
        if ($this->isNotNull($this->organizer)) {
            $params['organizer'] = $this->organizer;
        }
        if ($this->isNotNull($this->summary)) {
            $params['summary'] = $this->summary;
        }
        if ($this->isNotNull($this->color)) {
            $params['color'] = $this->color;
        }
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->shares)) {
            $params['shares'] = $this->shares;
        }
        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        return $params;
    }
}
