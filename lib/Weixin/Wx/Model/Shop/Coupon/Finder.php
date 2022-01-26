<?php

namespace Weixin\Wx\Model\Shop\Coupon;

/**
 * 推广视频号
 */
class Finder extends \Weixin\Model\Base
{
    /**
     * nickname	string	推广视频号昵称
     */
    public $nickname = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->nickname)) {
            $params['nickname'] = $this->nickname;
        }

        return $params;
    }
}
