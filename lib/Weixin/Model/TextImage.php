<?php
namespace Weixin\Model;

/**
 * 图文结构体
 */
class TextImage extends Base
{

    /**
     * image_url 否 string（128 ） 图片链接，必须调用 上传图片接口 上传图片获得链接，并在此填入， 否则报错
     */
    public $image_url = NULL;

    /**
     * text 否 string（512 ）
     */
    public $text = NULL;

    public function __construct()
    {}

    public function set_image_url($image_url)
    {
        $this->image_url = $image_url;
    }

    public function set_text($text)
    {
        $this->text = $text;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->image_url)) {
            $params['image_url'] = $this->image_url;
        }
        if ($this->isNotNull($this->text)) {
            $params['text'] = $this->text;
        }
        return $params;
    }
}
