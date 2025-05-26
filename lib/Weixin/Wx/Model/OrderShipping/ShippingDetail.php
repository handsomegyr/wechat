<?php

namespace Weixin\Wx\Model\OrderShipping;

/**
 * 物流信息
 */
class ShippingDetail extends \Weixin\Model\Base
{
    // tracking_no	string	否	物流单号，物流快递发货时必填，示例值: 323244567777 字符字节限制: [1, 128]
    public $tracking_no = NULL;
    // express_company	string	否	物流公司编码，快递公司ID，参见「获取运力 id 列表get_delivery_list」，物流快递发货时必填， 示例值: DHL 字符字节限制: [1, 128]
    public $express_company = NULL;
    // item_desc	string	是	商品信息，例如：微信红包抱枕*1个，限120个字以内
    public $item_desc = NULL;

    /**
     * @var \Weixin\Wx\Model\OrderShipping\Contact
     * contact	object	否	联系方式，当发货的物流公司为顺丰时，联系方式为必填，收件人或寄件人联系方式二选一
     */
    public $contact = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // tracking_no	string	否	物流单号，物流快递发货时必填，示例值: 323244567777 字符字节限制: [1, 128]
        if ($this->isNotNull($this->tracking_no)) {
            $params['tracking_no'] = $this->tracking_no;
        }
        // express_company	string	否	物流公司编码，快递公司ID，参见「获取运力 id 列表get_delivery_list」，物流快递发货时必填， 示例值: DHL 字符字节限制: [1, 128]
        if ($this->isNotNull($this->express_company)) {
            $params['express_company'] = $this->express_company;
        }
        // item_desc	string	是	商品信息，例如：微信红包抱枕*1个，限120个字以内
        if ($this->isNotNull($this->item_desc)) {
            $params['item_desc'] = $this->item_desc;
        }
        // contact	object	否	联系方式，当发货的物流公司为顺丰时，联系方式为必填，收件人或寄件人联系方式二选一
        if ($this->isNotNull($this->contact)) {
            $params['contact'] = $this->contact->getParams();
        }
        return $params;
    }
}
