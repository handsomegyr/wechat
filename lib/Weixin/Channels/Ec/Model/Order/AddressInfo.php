<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 地址
 */
class AddressInfo extends \Weixin\Model\Base
{
    /**
     * user_name	string	否	收货人姓名，订单deliver_method=0必填
     */
    public $user_name = NULL;

    /**
     * postal_code	string	否	邮编
     */
    public $postal_code = NULL;

    /**
     * province_name	string	否	省份，订单deliver_method=0必填
     */
    public $province_name = NULL;

    /**
     * city_name	string	否	城市，订单deliver_method=0必填
     */
    public $city_name = NULL;
    /**
     * county_name	string	否	区
     */
    public $county_name = NULL;
    /**
     * detail_info	string	否	详细地址，订单deliver_method=0必填
     */
    public $detail_info = NULL;
    /**
     * national_code	string	否	国家码
     */
    public $national_code = NULL;
    /**
     * tel_number	string	否	普通订单联系方式，订单deliver_method=0必填
     */
    public $tel_number = NULL;
    /**
     * house_number	string	否	门牌号码
     */
    public $house_number = NULL;
    /**
     * virtual_order_tel_number	string	否	虚拟商品订单联系方式，虚拟商品订单必填(deliver_method=1)
     */
    public $virtual_order_tel_number = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->user_name)) {
            $params['user_name'] = $this->user_name;
        }
        if ($this->isNotNull($this->postal_code)) {
            $params['postal_code'] = $this->postal_code;
        }
        if ($this->isNotNull($this->province_name)) {
            $params['province_name'] = $this->province_name;
        }
        if ($this->isNotNull($this->city_name)) {
            $params['city_name'] = $this->city_name;
        }
        if ($this->isNotNull($this->county_name)) {
            $params['county_name'] = $this->county_name;
        }
        if ($this->isNotNull($this->detail_info)) {
            $params['detail_info'] = $this->detail_info;
        }
        if ($this->isNotNull($this->national_code)) {
            $params['national_code'] = $this->national_code;
        }
        if ($this->isNotNull($this->tel_number)) {
            $params['tel_number'] = $this->tel_number;
        }
        if ($this->isNotNull($this->house_number)) {
            $params['house_number'] = $this->house_number;
        }
        if ($this->isNotNull($this->virtual_order_tel_number)) {
            $params['virtual_order_tel_number'] = $this->virtual_order_tel_number;
        }
        return $params;
    }
}
