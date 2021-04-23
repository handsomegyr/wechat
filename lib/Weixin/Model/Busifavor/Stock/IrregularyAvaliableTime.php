<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 无规律的有效时间段
 */
class IrregularyAvaliableTime extends Base
{
    /**
     * 开始时间 begin_time string[1,32] 否 开始时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。示例值：2015-05-20T13:29:35+08:00
     */
    public $begin_time = null;
    /**
     * 结束时间 end_time string[1,32] 否 结束时间，遵循rfc3339标准格式，格式为YYYY-MM-DDTHH:mm:ss+TIMEZONE，YYYY-MM-DD表示年月日，T出现在字符串中，表示time元素的开头，HH:mm:ss表示时分秒，TIMEZONE表示时区（+08:00表示东八区时间，领先UTC 8小时，即北京时间）。例如：2015-05-20T13:29:35+08:00表示，北京时间2015年5月20日 13点29分35秒。示例值：2015-05-20T13:29:35+08:00
     */
    public $end_time = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->begin_time)) {
            $params['begin_time'] = $this->begin_time;
        }
        if ($this->isNotNull($this->end_time)) {
            $params['end_time'] = $this->end_time;
        }
        return $params;
    }
}
