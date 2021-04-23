<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 换购券使用规则
 */
class ExchangeCoupon extends Base
{
    /**
     * 单品换购价 exchange_price int 是 单品换购价，单位：分。 特殊规则：取值范围 0 ≤ value ≤ 10000000示例值：100
     */
    public $exchange_price = null;
    /**
     * 消费门槛 transaction_minimum int 是 消费门槛，单位：分。 特殊规则：取值范围 1 ≤ value ≤ 10000000示例值：100
     */
    public $transaction_minimum = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->exchange_price)) {
            $params['exchange_price'] = $this->exchange_price;
        }
        if ($this->isNotNull($this->transaction_minimum)) {
            $params['transaction_minimum'] = $this->transaction_minimum;
        }
        return $params;
    }
}
