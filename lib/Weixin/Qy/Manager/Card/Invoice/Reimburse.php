<?php

namespace Weixin\Qy\Manager\Card\Invoice;

use Weixin\Qy\Client;

/**
 * 电子发票
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *        
 */
class Reimburse
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 查询电子发票
     * 调试工具
     * 接口说明：报销方在获得用户选择的电子发票标识参数后，可以通过该接口查询电子发票的结构化信息，并获取发票PDF文件。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/getinvoiceinfo?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "card_id":"CARDID" ,
     * "encrypt_code":"ENCRYPTCODE"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * card_id 是 发票id
     * encrypt_code 是 加密code
     * 权限说明：
     *
     * 仅认证的企业微信账号有接口权限
     *
     * 返回数据：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "card_id":"CARDID",
     * "begin_time":1469084420,
     * "end_time":2100236420,
     * "openid":"oxfdsfsafaf",
     * "type":"增值税电子普通发票",
     * "payee":"深圳市XX有限公司",
     * "detail":"可在公司企业微信内报销使用",
     * "user_info":{
     * "fee":4000,
     * "title":"XX有限公司",
     * "billing_time":1478620800,
     * "billing_no":"00000001",
     * "billing_code":"000000000001",
     * "info":[
     * {
     * "name":"NAME",
     * "num":10,
     * "unit":"吨",
     * "fee":10,
     * "price":4
     * }
     * ],
     * "fee_without_tax":2345,
     * "tax":123,
     * "detail":"项目",
     * "pdf_url":"pdf_url",
     * "reimburse_status":"INVOICE_REIMBURSE_INIT"
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * card_id 发票id
     * begin_time 发票的有效期起始时间
     * end_time 发票的有效期截止时间
     * openid 用户标识
     * type 发票类型，如广东增值税普通发票
     * payee 发票的收款方
     * detail 发票详情
     * user_info 发票的用户信息，见user_info结构说明
     * user_info包含以下信息：
     *
     * 参数 说明
     * fee 发票加税合计金额，以分为单位
     * title 发票的抬头
     * billing_time 开票时间，为十位时间戳
     * billing_no 发票代码
     * billing_code 发票号码
     * fee_without_tax 不含税金额，以分为单位
     * detail 发票详情，一般描述的是发票的使用说明
     * pdf_url 这张发票对应的PDF_URL
     * trip_pdf_url 其它消费凭证附件对应的URL，如行程单、水单等
     * check_code 校验码
     * buyer_number 购买方纳税人识别号
     * buyer_address_and_phone 购买方地址、电话
     * buyer_bank_account 购买方开户行及账号
     * seller_number 销售方纳税人识别号
     * seller_address_and_phone 销售方地址、电话
     * seller_bank_account 销售方开户行及账号
     * remarks 备注
     * cashier 收款人，发票左下角处
     * maker 开票人，发票右下角处
     * reimburse_status 发报销状态INVOICE_REIMBURSE_INIT：发票初始状态，未锁定；INVOICE_REIMBURSE_LOCK：发票已锁定；INVOICE_REIMBURSE_CLOSURE：发票已核销
     * info 商品信息结构，见下方说明
     * info包含以下信息：
     *
     * 参数 说明
     * name 项目（商品）名称
     * num 项目数量
     * unit 项目单位
     * price 单价，以分为单位
     */
    public function getInvoiceInfo($card_id, $encrypt_code)
    {
        $params = array();
        $params['card_id'] = $card_id;
        $params['encrypt_code'] = $encrypt_code;
        $rst = $this->_request->post($this->_url . 'getinvoiceinfo', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 批量查询电子发票
     * 调试工具
     * 接口说明：报销方在获得用户选择的电子发票标识参数后，可以通过该接口批量查询电子发票的结构化信息。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/getinvoiceinfobatch?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "item_list": [
     * {
     * "card_id":"CARDID1" ,
     * "encrypt_code":"ENCRYPTCODE1"
     * },
     * {
     * "card_id":"CARDID2" ,
     * "encrypt_code":"ENCRYPTCODE2"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * item_list 是 发票列表
     * card_id 是 发票id
     * encrypt_code 是 加密code
     * 权限说明：
     *
     * 仅认证的企业微信账号并且企业激活人数超过200的企业才有接口权限，如果认证的企业激活人数不超过200人请联系企业微信客服咨询。
     *
     * 返回数据：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "item_list": [
     * {
     * "card_id": "CARDID",
     * "openid": "ofdsfasfsafsafasf",
     * "type": "增值税电子普通发票",
     * "payee": "深圳市XX有限公司",
     * "detail": "可在公司企业微信内报销使用",
     * "user_info": {
     * "fee": 4000,
     * "title": "XX有限公司",
     * "billing_time": 1478620800,
     * "billing_no": "00000001",
     * "billing_code": "000000000001",
     * "info": [
     * {
     * "name": "NAME",
     * "num": 10,
     * "unit": "吨",
     * "fee": 10,
     * "price": 4
     * }
     * ],
     * "fee_without_tax": 2345,
     * "tax": 123,
     * "detail": "项目",
     * "pdf_url": "pdf_url",
     * "reimburse_status": "INVOICE_REIMBURSE_INIT",
     * "order_id": "12345678",
     * "check_code": "CHECKCODE",
     * "buyer_number": "BUYERNUMER"
     * }
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * card_id 发票id
     * openid 用户标识
     * type 发票类型，如广东增值税普通发票
     * payee 发票的收款方
     * detail 发票详情
     * user_info 发票的用户信息，见user_info结构说明
     * user_info包含以下信息：
     *
     * 参数 说明
     * fee 发票加税合计金额，以分为单位
     * title 发票的抬头
     * billing_time 开票时间，为十位时间戳
     * billing_no 发票代码
     * billing_code 发票号码
     * fee_without_tax 不含税金额，以分为单位
     * detail 发票详情，一般描述的是发票的使用说明
     * pdf_url 这张发票对应的PDF_URL
     * trip_pdf_url 其它消费凭证附件对应的URL，如行程单、水单等
     * check_code 校验码
     * buyer_number 购买方纳税人识别号
     * buyer_address_and_phone 购买方地址、电话
     * buyer_bank_account 购买方开户行及账号
     * seller_number 销售方纳税人识别号
     * seller_address_and_phone 销售方地址、电话
     * seller_bank_account 销售方开户行及账号
     * remarks 备注
     * cashier 收款人，发票左下角处
     * maker 开票人，发票有下角处
     * reimburse_status 发报销状态INVOICE_REIMBURSE_INIT：发票初始状态，未锁定；INVOICE_REIMBURSE_LOCK：发票已锁定；INVOICE_REIMBURSE_CLOSURE：发票已核销
     * info 商品信息结构，见下方说明
     * info包含以下信息：
     *
     * 参数 说明
     * name 项目（商品）名称
     * num 项目数量
     * unit 项目单位
     * price 单价，以分为单位
     */
    public function getInvoiceinfoBatch(array $item_list)
    {
        $params = array();
        $params['item_list'] = $item_list;
        $rst = $this->_request->post($this->_url . 'getinvoiceinfobatch', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新发票状态
     * 调试工具
     * 接口说明：报销企业和报销服务商可以通过该接口对某一张发票进行锁定、解锁和报销操作。各操作的业务含义及在用户端的表现如下：
     * 锁定：电子发票进入了企业的报销流程时应该执行锁定操作，执行锁定操作后的电子发票仍然会存在于用户卡包内，但无法重复提交报销。
     * 解锁：当电子发票由于各种原因，无法完成报销流程时，应执行解锁操作。执行锁定操作后的电子发票将恢复可以被提交的状态。
     * 报销：当电子发票报销完成后，应该使用本接口执行报销操作。执行报销操作后的电子发票将从用户的卡包中移除，用户可以在卡包的消息中查看到电子发票的核销信息。注意，报销为不可逆操作，请开发者慎重调用。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/updateinvoicestatus?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "card_id":"CARDID" ,
     * "encrypt_code":"ENCRYPTCODE",
     * "reimburse_status":"INVOICE_REIMBURSE_INIT"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * card_id 是 发票id
     * encrypt_code 是 加密code
     * reimburse_status 是 发报销状态 INVOICE_REIMBURSE_INIT：发票初始状态，未锁定；INVOICE_REIMBURSE_LOCK：发票已锁定，无法重复提交报销;INVOICE_REIMBURSE_CLOSURE:发票已核销，从用户卡包中移除
     * 权限说明：
     *
     * 仅认证的企业微信账号有接口权限
     *
     * 返回数据：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * }
     */
    public function updateInvoiceStatus($card_id, $encrypt_code, $reimburse_status)
    {
        $params = array();
        $params['card_id'] = $card_id;
        $params['encrypt_code'] = $encrypt_code;
        $params['reimburse_status'] = $reimburse_status;
        $rst = $this->_request->post($this->_url . 'updateinvoicestatus', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 批量更新发票状态
     * 调试工具
     * 接口说明：发票平台可以通过该接口对某个成员的一批发票进行锁定、解锁和报销操作。注意，报销状态为不可逆状态，请开发者慎重调用。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/card/invoice/reimburse/updatestatusbatch?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "openid":"OPENID" ,
     * "reimburse_status":"INVOICE_REIMBURSE_INIT",
     * "invoice_list":
     * [
     * {"card_id":"cardid_1","encrypt_code":"encrypt_code_1"},
     * {"card_id":"cardid_2","encrypt_code":"encrypt_code_2"}
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * openid 是 用户openid，可用“userid与openid互换接口”获取
     * reimburse_status 是 发票报销状态 INVOICE_REIMBURSE_INIT：发票初始状态，未锁定；INVOICE_REIMBURSE_LOCK：发票已锁定，无法重复提交报销;INVOICE_REIMBURSE_CLOSURE:发票已核销，从用户卡包中移除
     * invoice_list 是 发票列表，必须全部属于同一个openid
     * card_id 是 发票卡券的card_id
     * encrypt_code 是 发票卡券的加密code，和card_id共同构成一张发票卡券的唯一标识
     * 权限说明：
     *
     * 仅认证的企业微信账号有接口权限
     *
     * 返回数据：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * }
     * 注：
     *
     * 报销方须保证在报销、锁定、解锁后及时将状态同步至微信侧，保证用户发票可以正常使用
     * 批量更新发票状态接口为事务性操作，如果其中一张发票更新失败，列表中的其它发票状态更新也会无法执行，恢复到接口调用前的状态
     */
    public function updateStatusBatch($openid, $reimburse_status, array $invoice_list)
    {
        $params = array();
        $params['openid'] = $openid;
        $params['reimburse_status'] = $reimburse_status;
        $params['invoice_list'] = $invoice_list;
        $rst = $this->_request->post($this->_url . 'updatestatusbatch', $params);
        return $this->_client->rst($rst);
    }
}
