<?php
namespace Weixin\Model;

/**
 * 使用时段限制结构体
 */
class TimeLimit extends Base
{

    /**
     * type 否 string（24 ） 限制类型枚举值：支持填入 MONDAY 周一 TUESDAY 周二 WEDNESDAY 周三 THURSDAY 周四 FRIDAY 周五 SATURDAY 周六 SUNDAY 周日 此处只控制显示， 不控制实际使用逻辑，不填默认不显示
     */
    public $type = NULL;

    /**
     * begin_hour 否 int 当前type类型下的起始时间（小时） ，如当前结构体内填写了MONDAY， 此处填写了10，则此处表示周一 10:00可用
     */
    public $begin_hour = NULL;

    /**
     * begin_minute 否 int 当前type类型下的起始时间（分钟） ，如当前结构体内填写了MONDAY， begin_hour填写10，此处填写了59， 则此处表示周一 10:59可用
     */
    public $begin_minute = NULL;

    /**
     * end_hour 否 int 当前type类型下的结束时间（小时） ，如当前结构体内填写了MONDAY， 此处填写了20， 则此处表示周一 10:00-20:00可用
     */
    public $end_hour = NULL;

    /**
     * end_minute 否 int 当前type类型下的结束时间（分钟） ，如当前结构体内填写了MONDAY， begin_hour填写10，此处填写了59， 则此处表示周一 10:59-00:59可用
     */
    public $end_minute = NULL;

    public function __construct()
    {}

    public function set_type($type)
    {
        $this->type = $type;
    }

    public function set_begin_hour($begin_hour)
    {
        $this->begin_hour = $begin_hour;
    }

    public function set_begin_minute($begin_minute)
    {
        $this->begin_minute = $begin_minute;
    }

    public function set_end_hour($end_hour)
    {
        $this->end_hour = $end_hour;
    }

    public function set_end_minute($end_minute)
    {
        $this->end_minute = $end_minute;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }
        if ($this->isNotNull($this->begin_hour)) {
            $params['begin_hour'] = $this->begin_hour;
        }
        if ($this->isNotNull($this->begin_minute)) {
            $params['begin_minute'] = $this->begin_minute;
        }
        if ($this->isNotNull($this->end_hour)) {
            $params['end_hour'] = $this->end_hour;
        }
        if ($this->isNotNull($this->end_minute)) {
            $params['end_minute'] = $this->end_minute;
        }
        return $params;
    }
}
