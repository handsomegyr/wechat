<?php

namespace Weixin\Wx\Express\Business\Model\Order;

/**
 * 保价信息
 */
class Insured extends \Weixin\Model\Base
{
    // use_insured	number	否	是否保价，0 表示不保价，1 表示保价
    public $use_insured = NULL;
    // insured_value	number	否	保价金额，单位是分，比如: 10000 表示 100 元
    public $insured_value = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // use_insured	number	否	是否保价，0 表示不保价，1 表示保价
        if ($this->isNotNull($this->use_insured)) {
            $params['use_insured'] = $this->use_insured;
        }
        // insured_value	number	否	保价金额，单位是分，比如: 10000 表示 100 元        
        if ($this->isNotNull($this->insured_value)) {
            $params['insured_value'] = $this->insured_value;
        }
        return $params;
    }
}
