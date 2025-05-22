<?php

namespace Weixin\Wx\Express\Business\Model\Order;

/**
 * 包裹信息，将传递给快递公司
 */
class Cargo extends \Weixin\Model\Base
{
    // count	number	是	包裹数量, 默认为1
    public $count = NULL;
    // weight	number	是	货物总重量，比如1.2，单位是千克(kg)
    public $weight = NULL;
    // space_x	number	是	货物长度，比如20.0，单位是厘米(cm)
    public $space_x = NULL;
    // space_y	number	是	货物宽度，比如15.0，单位是厘米(cm)
    public $space_y = NULL;
    // space_z	number	是	货物高度，比如10.0，单位是厘米(cm)
    public $space_z = NULL;
    // detail_list	array<object>	是	货物总重量，单位是千克(kg)
    public $detail_list = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        // count	number	是	包裹数量, 默认为1
        if ($this->isNotNull($this->count)) {
            $params['count'] = $this->count;
        }
        // weight	number	是	货物总重量，比如1.2，单位是千克(kg)
        if ($this->isNotNull($this->weight)) {
            $params['weight'] = $this->weight;
        }
        // space_x	number	是	货物长度，比如20.0，单位是厘米(cm)
        if ($this->isNotNull($this->space_x)) {
            $params['space_x'] = $this->space_x;
        }
        // space_y	number	是	货物宽度，比如15.0，单位是厘米(cm)
        if ($this->isNotNull($this->space_y)) {
            $params['space_y'] = $this->space_y;
        }
        // space_z	number	是	货物高度，比如10.0，单位是厘米(cm)
        if ($this->isNotNull($this->space_z)) {
            $params['space_z'] = $this->space_z;
        }
        // detail_list	array<object>	是	货物总重量，单位是千克(kg)        
        if ($this->isNotNull($this->detail_list)) {
            foreach ($this->detail_list as $detail) {
                $params['detail_list'][] = $detail->getParams();
            }
        }
        return $params;
    }
}
