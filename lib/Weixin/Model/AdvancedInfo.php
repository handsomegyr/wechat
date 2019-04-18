<?php
namespace Weixin\Model;

/**
 * 卡券高级信息
 */
class AdvancedInfo extends Base
{

    /**
     * use_condition 否 JSON结构 使用门槛（条件）字段，若不填写使用条件则在券面拼写 ：无最低消费限制，全场通用，不限品类；并在使用说明显示： 可与其他优惠共享
     *
     * @var UseCondition
     */
    public $use_condition = NULL;

    /**
     * abstract 否 JSON结构 封面摘要结构体名称
     *
     * @var AbstractInfo
     */
    public $abstract = NULL;

    /**
     * text_image_list 否 JSON结构 图文列表，显示在详情内页 ，优惠券券开发者须至少传入 一组图文列表
     */
    public $text_image_list = NULL;

    /**
     * time_limit 否 JSON结构 使用时段限制，包含以下字段
     *
     * @var TimeLimit
     */
    public $time_limit = NULL;

    /**
     * business_service 否 arry 商家服务类型： BIZ_SERVICE_DELIVER 外卖服务； BIZ_SERVICE_FREE_PARK 停车位； BIZ_SERVICE_WITH_PET 可带宠物； BIZ_SERVICE_FREE_WIFI 免费wifi， 可多选
     */
    public $business_service = NULL;

    public function __construct()
    {}

    public static function getEmptyAdvancedInfo()
    {
        $objAdvancedInfo = new AdvancedInfo();
        return $objAdvancedInfo;
    }

    public function set_use_condition(UseCondition $use_condition)
    {
        $this->use_condition = $use_condition;
    }

    public function set_abstract(AbstractInfo $abstract)
    {
        $this->abstract = $abstract;
    }

    public function set_text_image_list(array $text_image_list)
    {
        $this->text_image_list = $text_image_list;
    }

    public function set_time_limit(TimeLimit $time_limit)
    {
        $this->time_limit = $time_limit;
    }

    public function set_business_service(array $business_service)
    {
        $this->business_service = $business_service;
    }

    public function getParams()
    {
        $params = array();
        if ($this->isNotNull($this->use_condition)) {
            $params['use_condition'] = $this->use_condition->getParams();
        }
        if ($this->isNotNull($this->abstract)) {
            $params['abstract'] = $this->abstract->getParams();
        }
        if ($this->isNotNull($this->text_image_list)) {
            $text_image_list = array();
            foreach ($this->text_image_list as $text_image) {
                $text_image_list[] = $text_image->getParams();
            }
            $params['text_image_list'] = $text_image_list;
        }
        if ($this->isNotNull($this->time_limit)) {
            $params['time_limit'] = $this->time_limit->getParams();
        }
        if ($this->isNotNull($this->business_service)) {
            $params['business_service'] = $this->business_service;
        }
        
        return $params;
    }
}
