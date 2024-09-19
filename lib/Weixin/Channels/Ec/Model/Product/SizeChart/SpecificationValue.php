<?php

namespace Weixin\Channels\Ec\Model\Product\SizeChart;

/**
 * 尺码表属性值
 */
class SpecificationValue extends \Weixin\Model\Base
{
    /**
     * size_chart.specification_list[].value_list[].key	string	是	尺码值，需与商品属性中的尺码规格保持一致
     */
    public $key = NULL;
    /**
     * size_chart.specification_list[].value_list[].value	string	否	尺码属性值；属性值为单值时填写；不能超过5个字符
     */
    public $value = NULL;
    /**
     * size_chart.specification_list[].value_list[].left	string	否	尺码属性值的左边界，需小于右边界；属性值为区间时填写；不能超过5个字符
     */
    public $left = NULL;
    /**
     * size_chart.specification_list[].value_list[].right	string	否	尺码属性值的右边界，需大于左边界；属性值为区间时填写；不能超过5个字符
     */
    public $right = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->key)) {
            $params['key'] = $this->key;
        }
        if ($this->isNotNull($this->value)) {
            $params['value'] = $this->value;
        }
        if ($this->isNotNull($this->left)) {
            $params['left'] = $this->left;
        }
        if ($this->isNotNull($this->right)) {
            $params['right'] = $this->right;
        }
        return $params;
    }
}
