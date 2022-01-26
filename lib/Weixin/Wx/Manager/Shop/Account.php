<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 商家入驻接口
 *
 * @author guoyongrong
 *        
 */
class Account
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/account/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取商家类目列表
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/category_list.html
     * 接口调用请求说明
     * 获取已申请成功的类类目列表
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/account/get_category_list?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data":
     * [
     * {
     * "first_cat_id": 6870,
     * "second_cat_id": 6911,
     * "third_cat_id": 6930,
     * "first_cat_name": "美妆护肤",
     * "second_cat_name": "香水彩妆",
     * "third_cat_name": "隔离霜/妆前乳"
     * },
     * ...
     * ]
     * }
     * 请求参数说明
     * 无
     *
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data object array 类目列表
     * data[].third_cat_id number 类目ID
     * data[].third_cat_name string 类目名称
     * data[].second_cat_id number 二级类目ID
     * data[].second_cat_name string 二级类目名称
     * data[].first_cat_id number 一级类目ID
     * data[].first_cat_name string 一级类目名称
     */
    public function getCategoryList()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get_category_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取商家品牌列表
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/brand_list.html
     * 接口调用请求说明
     * 获取已申请成功的品牌列表
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/account/get_brand_list?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data": [
     * {
     * "brand_id": 2101,
     * "brand_wording": "悦诗风吟"
     * }
     * ]
     * }
     * 请求参数说明
     * 无
     *
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data object array 品牌列表
     * data[].brand_id number 品牌ID
     * data[].brand_wording string 品牌名称
     */
    public function getBrandList()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get_brand_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新商家信息
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/update_info.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/account/update_info?access_token=xxxxxxxxx
     * 请求参数示例
     * 客服地址和客服联系方式二选一
     *
     * {
     * "service_agent_path": "小程序path",
     * "service_agent_phone": "020-888888",
     * "service_agent_type": [1,2]
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * service_agent_path string 否 小程序path
     * service_agent_phone string 否 客服联系方式
     * service_agent_type number[] 是 客服类型，支持多个，0: 小程序官方客服，1: 自定义客服path 2: 联系电话
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     */
    public function updateInfo(array $service_agent_type = array(0, 1, 2), $service_agent_path = "", $service_agent_phone = "")
    {
        $params = array();
        if (!empty($service_agent_path)) {
            $params['service_agent_path'] = $service_agent_path;
        }
        if (!empty($service_agent_phone)) {
            $params['service_agent_phone'] = $service_agent_phone;
        }
        $params['service_agent_type'] = $service_agent_type;
        $rst = $this->_request->post($this->_url . 'update_info', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取商家信息
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/account/get_info.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/account/get_info?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "data": {
     * "service_agent_path": "小程序path",
     * "service_agent_phone": "020-888888",
     * "service_agent_type": [1,2]
     * }
     * }
     * 请求参数说明
     * 无
     *
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data.service_agent_path string 客服地址
     * data.service_agent_phone string 客服联系方式
     * service_agent_type number[] 客服类型，支持多个，0: 小程序官方客服，1: 自定义客服path 2: 联系电话
     */
    public function getInfo()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get_info', $params);
        return $this->_client->rst($rst);
    }
}
