<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 审核接口
 *
 * @author guoyongrong
 *        
 */
class Audit
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/audit/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 品牌审核
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/audit/audit_brand.html
     * 接口调用请求说明
     * 请求成功后将会创建一个审核单，单号将在回包中给出。
     *
     * 审核完成后会进行回调，告知审核结果，请接入品牌审核回调，如果审核成功，则在回调中给出brand_id。
     *
     * 使用到的图片的地方，可以使用url或media_id(通过上传图片接口换取)。
     *
     * 请确认图片url可以正常打开，图片大小在2MB以下，图片格式为jpg, jpeg, png，如图片不能正常显示，会导致审核驳回。
     *
     * 图片需使用图片上传接口换取临时链接用于上传，上传后微信侧会转为永久链接。临时链接在微信侧永久有效，商家侧可以存储临时链接，避免重复换取链接。微信侧组件图片域名，store.mp.video.tencent-cloud.com,mmbizurl.cn,mmecimage.cn/p/。
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/audit/audit_brand?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "audit_req":
     * {
     * "license": ["https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg"],
     * "brand_info":
     * {
     * "brand_audit_type": 1,
     * "trademark_type" : "29",
     * "brand_management_type": 2,
     * "commodity_origin_type": 2,
     * "brand_wording": "346225226351203275",
     * "sale_authorization": ["https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg"],
     * "trademark_registration_certificate": ["https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg"],
     * "trademark_change_certificate": ["https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg"],
     * "trademark_registrant": "https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg",
     * "trademark_registrant_nu": "1249305",
     * "trademark_authorization_period": "2020-03-25 12:05:25",
     * "trademark_registration_application": ["https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg"],
     * "trademark_applicant": "张三",
     * "trademark_application_time": "2020-03-25 12:05:25",
     * "imported_goods_form": ["https://img.zhls.qq.com/3/609b98f7e0ff43d59ce6d9cca636c3e0.jpg"]
     * }
     * }
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "audit_id": "RQAAAPX1nuJsAAAAFTrfXW"
     * }
     * 请求参数说明
     * 表格内容较多，请注意可以左右滑动
     *
     * 参数 类型 是否必填
     * 自有品牌
     * R标 是否必填
     * 自有品牌
     * TM标 是否必填
     * 代理品牌
     * R标 是否必填
     * 代理品牌
     * TM标 说明
     * audit_req.license string array 是 是 是 是 营业执照或组织机构代码证，图片url/media_id
     * audit_req.brand_info.brand_audit_type uint32 是 是 是 是 认证审核类型 RegisterType
     * audit_req.brand_info.trademark_type string 是 是 是 是 商标分类 TrademarkType
     * audit_req.brand_info.brand_management_type uint32 是 是 是 是 选择品牌经营类型 BrandManagementType
     * audit_req.brand_info.commodity_origin_type uint32 是 是 是 是 商品产地是否进口 CommodityOriginType
     * audit_req.brand_info.brand_wording string 是 是 是 是 商标/品牌词
     * audit_req.brand_info.sale_authorization string array 否 否 是 是 销售授权书（如商持人为自然人，还需提供有其签名的身份证正反面扫描件)，图片url/media_id
     * audit_req.brand_info.trademark_registration_certificate string array 是 否 是 否 商标注册证书，图片url/media_id
     * audit_req.brand_info.trademark_change_certificate string array 否 否 否 否 商标变更证明，图片url/media_id
     * audit_req.brand_info.trademark_registrant string 是 否 是 否 商标注册人姓名
     * audit_req.brand_info.trademark_registrant_nu string 是 是 是 是 商标注册号/申请号
     * audit_req.brand_info.trademark_authorization_period string 是 否 是 否 商标有效期，yyyy-MM-dd HH:mm:ss
     * audit_req.brand_info.trademark_registration_application string array 否 是 否 是 商标注册申请受理通知书，图片url/media_id
     * audit_req.brand_info.trademark_applicant string 否 是 否 是 商标申请人姓名
     * audit_req.brand_info.trademark_application_time string 否 是 否 是 商标申请时间, yyyy-MM-dd HH:mm:ss
     * audit_req.brand_info.imported_goods_form string array 否 否 否 否 中华人民共和国海关进口货物报关单，图片url/media_id
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * audit_id string 审核单id
     * 枚举-RegisterType
     * 枚举值 描述
     * 1 国内品牌申请-R标
     * 2 国内品牌申请-TM标
     * 3 海外品牌申请-R标
     * 4 海外品牌申请-TM标
     * 枚举-TrademarkType
     * 枚举值 描述
     * "1" 第1类
     * "2" 第2类
     * "3" 第3类
     * ... ...
     * "45" 第45类
     * 商标共有45个分类，请按商标实际分类上传，如第45类商标，上传45即可。
     *
     * 枚举-enum BrandManagementType
     * 枚举值 描述
     * 1 自有品牌
     * 2 代理品牌
     * 3 无品牌
     * 枚举-CommodityOriginType
     * 枚举值 描述
     * 1 是
     * 2 否
     */
    public function auditBrand(\Weixin\Wx\Model\Shop\AuditBrandReq $audit_req)
    {
        $params = array();
        $params['audit_req'] = $audit_req->getParams();
        $rst = $this->_request->post($this->_url . 'audit_brand', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 类目审核
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/audit/audit_category.html
     * 接口调用请求说明
     * 请求成功后将会创建一个审核单，单号将在回包中给出
     *
     * 审核完成后会进行回调，告知审核结果
     *
     * 这个上传类目资质的接口，如果上传的类目是已经审核通过的，该接口会返回错误码 1050003
     *
     * 使用到的图片的地方，可以使用url或media_id(通过上传图片接口换取)。
     *
     * 图片需使用图片上传接口换取临时链接用于上传，上传后微信侧会转为永久链接。临时链接在微信侧永久有效，商家侧可以存储临时链接，避免重复换取链接。微信侧组件图片域名，store.mp.video.tencent-cloud.com,mmbizurl.cn,mmecimage.cn/p/。
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/audit/audit_category?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "audit_req":
     * {
     * "license": ["www.xxxxx.com"],
     * "category_info":
     * {
     * "level1": 7419, // 一级类目
     * "level2": 7439, // 二级类目
     * "level3": 7448, // 三级类目
     * "certificate": ["www.xxx.com"] // 资质材料
     * }
     * }
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "audit_id": "RQAAAPX1nuJsAAAAFTrfXW"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * audit_req.license string array 是 营业执照或组织机构代码证，图片url
     * audit_req.category_info.level1 uint32 是 一级类目
     * audit_req.category_info.level2 uint32 是 二级类目
     * audit_req.category_info.level3 uint32 是 三级类目
     * audit_req.category_info.certificate string array 是 资质材料，图片url
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * audit_id string 审核单id
     */
    public function auditCategory(\Weixin\Wx\Model\Shop\AuditCategoryReq $audit_req)
    {
        $params = array();
        $params['audit_req'] = $audit_req->getParams();
        $rst = $this->_request->post($this->_url . 'audit_category', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取审核结果
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/audit/audit_result.html
     * 根据审核id，查询品牌和类目的审核结果。
     *
     * 接口调用请求说明
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/audit/result?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "audit_id": "HIDFUSHJRIYAAAAAAAA"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "data": {
     * "status": 9,
     * "brand_id": 0,
     * "reject_reason": "请重新提交审核"
     * }
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * audit_id number 是 提交审核时返回的id
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data.status number 审核状态, 0：审核中，1：审核成功，9：审核拒绝
     * data.brand_id number 如果是品牌审核，返回brand_id
     * data.reject_reason string 如果审核拒绝，返回拒绝原因
     */
    public function result($audit_id)
    {
        $params = array();
        $params['audit_id'] = $audit_id;
        $rst = $this->_request->post($this->_url . 'result', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取小程序资质
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/audit/get_miniapp_certificate.html
     * 接口调用请求说明
     * 获取曾经提交的小程序审核资质
     *
     * 请求类目会返回多次的请求记录，请求品牌只会返回最后一次的提交记录
     *
     * 图片经过转链，请使用高版本chrome浏览器打开
     *
     * 如果曾经没有提交，没有储存历史文件，或是获取失败，接口会返回1050006
     *
     * 注：该接口返回的是曾经在小程序方提交过的审核，非组件的入驻审核！
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/audit/get_miniapp_certificate?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "req_type": 2
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "brand_info":
     * {
     * "brand_wording": "商标名",
     * "sale_authorization":
     * [
     * "https://store.mp.video.tencent-cloud.com/xxxxxxxxxxxxxxxxxxxxxxxxxx"
     * ],
     * "trademark_registration_certificate":
     * [
     * "https://store.mp.video.tencent-cloud.com/xxxxxxxxxxxxxxxxxxxxxxxxxx"
     * ]
     * },
     * "category_info_list": [] // 因为category_info_list为数组，因此即使为空，也可能出现在回包中
     * }
     *
     * {
     * "errcode": 0,
     * "errmsg": "",
     * "category_info_list":
     * [
     * {
     * "first_category_id": 304,
     * "first_category_name": "商家自营",
     * "second_category_id": 321,
     * "second_category_name": "食品",
     * "certificate_url":
     * [
     * "https://store.mp.video.tencent-cloud.com/xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
     * ]
     * }
     * ]
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * req_type uint32 是 REQ_TYPE
     * 枚举-REQ_TYPE
     * 枚举值 说明
     * 1 类目
     * 2 品牌
     * 回包参数说明
     * 参数 类型 说明
     * errcode uint32 错误码
     * errmsg string 错误信息
     * category_info_list Array 类目信息列表
     * category_info_list().first_category_id uint32 小程序的一级类目
     * category_info_list().first_category_name string 小程序的一级类目名
     * category_info_list().second_category_id uint32 小程序的二级类目
     * category_info_list().second_category_name string 小程序的二级类目名
     * category_info_list().certificate_url stringArray 资质相关图片
     * brand_info().brand_wording string 品牌名
     * brand_info().sale_authorization stringArray 商标授权书
     * brand_info().trademark_registration_certificate stringArray 商标注册证
     */
    public function getMiniappCertificate($req_type)
    {
        $params = array();
        $params['req_type'] = $req_type;
        $rst = $this->_request->post($this->_url . 'get_miniapp_certificate', $params);
        return $this->_client->rst($rst);
    }
}
