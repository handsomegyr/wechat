<?php

namespace Weixin\Wx\Model\Shop\Spu;

/**
 * 商品详情
 */
class DescInfo extends \Weixin\Model\Base
{
    /**
     * desc	string	否	商品详情图文
     */
    public $desc = NULL;

    /**
     * imgs	string array	否	商品详情图片
     */
    public $imgs = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->desc)) {
            $params['desc'] = $this->desc;
        }

        if ($this->isNotNull($this->imgs)) {
            $params['imgs'] = $this->imgs;
        }

        return $params;
    }
}
