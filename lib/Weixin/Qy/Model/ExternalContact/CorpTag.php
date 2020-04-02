<?php

namespace Weixin\Qy\Model\ExternalContact;

/**
 * 企业客户标签
 */
class CorpTag extends \Weixin\Model\Base
{

    /**
     * group_id 否 标签组id
     */
    public $group_id = NULL;

    /**
     * group_name 否 标签组名称，最长为30个字符
     */
    public $group_name = NULL;

    /**
     * order 否 标签组次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     */
    public $order = NULL;

    /**
     * tag.name 是 添加的标签名称，最长为30个字符
     * tag.order 否 标签次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * 
     * @var array
     */
    public $tag = NULL;

    public function __construct(array $tag)
    {
        $this->tag = $tag;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->group_id)) {
            $params['group_id'] = $this->group_id;
        }
        if ($this->isNotNull($this->group_name)) {
            $params['group_name'] = $this->group_name;
        }
        if ($this->isNotNull($this->order)) {
            $params['order'] = $this->order;
        }
        if ($this->isNotNull($this->tag)) {
            $params['tag'] = $this->tag;
        }
        return $params;
    }
}
