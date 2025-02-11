<?php

namespace Weixin\Channels\Ec\Model\League\Headsupplier;

/**
 * 时间范围
 */
class TimeRange extends \Weixin\Model\Base
{
    // start_time	number	否	开始时间，秒级时间戳
    public $start_time = NULL;
    // end_time	number	否	结束时间，秒级时间戳
    public $end_time = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->start_time)) {
            $params['start_time'] = $this->start_time;
        }
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }
        return $params;
    }
}
