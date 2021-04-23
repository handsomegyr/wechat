<?php

namespace Weixin\Model\Busifavor\Stock;

use Weixin\Model\Base;

/**
 * 核销规则
 */
class MiniProgramsInfo extends Base
{
    /**
     * 商家小程序appid mini_programs_appid string[1,32] 是 商家小程序appid要与归属商户号有M-A or M-m-suba关系。 示例值：wx234545656765876
     */
    public $mini_programs_appid = null;
    /**
     * 商家小程序path mini_programs_path string[1,128] 是 商家小程序path 示例值：/path/index/index
     */
    public $mini_programs_path = null;
    /**
     * 入口文案 entrance_words string[1,5] 是 入口文案，字数上限为5个，一个中文汉字/英文字母/数字均占用一个字数。 示例值：欢迎选购
     */
    public $entrance_words = null;
    /**
     * 引导文案 guiding_words string[1,6] 否 小程序入口引导文案，用户自定义字段。字数上限为6个，一个中文汉字/英文字母/数字均占用一个字数。 示例值：获取更多优惠
     */
    public $guiding_words = null;
    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->mini_programs_appid)) {
            $params['mini_programs_appid'] = $this->mini_programs_appid;
        }
        if ($this->isNotNull($this->mini_programs_path)) {
            $params['mini_programs_path'] = $this->mini_programs_path;
        }
        if ($this->isNotNull($this->entrance_words)) {
            $params['entrance_words'] = $this->entrance_words;
        }
        if ($this->isNotNull($this->guiding_words)) {
            $params['guiding_words'] = $this->guiding_words;
        }
        return $params;
    }
}
