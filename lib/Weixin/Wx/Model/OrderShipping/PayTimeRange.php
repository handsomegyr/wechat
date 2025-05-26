<?php

namespace Weixin\Wx\Model\OrderShipping;

/**
 * 支付时间所属范围。
 */
class PayTimeRange extends \Weixin\Model\Base
{
    // begin_time	number	否	起始时间，时间戳形式，不填则视为从0开始。
    public $begin_time = NULL;
    // end_time	number	否	结束时间（含），时间戳形式，不填则视为32位无符号整型的最大值。
    public $end_time = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // begin_time	number	否	起始时间，时间戳形式，不填则视为从0开始。
        if ($this->isNotNull($this->begin_time)) {
            $params['begin_time'] = $this->begin_time;
        }
        // end_time	number	否	结束时间（含），时间戳形式，不填则视为32位无符号整型的最大值。
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }

        return $params;
    }
}
