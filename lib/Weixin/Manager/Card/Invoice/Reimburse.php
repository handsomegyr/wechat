<?php

namespace Weixin\Manager\Card\Invoice;

use Weixin\Client;

/**
 * 报销方接口

 * 9 错误码
 * 错误码 错误信息 备注
 * 0 OK 成功
 * 72015 unauthorized create invoice 没有操作发票的权限，请检查是否已开通相应权限。
 * 72017 invalid invoice title 发票抬头不一致
 * 72023 invoice has been lock 发票已被其他公众号锁定。一般为发票已进入后续报销流程，报销企业公众号/企业号/App锁定了发票。
 * 72024 invoice status error 发票状态错误
 * 72025 invoice token error wx_invoice_token 无效
 * 72028 invoice never set pay mch info 未设置微信支付商户信息
 * 72029 invoice never set auth field 未设置授权字段
 * 72030 invalid mchid mchid 无效
 * 72031 invalid params 参数错误。可能为请求中包括无效的参数名称或包含不通过后台校验的参数值
 * 72035 biz reject insert 发票已经被拒绝开票。若order_id被用作参数调用过拒绝开票接口，再使用此order_id插卡机会报此错误
 * 72036 invoice is busy 发票正在被修改状态，请稍后再试
 * 72038 invoice order never auth 订单没有授权，可能是开票平台 appid 、商户 appid 、订单 order_id 不匹配
 * 72039 invoice must be lock first 订单未被锁定
 * 72040 invoice pdf error Pdf 无效，请提供真实有效的 pdf
 * 72042 billing_code and billing_no repeated 发票号码和发票代码重复
 * 72043 billing_code or billing_no size error 发票号码和发票代码错误
 * 72044 scan text out of time 发票抬头二维码超时
 * 40078 invalid card status card_id未授权。 若开发者使用沙箱环境报此错误，主要因为未将调用接口的微信添加到测试把名单； 若开发者使用正式环境报此错误，主要原因可能为：调用接口公众号未开通卡券权限，或创建card_id与插卡时间间隔过短。
 *
 * 10 发票报销状态一览表
 * 状态 描述
 * INVOICE_REIMBURSE_INIT 发票初始状态，未锁定
 * INVOICE_REIMBURSE_LOCK 发票已锁定
 * INVOICE_REIMBURSE_CLOSURE 发票已核销
 * INVOICE_REIMBURSE_CANCEL 发票被冲红
 * @author guoyongrong <handsomegyr@126.com>
 *        
 */
