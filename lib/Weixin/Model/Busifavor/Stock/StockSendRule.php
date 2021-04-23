<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 发放规则
 */
class StockSendRule extends Base
{
    /**
     * 批次最大发放个数 max_coupons int 是 批次最大可发放个数限制 特殊规则：取值范围 1 ≤ value ≤ 1000000000示例值：100
     */
    public $max_coupons = null;
    /**
     * 用户最大可领个数 max_coupons_per_user int 是 用户可领个数，每个用户最多100张券 。 示例值：5
     */
    public $max_coupons_per_user = null;
    /**
     * 单天发放上限个数 max_coupons_by_day int 否 单天发放上限个数（stock_type为DISCOUNT或EXCHANGE时可传入此字段控制单天发放上限）。 特殊规则：取值范围 1 ≤ value ≤ 1000000000示例值：100
     */
    public $max_coupons_by_day = null;
    /**
     * 是否开启自然人限制 natural_person_limit bool 否 不填默认否，枚举值：true：是 false：否 示例值：false
     */
    public $natural_person_limit = null;
    /**
     * 可疑账号拦截 prevent_api_abuse bool 否 不填默认否，枚举值：true：是 false：否 示例值：false
     */
    public $prevent_api_abuse = null;
    /**
     * 是否允许转赠 transferable bool 否 不填默认否，枚举值：true：是 false：否 该字段暂未开放示例值：false
     */
    public $transferable = null;
    /**
     * 是否允许分享链接 shareable bool 否 不填默认否，枚举值：true：是 false：否 该字段暂未开放示例值：false
     */
    public $shareable = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->max_coupons)) {
            $params['max_coupons'] = $this->max_coupons;
        }
        if ($this->isNotNull($this->max_coupons_per_user)) {
            $params['max_coupons_per_user'] = $this->max_coupons_per_user;
        }
        if ($this->isNotNull($this->max_coupons_by_day)) {
            $params['max_coupons_by_day'] = $this->max_coupons_by_day;
        }
        if ($this->isNotNull($this->natural_person_limit)) {
            $params['natural_person_limit'] = $this->natural_person_limit;
        }
        if ($this->isNotNull($this->prevent_api_abuse)) {
            $params['prevent_api_abuse'] = $this->prevent_api_abuse;
        }
        if ($this->isNotNull($this->transferable)) {
            $params['transferable'] = $this->transferable;
        }
        if ($this->isNotNull($this->shareable)) {
            $params['shareable'] = $this->shareable;
        }
        return $params;
    }
}
