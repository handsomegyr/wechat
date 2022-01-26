<?php

namespace Weixin\Wx\Model\Shop\Audit;

/**
 * 类目
 */
class CategoryInfo extends \Weixin\Model\Base
{
    /**
     * level1	uint32	是	一级类目
     */
    public $level1 = NULL;

    /**
     * level2	uint32	是	二级类目
     */
    public $level2 = NULL;

    /**
     * level3	uint32	是	三级类目
     */
    public $level3 = NULL;

    /**
     * certificate	string array	是	资质材料，图片url
     */
    public $certificate = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->level1)) {
            $params['level1'] = $this->level1;
        }

        if ($this->isNotNull($this->level2)) {
            $params['level2'] = $this->level2;
        }

        if ($this->isNotNull($this->level3)) {
            $params['level3'] = $this->level3;
        }

        if ($this->isNotNull($this->certificate)) {
            $params['certificate'] = $this->certificate;
        }

        return $params;
    }
}
