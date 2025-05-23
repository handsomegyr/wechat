<?php

namespace Weixin\Wx\Express\Delivery\Model\NoWorryReturn;

/**
 * goods_list内对象
 */
class GoodsInfo extends \Weixin\Model\Base
{
    // name	string	是	退货商品的名称
    public $name = NULL;
    // url	string	是	退货商品图片的url
    public $url = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // name	string	是	退货商品的名称
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        // url	string	是	退货商品图片的url
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        return $params;
    }
}
