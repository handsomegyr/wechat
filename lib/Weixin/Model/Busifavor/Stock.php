<?php

namespace Weixin\Model\Busifavor;

/**
 * 券
 */
class Stock extends StockBase
{    
    public $stock_id = null;
    /**
     * 商家券批次名称 stock_name string[1,21] 是 body 批次名称，字数上限为21个，一个中文汉字/英文字母/数字均占用一个字数。 示例值：8月1日活动券
     */
    public $stock_name = null;
    /**
     * 批次归属商户号 belong_merchant string[8,15] 是 body 批次归属于哪个商户。 示例值：10000022
     */
    public $belong_merchant = null;
    /**
     * 批次备注 comment string[1,20] 否 body 仅配置商户可见，用于自定义信息。字数上限为20个，一个中文汉字/英文字母/数字均占用一个字数。 示例值：活动使用
     */
    public $comment = null;
    /**
     * 适用商品范围 goods_name string[1,15] 是 body 用来描述批次在哪些商品可用，会显示在微信卡包中。字数上限为15个，一个中文汉字/英文字母/数字均占用一个字数。 示例值：xxx商品使用
     */
    public $goods_name = null;
    /**
     * 批次类型 stock_type string[1,32] 是 body 批次类型 NORMAL：固定面额满减券批次 DISCOUNT：折扣券批次 EXCHANGE：换购券批次 示例值：NORMAL
     */
    public $stock_type = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\CouponUseRule +核销规则 coupon_use_rule object 是 body 券核销相关规则
     */
    public $coupon_use_rule = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\StockSendRule +发放规则 stock_send_rule object 是 body 券发放相关规则
     */
    public $stock_send_rule = null;
    /**
     * 商户请求单号 out_request_no string[1,128] 是 body 商户创建批次凭据号（格式：商户id+日期+流水号），商户侧需保持唯一性。 示例值：100002322019090134234sfdf
     */
    public $out_request_no = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\CustomEntrance +自定义入口 custom_entrance object 否 body 卡详情页面，可选择多种入口引导用户。
     */
    public $custom_entrance = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\DisplayPatternInfo +样式信息 display_pattern_info object 否 body 创建批次时的样式信息。
     */
    public $display_pattern_info = null;
    /**
     * 券code模式 coupon_code_mode string[1,128] 是 body 枚举值： WECHATPAY_MODE：系统分配券code。（固定22位纯数字）MERCHANT_API：商户发放时接口指定券code。 MERCHANT_UPLOAD：商户上传自定义code，发券时系统随机选取上传的券code。 示例值：WECHATPAY_MODE
     */
    public $coupon_code_mode = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\NotifyConfig +事件通知配置 notify_config object 否 body 事件回调通知商户的配置。
     */
    public $notify_config = null;
    /**
     * 是否允许营销补贴 subsidy bool 否 body 该批次发放的券是否允许进行补差，默认为false 示例值：false
     */
    public $subsidy = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->stock_id)) {
            $params['stock_id'] = $this->stock_id;
        }
        if ($this->isNotNull($this->stock_name)) {
            $params['stock_name'] = $this->stock_name;
        }
        if ($this->isNotNull($this->belong_merchant)) {
            $params['belong_merchant'] = $this->belong_merchant;
        }
        if ($this->isNotNull($this->comment)) {
            $params['comment'] = $this->comment;
        }
        if ($this->isNotNull($this->goods_name)) {
            $params['goods_name'] = $this->goods_name;
        }
        if ($this->isNotNull($this->stock_type)) {
            $params['stock_type'] = $this->stock_type;
        }
        if ($this->isNotNull($this->coupon_use_rule)) {
            $params['coupon_use_rule'] = $this->coupon_use_rule->getParams();
        }
        if ($this->isNotNull($this->stock_send_rule)) {
            $params['stock_send_rule'] = $this->stock_send_rule->getParams();
        }
        if ($this->isNotNull($this->out_request_no)) {
            $params['out_request_no'] = $this->out_request_no;
        }
        if ($this->isNotNull($this->custom_entrance)) {
            $params['custom_entrance'] = $this->custom_entrance->getParams();
        }
        if ($this->isNotNull($this->display_pattern_info)) {
            $params['display_pattern_info'] = $this->display_pattern_info->getParams();
        }
        if ($this->isNotNull($this->coupon_code_mode)) {
            $params['coupon_code_mode'] = $this->coupon_code_mode;
        }
        if ($this->isNotNull($this->notify_config)) {
            $params['notify_config'] = $this->notify_config->getParams();
        }
        if ($this->isNotNull($this->subsidy)) {
            $params['subsidy'] = $this->subsidy;
        }
        return $params;
    }
}
