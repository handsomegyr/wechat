<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 核销规则
 */
class CustomEntrance extends Base
{
    /**
     * @var \Weixin\Model\Busifavor\Stock\MiniProgramsInfo +小程序入口 mini_programs_info object 否 需要小程序APPID、path、入口文案、引导文案。如果需要跳转小程序，APPID、path、入口文案为必填，引导文案非必填。appid要与归属商户号有M-A or M-m-suba关系。
     */
    /**
     * 商户公众号appid appid string[1,32] 否 可配置商户公众号，从券详情可跳转至公众号，用户自定义字段。 示例值：wx324345hgfhfghfg
     */
    /**
     * 营销馆id hall_id string[1,64] 否 填写微信支付营销馆的馆id，用户自定义字段。 营销馆需在商户平台 创建。 示例值：233455656
     */
    /**
     * 可用门店id store_id string[1,64] 否 填写代金券可用门店id，用户自定义字段。 示例值：233554655
     */
    /**
     * code展示模式 code_display_mode string[1,8] 否 枚举值：NOT_SHOW：不展示codeBARCODE：一维码QRCODE：二维码 示例值：BARCODE
     */
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->mini_programs_info)) {
            $params['mini_programs_info'] = $this->mini_programs_info->getParams();
        }
        if ($this->isNotNull($this->appid)) {
            $params['appid'] = $this->appid;
        }
        if ($this->isNotNull($this->hall_id)) {
            $params['hall_id'] = $this->hall_id;
        }
        if ($this->isNotNull($this->store_id)) {
            $params['store_id'] = $this->store_id;
        }
        if ($this->isNotNull($this->code_display_mode)) {
            $params['code_display_mode'] = $this->code_display_mode;
        }
        return $params;
    }
}
