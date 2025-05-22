<?php

namespace Weixin\Wx\Express\Business\Model\Order;

/**
 * 收件人信息
 */
class Receiver extends \Weixin\Model\Base
{
    // name	string	否	发/收件人姓名，不超过64字节
    public $name = NULL;
    // tel	string	否	发/收件人座机号码，若不填写则必须填写 mobile，不超过32字节
    public $tel = NULL;
    // mobile	string	否	发/收件人手机号码，若不填写则必须填写 tel，不超过32字节
    public $mobile = NULL;
    // company	string	否	发/收件人公司名称，不超过64字节
    public $company = NULL;
    // post_code	string	否	发/收件人邮编，不超过10字节
    public $post_code = NULL;
    // country	string	否	发/收件人国家，不超过64字节
    public $country = NULL;
    // province	string	否	发/收件人省份，比如："广东省"，不超过64字节
    public $province = NULL;
    // city	string	否	发/收件人市/地区，比如："广州市"，不超过64字节
    public $city = NULL;
    // area	string	否	发/收件人区/县，比如："海珠区"，不超过64字节
    public $area = NULL;
    // address	string	否	发/收件人详细地址，比如："XX路XX号XX大厦XX"，不超过512字节
    public $address = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // name	string	否	发/收件人姓名，不超过64字节
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        // tel	string	否	发/收件人座机号码，若不填写则必须填写 mobile，不超过32字节
        if ($this->isNotNull($this->tel)) {
            $params['tel'] = $this->tel;
        }
        // mobile	string	否	发/收件人手机号码，若不填写则必须填写 tel，不超过32字节
        if ($this->isNotNull($this->mobile)) {
            $params['mobile'] = $this->mobile;
        }
        // company	string	否	发/收件人公司名称，不超过64字节
        if ($this->isNotNull($this->company)) {
            $params['company'] = $this->company;
        }
        // post_code	string	否	发/收件人邮编，不超过10字节
        if ($this->isNotNull($this->post_code)) {
            $params['post_code'] = $this->post_code;
        }
        // country	string	否	发/收件人国家，不超过64字节
        if ($this->isNotNull($this->country)) {
            $params['country'] = $this->country;
        }
        // province	string	否	发/收件人省份，比如："广东省"，不超过64字节
        if ($this->isNotNull($this->province)) {
            $params['province'] = $this->province;
        }
        // city	string	否	发/收件人市/地区，比如："广州市"，不超过64字节
        if ($this->isNotNull($this->city)) {
            $params['city'] = $this->city;
        }
        // area	string	否	发/收件人区/县，比如："海珠区"，不超过64字节
        if ($this->isNotNull($this->area)) {
            $params['area'] = $this->area;
        }
        // address	string	否	发/收件人详细地址，比如："XX路XX号XX大厦XX"，不超过512字节
        if ($this->isNotNull($this->address)) {
            $params['address'] = $this->address;
        }
        return $params;
    }
}
