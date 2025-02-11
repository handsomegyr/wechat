<?php

namespace Weixin\Channels\Ec\Model\Promoter;

/**
 * 商品查询条件
 */
class SpuItemCondition extends \Weixin\Model\Base
{
    // selling_price_range	object Range	售卖价区间，单位是分。结构体详情请参考Range结构体
    public $selling_price_range = NULL;
    // monthly_sales_range	object Range	月销量区间，结构体详情请参考Range结构体
    public $monthly_sales_range = NULL;
    // flags	string array	保障标，0-7天无理由；1-运费险；2-品牌（已废弃）；3-放心买；4-损坏包退；5-假一赔三；6-先用后付；7-包邮；
    public $flags = NULL;
    // service_fee_rate_range	object Range	服务费率区间，单位是10万分之。结构体详情请参考Range结构体
    public $service_fee_rate_range = NULL;
    // commission_rate_range	object Range	佣金率区间，单位是10万分之。结构体详情请参考Range结构体
    public $commission_rate_range = NULL;
    // promote_time_range	object Range	推广时间范围，结构体详情请参考Range结构体
    public $promote_time_range = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->selling_price_range)) {
            $params['selling_price_range'] = $this->selling_price_range->getParams();
        }
        if ($this->isNotNull($this->monthly_sales_range)) {
            $params['monthly_sales_range'] = $this->monthly_sales_range->getParams();
        }
        if ($this->isNotNull($this->flags)) {
            $params['flags'] = $this->flags;
        }
        if ($this->isNotNull($this->service_fee_rate_range)) {
            $params['service_fee_rate_range'] = $this->service_fee_rate_range->getParams();
        }
        if ($this->isNotNull($this->commission_rate_range)) {
            $params['commission_rate_range'] = $this->commission_rate_range->getParams();
        }
        if ($this->isNotNull($this->promote_time_range)) {
            $params['promote_time_range'] = $this->promote_time_range->getParams();
        }
        return $params;
    }
}
