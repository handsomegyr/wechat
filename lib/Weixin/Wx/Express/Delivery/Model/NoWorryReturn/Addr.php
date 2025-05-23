<?php

namespace Weixin\Wx\Express\Delivery\Model\NoWorryReturn;

/**
 * 地址
 */
class Addr extends \Weixin\Model\Base
{
    // "name": "张三",
    // "mobile": "13600000000",//仅支持输入一个联系方式
    // "country": "中国",
    // "province": "广东省",
    // "city": "广州市",
    // "area": "海珠区",
    // "address": "xx路xx号"

    // - name	姓名	string	Y
    public $name = NULL;
    // - mobile	手机号	string	Y
    public $mobile = NULL;
    // - country	国家	string	Y
    public $country = NULL;
    // - province	省	string	Y
    public $province = NULL;
    // - city	市	string	Y
    public $city = NULL;
    // - area	区	string	Y
    public $area = NULL;
    // - address	详细地址	string	Y
    public $address = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // - name	姓名	string	Y
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        // - mobile	手机号	string	Y
        if ($this->isNotNull($this->mobile)) {
            $params['mobile'] = $this->mobile;
        }
        // - country	国家	string	Y
        if ($this->isNotNull($this->country)) {
            $params['country'] = $this->country;
        }
        // - province	省	string	Y
        if ($this->isNotNull($this->province)) {
            $params['province'] = $this->province;
        }
        // - city	市	string	Y
        if ($this->isNotNull($this->city)) {
            $params['city'] = $this->city;
        }
        // - area	区	string	Y
        if ($this->isNotNull($this->area)) {
            $params['area'] = $this->area;
        }
        // - address	详细地址	string	Y
        if ($this->isNotNull($this->address)) {
            $params['address'] = $this->address;
        }
        return $params;
    }
}
