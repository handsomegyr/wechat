<?php

namespace Weixin\Wx\Express\Business\Model;

/**
 * 运单
 */
class Order extends \Weixin\Model\Base
{
    // order_id	string	是	订单ID，须保证全局唯一，不超过512字节
    public $order_id = NULL;
    // openid	string	是	用户openid，当add_source=2时无需填写（不发送物流服务通知）
    public $openid = NULL;
    // delivery_id	string	是	快递公司ID，参见getAllDelivery
    public $delivery_id = NULL;
    // biz_id	string	是	快递客户编码或者现付编码
    public $biz_id = NULL;
    // custom_remark	string	否	快递备注信息，比如"易碎物品"，不超过1024字节
    public $custom_remark = NULL;
    // tagid	number	否	订单标签id，用于平台型小程序区分平台上的入驻方，tagid须与入驻方账号一一对应，非平台型小程序无需填写该字段
    public $tagid = NULL;
    // add_source	number	是	订单来源，0为小程序订单，2为App或H5订单，填2则不发送物流服务通知
    public $add_source = NULL;
    // wx_appid	string	否	App或H5的appid，add_source=2时必填，需和开通了物流助手的小程序绑定同一open帐号
    public $wx_appid = NULL;

    /**
     * @var \Weixin\Wx\Express\Business\Model\Order\Sender
     * sender	object	是	发件人信息
     */
    public $sender = NULL;

    /**
     * @var \Weixin\Wx\Express\Business\Model\Order\Receiver
     * receiver	object	是	收件人信息
     */
    public $receiver = NULL;

    /**
     * @var \Weixin\Wx\Express\Business\Model\Order\Cargo
     * cargo	object	是	包裹信息，将传递给快递公司
     */
    public $cargo = NULL;

    /**
     * @var \Weixin\Wx\Express\Business\Model\Order\Shop
     * shop	object	是	商品信息，会展示到物流服务通知和电子面单中
     */
    public $shop = NULL;

    /**
     * @var \Weixin\Wx\Express\Business\Model\Order\Insured
     * insured	object	是	保价信息
     */
    public $insured = NULL;

    /**
     * @var \Weixin\Wx\Express\Business\Model\Order\Service
     * service	object	是	服务类型
     */
    public $service = NULL;
    // expect_time	number	否	Unix 时间戳, 单位秒，顺丰必须传。 预期的上门揽件时间，0表示已事先约定取件时间；否则请传预期揽件时间戳，需大于当前时间，收件员会在预期时间附近上门。例如expect_time为“1557989929”，表示希望收件员将在2019年05月16日14:58:49-15:58:49内上门取货。说明：若选择 了预期揽件时间，请不要自己打单，由上门揽件的时候打印。如果是下顺丰散单，则必传此字段，否则不会有收件员上门揽件。
    public $expect_time = NULL;
    // take_mode	number	否	分单策略，【0：线下网点签约，1：总部签约结算】，不传默认线下网点签约。目前支持圆通。
    public $take_mode = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // order_id	string	是	订单ID，须保证全局唯一，不超过512字节
        if ($this->isNotNull($this->order_id)) {
            $params['order_id'] = $this->order_id;
        }
        // openid	string	是	用户openid，当add_source=2时无需填写（不发送物流服务通知）
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        // delivery_id	string	是	快递公司ID，参见getAllDelivery
        if ($this->isNotNull($this->delivery_id)) {
            $params['delivery_id'] = $this->delivery_id;
        }
        // biz_id	string	是	快递客户编码或者现付编码
        if ($this->isNotNull($this->biz_id)) {
            $params['biz_id'] = $this->biz_id;
        }
        // custom_remark	string	否	快递备注信息，比如"易碎物品"，不超过1024字节
        if ($this->isNotNull($this->custom_remark)) {
            $params['custom_remark'] = $this->custom_remark;
        }
        // tagid	number	否	订单标签id，用于平台型小程序区分平台上的入驻方，tagid须与入驻方账号一一对应，非平台型小程序无需填写该字段
        if ($this->isNotNull($this->tagid)) {
            $params['tagid'] = $this->tagid;
        }
        // add_source	number	是	订单来源，0为小程序订单，2为App或H5订单，填2则不发送物流服务通知
        if ($this->isNotNull($this->add_source)) {
            $params['add_source'] = $this->add_source;
        }
        // wx_appid	string	否	App或H5的appid，add_source=2时必填，需和开通了物流助手的小程序绑定同一open帐号
        if ($this->isNotNull($this->wx_appid)) {
            $params['wx_appid'] = $this->wx_appid;
        }
        // sender	object	是	发件人信息
        if ($this->isNotNull($this->sender)) {
            $params['sender'] = $this->sender->getParams();
        }
        // receiver	object	是	收件人信息
        if ($this->isNotNull($this->receiver)) {
            $params['receiver'] = $this->receiver;
        }
        // cargo	object	是	包裹信息，将传递给快递公司
        if ($this->isNotNull($this->cargo)) {
            $params['cargo'] = $this->cargo->getParams();
        }
        // shop	object	是	商品信息，会展示到物流服务通知和电子面单中
        if ($this->isNotNull($this->shop)) {
            $params['shop'] = $this->shop->getParams();
        }
        // insured	object	是	保价信息
        if ($this->isNotNull($this->insured)) {
            $params['insured'] = $this->insured->getParams();
        }
        // service	object	是	服务类型
        if ($this->isNotNull($this->service)) {
            $params['service'] = $this->service->getParams();
        }
        // expect_time	number	否	Unix 时间戳, 单位秒，顺丰必须传。 预期的上门揽件时间，0表示已事先约定取件时间；否则请传预期揽件时间戳，需大于当前时间，收件员会在预期时间附近上门。例如expect_time为“1557989929”，表示希望收件员将在2019年05月16日14:58:49-15:58:49内上门取货。说明：若选择 了预期揽件时间，请不要自己打单，由上门揽件的时候打印。如果是下顺丰散单，则必传此字段，否则不会有收件员上门揽件。
        if ($this->isNotNull($this->expect_time)) {
            $params['expect_time'] = $this->expect_time;
        }
        // take_mode	number	否	分单策略，【0：线下网点签约，1：总部签约结算】，不传默认线下网点签约。目前支持圆通。
        if ($this->isNotNull($this->take_mode)) {
            $params['take_mode'] = $this->take_mode;
        }

        return $params;
    }
}
