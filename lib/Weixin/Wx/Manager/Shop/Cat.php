<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 商品类目接口
 *
 * @author guoyongrong
 *        
 */
class Cat
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/cat/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取商品类目
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/cat/get_children_cateogry.html
     * 接口调用请求说明
     * 获取所有三级类目及其资质相关信息 注意：该接口拉到的是【全量】三级类目数据，数据回包大小约为2MB。 所以请商家自己做好缓存，不要频繁调用（有严格的频率限制），该类目数据不会频率变动，推荐商家每天调用一次更新商家自身缓存
     *
     * 若该类目资质必填，则新增商品前，必须先通过该类目资质申请接口进行资质申请; 若该类目资质不需要，则该类目自动拥有，无需申请，如依然调用，会报错1050011； 若该商品资质必填，则新增商品时，带上商品资质字段。 接入类目审核回调，才可获取审核结果。
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/cat/get?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "third_cat_list":
     * [
     * {
     * "third_cat_id": 6493,
     * "third_cat_name": "爬行垫/毯",
     * "qualification": "",
     * "qualification_type": 0,
     * "product_qualification": "《国家强制性产品认证证书》（CCC安全认证证书）",
     * "product_qualification_type": 1,
     * "first_cat_id": 6472,
     * "first_cat_name": "玩具乐器",
     * "second_cat_id": 6489,
     * "second_cat_name": "健身玩具"
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
     * third_cat_list object array 类目列表
     * third_cat_list[].third_cat_id number 类目ID
     * third_cat_list[].third_cat_name string 类目名称
     * third_cat_list[].qualification string 类目资质
     * third_cat_list[].qualification_type number 类目资质类型,0:不需要,1:必填,2:选填
     * third_cat_list[].product_qualification string 商品资质
     * third_cat_list[].product_qualification_type number 商品资质类型,0:不需要,1:必填,2:选填
     * third_cat_list[].second_cat_id number 二级类目ID
     * third_cat_list[].second_cat_name string 二级类目名称
     * third_cat_list[].first_cat_id number 一级类目ID
     * third_cat_list[].first_cat_name string 一级类目名称
     */
    public function get()
    {
        $params = array();
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }
}
