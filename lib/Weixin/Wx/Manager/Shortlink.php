<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * Short Link
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/short-link/shortlink.generate.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Shortlink
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * shortlink.generate
     * 本接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 获取小程序 Short Link，适用于微信内拉起小程序的业务场景。目前只开放给电商类目(具体包含以下一级类目：电商平台、商家自营、跨境电商)。通过该接口，可以选择生成到期失效和永久有效的小程序短链，详见获取 Short Link。
     *
     * 调用方式：
     *
     * HTTPS 调用
     * 云调用
     *
     * HTTPS 调用
     * 请求地址
     * POST https://api.weixin.qq.com/wxa/genwxashortlink?access_token=ACCESS_TOKEN
     * 请求参数
     * 属性 类型 默认值 必填 说明
     * access_token / cloudbase_access_token string 是 接口调用凭证
     * page_url string 是 通过 Short Link 进入的小程序页面路径，必须是已经发布的小程序存在的页面，可携带 query，最大1024个字符
     * page_title string 是 页面标题，不能包含违法信息，超过20字符会用... 截断代替
     * is_permanent boolean false 否 生成的 Short Link 类型，短期有效：false，永久有效：true
     * 返回值
     * link
     * 生成的小程序 Short Link
     *
     * 异常返回
     * Object
     * JSON
     *
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * errcode 的合法值
     *
     * 值 说明 最低版本
     * 40066 无效的url，已发布小程序没有对应url
     * 40225 无效的页面标题
     * 85400 长期有效Short Link达到生成上限10万
     * 45009 单天生成Short Link数量超过上限50万
     * 43104 没有调用权限，目前只开放给电商类目（具体包含以下一级类目：电商平台、商家自营、跨境电商）
     * 返回值说明
     * 如果调用成功，会直接返回生成的小程序 Short Link。如果请求失败，会返回 JSON 格式的数据。
     *
     * 示例
     * 请求
     *
     * {
     * "page_url": "/pages/publishHomework/publishHomework?query1=q1",
     * "page_title": "Homework title",
     * "is_permanent":false
     * }
     * 返回
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "link": "Short Link"
     * }
     */
    public function generate($page_url, $page_title, $is_permanent)
    {
        $params = array();
        $params['page_url'] = $page_url;
        $params['page_title'] = $page_title;
        $params['is_permanent'] = $is_permanent;
        $rst = $this->_request->post($this->_url . 'wxa/genwxashortlink', $params);
        return $this->_client->rst($rst);
    }
}
