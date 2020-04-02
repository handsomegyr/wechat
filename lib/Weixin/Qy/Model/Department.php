<?php

namespace Weixin\Qy\Model;

/**
 * 部门构体
 */
class Department extends \Weixin\Model\Base
{

    /**
     * name 是 部门名称。同一个层级的部门名称不能重复。长度限制为1~32个字符，字符不能包括\:?”<>｜
     */
    public $name = NULL;

    /**
     * name_en 否 英文名称，需要在管理后台开启多语言支持才能生效。长度限制为1~32个字符，字符不能包括\:?”<>｜
     */
    public $name_en = NULL;

    /**
     * parentid 是 父部门id，32位整型
     */
    public $parentid = NULL;

    /**
     * order 否 在父部门中的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     */
    public $order = NULL;

    /**
     * id 否 部门id，32位整型，指定时必须大于1。若不填该参数，将自动生成id
     */
    public $id = NULL;

    public function __construct($name, $parentid)
    {
        $this->name = $name;
        $this->parentid = $parentid;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->name_en)) {
            $params['name_en'] = $this->name_en;
        }
        if ($this->isNotNull($this->parentid)) {
            $params['parentid'] = $this->parentid;
        }
        if ($this->isNotNull($this->order)) {
            $params['order'] = $this->order;
        }
        if ($this->isNotNull($this->id)) {
            $params['id'] = $this->id;
        }
        return $params;
    }
}
