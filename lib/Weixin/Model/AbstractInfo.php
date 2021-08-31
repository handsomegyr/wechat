<?php
namespace Weixin\Model;

/**
 * 封面摘要结构体
 */
class AbstractInfo extends Base
{

    /**
     * abstract 否 string（24 ） 封面摘要简介。*
     */
    public $abstract = NULL;

    /**
     * icon_url_list 否 string（128 ） 封面图片列表，仅支持填入一 个封面图片链接， 上传图片接口 上传获取图片获得链接，填写 非CDN链接会报错，并在此填入。 建议图片尺寸像素850*350*
     */
    public $icon_url_list = NULL;

    public function __construct()
    {}

    public function set_abstract($abstract)
    {
        $this->abstract = $abstract;
    }

    public function set_icon_url_list($icon_url_list)
    {
        $this->icon_url_list = $icon_url_list;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->abstract)) {
            $params['abstract'] = $this->abstract;
        }
        if ($this->isNotNull($this->icon_url_list)) {
            $params['icon_url_list'] = $this->icon_url_list;
        }
        return $params;
    }
}
