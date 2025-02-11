<?php

namespace Weixin\Channels\Ec\Model\Promoter;

/**
 * 商品类目查询条件
 */
class Category extends \Weixin\Model\Base
{
    // 目前大部分情况只有一级类目，请求时填一级即可。

    // 参数	类型	描述
    // category_id	string	商品类目
    public $category_id = NULL;
    // category_name	string	商品类目名称，可填空
    public $category_name = NULL;
    // category_ids_1	string array	一级类目列表
    public $category_ids_1 = NULL;
    // category_ids_2	string array	二级类目列表
    public $category_ids_2 = NULL;
    // category_ids_3	string array	三级类目列表
    public $category_ids_3 = NULL;

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->category_id)) {
            $params['category_id'] = $this->category_id;
        }
        if ($this->isNotNull($this->category_name)) {
            $params['category_name'] = $this->category_name;
        }
        if ($this->isNotNull($this->category_ids_1)) {
            $params['category_ids_1'] = $this->category_ids_1;
        }
        if ($this->isNotNull($this->category_ids_2)) {
            $params['category_ids_2'] = $this->category_ids_2;
        }
        if ($this->isNotNull($this->category_ids_3)) {
            $params['category_ids_3'] = $this->category_ids_3;
        }
        return $params;
    }
}
