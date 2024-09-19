<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 售后
 */
class AfterSaleInfo extends \Weixin\Model\Base
{
    /**
     * after_sale_info.after_sale_address_id	number	否	售后地址id，使用地址管理相关接口进行添加或获取
     */
    public $after_sale_address_id = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->after_sale_address_id)) {
            $params['after_sale_address_id'] = $this->after_sale_address_id;
        }

        return $params;
    }
}
