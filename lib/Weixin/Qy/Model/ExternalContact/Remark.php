<?php

namespace Weixin\Qy\Model\ExternalContact;

/**
 * 客户备注信息
 */
class Remark extends \Weixin\Model\Base
{

    /**
     * userid 是 企业成员的userid
     */
    public $userid = NULL;

    /**
     * external_userid 是 外部联系人userid
     */
    public $external_userid = NULL;

    /**
     * remark 否 此用户对外部联系人的备注
     */
    public $remark = NULL;

    /**
     * description 否 此用户对外部联系人的描述
     */
    public $description = NULL;

    /**
     * remark_company 否 此用户对外部联系人备注的所属公司名称
     */
    public $remark_company = NULL;

    /**
     * remark_mobiles 否 此用户对外部联系人备注的手机号
     */
    public $remark_mobiles = NULL;

    /**
     * remark_pic_mediaid 否 备注图片的mediaid，
     */
    public $remark_pic_mediaid = NULL;

    public function __construct($userid, $external_userid)
    {
        $this->userid = $userid;
        $this->external_userid = $external_userid;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        if ($this->isNotNull($this->external_userid)) {
            $params['external_userid'] = $this->external_userid;
        }
        if ($this->isNotNull($this->remark)) {
            $params['remark'] = $this->remark;
        }
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->remark_company)) {
            $params['remark_company'] = $this->remark_company;
        }
        if ($this->isNotNull($this->remark_mobiles)) {
            $params['remark_mobiles'] = $this->remark_mobiles;
        }
        if ($this->isNotNull($this->remark_pic_mediaid)) {
            $params['remark_pic_mediaid'] = $this->remark_pic_mediaid;
        }
        return $params;
    }
}
