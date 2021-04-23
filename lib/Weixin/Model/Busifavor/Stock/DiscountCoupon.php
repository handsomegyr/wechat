<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 折扣券使用规则
 */
class DiscountCoupon extends Base
{
    /**
     * 折扣比例 discount_percent int 是 折扣百分比，例如：88为八八折。 示例值：88
     */
    public $discount_percent = null;
    /**
     * 消费门槛 transaction_minimum int 是 消费门槛，单位：分。 特殊规则：取值范围 1 ≤ value ≤ 10000000 示例值：100
     */
    public $transaction_minimum = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->discount_percent)) {
            $params['discount_percent'] = $this->discount_percent;
        }
        if ($this->isNotNull($this->transaction_minimum)) {
            $params['transaction_minimum'] = $this->transaction_minimum;
        }
        return $params;
    }
}
