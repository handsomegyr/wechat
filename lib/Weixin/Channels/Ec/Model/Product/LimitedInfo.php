<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 限购
 */
class LimitedInfo extends \Weixin\Model\Base
{
    /**
     * limited_info.period_type	number	否	限购周期类型，0:无限购（默认），1:按自然日限购，2:按自然周限购，3:按自然月限购，4:按自然年限购
     */
    public $period_type = NULL;
    /**
     * limited_info.limited_buy_num	number	否	限购数量
     */
    public $limited_buy_num = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->period_type)) {
            $params['period_type'] = $this->period_type;
        }

        if ($this->isNotNull($this->limited_buy_num)) {
            $params['limited_buy_num'] = $this->limited_buy_num;
        }

        return $params;
    }
}
