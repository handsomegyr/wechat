<?php

namespace Weixin\Wx\Model\Shop;

/**
 * 类目审核
 */
class AuditCategoryReq extends \Weixin\Model\Base
{

    /**
     * license	string array	是	是	是	是	营业执照或组织机构代码证，图片url/media_id
     */
    public $license = NULL;

    /**
     * @var \Weixin\Wx\Model\Shop\Audit\CategoryInfo
     * category_info	\Weixin\Wx\Model\Shop\Audit\CategoryInfo	是	类目
     */
    public $category_info = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->license)) {
            $params['license'] = $this->license;
        }

        if ($this->isNotNull($this->category_info)) {
            $params['category_info'] = $this->category_info->getParams();
        }

        return $params;
    }
}
