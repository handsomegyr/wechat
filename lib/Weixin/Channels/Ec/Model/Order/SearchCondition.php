<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 搜索条件
 */
class SearchCondition extends \Weixin\Model\Base
{
    /**
     * title	string	否	商品标题关键词
     */
    public $title = NULL;

    /**
     * sku_code	string	否	商品编码
     */
    public $sku_code = NULL;

    /**
     * user_name	string	否	收件人
     */
    public $user_name = NULL;

    /**
     * tel_number	string	否	收件人电话，当前字段已经废弃，请勿使用，如果原本填手机后四位，可正常使用，否则接口报错
     */
    public $tel_number = NULL;

    /**
     * tel_number_last4	string	否	收件人电话后四位
     */
    public $tel_number_last4 = NULL;

    /**
     * order_id	string	否	选填，只搜一个订单时使用
     */
    public $order_id = NULL;

    /**
     * merchant_notes	string	否	商家备注
     */
    public $merchant_notes = NULL;

    /**
     * customer_notes	string	否	买家备注
     */
    public $customer_notes = NULL;

    /**
     * address_under_review	bool	否	申请修改地址审核中
     */
    public $address_under_review = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->title)) {
            $params['title'] = $this->title;
        }
        if ($this->isNotNull($this->sku_code)) {
            $params['sku_code'] = $this->sku_code;
        }
        if ($this->isNotNull($this->user_name)) {
            $params['user_name'] = $this->user_name;
        }
        if ($this->isNotNull($this->tel_number)) {
            $params['tel_number'] = $this->tel_number;
        }
        if ($this->isNotNull($this->tel_number_last4)) {
            $params['tel_number_last4'] = $this->tel_number_last4;
        }
        if ($this->isNotNull($this->order_id)) {
            $params['order_id'] = $this->order_id;
        }
        if ($this->isNotNull($this->merchant_notes)) {
            $params['merchant_notes'] = $this->merchant_notes;
        }
        if ($this->isNotNull($this->customer_notes)) {
            $params['customer_notes'] = $this->customer_notes;
        }
        if ($this->isNotNull($this->address_under_review)) {
            $params['address_under_review'] = $this->address_under_review;
        }
        return $params;
    }
}
