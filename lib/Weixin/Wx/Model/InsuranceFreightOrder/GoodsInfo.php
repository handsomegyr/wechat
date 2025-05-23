<?php

namespace Weixin\Wx\Model\InsuranceFreightOrder;

/**
 * goods_list内对象
 */
class GoodsInfo extends \Weixin\Model\Base
{
    // name	string	Y	投保商品名称
    public $name = NULL;
    // url	string	Y	投保商品图片url
    public $url = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();
        // name	string	Y	投保商品名称
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        // url	string	Y	投保商品图片url
        if ($this->isNotNull($this->url)) {
            $params['url'] = $this->url;
        }
        return $params;
    }
}
