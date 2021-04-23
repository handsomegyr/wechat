<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 核销规则
 */
class CouponUseRule extends Base
{
    /**
     * @var \Weixin\Model\Busifavor\Stock\CouponAvailableTime +券可核销时间 coupon_available_time object 是 日期区间内可以使用优惠。
     */
    public $coupon_available_time = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\FixedNormalCoupon +固定面额满减券使用规则 fixed_normal_coupon object 三选一 stock_type为NORMAL时必填。
     */
    public $fixed_normal_coupon = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\DiscountCoupon +折扣券使用规则 discount_coupon object stock_type为DISCOUNT时必填。
     */
    public $discount_coupon = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\ExchangeCoupon +换购券使用规则 exchange_coupon object stock_type为EXCHANGE时必填。
     */
    public $exchange_coupon = null;
    /**
     * 核销方式 use_method string[1,128] 是 枚举值：OFF_LINE：线下滴码核销，点击券“立即使用”跳转展示券二维码详情。MINI_PROGRAMS：线上小程序核销，点击券“立即使用”跳转至配置的商家小程序（需要添加小程序appid和path）。PAYMENT_CODE：微信支付付款码核销，点击券“立即使用”跳转至微信支付钱包付款码。 SELF_CONSUME：用户自助核销，点击券“立即使用”跳转至用户自助操作核销界面（当前暂不支持用户自助核销）。示例值：OFF_LINE
     */
    public $use_method = null;
    /**
     * 小程序appid mini_programs_appid string[1,32] 条件选填 核销方式为线上小程序核销才有效。 示例值：wx23232232323
     */
    public $mini_programs_appid = null;
    /**
     * 小程序path mini_programs_path string[1,128] 条件选填 核销方式为线上小程序核销才有效。 示例值：/path/index/index
     */
    public $mini_programs_path = null;
    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->coupon_available_time)) {
            $params['coupon_available_time'] = $this->coupon_available_time->getParams();
        }
        if ($this->isNotNull($this->fixed_normal_coupon)) {
            $params['fixed_normal_coupon'] = $this->fixed_normal_coupon->getParams();
        }
        if ($this->isNotNull($this->discount_coupon)) {
            $params['discount_coupon'] = $this->discount_coupon->getParams();
        }
        if ($this->isNotNull($this->exchange_coupon)) {
            $params['exchange_coupon'] = $this->exchange_coupon->getParams();
        }
        if ($this->isNotNull($this->use_method)) {
            $params['use_method'] = $this->use_method;
        }
        if ($this->isNotNull($this->mini_programs_appid)) {
            $params['mini_programs_appid'] = $this->mini_programs_appid;
        }
        if ($this->isNotNull($this->mini_programs_path)) {
            $params['mini_programs_path'] = $this->mini_programs_path;
        }
        return $params;
    }
}
