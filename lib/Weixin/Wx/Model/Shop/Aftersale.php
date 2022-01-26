<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 售后
 */
class Aftersale extends \Weixin\Model\Base
{
    /**
     * out_order_id	string	是	商家自定义订单ID
     */
    public $out_order_id = NULL;

    /**
     * out_aftersale_id	string	是	商家自定义售后ID
     */
    public $out_aftersale_id = NULL;

    /**
     * path	string	是	商家小程序该售后单的页面path，不存在则使用订单path
     */
    public $path = NULL;

    /**
     * refund	number	是	退款金额,单位：分
     */
    public $refund = NULL;

    /**
     * openid	string	是	用户的openid
     */
    public $openid = NULL;

    /**
     * type	number	是	售后类型，1:退款,2:退款退货,3:换货
     */
    public $type = NULL;

    /**
     * create_time	string	是	发起申请时间，yyyy-MM-dd HH:mm:ss
     */
    public $create_time = NULL;

    /**
     * status	number	是	0:未受理,1:用户取消,2:商家受理中,3:商家逾期未处理,4:商家拒绝退款,5:商家拒绝退货退款,6:待买家退货,7:退货退款关闭,8:待商家收货,11:商家退款中,12:商家逾期未退款,13:退款完成,14:退货退款完成,15:换货完成,16:待商家发货,17:待用户确认收货,18:商家拒绝换货,19:商家已收到货
     */
    public $status = NULL;

    /**
     * finish_all_aftersale	number	是	0:订单可继续售后, 1:订单无继续售后
     */
    public $finish_all_aftersale = NULL;

    /**
     * product_infos	object array	是	退货相关商品列表
     */
    public $product_infos = NULL;

    /**
     * refund_reason	string	否	退款原因
     */
    public $refund_reason = NULL;

    /**
     * refund_address	string	否	买家收货地址
     */
    public $refund_address = NULL;

    /**
     * orderamt	number	否	退款金额
     */
    public $orderamt = NULL;


    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->out_order_id)) {
            $params['out_order_id'] = $this->out_order_id;
        }

        if ($this->isNotNull($this->out_aftersale_id)) {
            $params['out_aftersale_id'] = $this->out_aftersale_id;
        }

        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }

        if ($this->isNotNull($this->refund)) {
            $params['refund'] = $this->refund;
        }

        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }

        if ($this->isNotNull($this->type)) {
            $params['type'] = $this->type;
        }

        if ($this->isNotNull($this->create_time)) {
            $params['create_time'] = $this->create_time;
        }

        if ($this->isNotNull($this->status)) {
            $params['status'] = $this->status;
        }

        if ($this->isNotNull($this->finish_all_aftersale)) {
            $params['finish_all_aftersale'] = $this->finish_all_aftersale;
        }

        if ($this->isNotNull($this->product_infos)) {
            foreach ($this->product_infos as $product_info) {
                $params['product_infos'][] = $product_info->getParams();
            }
        }

        if ($this->isNotNull($this->refund_reason)) {
            $params['refund_reason'] = $this->refund_reason;
        }

        if ($this->isNotNull($this->refund_address)) {
            $params['refund_address'] = $this->refund_address;
        }

        if ($this->isNotNull($this->orderamt)) {
            $params['orderamt'] = $this->orderamt;
        }

        return $params;
    }
}
