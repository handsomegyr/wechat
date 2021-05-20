<?php

namespace Weixin\Wx\Model;

/**
 * 跳转到的目标小程序信息。
 */
class JumpWxa extends \Weixin\Model\Base
{

    /**
     * path	string 是 通过 scheme 码进入的小程序页面路径，必须是已经发布的小程序存在的页面，不可携带 query。path 为空时会跳转小程序主页。
     */
    public $path = NULL;

    /**
     * query string 是 通过 scheme 码进入小程序时的 query，最大1024个字符，只支持数字，大小写英文以及部分特殊字符：!#$&'()*+,/:;=?@-._~
     */
    public $query = NULL;


    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }

        if ($this->isNotNull($this->query)) {
            $params['query'] = $this->query;
        }

        return $params;
    }
}
