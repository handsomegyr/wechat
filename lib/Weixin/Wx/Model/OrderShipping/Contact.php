<?php

namespace Weixin\Wx\Model\OrderShipping;

/**
 * 联系方式
 */
class Contact extends \Weixin\Model\Base
{
    // consignor_contact	string	否	寄件人联系方式，寄件人联系方式，采用掩码传输，最后4位数字不能打掩码 示例值: `189****1234, 021-****1234, ****1234, 0**2-***1234, 0**2-******23-10, ****123-8008` 值限制: 0 ≤ value ≤ 1024
    public $consignor_contact = NULL;
    // receiver_contact	string	否	收件人联系方式，收件人联系方式为，采用掩码传输，最后4位数字不能打掩码 示例值: `189****1234, 021-****1234, ****1234, 0**2-***1234, 0**2-******23-10, ****123-8008` 值限制: 0 ≤ value ≤ 1024
    public $receiver_contact = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // consignor_contact	string	否	寄件人联系方式，寄件人联系方式，采用掩码传输，最后4位数字不能打掩码 示例值: `189****1234, 021-****1234, ****1234, 0**2-***1234, 0**2-******23-10, ****123-8008` 值限制: 0 ≤ value ≤ 1024
        if ($this->isNotNull($this->consignor_contact)) {
            $params['consignor_contact'] = $this->consignor_contact;
        }
        // receiver_contact	string	否	收件人联系方式，收件人联系方式为，采用掩码传输，最后4位数字不能打掩码 示例值: `189****1234, 021-****1234, ****1234, 0**2-***1234, 0**2-******23-10, ****123-8008` 值限制: 0 ≤ value ≤ 1024
        if ($this->isNotNull($this->receiver_contact)) {
            $params['receiver_contact'] = $this->receiver_contact;
        }
        return $params;
    }
}
