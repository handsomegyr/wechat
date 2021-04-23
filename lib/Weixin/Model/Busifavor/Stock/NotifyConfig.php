<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 事件通知配置
 */
class NotifyConfig extends Base
{
    /**
     * 事件通知appid notify_appid string[1,64] 否 用于回调通知时，计算返回操作用户的openid（诸如领券用户），支持小程序or公众号的APPID；如该字段不填写，则回调通知中涉及到用户身份信息的openid与unionid都将为空。 示例值：wx23232232323
     */
    public $notify_appid = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->notify_appid)) {
            $params['notify_appid'] = $this->notify_appid;
        }
        return $params;
    }
}
