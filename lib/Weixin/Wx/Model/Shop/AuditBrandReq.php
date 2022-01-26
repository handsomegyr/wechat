<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 品牌审核
 */
class AuditBrandReq extends \Weixin\Model\Base
{

    /**
     * license	string array	是	是	是	是	营业执照或组织机构代码证，图片url/media_id
     */
    public $license = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Audit\BrandInfo
     * brand_info	\Weixin\Wx\Model\Shop\Audit\BrandInfo	是	品牌
     */
    public $brand_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->license)) {
            $params['license'] = $this->license;
        }

        if ($this->isNotNull($this->brand_info)) {
            $params['brand_info'] = $this->brand_info->getParams();
        }

        return $params;
    }
}
