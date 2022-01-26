<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 有效期
 */
class ValidInfo extends \Weixin\Model\Base
{
    /**
     * valid_type	number	有效期类型,1:商品指定时间区间,2:生效天数,3:生效秒数
     */
    public $valid_type = NULL;

    /**
     * valid_day_num	number	生效天数，有效期类型为2时必需
     */
    public $valid_day_num = NULL;

    /**
     * valid_second	number	生效秒数，有效期类型为3时必需
     */
    public $valid_second = NULL;

    /**
     * start_time	number	生效开始时间，有效期类型为1时必需
     */
    public $start_time = NULL;

    /**
     * end_time	number	生效结束时间，有效期类型为1时必需
     */
    public $end_time = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->valid_type)) {
            $params['valid_type'] = $this->valid_type;
        }

        if ($this->isNotNull($this->valid_day_num)) {
            $params['valid_day_num'] = $this->valid_day_num;
        }

        if ($this->isNotNull($this->valid_second)) {
            $params['valid_second'] = $this->valid_second;
        }

        if ($this->isNotNull($this->start_time)) {
            $params['start_time'] = $this->start_time;
        }

        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }

        return $params;
    }
}
