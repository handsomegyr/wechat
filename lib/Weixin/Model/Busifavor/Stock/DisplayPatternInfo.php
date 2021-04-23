<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 样式信息
 */
class DisplayPatternInfo extends Base
{
    /**
     * 使用须知 description string[1,1000] 否 用于说明详细的活动规则，会展示在代金券详情页。 示例值：xxx门店可用
     */
    public $description = null;
    /**
     * 商户logo merchant_logo_url string[1,128] 否 商户logo的URL地址，仅支持通过《图片上传API》接口获取的图片URL地址。1、商户logo大小需为120像素*120像素。2、支持JPG/JPEG/PNG格式，且图片小于1M。示例值：https:/**qpic.cn/xxx
     */
    public $merchant_logo_url = null;
    /**
     * 商户名称 merchant_name string[1,16] 否 商户名称，字数上限为16个，一个中文汉字/英文字母/数字均占用一个字数。 示例值：微信支付
     */
    public $merchant_name = null;
    /**
     * 背景颜色 background_color string[1,16] 否 券的背景颜色，可设置10种颜色，色值请参考卡券背景颜色图。颜色取值为颜色图中的颜色名称。示例值：Color020
     */
    public $background_color = null;
    /**
     * 券详情图片 coupon_image_url string[1,128] 否 券详情图片，850像素*350像素，且图片大小不超过2M，支持JPG/PNG格式，仅支持通过《图片上传API》接口获取的图片URL地址。
     */
    public $coupon_image_url = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->merchant_logo_url)) {
            $params['merchant_logo_url'] = $this->merchant_logo_url;
        }
        if ($this->isNotNull($this->merchant_name)) {
            $params['merchant_name'] = $this->merchant_name;
        }
        if ($this->isNotNull($this->background_color)) {
            $params['background_color'] = $this->background_color;
        }
        if ($this->isNotNull($this->coupon_image_url)) {
            $params['coupon_image_url'] = $this->coupon_image_url;
        }
        return $params;
    }
}
