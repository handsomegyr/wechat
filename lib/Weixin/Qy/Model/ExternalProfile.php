<?php

namespace Weixin\Qy\Model;

/**
 * 成员对外属性构体
 */
class ExternalProfile extends \Weixin\Model\Base
{

    /**
     * external_attr 属性列表，目前支持文本、网页、小程序三种类型 是
     */
    public $external_attr = NULL;

    /**
     * external_corp_name 企业对外简称，需从已认证的企业简称中选填。可在“我的企业”页中查看企业简称认证状态。 否
     */
    public $external_corp_name = NULL;

    public function __construct(array $external_attr)
    {
        $this->external_attr = $external_attr;
    }

    public function getParams()
    {
        $params = array();

        if (!empty($this->external_attr)) {
            foreach ($this->external_attr as $item) {
                $params['external_attr'][] = $item->getParams();
            }
        }

        if ($this->isNotNull($this->external_corp_name)) {
            $params['external_corp_name'] = $this->external_corp_name;
        }

        return $params;
    }
}
