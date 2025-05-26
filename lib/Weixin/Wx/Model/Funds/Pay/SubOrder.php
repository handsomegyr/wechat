<?php

namespace Weixin\Wx\Model\Funds\Pay;

/**
 * 子订单
 */
class SubOrder extends \Weixin\Model\Base
{
    // mchid	string	是	交易单对应的商家商户号
    public $mchid = NULL;
    // description	string	是	商品描述
    public $description = NULL;
    // amount	number	是	订单金额，单位为分
    public $amount = NULL;
    // trade_no	string	是	商家交易单号，只能是数字、大小写字母_-|*@ ，长度为6～32个字符，小程序系统内保证唯一。同一trade_no不允许修改价格等参数。
    public $trade_no = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // mchid	string	是	交易单对应的商家商户号
        if ($this->isNotNull($this->mchid)) {
            $params['mchid'] = $this->mchid;
        }
        // description	string	是	商品描述
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        // amount	number	是	订单金额，单位为分
        if ($this->isNotNull($this->amount)) {
            $params['amount'] = $this->amount;
        }
        // trade_no	string	是	商家交易单号，只能是数字、大小写字母_-|*@ ，长度为6～32个字符，小程序系统内保证唯一。同一trade_no不允许修改价格等参数。
        if ($this->isNotNull($this->trade_no)) {
            $params['trade_no'] = $this->trade_no;
        }
        return $params;
    }
}
