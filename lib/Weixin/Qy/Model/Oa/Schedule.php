<?php

namespace Weixin\Qy\Model\Oa;

/**
 * 群聊会话构体
 */
class Schedule extends \Weixin\Model\Base
{

    /**
     * schedule_id 是 日程ID
     */
    public $schedule_id = NULL;

    /**
     * organizer 是 组织者
     */
    public $organizer = NULL;

    /**
     * start_time 是 日程开始时间，Unix时间戳
     */
    public $start_time = NULL;

    /**
     * end_time 是 日程结束时间，Unix时间戳
     */
    public $end_time = NULL;

    /**
     * attendees 否 日程参与者列表。最多支持2000人
     */
    public $attendees = NULL;

    /**
     * userid 是 日程参与者ID
     */
    public $userid = NULL;

    /**
     * summary 否 日程标题。0 ~ 128 字符。不填会默认显示为“新建事件”
     */
    public $summary = NULL;

    /**
     * description 否 日程描述。0 ~ 512 字符
     */
    public $description = NULL;

    /**
     * reminders 否 提醒相关信息
     * 
     * @var \Weixin\Qy\Model\Oa\Reminder
     */
    public $reminders = NULL;

    /**
     * location 否 日程地址。0 ~ 128 字符
     */
    public $location = NULL;

    /**
     * cal_id 否 日程所属日历ID。注意，这个日历必须是属于组织者(organizer)的日历；如果不填，那么插入到组织者的默认日历上
     */
    public $cal_id = NULL;

    public function __construct($organizer, $start_time, $end_time, $userid)
    {
        $this->organizer = $organizer;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->userid = $userid;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->schedule_id)) {
            $params['schedule_id'] = $this->schedule_id;
        }
        if ($this->isNotNull($this->organizer)) {
            $params['organizer'] = $this->organizer;
        }
        if ($this->isNotNull($this->start_time)) {
            $params['start_time'] = $this->start_time;
        }
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }
        if ($this->isNotNull($this->attendees)) {
            $params['attendees'] = $this->attendees;
        }
        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        if ($this->isNotNull($this->summary)) {
            $params['summary'] = $this->summary;
        }
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->reminders)) {
            $params['reminders'] = $this->reminders->getParams();
        }
        if ($this->isNotNull($this->location)) {
            $params['location'] = $this->location;
        }
        if ($this->isNotNull($this->cal_id)) {
            $params['cal_id'] = $this->cal_id;
        }
        return $params;
    }
}
