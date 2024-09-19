<?php

namespace Weixin\Channels\Ec\Model\Product\SizeChart;

/**
 * 尺码表属性
 */
class Specification extends \Weixin\Model\Base
{
    /**
     * size_chart.specification_list[].name	string	是	尺码属性名称
     */
    public $name = NULL;
    /**
     * size_chart.specification_list[].unit	string	是	尺码属性值的单位
     */
    public $unit = NULL;
    /**
     * size_chart.specification_list[].is_range	bool	是	尺码属性值是否为区间
     */
    public $is_range = NULL;
    /**
     * size_chart.specification_list[].value_list	array	是	尺码值与尺码属性值的映射列表
     */
    public $value_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->unit)) {
            $params['unit'] = $this->unit;
        }
        if ($this->isNotNull($this->is_range)) {
            $params['is_range'] = $this->is_range;
        }
        if ($this->isNotNull($this->value_list)) {
            foreach ($this->value_list as $vInfo) {
                $params['value_list'][] = $vInfo->getParams();
            }
        }
        return $params;
    }
}
