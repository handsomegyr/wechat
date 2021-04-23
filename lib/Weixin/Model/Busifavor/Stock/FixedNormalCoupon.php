<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 固定面额满减券使用规则
 */
class FixedNormalCoupon extends Base
{
    /**
     * 优惠金额 discount_amount int 是 优惠金额，单位：分。特殊规则：取值范围 1 ≤ value ≤ 10000000 示例值：5
     */
    public $discount_amount = null;
    /**
     * 消费门槛 transaction_minimum int 是 消费门槛，单位：分。特殊规则：取值范围 1 ≤ value ≤ 10000000 示例值：100
     */
    public $transaction_minimum = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->discount_amount)) {
            $params['discount_amount'] = $this->discount_amount;
        }
        if ($this->isNotNull($this->transaction_minimum)) {
            $params['transaction_minimum'] = $this->transaction_minimum;
        }
        return $params;
    }
}
