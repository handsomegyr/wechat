<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 运费模板
 */
class ExpressInfo extends \Weixin\Model\Base
{
    /**
     * express_info.template_id	string(uint64)	否	运费模板ID（先通过获取运费模板接口拿到），若deliver_method=1，则不用填写
     */
    public $template_id = NULL;
    /**
     * express_info.weight	number	否	商品重量，单位克，若当前运费模版计价方式为[按重量]，则必填
     */
    public $weight = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->template_id)) {
            $params['template_id'] = $this->template_id;
        }

        if ($this->isNotNull($this->weight)) {
            $params['weight'] = $this->weight;
        }

        return $params;
    }
}
