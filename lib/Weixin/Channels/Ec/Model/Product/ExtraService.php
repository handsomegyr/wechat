<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 额外信息
 */
class ExtraService extends \Weixin\Model\Base
{
    /**
     * extra_service.seven_day_return	number	是	是否支持七天无理由退货，0-不支持七天无理由，1-支持七天无理由，2-支持七天无理由(定制商品除外)，3-支持七天无理由(使用后不支持)。管理规则请参见七天无理由退货管理规则。类目是否必须支持七天无理由退货，可参考文档获取类目信息中的字段attr.seven_day_return
     */
    public $seven_day_return = NULL;

    /**
     * extra_service.pay_after_use	number	是	先用后付，字段已废弃。若店铺已开通先用后付，支持先用后付的类目商品将在上架后自动打开先用后付。管理规则请参见「先用后付」服务商家指南
     */
    public $pay_after_use = NULL;

    /**
     * extra_service.freight_insurance	number	是	是否支持运费险，0-不支持运费险，1-支持运费险。需要商户开通运费险服务，非必须开通运费险类目的商品依据该字段进行设置，必须开通运费险类目中的商品将默认开启运费险保障，不依据该字段。规则详情请参见 微信小店「运费险」管理规则
     */
    public $freight_insurance = NULL;

    /**
     * extra_service.fake_one_pay_three	number	否	是否支持假一赔三，0-不支持假一赔三，1-支持假一赔三。
     */
    public $fake_one_pay_three = NULL;

    /**
     * extra_service.damage_guarantee	number	否	是否支持坏损包退，0-不支持坏损包退，1-支持坏损包退。
     */
    public $damage_guarantee = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->seven_day_return)) {
            $params['seven_day_return'] = $this->seven_day_return;
        }
        if ($this->isNotNull($this->pay_after_use)) {
            $params['pay_after_use'] = $this->pay_after_use;
        }
        if ($this->isNotNull($this->freight_insurance)) {
            $params['freight_insurance'] = $this->freight_insurance;
        }
        if ($this->isNotNull($this->fake_one_pay_three)) {
            $params['fake_one_pay_three'] = $this->fake_one_pay_three;
        }
        if ($this->isNotNull($this->damage_guarantee)) {
            $params['damage_guarantee'] = $this->damage_guarantee;
        }
        return $params;
    }
}
