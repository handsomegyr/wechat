<?php

namespace Weixin\Qy\Model\Oa;

/**
 * 提醒相关信息构体
 */
class Reminder extends \Weixin\Model\Base
{

    /**
     * is_remind 否 是否需要提醒。0-否；1-是
     */
    public $is_remind = NULL;

    /**
     * remind_before_event_secs 否 日程开始（start_time）前多少秒提醒，当is_remind为1时有效。例如： 300表示日程开始前5分钟提醒。目前仅支持以下数值：
     */
    /**
     * 0 - 事件开始时
     */
    /**
     * 300 - 事件开始前5分钟
     */
    /**
     * 900 - 事件开始前15分钟
     */
    /**
     * 3600 - 事件开始前1小时
     */
    /**
     * 86400 - 事件开始前1天
     */
    public $remind_before_event_secs = NULL;

    /**
     * is_repeat 否 是否重复日程。0-否；1-是
     */
    public $is_repeat = NULL;

    /**
     * repeat_type 否 重复类型，当is_repeat为1时有效。目前支持如下类型：
     */
    /**
     * 0 - 每日
     */
    /**
     * 1 - 每周
     */
    /**
     * 2 - 每月
     */
    /**
     * 5 - 每年
     */
    /**
     * 7 - 工作日
     */
    public $repeat_type = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->is_remind)) {
            $params['is_remind'] = $this->is_remind;
        }
        if ($this->isNotNull($this->remind_before_event_secs)) {
            $params['remind_before_event_secs'] = $this->remind_before_event_secs;
        }
        if ($this->isNotNull($this->is_repeat)) {
            $params['is_repeat'] = $this->is_repeat;
        }
        if ($this->isNotNull($this->repeat_type)) {
            $params['repeat_type'] = $this->repeat_type;
        }
        return $params;
    }
}
