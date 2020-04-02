<?php

namespace Weixin\Qy\Model;

/**
 * 标签构体
 */
class Tag extends \Weixin\Model\Base
{

    /**
     * tagname 是 标签名称，长度限制为32个字以内（汉字或英文字母），标签名不可与其他标签重名。
     */
    public $tagname = NULL;

    /**
     * tagid 否 标签id，非负整型，指定此参数时新增的标签会生成对应的标签id，不指定时则以目前最大的id自增。
     */
    public $tagid = NULL;

    public function __construct($tagname)
    {
        $this->name = $tagname;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->tagname)) {
            $params['tagname'] = $this->tagname;
        }
        if ($this->isNotNull($this->tagid)) {
            $params['tagid'] = $this->tagid;
        }
        return $params;
    }
}
