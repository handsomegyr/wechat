<?php

namespace Weixin\Manager;

use Weixin\Client;

/**
 * 推广支持接口
 * https://developers.weixin.qq.com/doc/offiaccount/qrcode/qrcodejumpadd.html
 *
 * 为了满足用户渠道推广分析的需要，公众平台提供了生成带参数二维码的接口。
 * 使用该接口可以获得多个带不同场景值的二维码，用户扫描后，公众号可以接收到事件推送。
 * 目前有2种类型的二维码，分别是临时二维码和永久二维码，
 * 前者有过期时间，最大为1800秒，但能够生成较多数量，
 * 后者无过期时间，数量较少（目前参数只支持1--100000）。
 * 两种二维码分别适用于帐号绑定、用户来源统计等场景。
 * 用户扫描带场景值二维码时，可能推送以下两种事件：
 * 如果用户还未关注公众号，则用户可以关注公众号，关注后微信会将带场景值关注事件推送给开发者。
 * 如果用户已经关注公众号，在用户扫描后会自动进入会话，微信也会将带场景值扫描事件推送给开发者。
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Qrcode
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建二维码ticket
     *
     * 每次创建二维码ticket需要提供一个开发者自行设定的参数（scene_id），分别介绍临时二维码和永久二维码的创建二维码ticket过程。
     *
     * 临时二维码请求说明
     *
     * http请求方式: POST
     * URL: https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=TOKEN
     * POST数据格式：json
     * POST数据例子：{"expire_seconds": 604800, "action_name": "QR_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     * 永久二维码请求说明
     *
     * http请求方式: POST
     * URL: https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=TOKEN
     * POST数据格式：json
     * POST数据例子：{"action_name": "QR_LIMIT_SCENE", "action_info": {"scene": {"scene_id": 123}}}
     * 或者也可以使用以下POST数据创建字符串形式的二维码参数：
     * {"action_name": "QR_LIMIT_STR_SCENE", "action_info": {"scene": {"scene_str": "123"}}}
     * 参数说明
     *
     * 参数 说明
     * expire_seconds 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天），此字段如果不填，则默认有效期为30秒。
     * action_name 二维码类型，QR_SCENE为临时,QR_LIMIT_SCENE为永久,QR_LIMIT_STR_SCENE为永久的字符串参数值
     * action_info 二维码详细信息
     * scene_id 场景值ID，临时二维码时为32位非0整型，永久二维码时最大值为100000（目前参数只支持1--100000）
     * scene_str 场景值ID（字符串形式的ID），字符串类型，长度限制为1到64，仅永久二维码支持此字段
     * 返回说明
     *
     * 正确的Json返回结果:
     *
     * {"ticket":"gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==","expire_seconds":60,"url":"http:\/\/weixin.qq.com\/q\/kZgfwMTm72WWPkovabbI"}
     * 参数 说明
     * ticket 获取的二维码ticket，凭借此ticket可以在有效时间内换取二维码。
     * expire_seconds 该二维码有效时间，以秒为单位。 最大不超过2592000（即30天）。
     * url 二维码图片解析后的地址，开发者可根据该地址自行生成需要的二维码图片
     * 错误的Json返回示例:
     *
     * {"errcode":40013,"errmsg":"invalid appid"}
     *
     * @author Kan
     *        
     */
    public function create($scene_id, $isTemporary = true, $expire_seconds = 0)
    {
        $params = array();
        if ($isTemporary) {
            $params['expire_seconds'] = min($expire_seconds, 2592000);
            if (is_numeric($scene_id) && $scene_id > 0) {
                $params['action_name'] = "QR_SCENE";
                $params['action_info']['scene']['scene_id'] = $scene_id;
            } else {
                $params['action_name'] = "QR_STR_SCENE";
                $params['action_info']['scene']['scene_str'] = $scene_id;
            }
        } else {
            if (is_numeric($scene_id) && $scene_id >= 1 && $scene_id <= 100000) {
                $params['action_name'] = "QR_LIMIT_SCENE";
                $params['action_info']['scene']['scene_id'] = min($scene_id, 100000);
            } else {
                $params['action_name'] = "QR_LIMIT_STR_SCENE";
                $params['action_info']['scene']['scene_str'] = $scene_id;
            }
        }
        $rst = $this->_request->post($this->_url . 'qrcode/create', $params);
        return $this->_client->rst($rst);
    }
    public function create2($scene_str)
    {
        $params = array();
        $params['action_name'] = "QR_LIMIT_STR_SCENE";
        $params['action_info']['scene']['scene_str'] = $scene_str;
        $rst = $this->_request->post($this->_url . 'qrcode/create', $params);
        return $this->_client->rst($rst);
    }
    public function create3($action_name, $scene, $expire_seconds = 0)
    {
        $expire_seconds = min($expire_seconds, 2592000);
        $params = array();
        $params['action_name'] = $action_name;
        if ($action_name == "QR_SCENE") {
            $params['expire_seconds'] = $expire_seconds;
            $params['action_info']['scene']['scene_id'] = $scene;
        } elseif ($action_name == "QR_STR_SCENE") {
            $params['expire_seconds'] = $expire_seconds;
            $params['action_info']['scene']['scene_str'] = $scene;
        } elseif ($action_name == "QR_LIMIT_SCENE") {
            $params['action_info']['scene']['scene_id'] = $scene;
        } elseif ($action_name == "QR_LIMIT_STR_SCENE") {
            $params['action_info']['scene']['scene_str'] = $scene;
        }
        $rst = $this->_request->post($this->_url . 'qrcode/create', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 通过ticket换取二维码
     * 获取二维码ticket后，开发者可用ticket换取二维码图片。请注意，本接口无须登录态即可调用
     */
    public function getQrcodeUrl($ticket)
    {
        // 请求说明
        // HTTP GET请求（请使用https协议）
        // https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=TICKET
        // 返回说明
        // ticket正确情况下，http 返回码是200，是一张图片，可以直接展示或者下载。
        return "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket={$ticket}";
    }

    /**
     * 扫服务号二维码打开小程序 /增加或修改规则
     * 增加或修改二维码规则
     * 该接口用于将服务号的二维码增加或修改为小程序的二维码规则。
     *
     * 服务号要先关联小程序才可以调用该接口。如果服务号尚未关联小程序，可在“公众号管理后台—广告与服务—小程序管理”关联小程序。
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpadd?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token String 是 服务号接口调用凭证
     * prefix String 是 二维码规则，填服务号的带参二维码url ，必须是http://weixin.qq.com/q/开头的url，例如http://weixin.qq.com/q/02P5KzM_xxxxx
     * appid String 是 这里填要扫了服务号二维码之后要跳转的小程序的appid
     * path String 是 小程序功能页面
     * is_edit UInt 是 编辑标志位，0 表示新增二维码规则，1 表示修改已有二维码规则（注意，已经发布的规则，不支持修改）
     * POST 数据示例:
     *
     * {
     * "prefix": "http://weixin.qq.com/q/kZgfwMTm72Wxxxx",
     * "appid": “wxxxxxx”,
     * "path": "pages/index/index",
     * "is_edit": 0
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode UInt 返回码
     * errmsg String 错误信息
     * 返回结果示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 返回码说明
     * 返回码 说明
     * 0 正常
     * -1 系统繁忙
     * 886001 系统繁忙，请重试
     * 40097 invalid args，已经发布的规则，不支持修改
     * 44990 接口请求太快（超过5次/秒）
     * 85066 链接错误
     * 85070 个人类型小程序无法设置二维码规则
     * 85071 已添加该链接，请勿重复添加
     * 85072 该链接已被占用
     * 85073 二维码规则已满
     * 85075 个人类型小程序无法设置二维码规则
     * 其他错误码 请查看全局错误码
     */
    public function qrcodejumpadd($prefix, $appid, $path, $is_edit = 0)
    {
        $params = array();
        $params['prefix'] = $prefix;
        $params['appid'] = $appid;
        $params['path'] = $path;
        $params['is_edit'] = intval($is_edit);
        $rst = $this->_request->post($this->_url . 'wxopen/qrcodejumpadd', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 扫服务号二维码打开小程序 /删除已设置的规则
     * 删除已设置的二维码规则
     * 该接口用于删除已设置的二维码规则。
     *
     * 服务号要先关联小程序才可以调用该接口。如果服务号尚未关联小程序，可在“公众号管理后台—广告与服务—小程序管理”关联小程序。
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpdelete?access_token=TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token String 是 服务号接口调用凭证
     * prefix String 是 服务号的带参的二维码url
     * appid String 是 小程序appid
     * POST 数据示例:
     *
     * {
     * "prefix": "http://weixin.qq.com/q/02P5KzM_xxxxx",
     * "appid": "wxe5f52902cf4de896"
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode UInt 返回码
     * errmsg String 错误信息
     * 返回结果示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 返回码说明
     * 返回码 说明
     * 0 正常
     * -1 系统繁忙
     * 44990 接口请求太快（超过5次/秒）
     * 886001 系统繁忙，请重试
     * 其他错误码 请查看全局错误码
     */
    public function qrcodejumpdelete($prefix, $appid)
    {
        $params = array();
        $params['prefix'] = $prefix;
        $params['appid'] = $appid;
        $rst = $this->_request->post($this->_url . 'wxopen/qrcodejumpdelete', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 扫服务号二维码打开小程序 /获取已设置的规则
     * 获取已设置的二维码规则
     * 该接口用于获取已经设置的二维码规则。
     *
     * 服务号要先关联小程序才可以调用该接口。如果服务号尚未关联小程序，可在“公众号管理后台—广告与服务—小程序管理”关联小程序。
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumpget?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token String 是 服务号接口调用凭证
     * appid String 是 小程序的appid
     * get_type UInt 否 默认值为0。 0：查询最近新增 10000 条（数量大建议用1或者2）；1：prefix查询；2：分页查询，按新增顺序返回
     * prefix_list String Array 否 prefix查询，get_type=1 必传，最多传 200 个前缀
     * page_num UInt 否 页码，get_type=2 必传，从 1 开始
     * page_size UInt 否 每页数量，get_type=2 必传，最大为 200
     * 返回参数说明
     * 参数 类型 说明
     * errcode Number 返回码
     * errmsg String 错误信息
     * qrcodejump_open UInt 是否已经打开二维码跳转链接设置
     * qrcodejump_pub_quota UInt 本月还可发布的次数
     * list_size UInt 二维码规则数量
     * rule_list Object Array 二维码规则详情列表
     * total_count UInt 二维码规则总数据量，用于分页查询
     * 二维码规则详情
     * 参数 类型 说明
     * prefix String 二维码规则，说明服务号二维码规则已过滤不展示
     * path String 小程序功能页面
     * state UInt 发布标志位，1 表示未发布，2 表示已发布
     * 返回结果示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     *
     * "rule_list": [
     * {
     * "prefix": "https://weixin.qq.com/qrcodejump",
     * "state": 1,
     * "path": "pages/index/index"
     * },
     * {
     * "prefix": "https://weixin.qq.com/qrcodejumptest",
     * "state": 1,
     * "path": "pages/index/index"
     * }
     * ],
     *
     * "qrcodejump_open": 0,
     * "list_size": 2,
     * "qrcodejump_pub_quota": 20,
     * "total_count": 10
     * }
     *
     * 返回码说明
     * 返回码 说明
     * 0 正常
     * 40097 参数有误
     * 44990 接口请求太快（超过5次/秒）
     * 886001 系统繁忙，请重试
     * 其他错误码 请查看全局错误码
     */
    public function qrcodejumpget($appid, $get_type, array $prefix_list, $page_num = 1, $page_size = 200)
    {
        $params = array();
        $params['appid'] = $appid;
        $params['get_type'] = $get_type;
        $params['prefix_list'] = $prefix_list;
        if (intval($get_type) == 2) {
            $params['page_num'] = intval($page_num);
            $params['page_size'] = intval($page_size);
        }
        $rst = $this->_request->post($this->_url . 'wxopen/qrcodejumpget', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 扫服务号二维码打开小程序 /发布已设置的规则
     * 发布已设置的二维码规则
     * 需要先添加二维码规则，然后调用本接口将二维码规则发布生效，发布后现网用户扫码命中该规则的服务号的二维码时将跳转到正式版小程序指定的页面。
     *
     * 服务号要先关联小程序才可以调用该接口。如果服务号尚未关联小程序，可在“公众号管理后台—广告与服务—小程序管理”关联小程序。
     *
     * 请求地址
     * POST https://api.weixin.qq.com/cgi-bin/wxopen/qrcodejumppublish?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 必填 说明
     * access_token String 是 服务号接口调用凭证
     * prefix String 是 服务号的带参的二维码url
     * POST 数据示例:
     *
     * {
     * "prefix": "http://weixin.qq.com/q/02P5KzM_xxxxx"
     * }
     * 返回参数说明
     * 参数 类型 说明
     * errcode UInt 返回码
     * errmsg String 错误信息
     * 返回结果示例：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 返回码说明
     * 返回码 说明
     * 0 正常
     * -1 系统繁忙
     * 886001 系统繁忙，请重试
     * 85074 小程序未发布, 小程序必须先发布代码才可以发布二维码跳转规则
     * 85075 个人类型小程序无法设置二维码规则
     * 85095 数据异常，请删除后重新添加
     * 44990 接口请求太快（超过5次/秒）
     * 其他错误码 请查看全局错误码
     */
    public function qrcodejumppublish($prefix)
    {
        $params = array();
        $params['prefix'] = $prefix;
        $rst = $this->_request->post($this->_url . 'wxopen/qrcodejumppublish', $params);
        return $this->_client->rst($rst);
    }
}
