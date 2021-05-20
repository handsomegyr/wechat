<?php

namespace Weixin\Wx\Model;

/**
 * 云开发静态网站自定义 H5 配置参数，可配置中转的云开发 H5 页面。不填默认用官方 H5 页面
 */
class CloudBase extends \Weixin\Model\Base
{

    /**
     * env	string	是	云开发环境
     */
    public $env = NULL;

    /**
     * domain	string	否	静态网站自定义域名，不填则使用默认域名
     */
    public $domain = NULL;

    /**
     * path	string	/否	云开发静态网站 H5 页面路径，不可携带 query
     */
    public $path = NULL;

    /**
     * query string	否	云开发静态网站 H5 页面 query 参数，最大 1024 个字符，只支持数字，大小写英文以及部分特殊字符：!#$&'()*+,/:;=?@-._~
     */
    public $query = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->env)) {
            $params['env'] = $this->env;
        }

        if ($this->isNotNull($this->domain)) {
            $params['domain'] = $this->domain;
        }

        if ($this->isNotNull($this->path)) {
            $params['path'] = $this->path;
        }

        if ($this->isNotNull($this->query)) {
            $params['query'] = $this->query;
        }

        return $params;
    }
}
