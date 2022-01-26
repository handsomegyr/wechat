<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 场景值接口
 *
 * @author guoyongrong
 *        
 */
class Scene
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/scene/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 检查场景值是否在支付校验范围内
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/order/check_scene.html
     * 接口调用请求说明
     * 微信后台会对符合支付校验范围内的场景值下的收银台进行支付（ticket/订单信息）校验
     *
     * 场景值枚举列表
     *
     * 获取场景值指引
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/scene/check?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "scene": 1175
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "is_matched": 1
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * scene number 是 场景值
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * is_matched number 0: 不在支付校验范围内，1: 在支付校验范围内
     */
    public function check($scene)
    {
        $params = array();
        $params['scene'] = $scene;
        $rst = $this->_request->post($this->_url . 'check', $params);
        return $this->_client->rst($rst);
    }
}
