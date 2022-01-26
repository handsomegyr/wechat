<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 领取
 */
class ReceiveInfo extends \Weixin\Model\Base
{
    /**
     * start_time	number	领取开始时间
     */
    public $start_time = NULL;

    /**
     * end_time	number	领取结束时间
     */
    public $end_time = NULL;

    /**
     * limit_num_one_person	number	领张数
     */
    public $limit_num_one_person = NULL;

    /**
     * total_num	number	总发放量
     */
    public $total_num = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->start_time)) {
            $params['start_time'] = $this->start_time;
        }

        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }

        if ($this->isNotNull($this->limit_num_one_person)) {
            $params['limit_num_one_person'] = $this->limit_num_one_person;
        }

        if ($this->isNotNull($this->total_num)) {
            $params['total_num'] = $this->total_num;
        }
        return $params;
    }
}
