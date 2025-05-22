<?php

namespace Weixin\Wx\Express\Business\Model\Order;

/**
 * 货物
 */
class GoodsDetail extends \Weixin\Model\Base
{
    // name	string	是	商品名，不超过128字节
    public $name = NULL;
    // count	number	是	商品数量
    public $count = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // name	string	是	商品名，不超过128字节
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        // count	number	是	商品数量   
        if ($this->isNotNull($this->count)) {
            $params['count'] = $this->count;
        }
        return $params;
    }
}
