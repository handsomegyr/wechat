<?php

namespace Weixin\Channels\Ec\Model\Promoter;

/**
 * 范围
 */
class Range extends \Weixin\Model\Base
{
    // min	string	区间最小值
    public $min = NULL;
    // max	string	区间最大值
    public $max = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->min)) {
            $params['min'] = $this->min;
        }
        if ($this->isNotNull($this->max)) {
            $params['max'] = $this->max;
        }
        return $params;
    }
}
