<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 时间范围
 */
class TimeRange extends \Weixin\Model\Base
{
    /**
     * start_time	number	是	秒级时间戳（距离end_time不可超过7天）
     */
    public $start_time = NULL;

    /**
     * end_time	number	是	秒级时间戳（距离start_time不可超过7天
     */
    public $end_time = NULL;

    public function __construct() {}

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
