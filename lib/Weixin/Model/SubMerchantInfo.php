<?php
namespace Weixin\Model;

/**
 * 子商户信息
 */
class SubMerchantInfo extends Base
{

    private $merchant_id = NULL;

    public function __construct($merchant_id)
    {
        $this->merchant_id = $merchant_id;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->merchant_id)) {
            $params['merchant_id'] = $this->merchant_id;
        }
        return $params;
    }
}