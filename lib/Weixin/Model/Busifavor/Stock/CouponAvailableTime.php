<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 券可核销时间
 */
class CouponAvailableTime extends Base
{
    /**
     * 开始时间 available_begin_time string[1,32] 是 批次开始时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。注意：开始时间设置有效期最长为1年。示例值：2015-05-20T13:29:35+08:00
     */
    public $available_begin_time = null;
    /**
     * 结束时间 available_end_time string[1,32] 是 批次结束时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。注意：结束时间设置有效期最长为1年。 示例值：2015-05-20T13:29:35+08:00
     */
    public $available_end_time = null;
    /**
     * 生效后N天内有效 available_day_after_receive int 否 日期区间内，券生效后x天内有效。例如生效当天内有效填1，生效后2天内有效填2，以此类推……注意，用户在有效期开始前领取商家券，则从有效期第1天开始计算天数，用户在有效期内领取商家券，则从领取当天开始计算天数，无论用户何时领取商家券，商家券在活动有效期结束后均不可用。可配合wait_days_after_receive一同填写，也可单独填写。单独填写时，有效期内领券后立即生效，生效后x天内有效。 示例值：3
     */
    public $available_day_after_receive = null;
    /**
     * @var \Weixin\Model\Busifavor\Stock\AvailableWeek + 固定周期有效时间段 available_week object 否 可以设置多个星期下的多个可用时间段，比如每周二10点到18点，用户自定义字段。
     */
    public $available_week = null;
    /**
     * + 无规律的有效时间段 irregulary_avaliable_time array 否 无规律的有效时间，多个无规律时间段，用户自定义字段。
     */
    public $irregulary_avaliable_time = null;
    /**
     * 领取后N天开始生效 wait_days_after_receive int 否 日期区间内，用户领券后需等待x天开始生效。例如领券后当天开始生效则无需填写，领券后第2天开始生效填1，以此类推……用户在有效期开始前领取商家券，则从有效期第1天开始计算天数，用户在有效期内领取商家券，则从领取当天开始计算天数。无论用户何时领取商家券，商家券在活动有效期结束后均不可用。需配合available_day_after_receive一同填写，不可单独填写。 示例值：7
     */
    public $wait_days_after_receive = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->available_begin_time)) {
            $params['available_begin_time'] = $this->available_begin_time;
        }
        if ($this->isNotNull($this->available_end_time)) {
            $params['available_end_time'] = $this->available_end_time;
        }
        if ($this->isNotNull($this->available_day_after_receive)) {
            $params['available_day_after_receive'] = $this->available_day_after_receive;
        }
        if ($this->isNotNull($this->available_week)) {
            $params['available_week'] = $this->available_week->getParams();
        }
        if ($this->isNotNull($this->irregulary_avaliable_time)) {
            foreach ($this->irregulary_avaliable_time as $value) {
                $params['irregulary_avaliable_time'][] = $value->getParams();
            }
        }
        if ($this->isNotNull($this->wait_days_after_receive)) {
            $params['wait_days_after_receive'] = $this->wait_days_after_receive;
        }
        return $params;
    }
}
