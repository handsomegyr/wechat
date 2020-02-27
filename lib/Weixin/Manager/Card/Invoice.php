<?php

/**
 * 发票控制器
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Manager\Card;

use Weixin\Client;
use Weixin\Manager\Card\Invoice\Reimburse;

class Invoice
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/card/invoice/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 2 获取授权页链接
     * 接口说明
     *
     * 本接口供商户调用。商户通过本接口传入订单号、开票平台标识等参数，获取授权页的链接。在微信中向用户展示授权页，当用户点击了授权页上的“领取发票”/“申请开票”按钮后，即完成了订单号与该用户的授权关系绑定，后续开票平台可凭此订单号发起将发票卡券插入用户卡包的请求，微信也将据此授权关系校验是否放行插卡请求。
     *
     * 授权页包括三种样式，商户可以通过传入不同type的值进行调用。各样式授权页如下图所示：
     *
     * 授权页样式
     *
     * 不同样式授权页作用如下：
     *
     * type=0（申请开票类型）：用于商户已从其它渠道获得用户抬头，拉起授权页发起开票，开票成功后保存到用户卡包；
     *
     * type=1（填写抬头申请开票类型）：调用该类型时，页面会显示微信存储的用户常用抬头。用于商户未收集用户抬头，希望为用户减少填写步骤。需要留意的是，当使用支付后开票业务时，只能调用type=1类型。
     *
     * type=2（领取发票类型）：用于商户发票已开具成功，拉起授权页后让用户将发票归集保存到卡包。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/getauthurl?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * s_pappid String 是 开票平台在微信的标识号，商户需要找开票平台提供
     * order_id String 是 订单id，在商户内单笔开票请求的唯一识别号，
     * money Int 是 订单金额，以分为单位
     * timestamp Int 是 时间戳
     * source String 是 开票来源，app：app开票，web：微信h5开票，wxa：小程序开发票，wap：普通网页开票
     * redirect_url String 否 授权成功后跳转页面。本字段只有在source为H5的时候需要填写，引导用户在微信中进行下一步流程。app开票因为从外部app拉起微信授权页，授权完成后自动回到原来的app，故无需填写。
     * ticket String 是 从上一环节中获取
     * type Int 是 授权类型，0：开票授权，1：填写字段开票授权，2：领票授权
     * 返回结果
     *
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * 当错误码为0时，有以下信息：
     *
     * 参数 类型 是否必填 描述
     * auth_url String 是 授权链接
     * appid String 否 source为wxa时才有
     * 示例代码
     *
     * 请求：
     * {
     * "s_pappid": "wxabcd",
     * "order_id": "1234",
     * "money": 11,
     * "timestamp": 1474875876,
     * "source": "web",
     * "redirect_url": "https://mp.weixin.qq.com",
     * "ticket": "tttt",
     * "type": 1
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "auth_url": "http://auth_url"
     * }
     * 如果是小程序，返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "auth_url": "auth_url"
     * "appid": "appid"
     * }
     */
    public function getAuthUrl($s_appid, $order_id, $money, $timestamp, $source, $redirect_url, $ticket, $type)
    {
        $params = array();
        $params['s_appid'] = $s_appid;
        $params['order_id'] = $order_id;
        $params['money'] = $money;
        $params['timestamp'] = $timestamp;
        $params['source'] = $source;
        $params['redirect_url'] = $redirect_url;
        $params['ticket'] = $ticket;
        $params['type'] = $type;
        $rst = $this->_request->post($this->_url . "getauthurl", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 7 查询授权完成状态
     * 接口说明
     *
     * 本接口的调用场景包括两个：
     *
     * 一、若商户在某次向用户展示授权页后经过较长时间仍未收到授权完成状态推送，可以使用本接口主动查询用户是否实际上已完成授权，只是由于网络等原因未收到授权完成事件；
     *
     * 二、若商户向用户展示的授权页为type=1类型，商户在收到授权完成事件推送后需要进一步获取用户的开票信息，也可以调用本接口。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/getauthdata?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * order_id string 是 发票order_id
     * s_pappid String 是 开票平台在微信的标识，由开票平台告知商户
     * 返回结果
     *
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * invoice_status String 否 订单授权状态，当errcode为0时会出现
     * auth_time Int 否 授权时间，为十位时间戳（utc+8），当errcode为0时会出现
     * user_auth_info Object 否 用户授权信息结构体，仅在授权页为type=1时出现
     * 示例代码
     *
     * 请求：
     * {
     * "s_pappid": "{s_pappid}",
     * "order_id": "{order_id}"
     * }
     * 返回：
     * 若用户填入的是个人抬头：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "invoice_status": "auth success",
     * "auth_time": 1480342498,
     * "user_auth_info": {
     * "user_field": {
     * "title": "Dhxhhx ",
     * "phone": "5554545",
     * "email": "dhxhxhhx@qq.cind",
     * "custom_field": [
     * {
     * "key": "field1",
     * "value": "管理理论"
     * }
     * ]
     * }
     * }
     * }
     * 若用户填入的是单位抬头：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "invoice_status": "auth success",
     * "auth_time": 1480342897,
     * "user_auth_info": {
     * "biz_field": {
     * "title": "xx公司",
     * "tax_no": "6464646766",
     * "addr": "xx大厦",
     * "phone": "1557548768",
     * "bank_type": "xx银行",
     * "bank_no": "545454646",
     * "custom_field": [
     * {
     * "key": "field2",
     * "value": "哈哈哈啊"
     * }
     * ]
     * }
     * }
     * }
     */
    public function getAuthData($order_id, $s_appid)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $params['s_appid'] = $s_appid;
        $rst = $this->_request->post($this->_url . "getauthdata", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 8 拒绝开票
     * 接口说明
     *
     * 用户完成授权后，商户若发现用户提交信息错误、或者发生了退款时，可以调用该接口拒绝开票并告知用户。拒绝开票后，该订单无法向用户再次开票。已经拒绝开票的订单，无法再次使用，如果要重新开票，需使用新的order_id，获取授权链接，让用户再次授权。
     * 调用接口后用户侧收到的通知消息如下图所示：
     *
     * 拒绝开票模板消息
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/rejectinsert?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * s_pappid string 是 开票平台在微信上的标识，由开票平台告知商户
     * order_id string 是 订单 id
     * reason string 是 商家解释拒绝开票的原因，如重复开票，抬头无效、已退货无法开票等
     * url string 否 跳转链接，引导用户进行下一步处理，如重新发起开票、重新填写抬头、展示订单情况等
     * 返回结果
     *
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码
     * errmsg string 是 错误信息
     * 示例代码
     *
     * 请求：
     * {
     * "s_pappid": "d3JCEfhGLW+q0iGP+o9",
     * "order_id": "111229",
     * "reason": "1234",
     * url": "http://xxx.com"
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function rejectInsert($s_appid, $order_id, $reason, $url)
    {
        $params = array();
        $params['order_id'] = $order_id;
        $params['s_appid'] = $s_appid;
        $params['reason'] = $reason;
        $params['url'] = $url;
        $rst = $this->_request->post($this->_url . "rejectinsert", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 9 设置授权页字段信息
     * 接口说明
     *
     * 当用户使用type=1的类型的授权页时，可以使用本接口设置授权页上需要用户填写的信息。若使用type=0或type=2类型的授权页，无需调用本接口。本接口为一次性设置，后续除非在需要调整页面字段时才需要再次调用。
     *
     * 注意，设置为显示状态的字段均为必填字段，用户若不填写将无法进入后续流程
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/setbizattr?action=set_auth_field&access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * auth_field Object 是 授权页字段
     * auth_field为Object，包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * user_field Object 是 授权页个人发票字段
     * biz_field Object 是 授权页单位发票字段
     * user_field为Object，包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * show_title Int 否 是否填写抬头，0为否，1为是
     * show_phone Int 否 是否填写电话号码，0为否，1为是
     * show_email Int 否 是否填写邮箱，0为否，1为是
     * require_phone Int 否 电话号码是否必填,0为否，1为是
     * require_email Int 否 邮箱是否必填，0位否，1为是
     * custom_field Object 否 自定义字段
     * biz_field为Object，包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * show_title Int 否 是否填写抬头，0为否，1为是
     * show_tax_no Int 否 是否填写税号，0为否，1为是
     * show_addr Int 否 是否填写单位地址，0为否，1为是
     * show_phone Int 否 是否填写电话号码，0为否，1为是
     * show_bank_type Int 否 是否填写开户银行，0为否，1为是
     * show_bank_no Int 否 是否填写银行帐号，0为否，1为是
     * require_tax_no Int 否 税号是否必填，0为否，1为是
     * require_addr Int 否 单位地址是否必填，0为否，1为是
     * require_phone Int 否 电话号码是否必填，0为否，1为是
     * require_bank_type Int 否 开户类型是否必填，0为否，1为是
     * require_bank_no Int 否 税号是否必填，0为否，1为是
     * custom_field Object 否 自定义字段
     * custom_field为List，每个对象包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * key String 是 字段名
     * is_require Int 否 0：否，1：是， 默认为0
     * notice String 否 提示文案
     * 返回结果
     *
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * 示例代码
     *
     * 请求：
     * {
     * "auth_field" : {
     * "user_field" : {
     * "require_phone" : 1,
     * "custom_field" : [
     * {
     * "is_require" : 1,
     * "key" : "field1"
     * }
     * ],
     * "show_email" : 1,
     * "show_title" : 1,
     * "show_phone" : 1,
     * "require_email" : 1
     * },
     * "biz_field" : {
     * "require_phone" : 0,
     * "custom_field" : [
     * {
     * "is_require" : 0,
     * "key" : "field2"
     * }
     * ],
     * "require_bank_type" : 0,
     * "require_tax_no" : 0,
     * "show_addr" : 1,
     * "require_addr" : 0,
     * "show_title" : 1,
     * "show_tax_no" : 1,
     * "show_phone" : 1,
     * "show_bank_type" : 1,
     * "show_bank_no" : 1,
     * "require_bank_no" : 0
     * }
     * }
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function setAuthField4Setbizattr(\Weixin\Model\Invoice\AuthField $auth_field)
    {
        $params = array();
        $params['auth_field'] = $auth_field->getParams();
        $rst = $this->_request->post($this->_url . "setbizattr?action=set_auth_field", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 10 查询授权页字段信息
     * 接口说明
     *
     * 商户可以通过本接口查询到授权页的字段设置情况。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/setbizattr?action=get_auth_field&access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，传入空值，即{}
     *
     * 返回结果
     *
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * auth_field Object 否 当错误码为0时非空，为查询所得的授权页字段设置情况
     * auth_field为Object，包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * user_field Object 否 授权页个人发票字段
     * biz_field Object 否 授权页单位发票字段
     * user_filed为Object，包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * show_title Int 否 是否填写抬头，0为否，1为是
     * show_phone Int 否 是否填写电话号码，0为否，1为是
     * show_email Int 否 是否填写邮箱，0为否，1为是
     * require_phone Int 否 电话是否必填，0为否，1为是
     * require_email Int 否 邮箱是否必填，0为
     * custom_field Object 否 自定义字段
     * biz_field为Object，包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * show_title Int 否 是否填写抬头，0为否，1为是
     * show_tax_no Int 否 是否填写税号，0为否，1为是
     * show_addr Int 否 是否填写单位地址，0为否，1为是
     * show_phone Int 否 是否填写电话号码，0为否，1为是
     * show_bank_type Int 否 是否填写开户银行，0为否，1为是
     * show_bank_no Int 否 是否填写银行帐号，0为否，1为是
     * require_tax_no Int 否 税号是否必填，0为否，1为是
     * require_addr Int 否 单位地址是否必填，0为否，1为是
     * require_phone Int 否 电话号码是否必填，0为否，1为是
     * require_bank_type Int 否 开户类型是否必填，0为否，1为是
     * require_bank_no Int 否 税号是否必填，0为否，1为是
     * require_tax_no Int 否 税号是否必填，0为否，1为是
     * custom_field Object 否 自定义字段
     * custom_field为list每个对象包括以下字段：
     *
     * 参数 类型 是否必填 描述
     * key String 是 自定义字段名称，最长5个字
     * Is_require Int 否 自定义字段是否必填，0位否，1为是
     * 示例代码
     *
     * 请求： {}
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "auth_field": {
     * "user_field": {
     * "show_title": 1,
     * "show_phone": 1,
     * "show_email": 1,
     * "custom_field": [{"key": "field1"}]
     * },
     * "biz_field": {
     * "show_title": 1,
     * "show_tax_no": 1,
     * "show_addr": 1,
     * "show_phone": 1,
     * "show_bank_type": 1,
     * "show_bank_no": 1,
     * "custom_field": [{"key": "field2"}]
     * }
     * }
     * }
     */
    public function getAuthField4Setbizattr(\Weixin\Model\Invoice\AuthField $auth_field)
    {
        $params = array();
        $params['auth_field'] = $auth_field->getParams();
        if (empty($params['auth_field'])) {
            $params['auth_field'] = '{}';
        }
        $rst = $this->_request->post($this->_url . "setbizattr?action=get_auth_field", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 11 关联商户号与开票平台
     * 接口说明
     *
     * 商户使用支付后开票，需要先将自身的商户号和开票平台的识别号进行关联，开票平台识别号由开票平台根据微信规则生成后告知商户。本接口为一次性设置，后续一般在遇到开票平台识别号变更，或者商户更换开票平台时才需要调用本接口重设对应关系。
     *
     * 若商户已经实现电子发票的微信卡包送达方案，调用本接口前，建议在微信支付商户平台中确认商户号所绑定的公众号和拉起授权页的公众号是同一个。若不是同一个，仍需重新使用商户号所绑定公众号去调通拉取授权页的接口。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/setbizattr?action=set_pay_mch&access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * paymch_info Object 是 微信商户号与开票平台关系信息
     * paymch_info是Object，里面包括以下字段：
     *
     * 参数 类型 是否必填 描述
     * mchid string 是 微信支付商户号
     * s_pappid string 是 为该商户提供开票服务的开票平台 id ，由开票平台提供给商户
     * 返回结果
     *
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码
     * errmsg string 是 错误信息
     * 示例代码
     *
     * 请求：
     * {
     * "paymch_info":
     * {
     * "mchid": "1234",
     * "s_pappid": "wxabcd"
     * }
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function setPaymch4Setbizattr(\Weixin\Model\Invoice\PaymchInfo $paymch_info)
    {
        $params = array();
        $params['paymch_info'] = $paymch_info->getParams();
        $rst = $this->_request->post($this->_url . "setbizattr?action=set_pay_mch", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 12 查询商户号与开票平台关联情况
     * 接口说明
     *
     * 商户可以通过本接口查询到与开票平台的绑定情况。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/setbizattr?action=get_pay_mch&access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，传入空值{}
     *
     * 返回结果
     *
     * 返回结果数据使用JSON格式，结果字段清单如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码
     * errmsg string 是 错误信息
     * paymch_info object 否 当 errcode 为 0 时出现，为商户号与开票平台的关联情况
     * 当errcode为0时，返回数据中还有paymch_info对象，paymch_info包括以下字段：
     *
     * 参数 类型 是否必填 描述
     * mchid string 是 微信支付商户号
     * s_pappid string 是 绑定的开票平台识别码
     * 示例代码
     *
     * 请求： {}
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "paymch_info":
     * {
     * "mchid": "1234",
     * "s_pappid": "wxabcd"
     * }
     * }
     */
    public function getPaymch4Setbizattr(\Weixin\Model\Invoice\PaymchInfo $paymch_info)
    {
        $params = array();
        $params['paymch_info'] = $paymch_info->getParams();
        if (empty($params['paymch_info'])) {
            $params['paymch_info'] = '{}';
        }
        $rst = $this->_request->post($this->_url . "setbizattr?action=get_pay_mch", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 14 统一开票接口-开具蓝票
     * 接口说明
     * 对于使用微信电子发票开票接入能力的商户，在公众号后台选择任何一家开票平台的套餐，都可以使用本接口实现电子发票的开具。
     *
     * 请求方式
     * 请求URL：https://api.weixin.qq.com/card/invoice/makeoutinvoice?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * wxopenid String 是 用户的openid 用户知道是谁在开票
     * ddh String 是 订单号，企业自己内部的订单号码。注1
     * fpqqlsh String 是 发票请求流水号，唯一识别开票请求的流水号。注2
     * nsrsbh String 是 纳税人识别码
     * nsrmc String 是 纳税人名称
     * nsrdz String 是 纳税人地址
     * nsrdh String 是 纳税人电话
     * nsrbank String 是 纳税人开户行
     * nsrbankid String 是 纳税人银行账号
     * ghfmc Sring 是 购货方名称
     * ghfnsrsbh String 否 购货方识别号
     * ghfdz String 否 购货方地址
     * ghfdh String 否 购货方电话
     * ghfbank String 否 购货方开户行
     * ghfbankid String 否 购货方银行帐号
     * kpr String 是 开票人
     * skr String 否 收款人
     * fhr String 否 复核人
     * jshj String 是 价税合计
     * hjse String 是 合计金额
     * bz String 否 备注
     * hylx String 否 行业类型 0 商业 1其它
     * invoicedetail_list List 是 发票行项目数据
     * 注1：ddh（订单号）需要和拉起授权页时的order_id保持一致，否则会出现未授权订单号的报错
     * 注2：fpqqlsh（发票请求流水号）为开票的唯一标识，头六位需要和后台的商户识别号保持一致
     *
     * invoicedetail_list是一个JSON list，其中每一个对象的结构为
     *
     * 参数 类型 是否必填 描述
     * fphxz String 是 发票行性质 0 正常 1折扣 2 被折扣
     * spbm String 是 19位税收分类编码说明见注
     * xmmc String 是 项目名称
     * dw String 否 计量单位
     * ggxh String 否 规格型号
     * xmsl String 是 项目数量
     * xmdj String 是 项目单价
     * xmje String 是 项目金额 不含税，单位元 两位小数
     * sl String 是 税率 精确到两位小数 如0.01
     * se String 是 税额 单位元 两位小数
     * 注：税收分类编码，即根据开票项目，从国家《商品和服务税收分类与编码》选出的19位编码，具体填入内容请根据企业实际情况与企业财务核实
     *
     * 返回结果
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码，见错误码列表
     * errmsg string 是 错误信息
     * 示例代码
     *
     * 请求
     * {
     * "invoiceinfo" :
     * {
     * "wxopenid": "os92LxEDbiOw7kWZanRN_Bb3Q45I",
     * "ddh" : "30000",
     * "fpqqlsh": "test20160511000461",
     * "nsrsbh": "110109500321654",
     * "nsrmc": "百旺电子测试1",
     * "nsrdz": "深圳市",
     * "nsrdh": "0755228899988",
     * "nsrbank": "中国银行广州支行",
     * "nsrbankid": "12345678",
     * "ghfnsrsbh": "110109500321654",
     * "ghfmc": "周一",
     * "ghfdz": "广州市",
     * "ghfdh": "13717771888",
     * "ghfbank": "工商银行",
     * "ghfbankid": "12345678",
     * "kpr": "小明",
     * "skr": "李四",
     * "fhr": "小王",
     * "jshj": "159",
     * "hjje": "135.9",
     * "hjse": "23.1",
     * "bz": "备注",
     * "hylx": "0",
     * "invoicedetail_list": [
     * {
     * "fphxz": "0",
     * "spbm": "1090418010000000000",
     * "xmmc": "洗衣机",
     * "dw": "台",
     * "ggxh": "60L",
     * "xmsl": "1",
     * "xmdj": "135.9",
     * "xmje": "135.9",
     * "sl": "0.17",
     * "se": "23.1"
     * }
     * ],
     * }
     * }
     * 返回
     * {
     * "errcode": 0,
     * "errmsg": "sucesss"
     * }
     */
    public function makeoutInvoice(\Weixin\Model\Invoice\Invoiceinfo $invoiceinfo)
    {
        $params = array();
        $params['invoiceinfo'] = $invoiceinfo->getParams();
        $rst = $this->_request->post($this->_url . "makeoutinvoice", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 15 统一开票接口-发票冲红
     * 接口说明
     * 对于使用微信电子发票开票接入能力的商户，在公众号后台选择任何一家开票平台的套餐，都可以使用本接口实现电子发票的冲红。
     *
     * 请求方式
     * 请求URL：https://api.weixin.qq.com/card/invoice/clearoutinvoice?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * wxopenid String 是 用户的openid 用户知道是谁在开票
     * fpqqlsh String 是 发票请求流水号，唯一查询发票的流水号
     * nsrsbh String 是 纳税人识别码
     * nsrmc String 是 纳税人名称
     * yfpdm String 是 原发票代码，即要冲红的蓝票的发票代码
     * yfphm String 是 原发票代码，即要冲红的蓝票的发票号码
     * 返回结果
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码，见错误码列表
     * errmsg string 是 错误信息，见错误码列表
     * 示例代码
     *
     * 请求
     * {
     * "invoiceinfo" :
     * {
     * "wxopenid": "os92LxEDbiOw7kWZanRN_Bb3Q45I",
     * "fpqqlsh": "test20160511000400",
     * "nsrsbh": "110109500321654",
     * "nsrmc": "百旺电子测试1",
     * "yfpdm" : "050003521100",
     * "yfphm" : "30329969",
     *
     * }
     * }
     *
     * 返回
     * {
     * "errcode": 0,
     * "errmsg": "sucesss"
     * }
     */
    public function clearoutInvoice($wxopenid, $fpqqlsh, $nsrsbh, $nsrmc, $yfpdm, $yfphm)
    {
        $params = array();
        // 参数 类型 是否必填 描述
        // wxopenid String 是 用户的openid 用户知道是谁在开票
        $params['wxopenid'] = $wxopenid;
        // fpqqlsh String 是 发票请求流水号，唯一查询发票的流水号
        $params['fpqqlsh'] = $fpqqlsh;
        // nsrsbh String 是 纳税人识别码
        $params['nsrsbh'] = $nsrsbh;
        // nsrmc String 是 纳税人名称
        $params['nsrmc'] = $nsrmc;
        // yfpdm String 是 原发票代码，即要冲红的蓝票的发票代码
        $params['yfpdm'] = $yfpdm;
        // yfphm String 是 原发票代码，即要冲红的蓝票的发票号码
        $params['yfphm'] = $yfphm;

        $rst = $this->_request->post($this->_url . "clearoutinvoice", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 16 统一开票接口-查询已开发票
     * 接口说明
     * 对于使用微信电子发票开票接入能力的商户，在公众号后台选择任何一家开票平台的套餐，都可以使用本接口实现已开具电子发票的查询。
     *
     * 请求方式
     * 请求URL：https://api.weixin.qq.com/card/invoice/queryinvoceinfo?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * fpqqlsh String 是 发票请求流水号，唯一查询发票的流水号
     * nsrsbh String 是 纳税人识别码
     * 返回结果
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码，见错误码列表
     * errmsg string 是 错误信息，见错误码列表
     * fpqqlsh String 是 发票请求流水号，唯一查询发票的流水号
     * jym String 是 校验码，位于电子发票右上方，开票日期下
     * kprq String 是 校验码
     * fpdm String 是 发票代码
     * fphm String 是 发票号码
     * pdfurl String 是 发票url
     * 示例代码
     *
     * 请求
     * {
     * "fpqqlsh": "test20160511000440",
     * "nsrsbh": "110109500321654"
     * }
     *
     * 返回：
     *
     * {
     * "errcode": 0,
     * "errmsg": "发票数据获取成功",
     * "invoicedetail": {
     * "fpqqlsh": "14574d75004451097845",
     * "fpdm": "088978450417",
     * "fphm": "21590001",
     * "jym": "59004166725791147047",
     * "kprq": "20171204172159",
     * "pdfurl": "http://weixin.com"
     * }
     * }
     */
    public function queryInvoceInfo($fpqqlsh, $nsrsbh)
    {
        $params = array();
        // 参数 类型 是否必填 描述
        // fpqqlsh String 是 发票请求流水号，唯一查询发票的流水号
        $params['fpqqlsh'] = $fpqqlsh;
        // nsrsbh String 是 纳税人识别码
        $params['nsrsbh'] = $nsrsbh;
        $rst = $this->_request->post($this->_url . "queryinvoceinfo", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 17 设置商户联系方式
     * 接口说明
     * 商户获取授权链接之前，需要先设置商户的联系方式
     *
     * 请求方式
     * 请求URL：https://api.weixin.qq.com/card/invoice/setbizattr?action=set_contact&access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * contact Object 是 联系方式信息
     * contact是Object，里面包括以下字段：
     *
     * 参数 类型 是否必填 描述
     * time_out int 是 开票超时时间
     * phone string 是 联系电话
     * 返回结果
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码
     * errmsg string 是 错误信息
     * 示例代码
     *
     * 请求：
     * {
     * "contact" :
     * {
     * "phone" : "88888888",
     * "time_out" : 12345
     * }
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     */
    public function setContact4Setbizattr(\Weixin\Model\Invoice\Contact $contact)
    {
        $params = array();
        $params['contact'] = $contact->getParams();
        $rst = $this->_request->post($this->_url . "setbizattr?action=set_contact", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 18 查询商户联系方式
     * 接口说明
     * 商户获取授权链接之前，需要先设置商户的联系方式
     *
     * 请求方式
     * 请求URL：https://api.weixin.qq.com/card/invoice/setbizattr?action=get_contact&access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数使用JSON格式，传入空值{}
     *
     * 返回结果
     * 返回结果使用JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode int 是 错误码
     * errmsg string 是 错误信息
     * contact Object 是 联系方式信息
     * contact是Object，里面包括以下字段：
     *
     * 参数 类型 是否必填 描述
     * time_out int 是 开票超时时间
     * phone string 是 联系电话
     * 示例代码
     *
     * 请求：
     * {}
     * 返回：
     * {
     * "contact" : {
     * "phone" : "88888888",
     * "time_out" : 12345
     * },
     * "errcode" : 0,
     * "errmsg" : "ok"
     * }
     */
    public function getContact4Setbizattr(\Weixin\Model\Invoice\Contact $contact)
    {
        $params = array();
        $contackParams = $contact->getParams();
        if (!empty($contackParams)) {
            $params['contact'] = $contackParams;
        }
        $rst = $this->_request->post($this->_url . "setbizattr?action=get_contact", $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取报销发票对象
     *
     * @return \Weixin\Manager\Card\Invoice\Reimburse
     */
    public function getReimburseManager()
    {
        return new Reimburse($this->_client);
    }
}
