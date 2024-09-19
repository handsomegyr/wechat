<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 商品资质
 */
class ProductQuaInfo extends \Weixin\Model\Base
{
    /**
     * product_qua_infos[].qua_id	string(uint64)	否	商品资质id，对应获取类目信息中的字段product_qua_list[].qua_id
     */
    public $qua_id = NULL;
    /**
     * product_qua_infos[].qua_url[]	array(string)	否	商品资质图片列表（单个商品资质id下，最多10张）
     */
    public $qua_url = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->qua_id)) {
            $params['qua_id'] = $this->qua_id;
        }

        if ($this->isNotNull($this->qua_url)) {
            $params['qua_url'] = $this->qua_url;
        }

        return $params;
    }
}
