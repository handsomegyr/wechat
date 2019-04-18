<?php
namespace Weixin\Model;

/**
 * 使用门槛
 */
class UseCondition extends Base
{

    /**
     * accept_category 否 string（512） 指定可用的商品类目，仅用于代金券类型 ，填入后将在券面拼写适用于xxx
     */
    public $accept_category = NULL;

    /**
     * reject_category 否 string（ 512 ） 指定不可用的商品类目，仅用于代金券类型 ，填入后将在券面拼写不适用于xxxx
     */
    public $reject_category = NULL;

    /**
     * least_cost 否 int 满减门槛字段，可用于兑换券和代金券 ，填入后将在全面拼写消费满xx元可用。
     */
    public $least_cost = NULL;

    /**
     * object_use_for 否 string（ 512 ） 购买xx可用类型门槛，仅用于兑换 ，填入后自动拼写购买xxx可用。
     */
    public $object_use_for = NULL;

    /**
     * can_use_with_other_discount 否 bool 不可以与其他类型共享门槛 ，填写false时系统将在使用须知里 拼写“不可与其他优惠共享”， 填写true时系统将在使用须知里 拼写“可与其他优惠共享”， 默认为true
     */
    public $can_use_with_other_discount = NULL;

    public function __construct()
    {}

    public function set_accept_category($accept_category)
    {
        $this->accept_category = $accept_category;
    }

    public function set_reject_category($reject_category)
    {
        $this->reject_category = $reject_category;
    }

    public function set_least_cost($least_cost)
    {
        $this->least_cost = $least_cost;
    }

    public function set_object_use_for($object_use_for)
    {
        $this->object_use_for = $object_use_for;
    }

    public function set_can_use_with_other_discount($can_use_with_other_discount)
    {
        $this->can_use_with_other_discount = $can_use_with_other_discount;
    }

    public function getParams()
    {
        $params = array();
        
        if ($this->isNotNull($this->accept_category)) {
            $params['accept_category'] = $this->accept_category;
        }
        
        if ($this->isNotNull($this->reject_category)) {
            $params['reject_category'] = $this->reject_category;
        }
        
        if ($this->isNotNull($this->least_cost)) {
            $params['least_cost'] = $this->least_cost;
        }
        
        if ($this->isNotNull($this->object_use_for)) {
            $params['object_use_for'] = $this->object_use_for;
        }
        
        if ($this->isNotNull($this->can_use_with_other_discount)) {
            $params['can_use_with_other_discount'] = $this->can_use_with_other_discount;
        }
        
        return $params;
    }
}
