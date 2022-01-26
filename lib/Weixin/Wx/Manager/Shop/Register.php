<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 申请接入接口
 *
 * @author guoyongrong
 *        
 */
class Register
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/register/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 接入申请
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/enter_apply.html
     * 通过此接口开通自定义版交易组件，将同步返回接入结果，不再有异步事件回调。
     *
     * 如果账户已接入标准版组件，则无法开通，请到微信公众平台取消标准组件的开通。
     *
     * action_type已经废弃，自定义版交易组件不再区分校验打开状态
     *
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/register/apply?access_token=xxxxxxxxx
     * 请求参数示例
     * {}
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function apply()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'apply', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取接入状态
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/enter_check.html
     * 如果账户未接入，将返回错误码1040003。
     *
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/register/check?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data":
     * {
     * "status": 2,
     * "access_info": {
     * "spu_audit_success": 1,
     * "pay_order_success": 0,
     * "send_delivery_success": 0,
     * "add_aftersale_success": 0,
     * "spu_audit_finished": 0,
     * "pay_order_finished": 0,
     * "send_delivery_finished": 0,
     * "add_aftersale_finished": 0,
     * "test_api_finished": 0,
     * "deploy_wxa_finished" :0,
     * "open_product_task_finished": 0
     * },
     * "scene_group_list" : [
     * {
     * "group_id": 1,
     * "reason": "小程序没有售后和客服功能，暂时无法使用视频号场景。",
     * "name": "视频号、公众号场景",
     * "status": 1,
     * "scene_group_ext_list": [
     * {
     * "ext_id": 1,
     * "status": 2,
     * },
     * {
     * "ext_id": 2,
     * "status": 2,
     * }
     * ]
     * }
     * ]
     * }
     * }
     * 请求参数说明
     * 无
     *
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码，未开通将返回1040003（该小程序还没接入）
     * errmsg string 错误信息
     * data.status number 审核状态, 2: 已接入, 3: 封禁中
     * data.access_info object 接入相关信息
     * data.access_info.spu_audit_success number 上传商品并审核成功，0:未成功，1:成功
     * data.access_info.pay_order_success number 发起一笔订单并支付成功，0:未成功，1:成功
     * data.access_info.send_delivery_success number 物流接口调用成功，0:未成功，1:成功
     * data.access_info.add_aftersale_success number 售后接口调用成功，0:未成功，1:成功
     * data.access_info.spu_audit_finished number 商品接口调试完成，0:未完成，1:已完成
     * data.access_info.pay_order_finished number 订单接口调试完成，0:未完成，1:已完成
     * data.access_info.send_delivery_finished number 物流接口调试完成，0:未完成，1:已完成
     * data.access_info.add_aftersale_finished number 售后接口调试完成，0:未完成，1:已完成
     * data.access_info.test_api_finished number 测试完成，0:未完成，1:已完成
     * data.access_info.deploy_wxa_finished number 发版完成，0:未完成，1:已完成
     * data.access_info.open_product_task_finished number 完成自定义组件全部任务 0:未完成 1:已完成
     * data.scene_group_list[] object array 场景接入相关
     * data.scene_group_list[].group_id object 场景枚举，1:视频号、公众号场景
     * data.scene_group_list[].name string 场景名称
     * data.scene_group_list[].status number 审核状态，0:审核中，1:审核完成，2:审核失败，3未审核
     * data.scene_group_list[].reason string 审核理由
     * data.scene_group_list[].scene_group_ext_list[] object array 场景相关审核结果
     * data.scene_group_list[].scene_group_ext_list[].ext_id number 审核事项id，1:客服售后，2:电商平台
     * data.scene_group_list[].scene_group_ext_list[].status number 场景相关审核结果，0:审核中，1:审核成功，2:审核失败，3未审核
     * 注：由于历史原因可能出现0和1的status，视为已接入即可，后续会自动流转到2。
     */
    public function check()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'check', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 完成接入任务
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/finish_access_info.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/register/finish_access_info?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "access_info_item" : 6
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * access_info_item number 是 6:完成spu接口，7:完成订单接口，8:完成物流接口，9:完成售后接口，10:测试完成，11:发版完成
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function finishAccessInfo($access_info_item)
    {
        $params = array();
        $params['access_info_item'] = $access_info_item;
        $rst = $this->_request->post($this->_url . 'finish_access_info', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 场景接入申请
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/enter/scene_apply.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/register/apply_scene?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "scene_group_id" : 1
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * scene_group number 是 1:视频号、公众号场景
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function applyScene($scene_group_id)
    {
        $params = array();
        $params['scene_group_id'] = $scene_group_id;
        $rst = $this->_request->post($this->_url . 'apply_scene', $params);
        return $this->_client->rst($rst);
    }
}
