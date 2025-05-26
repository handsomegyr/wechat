<?php

namespace Weixin\Wx\Model\Funds\Pay;

/**
 * 订单
 */
class Order extends \Weixin\Model\Base
{
    // openid	string	是	用户的openid
    public $openid = NULL;
    // combine_trade_no	string	是	商家合单支付总交易单号，长度为6～32个字符，只能是数字、大小写字母_-|*@，小程序系统内保证唯一。同一combine_trade_no视为同一请求，不允许修改子单等参数。
    public $combine_trade_no = NULL;
    // expire_time	number	否	订单失效时间，秒级时间戳
    public $expire_time = NULL;
    // sub_orders	Array Object SubOrder	是	子单列表
    public $sub_orders = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // openid	string	是	用户的openid
        if ($this->isNotNull($this->openid)) {
            $params['openid'] = $this->openid;
        }
        // combine_trade_no	string	是	商家合单支付总交易单号，长度为6～32个字符，只能是数字、大小写字母_-|*@，小程序系统内保证唯一。同一combine_trade_no视为同一请求，不允许修改子单等参数。
        if ($this->isNotNull($this->combine_trade_no)) {
            $params['combine_trade_no'] = $this->combine_trade_no;
        }
        // expire_time	number	否	订单失效时间，秒级时间戳
        if ($this->isNotNull($this->expire_time)) {
            $params['expire_time'] = $this->expire_time;
        }
        // sub_orders	Array Object SubOrder	是	子单列表
        if ($this->isNotNull($this->sub_orders)) {
            foreach ($this->sub_orders as $detail) {
                $params['sub_orders'][] = $detail->getParams();
            }
        }
        return $params;
    }
}
