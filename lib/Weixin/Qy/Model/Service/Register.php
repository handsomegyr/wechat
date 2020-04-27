<?php

namespace Weixin\Qy\Model\Service;

/**
 * 推广二维码构体
 */
class Register extends \Weixin\Model\Base
{

    /**
     * template_id 是 推广包ID，最长为128个字节
     */
    public $template_id = NULL;

    /**
     * corp_name 否 企业名称
     */
    public $corp_name = NULL;

    /**
     * admin_name 否 管理员姓名
     */
    public $admin_name = NULL;

    /**
     * admin_mobile 否 管理员手机号
     */
    public $admin_mobile = NULL;

    /**
     * state 否 用户自定义的状态值。只支持英文字母和数字，最长为128字节。若指定该参数， 接口 查询注册状态 及 注册完成回调事件 会相应返回该字段值
     */
    public $state = NULL;

    /**
     * follow_user 否 跟进人的userid，必须是服务商所在企业的成员。若配置该值，则由该注册码创建的企业，在服务商管理后台，该企业的报备记录会自动标注跟进人员为指定成员
     */
    public $follow_user = NULL;

    public function __construct(array $template_id)
    {
        $this->template_id = $template_id;
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->template_id)) {
            $params['template_id'] = $this->template_id;
        }
        if ($this->isNotNull($this->corp_name)) {
            $params['corp_name'] = $this->corp_name;
        }
        if ($this->isNotNull($this->admin_name)) {
            $params['admin_name'] = $this->admin_name;
        }
        if ($this->isNotNull($this->admin_mobile)) {
            $params['admin_mobile'] = $this->admin_mobile;
        }
        if ($this->isNotNull($this->state)) {
            $params['state'] = $this->state;
        }
        if ($this->isNotNull($this->follow_user)) {
            $params['follow_user'] = $this->follow_user;
        }
        return $params;
    }
}
