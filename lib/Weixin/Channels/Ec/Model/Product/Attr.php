<?php

namespace Weixin\Channels\Ec\Model\Product;

/**
 * 属性
 */
class Attr extends \Weixin\Model\Base
{
    /**
     * attrs[].attr_key	string	是	属性键key（属性自定义用）
     */
    public $attr_key = NULL;

    /**
     * attrs[].attr_value	string	是	属性值（属性自定义用）。如果添加时没录入，回包可能不包含该字段，参数规则如下：
     * ● 当获取类目信息接口中返回的type：为 select_many，
     * attr_value的格式：多个选项用分号;隔开
     * 示例：某商品的适用人群属性，选择了：青年、中年，则 attr_value的值为：青年;中年
     * ● 当获取类目信息接口中返回的type：为 integer_unit/decimal4_unit
     * attr_value格式：数值 单位，用单个空格隔开
     * 示例：某商品的重量属性，要求integer_unit属性类型，数值部分为 18，单位选择为kg，则 attr_value的值为：18 kg
     * ● 当获取类目信息接口中返回的type：为 integer/decimal4
     * attr_value 的格式：字符串形式的数字
     */
    public $attr_value = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->attr_key)) {
            $params['attr_key'] = $this->attr_key;
        }

        if ($this->isNotNull($this->attr_value)) {
            $params['attr_value'] = $this->attr_value;
        }

        return $params;
    }
}
