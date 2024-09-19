<?php

namespace Weixin\Channels\Ec\Model\Product\Sku;

/**
 * sku库存情况
 */
class DeliverInfo extends \Weixin\Model\Base
{
    /**
     * skus[].sku_deliver_info.stock_type	number	否	sku库存情况。0:现货（默认），1:全款预售。部分类目支持全款预售，具体参考文档获取类目信息中的字段attr.pre_sale
     */
    public $stock_type = NULL;
    /**
     * skus[].sku_deliver_info.full_payment_presale_delivery_type	number	否	sku发货节点，该字段仅对stock_type=1有效。0:付款后n天发货，1:预售结束后n天发货
     */
    public $full_payment_presale_delivery_type = NULL;
    /**
     * skus[].sku_deliver_info.presale_begin_time	number	否	sku预售周期开始时间，秒级时间戳，该字段仅对delivery_type=1有效
     */
    public $presale_begin_time = NULL;
    /**
     * skus[].sku_deliver_info.presale_end_time	number	否	sku预售周期结束时间，秒级时间戳，该字段仅对delivery_type=1有效。限制：预售结束时间距离现在<=30天，即presale_end_time - now <= 2592000。预售时间区间<=15天，即presale_end_time - presale_begin_time <= 1296000
     */
    public $presale_end_time = NULL;
    /**
     * skus[].sku_deliver_info.full_payment_presale_delivery_time	number	否	sku发货时效，即付款后/预售结束后{full_payment_presale_delivery_time}天内发货，该字段仅对stock_type=1时有效。当发货节点选择“0:付款后n天发货”时，范围是[4, 15]的整数；当发货节点选择“1:预售结束后n天发货”时，范围是[1, 3]的整数
     */
    public $full_payment_presale_delivery_time = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->stock_type)) {
            $params['stock_type'] = $this->stock_type;
        }
        if ($this->isNotNull($this->full_payment_presale_delivery_type)) {
            $params['full_payment_presale_delivery_type'] = $this->full_payment_presale_delivery_type;
        }
        if ($this->isNotNull($this->presale_begin_time)) {
            $params['presale_begin_time'] = $this->presale_begin_time;
        }
        if ($this->isNotNull($this->presale_end_time)) {
            $params['presale_end_time'] = $this->presale_end_time;
        }
        if ($this->isNotNull($this->full_payment_presale_delivery_time)) {
            $params['full_payment_presale_delivery_time'] = $this->full_payment_presale_delivery_time;
        }
        return $params;
    }
}
