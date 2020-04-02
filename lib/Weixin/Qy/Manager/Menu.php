<?php

/**
 * 菜单接口
 * @author guoyongrong <handsomegyr@126.com>
 */

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

class Menu
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/menu/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建菜单
     * 调试工具
     * 自定义菜单接口可实现多种类型按钮，如下：
     *
     * 字段值 功能名称 说明
     * click 点击推事件 成员点击click类型按钮后，企业微信服务器会通过消息接口推送消息类型为event 的结构给开发者（参考消息接口指南），并且带上按钮中开发者填写的key值，开发者可以通过自定义的key值与成员进行交互；
     * view 跳转URL 成员点击view类型按钮后，企业微信客户端将会打开开发者在按钮中填写的网页URL，可与网页授权获取成员基本信息接口结合，获得成员基本信息。
     * scancode_push 扫码推事件 成员点击按钮后，企业微信客户端将调起扫一扫工具，完成扫码操作后显示扫描结果（如果是URL，将进入URL），且会将扫码的结果传给开发者，开发者可用于下发消息。
     * scancode_waitmsg 扫码推事件 且弹出“消息接收中”提示框 成员点击按钮后，企业微信客户端将调起扫一扫工具，完成扫码操作后，将扫码的结果传给开发者，同时收起扫一扫工具，然后弹出“消息接收中”提示框，随后可能会收到开发者下发的消息。
     * pic_sysphoto 弹出系统拍照发图 弹出系统拍照发图 成员点击按钮后，企业微信客户端将调起系统相机，完成拍照操作后，会将拍摄的相片发送给开发者，并推送事件给开发者，同时收起系统相机，随后可能会收到开发者下发的消息。
     * pic_photo_or_album 弹出拍照或者相册发图 成员点击按钮后，企业微信客户端将弹出选择器供成员选择“拍照”或者“从手机相册选择”。成员选择后即走其他两种流程。
     * pic_weixin 弹出企业微信相册发图器 成员点击按钮后，企业微信客户端将调起企业微信相册，完成选择操作后，将选择的相片发送给开发者的服务器，并推送事件给开发者，同时收起相册，随后可能会收到开发者下发的消息。
     * location_select 弹出地理位置选择器 成员点击按钮后，企业微信客户端将调起地理位置选择工具，完成选择操作后，将选择的地理位置发送给开发者的服务器，同时收起位置选择工具，随后可能会收到开发者下发的消息。
     * view_miniprogram 跳转到小程序 成员点击按钮后，企业微信客户端将会打开开发者在按钮中配置的小程序
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN&agentid=AGENTID
     *
     * 示例：构造click和view类型的请求包如下
     *
     * {
     * "button":[
     * {
     * "type":"click",
     * "name":"今日歌曲",
     * "key":"V1001_TODAY_MUSIC"
     * },
     * {
     * "name":"菜单",
     * "sub_button":[
     * {
     * "type":"view",
     * "name":"搜索",
     * "url":"http://www.soso.com/"
     * },
     * {
     * "type":"click",
     * "name":"赞一下我们",
     * "key":"V1001_GOOD"
     * }
     * ]
     * }
     * ]
     * }
     * 示例：其他新增按钮类型的请求
     *
     * {
     * "button": [
     * {
     * "name": "扫码",
     * "sub_button": [
     * {
     * "type": "scancode_waitmsg",
     * "name": "扫码带提示",
     * "key": "rselfmenu_0_0",
     * "sub_button": [ ]
     * },
     * {
     * "type": "scancode_push",
     * "name": "扫码推事件",
     * "key": "rselfmenu_0_1",
     * "sub_button": [ ]
     * },
     * {
     * "type":"view_miniprogram",
     * "name":"小程序",
     * "pagepath":"pages/lunar/index",
     * "appid":"wx4389ji4kAAA"
     * }
     * ]
     * },
     * {
     * "name": "发图",
     * "sub_button": [
     * {
     * "type": "pic_sysphoto",
     * "name": "系统拍照发图",
     * "key": "rselfmenu_1_0",
     * "sub_button": [ ]
     * },
     * {
     * "type": "pic_photo_or_album",
     * "name": "拍照或者相册发图",
     * "key": "rselfmenu_1_1",
     * "sub_button": [ ]
     * },
     * {
     * "type": "pic_weixin",
     * "name": "微信相册发图",
     * "key": "rselfmenu_1_2",
     * "sub_button": [ ]
     * }
     * ]
     * },
     * {
     * "name": "发送位置",
     * "type": "location_select",
     * "key": "rselfmenu_2_0"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 企业应用的id，整型。可在应用的设置页面查看
     * button 是 一级菜单数组，个数应为1~3个
     * sub_button 否 二级菜单数组，个数应为1~5个
     * type 是 菜单的响应动作类型
     * name 是 菜单的名字。不能为空，主菜单不能超过16字节，子菜单不能超过40字节。
     * key click等点击类型必须 菜单KEY值，用于消息接口推送，不超过128字节
     * url view类型必须 网页链接，成员点击菜单可打开链接，不超过1024字节。为了提高安全性，建议使用https的url
     * pagepath view_miniprogram类型必须 小程序的页面路径
     * appid view_miniprogram类型必须 小程序的appid（仅与企业绑定的小程序可配置）
     * 权限说明 :
     *
     * 仅企业可调用；第三方不可调用。
     *
     * 返回结果 ：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     */
    public function create($agentid, $menus)
    {
        $queryParams = array();
        $queryParams['agentid'] = $agentid;
        $rst = $this->_request->post($this->_url . 'create', $menus, array(), '', $queryParams);
        return $this->_client->rst($rst);
    }

    /**
     * 获取菜单
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN&agentid=AGENTID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 应用id
     * 权限说明：
     *
     * 仅企业可调用；第三方不可调用。
     *
     * 返回结果：
     *
     * 返回结果与请参考菜单创建接口
     */
    public function get($agentid)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $rst = $this->_request->get($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除菜单
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN&agentid=AGENTID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * agentid 是 应用id
     * 权限说明：
     *
     * 仅企业可调用；第三方不可调用。
     *
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     */
    public function delete($agentid)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $rst = $this->_request->get($this->_url . 'delete', $params);
        return $this->_client->rst($rst);
    }

    private function validateSubbutton($menus)
    {
        $ret = 0;
        foreach ($menus as $menu) {
            if (key_exists("sub_button", $menu)) {
                $sub_button_num = count($menu['sub_button']);
                if ($sub_button_num > 5 || $sub_button_num < 1) {
                    $ret = 40023;
                    break;
                }
                $ret = $this->validateSubbutton($menu['sub_button']);
                if ($ret)
                    break;
            }
        }
        return $ret;
    }

    private function validateKey($menu)
    {
        // click等点击类型必须
        if (in_array(strtolower($menu['type']), array(
            'click',
            'scancode_push',
            'scancode_waitmsg',
            'pic_sysphoto',
            'pic_photo_or_album',
            'pic_weixin',
            'location_select'
        ))) {
            if (strlen(trim($menu['key'])) < 1)
                return 40019;
        }
        // 按钮KEY值，用于消息接口(event类型)推送，不超过128字节
        if (strlen(trim($menu['key'])) > 128)
            return 40019;
        return 0;
    }

    private function validateName($menu)
    {
        // 按钮描述，既按钮名字，不超过16个字节，子菜单不超过40个字节
        if ($menu['fatherNode']) // 子菜单
        {
            if (strlen($menu['name']) > 40)
                return 40018;
        } else // 按钮
        {
            if (strlen($menu['name']) > 16)
                return 40018;
        }
        return 0;
    }

    public function validateMenu($menu)
    {
        $errcode = $this->validateName($menu);
        if ($errcode) {
            return $errcode;
        }
        $errcode = $this->validateKey($menu);
        if ($errcode) {
            return $errcode;
        }
        return 0;
    }

    public function validateAllMenus($menus)
    {
        // 按钮数组，按钮个数应为1~3个
        $button_num = count($menus);
        if ($button_num > 3 || $button_num < 1) {
            return 40017;
        }

        // 子按钮数组，按钮个数应为1~5个
        if ($this->validateSubbutton($menus)) {
            return 40023;
        }
    }
}
