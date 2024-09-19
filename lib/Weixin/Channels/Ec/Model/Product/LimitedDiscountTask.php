<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 限时抢购任务
 */
class LimitedDiscountTask extends \Weixin\Model\Base
{
    /**
     * product_id	string(uint64)	是	参与抢购的商品ID
     */
    public $product_id = NULL;
    /**
     * start_time	number	是	限时抢购任务开始时间(秒级时间戳)，只能取大于等于当前时间的值(允许有最多十分钟的误差)，且距离当前时间不得超过一年（365天）
     */
    public $start_time = NULL;
    /**
     * end_time	number	是	限时抢购任务结束时间(秒级时间戳)，必须大于当前时间以及start_time，且距离当前时间不得超过一年（365天）
     */
    public $end_time = NULL;
    /**
     * limited_discount_skus array	是	参与抢购的商品
     */
    public $limited_discount_skus = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->product_id)) {
            $params['product_id'] = $this->product_id;
        }
        if ($this->isNotNull($this->start_time)) {
            $params['start_time'] = $this->start_time;
        }
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }
        if ($this->isNotNull($this->limited_discount_skus)) {
            foreach ($this->limited_discount_skus as $limited_discount_sku) {
                $params['limited_discount_skus'][] = $limited_discount_sku->getParams();
            }
        }
        return $params;
    }
}
