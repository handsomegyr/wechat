<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 尺码表
 */
class SizeChart extends \Weixin\Model\Base
{
    /**
     * size_chart.enable	bool	否	是否启用尺码表
     */
    public $enable = NULL;

    /**
     * size_chart.specification_list	array	否	尺码表，启用尺码表时必填
     */
    public $specification_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->enable)) {
            $params['enable'] = $this->enable;
        }

        if ($this->isNotNull($this->specification_list)) {
            foreach ($this->specification_list as $info) {
                $params['specification_list'][] = $info->getParams();
            }
        }

        return $params;
    }
}
