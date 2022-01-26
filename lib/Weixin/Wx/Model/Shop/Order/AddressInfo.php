<?php

namespace Weixin\Wx\Model\Shop\Order;

/**
 * 地址信息
 */
class AddressInfo extends \Weixin\Model\Base
{
    /**
     * receiver_name	string	是	收件人姓名
     */
    public $receiver_name = NULL;

    /**
     * detailed_address	string	是	详细收货地址信息
     */
    public $detailed_address = NULL;

    /**
     * tel_number	string	是	收件人手机号码
     */
    public $tel_number = NULL;

    /**
     * country	string	否	国家
     */
    public $country = NULL;

    /**
     * province	string	否	省份
     */
    public $province = NULL;

    /**
     * city	string	否	城市
     */
    public $city = NULL;

    /**
     * town	string	否	乡镇
     */
    public $town = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->receiver_name)) {
            $params['receiver_name'] = $this->receiver_name;
        }

        if ($this->isNotNull($this->detailed_address)) {
            $params['detailed_address'] = $this->detailed_address;
        }

        if ($this->isNotNull($this->tel_number)) {
            $params['tel_number'] = $this->tel_number;
        }

        if ($this->isNotNull($this->country)) {
            $params['country'] = $this->country;
        }

        if ($this->isNotNull($this->province)) {
            $params['province'] = $this->province;
        }

        if ($this->isNotNull($this->city)) {
            $params['city'] = $this->city;
        }

        if ($this->isNotNull($this->town)) {
            $params['town'] = $this->town;
        }
        return $params;
    }
}
