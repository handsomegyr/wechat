<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 当天可用时间段
 */
class AvailableDayTime extends Base
{
    /**
     * 当天可用开始时间 begin_time int 否 当天可用开始时间，单位：秒，1代表当天0点0分1秒。 示例值：3600
     */
    public $begin_time = null;
    /**
     * 当天可用结束时间 end_time int 否 当天可用结束时间，单位：秒，86399代表当天23点59分59秒。 示例值：86399
     */
    public $end_time = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->begin_time)) {
            $params['begin_time'] = $this->begin_time;
        }
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }
        return $params;
    }
}
