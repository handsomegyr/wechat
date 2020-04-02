<?php

namespace Weixin\Qy\Model;

/**
 * 按钮构体
 */
class Btn extends \Weixin\Model\Base
{

    /**
     * btn:key 是 按钮key值，用户点击后，会产生任务卡片回调事件，回调事件会带上该key值，只能由数字、字母和“_-@”组成，最长支持128字节
     */
    public $key = NULL;

    /**
     * btn:name 是 按钮名称
     */
    public $name = NULL;

    /**
     * btn:replace_name 否 点击按钮后显示的名称，默认为“已处理”
     */
    public $replace_name = NULL;

    /**
     * btn:color 否 按钮字体颜色，可选“red”或者“blue”,默认为“blue”
     */
    public $color = NULL;

    /**
     * btn:is_bold 否 按钮字体是否加粗，默认false
     */
    public $is_bold = NULL;

    public function __construct($key, $name)
    {
        $this->key = $key;
        $this->name = $name;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->key)) {
            $params['key'] = $this->key;
        }
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->replace_name)) {
            $params['replace_name'] = $this->replace_name;
        }
        if ($this->isNotNull($this->color)) {
            $params['color'] = $this->color;
        }
        if ($this->isNotNull($this->is_bold)) {
            $params['is_bold'] = $this->is_bold;
        }
        return $params;
    }
}
