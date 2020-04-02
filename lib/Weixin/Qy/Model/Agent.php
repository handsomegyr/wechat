<?php

namespace Weixin\Qy\Model;

/**
 * 应用详情构体
 */
class Agent extends \Weixin\Model\Base
{

    /**
     * agentid 企业应用id
     */
    public $agentid = NULL;

    /**
     * name 企业应用名称
     */
    public $name = NULL;

    /**
     * square_logo_url 企业应用方形头像
     */
    public $square_logo_url = NULL;

    /**
     * description 企业应用详情
     */
    public $description = NULL;

    /**
     * allow_userinfos 企业应用可见范围（人员），其中包括userid
     */
    public $allow_userinfos = NULL;

    /**
     * allow_partys 企业应用可见范围（部门）
     */
    public $allow_partys = NULL;

    /**
     * allow_tags 企业应用可见范围（标签）
     */
    public $allow_tags = NULL;

    /**
     * close 企业应用是否被停用
     */
    public $close = NULL;

    /**
     * redirect_domain 企业应用可信域名
     */
    public $redirect_domain = NULL;

    /**
     * report_location_flag 企业应用是否打开地理位置上报 0：不上报；1：进入会话上报；
     */
    public $report_location_flag = NULL;

    /**
     * isreportenter 是否上报用户进入应用事件。0：不接收；1：接收
     */
    public $isreportenter = NULL;

    /**
     * home_url 应用主页url
     */
    public $home_url = NULL;

    public function __construct()
    {
    }

    public function getParams()
    {
        $params = array();

        if ($this->isNotNull($this->agentid)) {
            $params['agentid'] = $this->agentid;
        }
        if ($this->isNotNull($this->name)) {
            $params['name'] = $this->name;
        }
        if ($this->isNotNull($this->square_logo_url)) {
            $params['square_logo_url'] = $this->square_logo_url;
        }
        if ($this->isNotNull($this->description)) {
            $params['description'] = $this->description;
        }
        if ($this->isNotNull($this->allow_userinfos)) {
            $params['allow_userinfos'] = $this->allow_userinfos;
        }
        if ($this->isNotNull($this->allow_partys)) {
            $params['allow_partys'] = $this->allow_partys;
        }
        if ($this->isNotNull($this->allow_tags)) {
            $params['allow_tags'] = $this->allow_tags;
        }
        if ($this->isNotNull($this->close)) {
            $params['close'] = $this->close;
        }
        if ($this->isNotNull($this->redirect_domain)) {
            $params['redirect_domain'] = $this->redirect_domain;
        }
        if ($this->isNotNull($this->report_location_flag)) {
            $params['report_location_flag'] = $this->report_location_flag;
        }
        if ($this->isNotNull($this->isreportenter)) {
            $params['isreportenter'] = $this->isreportenter;
        }
        if ($this->isNotNull($this->home_url)) {
            $params['home_url'] = $this->home_url;
        }
        return $params;
    }
}
