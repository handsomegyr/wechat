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

    /**
     * env_version	string	"release"	否	要打开的小程序版本。正式版为"release"，体验版为"trial"，开发版为"develop"，仅在微信外打开时生效。
     */
    public $env_version = "release";

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

        if ($this->isNotNull($this->env_version)) {
            $params['env_version'] = $this->env_version;
        }

        return $params;
    }
}
