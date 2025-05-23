<?php

namespace Weixin\Wx\Model\InsuranceFreightOrder;

/**
 * 地址
 */
class Place extends \Weixin\Model\Base
{
    // - province	省	string	Y
    public $province = NULL;
    // - city	市	string	Y
    public $city = NULL;
    // - county	区	string	Y
    public $county = NULL;
    // - address	详细地址	string	Y
    public $address = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // - province	省	string	Y
        if ($this->isNotNull($this->province)) {
            $params['province'] = $this->province;
        }
        // - city	市	string	Y
        if ($this->isNotNull($this->city)) {
            $params['city'] = $this->city;
        }
        // - county	区	string	Y
        if ($this->isNotNull($this->county)) {
            $params['county'] = $this->county;
        }
        // - address	详细地址	string	Y
        if ($this->isNotNull($this->address)) {
            $params['address'] = $this->address;
        }
        return $params;
    }
}
