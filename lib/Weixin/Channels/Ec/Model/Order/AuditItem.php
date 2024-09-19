<?php

namespace Weixin\Channels\Ec\Model\Order;

/**
 * 审核项
 */
class AuditItem extends \Weixin\Model\Base
{
    /**
     * item_name	string	是	审核项名称，枚举类型参考AuditItemType
     */
    public $item_name = NULL;

    /**
     * item_value	string	是	图片/视频url
     */
    public $item_value = NULL;

    public function __construct() {}

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->item_name)) {
            $params['item_name'] = $this->item_name;
        }
        if ($this->isNotNull($this->item_value)) {
            $params['item_value'] = $this->item_value;
        }
        return $params;
    }
}
