<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 核销规则
 */
class AvailableWeek extends Base
{
    /**
     * 可用星期数 week_day array[int] 条件选填 0代表周日，1代表周一，以此类推 当填写available_day_time时，week_day必填 示例值：1, 2
     */
    public $week_day = null;
    /**
     * + 当天可用时间段 available_day_time array 否 可以填写多个时间段，最多不超过2个。
     */
    public $available_day_time = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->week_day)) {
            foreach ($this->week_day as $value) {
                $params['week_day'][] = $value;
            }
        }
        if ($this->isNotNull($this->available_day_time)) {
            foreach ($this->available_day_time as $value) {
                $params['available_day_time'][] = $value->getParams();
            }
        }
        return $params;
    }
}
