<?php

namespace Weixin\Qy\Model;

/**
 * 成员信息
 */
class User extends \Weixin\Model\Base
{

    /**userid	是	成员UserID。对应管理端的帐号，企业内必须唯一。不区分大小写，长度为1~64个字节。只能由数字、字母和“_-@.”四种字符组成，且第一个字符必须是数字或字母。*/
    public $userid = NULL;
    /**name	是	成员名称。长度为1~64个utf8字符*/
    public $name = NULL;
    /**alias	否	成员别名。长度1~32个utf8字符*/
    public $alias = NULL;
    /**mobile	否	手机号码。企业内必须唯一，mobile/email二者不能同时为空*/
    public $mobile = NULL;
    /**department	否	成员所属部门id列表,不超过20个*/
    public $department = NULL;
    /**order	否	部门内的排序值，默认为0，成员次序以创建时间从小到大排列。数量必须和department一致，数值越大排序越前面。有效的值范围是[0, 2^32)*/
    public $order = NULL;
    /**position	否	职务信息。长度为0~128个字符*/
    public $position = NULL;
    /**gender	否	性别。1表示男性，2表示女性*/
    public $gender = NULL;
    /**email	否	邮箱。长度6~64个字节，且为有效的email格式。企业内必须唯一，mobile/email二者不能同时为空*/
    public $email = NULL;
    /**telephone	否	座机。32字节以内，由纯数字或’-‘号组成。*/
    public $telephone = NULL;
    /**is_leader_in_dept	否	个数必须和department一致，表示在所在的部门内是否为上级。1表示为上级，0表示非上级。在审批等应用里可以用来标识上级审批人*/
    public $is_leader_in_dept = NULL;
    /**avatar_mediaid	否	成员头像的mediaid，通过素材管理接口上传图片获得的mediaid*/
    public $avatar_mediaid = NULL;
    /**enable	否	启用/禁用成员。1表示启用成员，0表示禁用成员*/
    public $enable = NULL;
    /**extattr	否	自定义字段。自定义字段需要先在WEB管理端添加，见扩展属性添加方法，否则忽略未知属性的赋值。与对外属性一致，不过只支持type=0的文本和type=1的网页类型，详细描述查看对外属性*/
    public $extattr = NULL;
    /**to_invite	否	是否邀请该成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。*/
    public $to_invite = NULL;
    /**external_profile	否	成员对外属性，字段详情见对外属性*/
    public $external_profile = NULL;
    /**external_position	否	对外职务，如果设置了该值，则以此作为对外展示的职务，否则以position来展示。长度12个汉字内*/
    public $external_position = NULL;
    /**address	否	地址。长度最大128个字符*/
    public $address = NULL;

    public function __construct($userid, $name)
    {
        $this->userid = $userid;
        $this->name = $name;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->userid)) {
            $params['userid'] = $this->userid;
        }
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->alias)) {
            $params['alias'] = $this->alias;
        }
        if ($this->isNotNull($this->mobile)) {
            $params['mobile'] = $this->mobile;
        }
        if ($this->isNotNull($this->department)) {
            $params['department'] = $this->department;
        }
        if ($this->isNotNull($this->order)) {
            $params['order'] = $this->order;
        }
        if ($this->isNotNull($this->position)) {
            $params['position'] = $this->position;
        }
        if ($this->isNotNull($this->gender)) {
            $params['gender'] = $this->gender;
        }
        if ($this->isNotNull($this->email)) {
            $params['email'] = $this->email;
        }
        if ($this->isNotNull($this->telephone)) {
            $params['telephone'] = $this->telephone;
        }
        if ($this->isNotNull($this->is_leader_in_dept)) {
            $params['is_leader_in_dept'] = $this->is_leader_in_dept;
        }
        if ($this->isNotNull($this->avatar_mediaid)) {
            $params['avatar_mediaid'] = $this->avatar_mediaid;
        }
        if ($this->isNotNull($this->enable)) {
            $params['enable'] = $this->enable;
        }
        if (!empty($this->extattr)) {
            foreach ($this->extattr as $attr) {
                $params['extattr'][] = $attr->getParams();
            }
        }
        if ($this->isNotNull($this->to_invite)) {
            $params['to_invite'] = $this->to_invite;
        }
        if ($this->isNotNull($this->external_profile)) {
            $params['external_profile'] = $this->external_profile->getParams();
        }
        if ($this->isNotNull($this->external_position)) {
            $params['external_position'] = $this->external_position;
        }
        if ($this->isNotNull($this->address)) {
            $params['address'] = $this->address;
        }
        return $params;
    }
}
