<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 推广员接口
 *
 * @author guoyongrong
 *        
 */
class Promoter
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/promoter/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取推广员列表
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/promoter/list.html
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/promoter/list?access_token=xxxxxxxxx
     * 请求参数
     * {
     * "page": 1,
     * "page_size": 10
     * }
     * 回包示例
     * {
     * "errcode":0,
     * "total_num":3,
     * "promoters":[
     * {
     * "finder_nickname":"XXXX",
     * "promoter_id":"a-***************************************po",
     * "promoter_openid": "openid"
     * },
     * {
     * "finder_nickname":"XXXX",
     * "promoter_id":"N1***************************************BE",
     * "promoter_openid": "openid"
     * },
     * {
     * "finder_nickname":"XXXX",
     * "promoter_id":"9Z***************************************Vk",
     * "promoter_openid": "openid"
     * }
     * ]
     * }
     *
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * page number 是 第几页（最小填1）
     * page_size number 是 每页数量（不超过20）
     * 回包参数说明
     * 参数 类型 说明
     * errcode string 错误码
     * errmsg string 错误信息
     * promoters[] Promoter[] 推广员信息
     * promoters[].finder_nickname string 推广员视频号昵称
     * promoters[].promoter_id string 推广员唯一ID
     * promoters[].promoter_openid string 推广员openid
     * total_num number 推广员总数
     */
    public function getlist($page = 1, $page_size = 20)
    {
        $params = array();
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        $rst = $this->_request->post($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }
}