class Reimburse
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/card/invoice/reimburse/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 5 查询报销发票信息
     * 接口说明
     *
     * 通过该接口查询电子发票的结构化信息，并获取发票PDF文件。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/reimburse/getinvoiceinfo?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下:
     *
     * 参数 类型 是否必填 描述
     * card_id string 是 发票卡券的 card_id
     * encrypt_code string 是 发票卡券的加密 code ，和 card_id 共同构成一张发票卡券的唯一标识
     * 返回结果
     *
     * 返回结果为JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * 当错误码为0时，有以下信息：
     *
     * 参数 类型 是否必填 描述
     * card_id String 是 发票 id
     * begin_time Int 是 发票的有效期起始时间
     * end_time Int 是 发票的有效期截止时间
     * openid String 是 用户标识
     * type String 是 发票的类型，如广东增值税普通发票
     * payee String 是 发票的收款方
     * detail String 是 发票详情
     * user_info Object 是 用户可在发票票面看到的主要信息
     * user_info包含以下信息：
     *
     * 参数 类型 是否必填 描述
     * fee Int 是 发票加税合计金额，以分为单位
     * title String 是 发票的抬头
     * billing_time Int 是 开票时间，为十位时间戳（utc+8）
     * billing_no String 是 发票代码
     * billing_code String 是 发票号码
     * info List 否 商品信息结构，见下方说明
     * fee_without_tax Int 是 不含税金额，以分为单位
     * tax Int 是 税额,以分为单位
     * pdf_url String 是 这张发票对应的PDF_URL
     * trip_pdf_url String 否 其它消费凭证附件对应的URL，如行程单、水单等
     * reimburse_status String 是 发票报销状态，见 备注7.4
     * check_code String 是 校验码（必填）
     * buyer_number String 否 购买方纳税人识别号（选填）
     * buyer_address_and_phone String 否 购买方地址、电话（选填）
     * buyer_bank_account String 否 购买方开户行及账号（选填）
     * seller_number String 否 销售方纳税人识别号（选填）
     * seller_address_and_phone String 否 销售方地址、电话（选填）
     * seller_bank_account String 否 销售方开户行及账号（选填）
     * remarks String 否 备注
     * cashier String 否 收款人，发票左下角处（选填）
     * maker String 否 开票人，发票有下角处（选填）
     * info为发票项目明细信息。数据格式表现为Object列表，每个Object包含以下信息：
     *
     * 参数 类型 是否必填 描述
     * name String 是 项目（商品）名称
     * num Int 否 项目数量
     * unit String 否 项目单位
     * price Int 是 单价，以分为单位
     * 示例代码
     *
     * 请求：
     * {
     * "card_id": "pjZ8Yt5crPbAouhFqFf6JFgZv4Lc",
     * "encrypt_code": "fbdt/fWy1VitQwhbKtSjNeR3BJyfpeJXfZjjGsdCXiM="
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "card_id": "pjZ8Yt5crPbAouhFqFf6JFgZv4Lc",
     * "begin_time": 1476068114,
     * "end_time": 1476168114,
     * "user_card_status": "EXPIRE",
     * "openid": "obLatjnG4vRXJvSO8p914rSK8-Vo",
     * "type": "广东省增值税普通发票",
     * "payee": "测试-收款方",
     * "detail": "测试-detail",
     * "user_info": {
     * "fee": 1100,
     * "title": "XX公司",
     * "billing_time": 1468322401,
     * "billing_no": "hello",
     * "billing_code": "world",
     * "info": [
     * {
     * "name": "绿巨人",
     * "num": 10,
     * "unit": "吨",
     * "price": 4
     * }
     * ],
     * "accept": true,
     * "fee_without_tax": 2345,
     * "tax": 123,
     * "pdf_url": "pdf_url",
     * " reimburse_status": "INVOICE_REIMBURSE_INIT",
     * }
     * }
     *
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
     * 6 批量查询报销发票信息
     * 接口说明
     *
     * 通过该接口批量查询电子发票的结构化信息，并获取发票PDF文件。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/reimburse/getinvoicebatch?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下:
     *
     * 参数 类型 是否必填 描述
     * item_list List 是 发票列表
     * item_list每个对象包含以下字段
     *
     * 参数 类型 是否必填 描述
     * card_id string 是 发票卡券的 card_id
     * encrypt_code string 是 发票卡券的加密 code ，和 card_id 共同构成一张发票卡券的唯一标识
     * 返回结果
     *
     * 返回结果为JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * item_list List 是 发票信息
     * 当错误码为0时，item_list每个对象包含以下信息：
     *
     * 参数 类型 是否必填 描述
     * card_id String 是 发票 id
     * begin_time Int 是 发票的有效期起始时间
     * end_time Int 是 发票的有效期截止时间
     * openid String 是 用户标识
     * type String 是 发票的类型，如广东增值税普通发票
     * payee String 是 发票的收款方
     * detail String 是 发票详情
     * user_info Object 是 用户可在发票票面看到的主要信息
     * user_info包含以下信息：
     *
     * 参数 类型 是否必填 描述
     * fee Int 是 发票加税合计金额，以分为单位
     * title String 是 发票的抬头
     * billing_time Int 是 开票时间，为十位时间戳（utc+8）
     * billing_no String 是 发票代码
     * billing_code String 是 发票号码
     * info List 否 商品信息结构，见下方说明
     * fee_without_tax Int 是 不含税金额，以分为单位
     * tax Int 是 税额,以分为单位
     * pdf_url String 是 这张发票对应的PDF_URL
     * trip_pdf_url String 否 其它消费凭证附件对应的URL，如行程单、水单等
     * reimburse_status String 是 发票报销状态，见 备注7.4
     * check_code String 是 校验码（必填）
     * buyer_number String 否 购买方纳税人识别号（选填）
     * buyer_address_and_phone String 否 购买方地址、电话（选填）
     * buyer_bank_account String 否 购买方开户行及账号（选填）
     * seller_number String 否 销售方纳税人识别号（选填）
     * seller_address_and_phone String 否 销售方地址、电话（选填）
     * seller_bank_account String 否 销售方开户行及账号（选填）
     * remarks String 否 备注
     * cashier String 否 收款人，发票左下角处（选填）
     * maker String 否 开票人，发票有下角处（选填）
     * info为发票项目明细信息。数据格式表现为Object列表，每个Object包含以下信息：
     *
     * 参数 类型 是否必填 描述
     * name String 是 项目（商品）名称
     * num Int 否 项目数量
     * unit String 否 项目单位
     * price Int 是 单价，以分为单位
     * 示例代码
     *
     * 请求：
     * {
     * "item_list": [
     * {
     * "card_id": "pjZ8Yt7KKEXWMpETmwG2ZZxX2m6E",
     * "encrypt_code": "O/mPnGTpBu22a1szmK2 "
     * },
     * {
     * "card_id": "pjZ8YtxSguaLUaaDqzeAf385soJM",
     * "encrypt_code": "O/mPnGTpBu22a1szmK2ogz "
     * }
     * ]
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "item_list": [
     * {
     * "user_info": {
     * "fee": 123,
     * "title": "灌哥发票",
     * "billing_time": 1504085973,
     * "billing_no": "1504085973",
     * "billing_code": "aabbccdd",
     * "info": [
     * {
     * "name": "牙膏",
     * "num": 3,
     * "unit": "个",
     * "price": 10000
     * }
     * ],
     * "fee_without_tax": 2345,
     * "tax": 123,
     * "detail": "项目",
     * "pdf_url": "http://pdfurl",
     * "reimburse_status": "INVOICE_REIMBURSE_INIT",
     * "order_id": "1504085935",
     * "check_code": "check_code",
     * "buyer_number": "buyer_number"
     * },
     * "card_id": "pjZ8Yt7KKEXWMpETmwG2ZZxX2m6E",
     * "openid": "oZI8Fj8L63WugQsljlzzfCcw3AkQ",
     * "type": "广东省增值税普通发票",
     * "payee": "测试-收款方",
     * "detail": "detail"
     * },
     * {
     * "user_info": {
     * "fee": 123,
     * "title": "灌哥发票",
     * "billing_time": 1504083578,
     * "billing_no": "1504083578",
     * "billing_code": "aabbccdd",
     * "info": [
     * {
     * "name": "牙膏",
     * "num": 3,
     * "unit": "个",
     * "price": 10000
     * }
     * ],
     * "fee_without_tax": 2345,
     * "tax": 123,
     * "detail": "项目",
     * "pdf_url": " http://pdfurl",
     * "reimburse_status": "INVOICE_REIMBURSE_INIT",
     * "order_id": "1504083522",
     * "check_code": "check_code",
     * "buyer_number": "buyer_number"
     * },
     * "card_id": "pjZ8YtxSguaLUaaDqzeAf385soJM",
     * "openid": "oZI8Fj8L63WugQsljlzzfCcw3AkQ",
     * "type": "广东省增值税普通发票",
     * "payee": "测试-收款方",
     * "detail": "detail"
     * }
     * ]
     * }
     */
    public function getInvoiceBatch(array $item_list)
    {
        $params = array();
        $params['item_list'] = $item_list;
        $rst = $this->_request->post($this->_url . 'getinvoicebatch', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 7 报销方更新发票状态
     * 接口说明
     *
     * 报销企业和报销服务商可以通过该接口对某一张发票进行锁定、解锁和报销操作。各操作的业务含义及在用户端的表现如下：
     *
     * 锁定：电子发票进入了企业的报销流程时应该执行锁定操作，执行锁定操作后的电子发票仍然会存在于用户卡包内，但无法重复提交报销。
     *
     * 解锁：当电子发票由于各种原因，无法完成报销流程时，应执行解锁操作。执行锁定操作后的电子发票将恢复可以被提交的状态。
     *
     * 报销：当电子发票报销完成后，应该使用本接口执行报销操作。执行报销操作后的电子发票将从用户的卡包中移除，用户可以在卡包的消息中查看到电子发票的核销信息。注意，报销为不可逆操作，请开发者慎重调用。
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/reimburse/updateinvoicestatus?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下:
     *
     * 参数 类型 是否必填 描述
     * card_id string 是 发票卡券的 card_id
     * encrypt_code string 是 发票卡券的加密 code ，和 card_id 共同构成一张发票卡券的唯一标识
     * reimburse_status string 是 发票报销状态
     * 返回结果
     *
     * 返回结果为JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * 示例代码
     *
     * 请求：
     * {
     * "card_id": "pjZ8Yt5crPbAouhFqFf6JFgZv4Lc",
     * "encrypt_code": "fbdt/fWy1VitQwhbKtSjNeR3BJyfpeJXfZjjGsdCXiM=",
     * "reimburse_status": "INVOICE_REIMBURSE_INIT"
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok"
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
     * 8 报销方批量更新发票状态
     * 接口说明
     *
     * 发票平台可以通过该接口对某一张发票进行锁定、解锁和报销操作，注意，报销状态为不可逆状态，请开发者慎重调用。
     *
     * 注意：
     *
     * 1 报销方须保证在报销、锁定、解锁后及时将状态同步至微信侧，保证用户发票可以正常使用
     *
     * 2 批量更新发票状态接口为事务性操作，如果其中一张发票更新失败，列表中的其它发票状态更新也会无法执行，恢复到接口调用前的状态
     *
     * 请求方式
     *
     * 请求URL：https://api.weixin.qq.com/card/invoice/reimburse/updatestatusbatch?access_token={access_token}
     *
     * 请求方法：POST
     *
     * 请求参数
     *
     * 请求参数使用JSON格式，字段如下:
     *
     * 参数 类型 是否必填 描述
     * openid String 是 用户openid
     * reimburse_status String 是 发票报销状态，见备注7.2
     * invoice_list List 是 发票列表
     * invoice_list每个对象包含以下字段：
     *
     * 参数 类型 是否必填 描述
     * card_id String 是 发票卡券的card_id
     * encrypt_code String 是 发票卡券的加密code，和card_id共同构成一张发票卡券的唯一标识
     * 返回结果
     *
     * 返回结果为JSON格式，字段如下：
     *
     * 参数 类型 是否必填 描述
     * errcode Int 是 错误码
     * errmsg String 是 错误信息
     * 示例代码
     *
     * 请求：
     * {
     * "openid": "{openid}",
     * "reimburse_status": "{reimburse_status}",
     * "invoice_list":
     * [
     * {"card_id":"cardid_1","encrypt_code":"encrypt_code_1"},
     * {"card_id":"cardid_2","encrypt_code":"encrypt_code_2"}
     * ]
     * }
     * 返回：
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
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
