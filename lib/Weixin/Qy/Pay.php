<?php

namespace Weixin\Qy;

use Weixin\Helpers;
use Weixin\Http\Request;

/**
 * 企业微信支付接口
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Pay
{
    private $_url = 'https://api.mch.weixin.qq.com/';

    // 设置是否沙箱环境测试
    private $is_sandbox = false;

    public function is_sandbox($is_sandbox)
    {
        $this->is_sandbox = $is_sandbox;
        if ($is_sandbox) {
            $this->_url = 'https://api.mch.weixin.qq.com/sandboxnew/';
        } else {
            $this->_url = 'https://api.mch.weixin.qq.com/';
        }
    }

    /**
     * appId
     * 微信公众号身份的唯一标识。
     *
     * @var string
     */
    private $appId = "";

    public function setAppId($appId)
    {
        $this->appId = $appId;
    }

    public function getAppId()
    {
        if (empty($this->appId)) {
            throw new \Exception('AppId未设定');
        }
        return $this->appId;
    }

    /**
     * appSecret
     * 微信公众号秘钥。
     *
     * @var string
     */
    private $appSecret = "";

    public function setAppSecret($appSecret)
    {
        $this->appSecret = $appSecret;
    }

    public function getAppSecret()
    {
        if (empty($this->appSecret)) {
            throw new \Exception('AppSecret未设定');
        }
        return $this->appSecret;
    }

    /**
     * access_token微信公众平台凭证。
     */
    private $accessToken = "";

    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
    }

    public function getAccessToken()
    {
        if (empty($this->accessToken)) {
            throw new \Exception('access token未设定');
        }
        return $this->accessToken;
    }

    /**
     * Mchid 商户 ID ，身份标识
     */
    private $mchid = "";

    public function setMchid($mchid)
    {
        $this->mchid = $mchid;
    }

    public function getMchid()
    {
        if (empty($this->mchid)) {
            throw new \Exception('Mchid未设定');
        }
        return $this->mchid;
    }

    /**
     * Key 商户支付密钥。登录微信商户后台，进入栏目【账设置】【密码安全】【 API密钥】，进入设置 API密钥。
     */
    private $key = "";

    public function setKey($key)
    {
        $this->key = $key;
    }

    public function getKey()
    {
        if (empty($this->key)) {
            throw new \Exception('Key未设定');
        }
        return $this->key;
    }

    /**
     * cert 商户证书。
     *
     * @var string
     */
    private $cert = "";

    public function setCert($cert)
    {
        $this->cert = $cert;
    }

    public function getCert()
    {
        if (empty($this->cert)) {
            throw new \Exception('商户证书未设定');
        }
        return $this->cert;
    }

    /**
     * certKey 商户证书秘钥。
     *
     * @var string
     */
    private $certKey = "";

    public function setCertKey($certKey)
    {
        $this->certKey = $certKey;
    }

    public function getCertKey()
    {
        if (empty($this->certKey)) {
            throw new \Exception('商户证书秘钥未设定');
        }
        return $this->certKey;
    }

    public function __construct()
    {
    }

    /**
     * 发放企业红包
     * API接口协议
     * 发放规则：
     *
     * 发送频率限制———默认1800/min
     * 发送个数上限———默认1800/min
     * 场景金额限制———默认红包金额为1-200元，如有需要，可前往商户平台进行设置和申请
     * 其他限制———商户单日出资金额上限—100万元；单用户单日收款金额上限—1000元；单用户可领取红包个数上限—10个
     * 注意事项：
     *
     * 红包金额大于200或者小于1元时，请求参数scene_id必传，参数说明见下文。
     * 根据监管要求，新申请商户号使用现金红包需要满足两个条件：1、入驻时间超过90天 2、连续正常交易30天。
     * 移动应用的appid无法使用红包接口。
     * 当返回错误码为“SYSTEMERROR”时，请不要更换商户订单号，一定要使用原商户订单号重试，否则可能造成重复发放红包等资金风险。
     * XML具有可扩展性，因此返回参数可能会有新增，而且顺序可能不完全遵循此文档规范，如果在解析回包的时候发生错误，请商户务必不要换单重试，请商户联系客服确认红包发放情况。如果有新回包字段，会更新到此API文档中。
     * 因为错误代码字段err_code的值后续可能会增加，所以商户如果遇到回包返回新的错误码，请商户务必不要换单重试，请商户联系客服确认红包发放情况。如果有新的错误码，会更新到此API文档中。
     * 错误代码描述字段err_code_des只供人工定位问题时做参考，系统实现时请不要依赖这个字段来做自动化处理。
     * 请商户在自身的系统中合理设置发放频次并做好并发控制，防范错付风险。
     * 因商户自身系统设置存在问题导致的资金损失，由商户自行承担。
     * 请求方式：POST（HTTPS）
     * 请求地址：https://api.mch.weixin.qq.com/mmpaymkttransfers/sendworkwxredpack
     * 是否需要证书：是
     * 数据格式：xml
     *
     * 证书使用详见：https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=4_3
     *
     * 请求示例：
     *
     * <xml>
     * <nonce_str>5K8264ILTKCH16CQ2502SI8ZNMTM67VS</nonce_str>
     * <sign>C380BEC2BFD727A4B6845133519F3AD6</sign>
     * <mch_billno>123456</mch_billno>
     * <mch_id>10000098</mch_id>
     * <wxappid>wx8888888888888888</wxappid>
     * <sender_name>XX活动</sender_name>
     * <sender_header_media_id>1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0</sender_header_media_id>
     * <re_openid>oxTWIuGaIt6gTKsQRLau2M0yL16E</re_openid>
     * <total_amount>1000</total_amount>
     * <wishing>感谢您参加猜灯谜活动，祝您元宵节快乐！</wishing>
     * <act_name>猜灯谜抢红包活动</act_name>
     * <remark>猜越多得越多，快来抢！</remark>
     * <workwx_sign>99BCDAFF065A4B95628E3DB468A874A8</workwx_sign>
     * </xml>
     * 参数说明：
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 参见“签名算法”
     * 商户订单号 mch_billno 是 123456 String(28) 商户订单号（每个订单号必须唯一。取值范围：0~9，a~z，A~Z）.接口根据商户订单号支持重入，如出现超时可再调用。组成参考：mch_id+yyyymmdd+10位一天内不能重复的数字
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 公众账号appid wxappid 是 wx8888888888888888 String(32) 微信分配的公众账号ID（企业微信corpid即为此appId）。接口传入的所有appid应该为公众号的appid（在mp.weixin.qq.com申请的），不能为APP的appid（在open.weixin.qq.com申请的）。
     * 发送者名称 sender_name 否 XX活动 String(128) 以个人名义发红包，红包发送者名称(需要utf-8格式)。与agentid互斥，二者只能填一个。
     * 发送红包的应用id agentid 否 1 unsigned int 以企业应用的名义发红包，企业应用id，整型，可在企业微信管理端应用的设置页面查看。与sender_name互斥，二者只能填一个。
     * 发送者头像 sender_header_media_id 否 1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0 String(128) 发送者头像素材id，通过企业微信开放上传素材接口获取
     * 用户openid re_openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String(32) 接受红包的用户.用户在wxappid下的openid。获取用户openid参见：http://work.weixin.qq.com/api/doc#11279
     * 金额 total_amount 是 1000 int 金额，单位分，单笔最小金额默认为1元
     * 红包祝福语 wishing 是 感谢您参加猜灯谜活动，祝您元宵节快乐！ String(128) 红包祝福语
     * 项目名称 act_name 是 猜灯谜抢红包活动 String(32) 项目名称
     * 备注 remark 是 猜越多得越多，快来抢！ String(256) 备注信息
     * 场景 scene_id 否 PRODUCT_1 String(32) 发放红包使用场景，红包金额大于200或者小于1元时必传
     * PRODUCT_1:商品促销
     * PRODUCT_2:抽奖
     * PRODUCT_3:虚拟物品兑奖
     * PRODUCT_4:企业内部福利
     * PRODUCT_5:渠道分润
     * PRODUCT_6:保险回馈
     * PRODUCT_7:彩票派奖
     * PRODUCT_8:税务刮奖
     * 企业微信签名 workwx_sign 是 企业微信签名 String(32) 参见“签名算法”
     * 返回结果 ：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[ok]]></return_msg>
     * <sign><![CDATA[C380BEC2BFD727A4B6845133519F3AD6]]></sign>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <mch_billno><![CDATA[123456]]></mch_billno>
     * <mch_id><![CDATA[10000098]]></mch_id>
     * <wxappid><![CDATA[wx8888888888888888]]></wxappid>
     * <re_openid><![CDATA[oxTWIuGaIt6gTKsQRLau2M0yL16E]]></re_openid>
     * <total_amount><![CDATA[1000]]></total_amount>
     * <send_listid><![CDATA[235785324578098]]></send_listid>
     * <sender_name><![CDATA[XX活动]]></sender_name>
     * <sender_header_media_id><![CDATA[1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0]]></sender_header_media_id>
     * </xml>
     * 返回参数:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS String(16) SUCCESS/FAIL 此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128) 返回信息，如非空，为错误原因
     * 以下字段在return_code为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 微信支付签名
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 商户订单号 mch_billno 是 1E+25 String(28) 商户订单号（每个订单号必须唯一）组成：mch_id+yyyymmdd+10位一天内不能重复的数字
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 公众账号appid wxappid 是 wx8888888888888888 String(32) 商户appid，接口传入的所有appid应该为公众号的appid（在mp.weixin.qq.com申请的），不能为APP的appid（在open.weixin.qq.com申请的）
     * 用户openid re_openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String(32) 接受收红包的用户在wxappid下的openid
     * 付款金额 total_amount 是 1000 int 付款金额，单位分
     * 微信单号 send_listid 是 1E+29 String(32) 红包订单的微信单号
     * 发送者名称 sender_name 是 XX活动 String(128) 红包发送者名称(需要utf-8格式)
     * 发送者头像 sender_header_media_id 是 1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0 String(128) 发送者头像素材id，通过企业微信开放上传素材接口获取
     * 错误码:
     *
     * 错误码 错误描述 原因 解决方式
     * NO_AUTH 发放失败，此请求可能存在风险，已被微信拦截 用户账号异常，被拦截 请提醒用户检查自身帐号是否异常。使用常用的活跃的微信号可避免这种情况。
     * SENDNUM_LIMIT 该用户今日领取红包个数超过限制 该用户今日领取红包个数超过你在微信支付商户平台配置的上限 如有需要、请在微信支付商户平台【api安全】中重新配置 【每日同一用户领取本商户红包不允许超过的个数】。
     * SENDAMOUNT_LIMIT 您的商户号今日发放金额超过限制，如有需要请登录微信支付商户平台更改API安全配置 商户今日发放的总金额超过您在微信支付商户平台配置的上限 如有需要，请联系管理员在商户平台上调整单日发送金额上限。
     * RCVDAMOUNT_LIMIT 该用户今日领取金额超过限制，如有需要请登录微信支付商户平台更改API安全配置 该用户今日领取红包总金额超过您在微信支付商户平台配置的上限 如有需要，请联系管理员在商户平台上调整单用户单日领取金额上限。
     * ILLEGAL_APPID 非法appid，请确认是否为公众号的appid，不能为APP的appid 错误传入了app的appid 接口传入的所有appid应该为公众号的appid（在mp.weixin.qq.com申请的），不能为APP的appid（在open.weixin.qq.com申请的）。
     * MONEY_LIMIT 红包金额发放限制 发送红包金额不在限制范围内 每个红包金额必须在默认额度内（默认大于1元，小于200元，可在产品设置中自行申请调高额度）
     * SEND_FAILED 红包发放失败,请更换单号再重试 该红包已经发放失败 如果需要重新发放，请更换单号再发放
     * FATAL_ERROR openid和原始单参数不一致 更换了openid，但商户单号未更新 请商户检查代码实现逻辑
     * CA_ERROR CA证书出错，请登录微信支付商户平台下载证书 请求携带的证书出错 到商户平台下载证书，请求带上证书后重试
     * SIGN_ERROR 签名错误；企业微信签名失败 1. 没有使用商户平台设置的商户API密钥进行加密（有可能之前设置过密钥，后来被修改了，没有使用新的密钥进行加密）。
     * 2. 加密前没有按照文档进行参数排序（可参考文档）。
     * 3. 把值为空的参数也进行了签名。可到（http://mch.weixin.qq.com/wiki/tools/signverify/ ）验证。
     * 4. 如果以上3步都没有问题，把请求串中(post的数据）里面中文都去掉，换成英文，试下，看看是否是编码问题。（post的数据要求是utf8）
     * 5. 没有按照企业微信签名算法进行签名 1. 到商户平台重新设置新的密钥后重试；
     * 2. 检查请求参数把空格去掉重试；
     * 3. 中文不需要进行encode，使用CDATA；
     * 4. 按文档要求生成签名后再重试；
     * 5. 检查企业微信支付应用secret是否和企业微信管理端支付应用的secret保持一致；检查参与企业微信签名的字段是否和签名算法里面的字段保持一直。
     * SYSTEMERROR 请求已受理，请稍后使用原单号查询发放结果 系统无返回明确发放结果 使用原单号调用接口，查询发放结果，如果使用新单号调用接口，视为新发放请求
     * XML_ERROR 输入xml参数格式错误 请求的xml格式错误，或者post的数据为空 检查请求串，确认无误后重试
     * FREQ_LIMIT 超过频率限制,请稍后再试 受频率限制 请对请求做频率控制（可联系微信支付wxhongbao@tencent.com申请调高）
     * NOTENOUGH 帐号余额不足，请到商户平台充值后再重试 账户余额不足 充值后重试
     * OPENID_ERROR openid和appid不匹配 openid和appid不匹配 发红包的openid必须是本appid下的openid
     * PROCESSING 请求已受理，请稍后使用原单号查询发放结果 发红包流程正在处理 二十分钟后查询,按照查询结果成功失败进行处理
     * PARAM_ERROR 请求参数错误 请求携带的字段非法（或者没填） 请检查字段后重试;如果是重试请求，请与原单请求的金额保持一致。
     * NO_COMPETENCE 商户号错误 该商户号没有开通企业支付 该商户号没有开通企业支付，请登录企业微信管理端，进入企业支付应用核对商户号是否正确
     * API_METHOD_CLOSED 您的商户号API发放方式已关闭，请联系管理员在商户平台开启。 商户API发放方式处于关闭状态 请联系管理员在微信支付商户平台开启。
     */
    public function sendworkwxredpack($nonce_str, $mch_billno, $sender_name, $agentid, $sender_header_media_id, $re_openid, $total_amount, $wishing, $act_name, $remark, $scene_id)
    {
        $postData = array();
        $postData["nonce_str"] = $nonce_str;
        $postData["mch_billno"] = $mch_billno;
        $postData["mch_id"] = $this->getMchid();
        $postData["wxappid"] = $this->getAppId();
        if (!empty($sender_name)) {
            $postData["sender_name"] = $sender_name;
        }
        if (!empty($agentid)) {
            $postData["agentid"] = $agentid;
        }
        $postData["sender_header_media_id"] = $sender_header_media_id;
        $postData["re_openid"] = $re_openid;
        $postData["total_amount"] = $total_amount;
        $postData["wishing"] = $wishing;
        $postData["act_name"] = $act_name;
        $postData["remark"] = $remark;
        $postData["scene_id"] = $scene_id;

        // 企业微信签名
        $workwx_sign = $this->getWorkwxSign($postData, 1);
        $postData["workwx_sign"] = $workwx_sign;

        // 微信支付签名
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;

        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/sendworkwxredpack', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 查询红包记录
     * API接口协议
     * 注意事项：
     *
     * 查询红包记录API只支持查询30天内的红包订单，30天之前的红包订单请登录商户平台查询。
     * 如果查询单号对应的数据不存在，那么数据不存在的原因可能是：（1）发放请求还在处理中；（2）红包发放处理失败导致红包订单没有落地。在上述情况下，商户首先需要检查该商户订单号是否确实是自己发起的，如果商户确认是自己发起的，则请商户不要直接当做红包发放失败处理，请商户隔几分钟再尝试查询，或者商户可以通过相同的商户订单号再次发起发放请求。如果商户误把还在发放中的订单直接当发放失败处理，商户应当自行承担因此产生的所有损失和责任。
     * XML具有可扩展性，因此返回参数可能会有新增，而且顺序可能不完全遵循此文档规范，如果在解析回包的时候发生错误，请商户务必不要换单重试，请商户联系客服确认红包发放情况。如果有新回包字段，会更新到此API文档中。
     * 因为错误代码字段err_code的值后续可能会增加，所以商户如果遇到回包返回新的错误码，请商户务必不要换单重试，请商户联系客服确认红包发放情况。如果有新的错误码，会更新到此API文档中。
     * 错误代码描述字段err_code_des只供人工定位问题时做参考，系统实现时请不要依赖这个字段来做自动化处理。
     * 请求地址：https://api.mch.weixin.qq.com/mmpaymkttransfers/queryworkwxredpack
     * 是否需要证书 : 是
     * 请求方式：POST
     * 数据格式：xml
     *
     * 请求示例：
     *
     * <xml>
     * <nonce_str>5K8264ILTKCH16CQ2502SI8ZNMTM67VS</nonce_str>
     * <sign>C380BEC2BFD727A4B6845133519F3AD6</sign>
     * <mch_billno>123456</mch_billno>
     * <mch_id>10000098</mch_id>
     * <appid>wx8888888888888888</appid>
     * </xml>
     * 参数说明：
     *
     * 字段名 字段 必填 示例值 类型
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32)
     * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32)
     * 商户订单号 mch_billno 是 123456 String(28)
     * 商户号 mch_id 是 10000098 String(32)
     * Appid appid 是 wxe062425f740d30d8 String(32)
     * 返回结果 ：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[ok]]></return_msg>
     * <sign><![CDATA[C380BEC2BFD727A4B6845133519F3AD6]]></sign>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <mch_billno><![CDATA[123456]]></mch_billno>
     * <mch_id><![CDATA[10000098]]></mch_id>
     * <detail_id><![CDATA[43235678654322356]]></detail_id>
     * <status><![CDATA[RECEIVED]]></status>
     * <send_type><![CDATA[API]]></send_type>
     * <total_amount><![CDATA[5000]]></total_amount>
     * <reason><![CDATA[余额不足]]></reason>
     * <send_time><![CDATA[2017-07-20 22：45：12]]></send_time>
     * <wishing><![CDATA[新年快乐]]></wishing>
     * <remark><![CDATA[新年红包]]></remark>
     * <act_name><![CDATA[新年红包]]></act_name>
     * <openid><![CDATA[ohO4GtzOAAYMp2yapORH3dQB3W18]]></openid>
     * <amount><![CDATA[100]]></amount>
     * <rcv_time><![CDATA[2017-07-20 22：46：59]]></rcv_time>
     * <sender_name><![CDATA[XX活动]]></sender_name>
     * <sender_header_media_id><![CDATA[1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0]]></sender_header_media_id>
     * </xml>
     * 返回参数:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS String(16) SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128) 返回信息，如非空，为错误原因
     * 以下字段在return_code为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 微信支付签名
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 商户订单号 mch_billno 是 1E+25 String(28) 商户使用查询API填写的商户单号的原路返回
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 红包单号 detail_id 是 1E+27 String(32) 使用API发放现金红包时返回的红包单号
     * 红包状态 status 是 RECEIVED string(16) SENDING:发放 SENT:已发放待领取 FAILED：发放失败 RECEIVED:已领取 RFUND_ING:退款中 REFUND:已退款
     * 发放类型 send_type 是 API String(32) API:通过API接口发放
     * 红包金额 total_amount 是 5000 int 红包总金额（单位分）
     * 失败原因 reason 否 余额不足 String(32) 发送失败原因
     * 红包发送时间 send_time 是 ######## String(32)
     * 红包退款时间 refund_time 否 ######## String(32) 红包的退款时间（如果其未领取的退款）
     * 红包退款金额 refund_amount 否 8000 Int 红包退款金额
     * 祝福语 wishing 否 新年快乐 String(128) 祝福语
     * 活动描述 remark 否 新年红包 String(256) 活动描述，低版本微信可见
     * 活动名称 act_name 否 新年红包 String(32) 发红包的活动名称
     * 领取红包的Openid openid 是 ohO4GtzOAAYMp2yapORH3dQB3W18 String(32) 领取红包的openid
     * 金额 amount 是 100 int 领取金额
     * 接收时间 rcv_time 是 ######## String(32) 领取红包的时间
     * 发送者名称 sender_name 是 XX活动 String(128) 发送者名称
     * 发送者头像 sender_header_media_id 否 1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0 String(128) 发送者头像素材，通过企业微信开放接口上传获取
     * 错误码:
     *
     * 错误码 错误描述 解决方式
     * CA_ERROR 请求未携带证书，或请求携带的证书出错 到商户平台下载证书，请求带上证书后重试。
     * SIGN_ERROR 微信支付签名错误 按文档要求重新生成签名后再重试。
     * NO_AUTH 没有权限 请联系微信支付开通api权限
     * NOT_FOUND 指定单号数据不存在 查询单号对应的数据不存在，请使用正确的商户订单号查询
     * FREQ_LIMIT 受频率限制 请对请求做频率控制
     * XML_ERROR 请求的xml格式错误，或者post的数据为空 检查请求串，确认无误后重试
     * PARAM_ERROR 参数错误 请查看err_code_des，修改设置错误的参数
     * PSYSTEMERROR 系统繁忙，请再试 红包系统繁忙
     */
    public function queryWorkwxRedpack($nonce_str, $mch_billno)
    {
        $postData = array();
        $postData["nonce_str"] = $nonce_str;
        $postData["mch_billno"] = $mch_billno;
        $postData["mch_id"] = $this->getMchid();
        $postData["appid"] = $this->getAppId();
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/queryworkwxredpack', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 向员工付款
     * API接口协议
     * 接口调用规则：
     *
     * 给同一个实名用户付款，单笔单日限额5000/5000
     * 不支持给非实名用户打款
     * 一个商户同一日付款总额限额10W
     * 单笔最小金额默认为1元
     * 每个用户每天最多可付款10次，可以在商户平台—API安全进行设置
     * 给同一个用户付款时间间隔不得低于15秒
     * 请求示例：
     *
     * <xml>
     * <appid>wxe062425f740c8888</appid>
     * <mch_id>1900000109</mch_id>
     * <device_info>013467007045764</device_info>
     * <nonce_str>3PG2J4ILTKCH16CQ2502SI8ZNMTM67VS</nonce_str>
     * <sign>C97BDBACF37622775366F38B629F45E3</sign>
     * <partner_trade_no>100000982017072019616</partner_trade_no>
     * <openid>ohO4Gt7wVPxIT1A9GjFaMYMiZY1s</openid>
     * <check_name>NO_CHECK</check_name>
     * <re_user_name>张三</re_user_name>
     * <amount>100</amount>
     * <desc>六月出差报销费用</desc>
     * <spbill_create_ip>10.2.3.10</spbill_create_ip>
     * <workwx_sign>99BCDAFF065A4B95628E3DB468A874A8</workwx_sign>
     * <ww_msg_type>NORMAL_MSG</ww_msg_type>
     * <act_name>示例项目</act_name>
     * </xml>
     * 请求方式：POST（HTTPS）
     * 请求地址：https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/paywwsptrans2pocket
     * 是否需要证书：请求需要双向证书。
     * 请求方式：POST
     * 数据格式：xml
     *
     * 证书使用详见：https://pay.weixin.qq.com/wiki/doc/api/tools/mch_pay.php?chapter=4_3
     *
     * 参数说明：
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 公众账号appid appid 是 wx8888888888888888 String(128) 微信分配的公众账号ID（企业微信corpid即为此appid）
     * 商户号 mch_id 是 1900000109 String(32) 微信支付分配的商户号
     * 设备号 device_info 否 013467007045764 String(32) 微信支付分配的终端设备号
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 参见“签名算法”
     * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(32) 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
     * 用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String(64) 商户appid下，某用户的openid。获取用户openid参见：http://work.weixin.qq.com/api/doc#11279
     * 校验用户姓名选项 check_name 是 FORCE_CHECK String(16) NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
     * 收款用户姓名 re_user_name 否 马花花 String(64) 收款用户真实姓名。 如果check_name设置为FORCE_CHECK，则必填用户真实姓名
     * 金额 amount 是 10099 int 企业微信企业付款金额，单位为分
     * 付款说明 desc 是 六月出差报销费用 String(81) 向员工付款说明信息。必填
     * Ip地址 spbill_create_ip 是 192.168.0.1 String(32) 调用接口的机器Ip地址
     * 企业微信签名 workwx_sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(128) 参见“签名算法”
     * 付款消息类型 ww_msg_type 是 NORMAL_MSG String NORMAL_MSG：普通付款消息 APPROVAL _MSG：审批付款消息
     * 审批单号 approval_number 否 201705160008 String ww_msg_type为APPROVAL _MSG时，需要填写approval_number
     * 审批类型 approval_type 否 1 int ww_msg_type为APPROVAL _MSG时，需要填写1
     * 项目名称 act_name 是 产品部门报销 String 项目名称，最长50个utf8字符
     * 付款的应用id agentid 否 1 unsigned int 以企业应用的名义付款，企业应用id，整型，可在企业微信管理端应用的设置页面查看。
     * 返回结果 ：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[ok]]></return_msg>
     * <appid><![CDATA[wxec38b8ff840b8888]]></appid>
     * <mch_id><![CDATA[1900000109]]></mch_id>
     * <device_info><![CDATA[013467007045764]]></device_info>
     * <nonce_str><![CDATA[lxuDzMnRjpcXzxLx0q]]></nonce_str>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <partner_trade_no><![CDATA[100000982017072019616]]></partner_trade_no>
     * <payment_no><![CDATA[1000018301201505190181489473]]></payment_no>
     * <payment_time><![CDATA[2017-07-20 22：05：59]]></payment_time>
     * </xml>
     * 返回参数:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS String(16) SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128) 返回信息，如非空，为错误原因
     * 以下字段在return_code为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 商户appid appid 是 wx8888888888888888 String(128) 微信分配的公众账号ID（企业微信corpid即为此appid）
     * 商户号 mch_id 是 1900000109 String(32) 微信支付分配的商户号
     * 设备号 device_info 否 013467007045764 String(32) 终端设备号
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL，注意：当状态为FAIL时，存在业务结果未明确的情况，所以如果状态为FAIL，请务必再请求一次查询接口，通过查询接口确认此次付款结果。如果要重试，请使用原商户订单号+原参数重试，避免重复付款。
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 商户订单号 partner_trade_no 是 1217752501201407033233368018 String(32) 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
     * 微信订单号 payment_no 是 1007752501201407033233368018 String(64) 企业微信企业付款成功，返回的微信订单号
     * 微信支付成功时间 payment_time 是 2017-07-19 15：26：59 String(32) 企业微信企业付款成功时间
     * 错误码:
     *
     * 错误码 错误描述 原因 解决方式
     * NOAUTH 没有权限 没有授权请求此api 请联系微信支付开通api权限
     * AMOUNT_LIMIT 付款金额不能小于最低限额 付款金额不能小于最低限额 每次付款金额必须大于1元
     * PARAM_ERROR 参数错误 参数缺失，或参数格式出错，参数不合法等 请查看err_code_des，修改设置错误的参数
     * OPENID_ERROR Openid错误 Openid格式错误或者不属于商家公众账号 请核对商户自身公众号appid和用户在此公众号下的openid
     * NOTENOUGH 余额不足 帐号余额不足 请用户充值后再支付
     * SYSTEMERROR 系统繁忙，请稍后再试 系统错误，请重试 使用原单号以及原请求参数重试
     * NAME_MISMATCH 姓名校验出错 请求参数里填写了需要检验姓名，但是输入了错误的姓名 填写正确的用户姓名
     * SIGN_ERROR 微信支付签名错误 没有按照文档要求进行签名 1.签名前没有按照要求进行排序。
     * 2.没有使用商户平台设置的密钥进行签名
     * 3.参数有空格或者进行了encode后进行签名。
     * XML_ERROR Post内容出错 Post请求数据不是合法的xml格式内容 修改post的内容
     * HTTP_METHOD_ERROR 发送请求方式错误 发送请求方式错误 改为使用http post的方式来请求
     * FATAL_ERROR 两次请求参数不一致 两次请求商户单号一样，但是参数不一致 如果想重试前一次的请求，请用原参数重试，如果重新发送，请更换单号
     * CA_ERROR 证书出错 请求没带证书或者带上了错误的证书 1.到商户平台下载证书
     * 2.请求的时候带上该证书
     * 3.请通过查询接口确认此次付款结果；如果要重试，请使用原商户订单号+原参数重试，避免重复付款。
     * V2_ACCOUNT_SIMPLE_BAN 无法给非实名用户付款 用户微信支付账户未知名，无法付款 引导用户在微信支付内进行绑卡实名
     * WORKWX_MCHID_ERROR 企业微信商户号和企业关系校验失败 企业微信商户号和企业关系校验失败 确认是否已经绑定商户号和企业微信的关系
     * WORKWX_SIGN_ERROR 企业微信签名错误 企业微信签名校验失败 按文档要求重新生成签名后再重试
     * SENDNUM_LIMIT 用户今日付款次数超过限制 用户今日付款次数超过限制 登录微信支付商户平台更改API安全配置，如果要继续付款必须使用原商户订单号重试。
     */
    public function paywwsptrans2pocket($openid, $partner_trade_no, $nonce_str, $check_name, $amount, $desc, $act_name, $ww_msg_type, $spbill_create_ip, $device_info = "", $re_user_name = "", $approval_number = "", $approval_type = "", $agentid = 0)
    {
        $postData = array();
        /**
         * 公众账号appid appid 是 wx8888888888888888 String(128) 微信分配的公众账号ID（企业微信corpid即为此appid）
         */
        $postData["appid"] = $this->getAppId();
        /**
         * 商户号 mch_id 是 1900000109 String(32) 微信支付分配的商户号
         */
        $postData["mch_id"] = $this->getMchid();
        /**
         * 设备号 device_info 否 013467007045764 String(32) 微信支付分配的终端设备号
         */
        $postData["device_info"] = $device_info;
        /**
         * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
         */
        $postData["nonce_str"] = $nonce_str;
        /**
         * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(32) 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有符号)
         */
        $postData["partner_trade_no"] = $partner_trade_no;
        /**
         * 用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String(64) 商户appid下，某用户的openid。获取用户openid参见：http://work.weixin.qq.com/api/doc#11279
         */
        $postData["openid"] = $openid;
        /**
         * 校验用户姓名选项 check_name 是 FORCE_CHECK String(16) NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
         */
        $postData["check_name"] = $check_name;
        /**
         * 收款用户姓名 re_user_name 否 马花花 String(64) 收款用户真实姓名。 如果check_name设置为FORCE_CHECK，则必填用户真实姓名
         */
        $postData["re_user_name"] = $re_user_name;
        /**
         * 金额 amount 是 10099 int 企业微信企业付款金额，单位为分
         */
        $postData["amount"] = $amount;
        /**
         * 付款说明 desc 是 六月出差报销费用 String(81) 向员工付款说明信息。必填
         */
        $postData["desc"] = $desc;
        /**
         * Ip地址 spbill_create_ip 是 192.168.0.1 String(32) 调用接口的机器Ip地址
         */
        $postData["spbill_create_ip"] = $spbill_create_ip;
        /**
         * 付款消息类型 ww_msg_type 是 NORMAL_MSG String NORMAL_MSG：普通付款消息 APPROVAL _MSG：审批付款消息
         */
        $postData["ww_msg_type"] = $ww_msg_type;
        /**
         * 审批单号 approval_number 否 201705160008 String ww_msg_type为APPROVAL _MSG时，需要填写approval_number
         */
        $postData["approval_number"] = $approval_number;
        /**
         * 审批类型 approval_type 否 1 int ww_msg_type为APPROVAL _MSG时，需要填写1
         */
        $postData["approval_type"] = $approval_type;
        /**
         * 项目名称 act_name 是 产品部门报销 String 项目名称，最长50个utf8字符
         */
        $postData["act_name"] = $act_name;
        /**
         * 付款的应用id agentid 否 1 unsigned int 以企业应用的名义付款，企业应用id，整型，可在企业微信管理端应用的设置页面查看
         */
        if (!empty($agentid)) {
            $postData["agentid"] = $agentid;
        }

        /**
         * 企业微信签名 workwx_sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(128) 参见“签名算法”
         */
        $workwx_sign = $this->getWorkwxSign($postData, 2);
        $postData["workwx_sign"] = $workwx_sign;

        /**
         * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 参见“签名算法”
         */
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;

        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/promotion/paywwsptrans2pocket', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * 查询付款记录
     * API接口协议
     * 用于商户的企业微信企业付款操作进行结果查询，返回付款操作详细结果。
     * 查询企业微信企业付款API只支持查询30天内的订单，30天之前的订单请登录商户平台查询。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://api.mch.weixin.qq.com/mmpaymkttransfers/promotion/querywwsptrans2pocket
     * 是否需要证书：请求需要双向证书。 详见证书使用
     * 数据格式：xml
     *
     * 请求示例：
     *
     * <xml>
     * <sign><![CDATA[E1EE61A91C8E90F299DE6AE075D60A2D]]></sign>
     * <partner_trade_no><![CDATA[0010010404201411170000046545]]></partner_trade_no>
     * <mch_id ><![CDATA[10000097]]></mch_id >
     * <appid><![CDATA[wxe062425f740c8888]]></appid>
     * <nonce_str><![CDATA[50780e0cca98c8c8e814883e5caa672e]]></nonce_str>
     * </xml>
     * 参数说明：
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
     * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 参见“签名算法”
     * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(28) 商户调用企业微信企业付款API时使用的商户订单号
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * Appid appid 是 wxe062425f740d30d8 String(128) 商户号的appid
     * 返回结果 ：
     *
     * <xml>
     * <return_code><![CDATA[SUCCESS]]></return_code>
     * <return_msg><![CDATA[获取成功]]></return_msg>
     * <result_code><![CDATA[SUCCESS]]></result_code>
     * <mch_id>10000098</mch_id>
     * <appid><![CDATA[wxe062425f740c30d8]]></appid>
     * <detail_id><![CDATA[1000000000201503283103439304]]></detail_id>
     * <partner_trade_no><![CDATA[0010010404201411170000046545]]></partner_trade_no>
     * <status><![CDATA[SUCCESS]]></status>
     * <payment_amount>100</payment_amount >
     * <openid ><![CDATA[oxTWIuGaIt6gTKsQRLau2M0yL16E]]></openid>
     * <transfer_time><![CDATA[2017-07-22 20:10:15]]></transfer_time>
     * <transfer_name ><![CDATA[测试]]></transfer_name >
     * <desc><![CDATA[付款测试]]></desc>
     * </xml>
     * 返回参数:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 返回状态码 return_code 是 SUCCESS String(16) SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查看result_code来判断
     * 返回信息 return_msg 否 签名失败 String(128) 返回信息，如非空，为错误原因
     * 以下字段在return_code为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 业务结果 result_code 是 SUCCESS String(16) SUCCESS/FAIL
     * 错误代码 err_code 否 SYSTEMERROR String(32) 错误码信息
     * 错误代码描述 err_code_des 否 系统错误 String(128) 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回:
     *
     * 字段名 字段 必填 示例值 类型 说明
     * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(32) 商户使用查询API填写的单号的原路返回
     * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
     * 付款单号 detail_id 是 1000000000201503283103439304 String(64) 调用企业微信企业付款API时，微信系统内部产生的单号
     * 转账状态 status 是 SUCCESS string(16) SUCCESS:转账成功 FAILED:转账失败 PROCESSING:处理中
     * 失败原因 reason 否 余额不足 String(128) 如果失败则有失败原因
     * 收款用户openid openid 是 oxTWIuGaIt6gTKsQRLau2M0yL16E String(64) 转账的openid
     * 收款用户姓名 transfer_name 否 马华 String(64) 收款用户姓名
     * 付款金额 payment_amount 是 5000 int 付款金额单位分
     * 转账时间 transfer_time 是 2015-04-21 20:00:00 String(32) 发起转账的时间
     * 付款描述 desc 是 用车补贴 String(100) 付款时候的描述
     * 错误码:
     *
     * 错误码 错误描述 解决方式
     * CA_ERROR 请求未携带证书，或请求携带的证书出错 到商户平台下载证书，请求带上证书后重试
     * SIGN_ERROR 微信支付签名错误 按文档要求重新生成签名后再重试
     * NO_AUTH 没有权限 请联系微信支付开通api权限
     * FREQ_LIMIT 受频率限制 请对请求做频率控制
     * XML_ERROR 请求的xml格式错误，或者post的数据为空 检查请求串，确认无误后重试
     * PARAM_ERROR 参数错误 请查看err_code_des，修改设置错误的参数
     * SYSTEMERROR 系统繁忙，请再试 系统繁忙
     * NOT_FOUND 指定单号数据不存在 查询单号对应的数据不存在，请使用正确的商户订单号查询
     * WORKWX_MCHID_ERROR 企业微信商户号和企业关系校验失败 确认是否已经绑定商户号和企业微信的关系
     * WORKWX_SIGN_ERROR 企业微信签名错误 按文档要求重新生成签名后再重试
     */
    public function querywwsptrans2pocket($nonce_str, $partner_trade_no)
    {
        $postData = array();
        /**
         * 随机字符串 nonce_str 是 5K8264ILTKCH16CQ2502SI8ZNMTM67VS String(32) 随机字符串，不长于32位
         */
        $postData["nonce_str"] = $nonce_str;
        /**
         * 商户订单号 partner_trade_no 是 10000098201411111234567890 String(28) 商户调用企业微信企业付款API时使用的商户订单号
         */
        $postData["partner_trade_no"] = $partner_trade_no;
        /**
         * 商户号 mch_id 是 10000098 String(32) 微信支付分配的商户号
         */
        $postData["mch_id"] = $this->getMchid();
        /**
         * Appid appid 是 wxe062425f740d30d8 String(128) 商户号的appid
         */
        $postData["appid"] = $this->getAppId();

        /**
         * 微信支付签名 sign 是 C380BEC2BFD727A4B6845133519F3AD6 String(32) 参见“签名算法”
         */
        $sign = $this->getSign($postData);
        $postData["sign"] = $sign;
        $xml = Helpers::arrayToXml($postData);
        $options = array();
        $options['cert'] = $this->getCert();
        $options['ssl_key'] = $this->getCertKey();
        $rst = $this->post($this->_url . 'mmpaymkttransfers/promotion/querywwsptrans2pocket', $xml, $options);
        return $this->returnResult($rst);
    }

    /**
     * Sign签名生成方法
     *
     * @param array $para            
     * @throws Exception
     * @return string
     */
    public function getSign(array $para)
    {
        /**
         * a.除sign 字段外，对所有传入参数按照字段名的ASCII 码从小到大排序（字典序）后，
         * 使用URL 键值对的格式（即key1=value1&key2=value2…）拼接成字符串string1，
         * 注意： 值为空的参数不参与签名 ；
         */
        // 过滤不参与签名的参数
        $paraFilter = Helpers::paraFilter($para);
        // 对数组进行（字典序）排序
        $paraFilter = Helpers::argSort($paraFilter);
        // 进行URL键值对的格式拼接成字符串string1
        $string1 = Helpers::createLinkstring($paraFilter);
        /**
         * b.
         * 在string1 最后拼接上key=Key(商户支付密钥 ) 得到stringSignTemp 字符串，
         * 并对stringSignTemp 进行md5 运算，再将得到的字符串所有字符转换为大写，得到sign 值signValue。
         */
        $sign = $string1 . '&key=' . $this->getKey();
        $sign = strtoupper(md5($sign));

        return $sign;
    }

    public function getWorkwxSign(array $params, $sign_type = 1)
    {
        // 企业微信签名算法
        // 第一步: 设所有发送或者接收到的数据为集合M，将集合M内非空参数值的参数按照参数名ASCII码从小到大排序（字典序），使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串stringA。

        // 注意:

        // 参数名ASCII码从小到大排序（字典序）
        // 如果参数的值为空不参与签名
        // 参数名区分大小写
        // 传送的sign参数不参与签名，将生成的签名与该sign值作校验
        // 第二步: 在stringA最后拼接上企业微信支付应用secret（参见企业微信管理端支付应用页面的secret），得到stringSignTemp字符串，并对stringSignTemp进行MD5运算，再将得到的字符串所有字符转换为大写，得到sign值signValue。

        // 企业微信签名字段说明：
        // 发红包api固定如下几个字段参与签名：
        // act_name
        // mch_billno
        // mch_id
        // nonce_str
        // re_openid
        // total_amount
        // wxappid

        // 付款api固定如下几个字段参与签名：
        // amount
        // appid
        // desc
        // mch_id
        // nonce_str
        // openid
        // partner_trade_no
        // ww_msg_type

        // 示例:请求内容:
        // act_name XXX
        // mch_billno 11111234567890
        // mch_id 10000098
        // nonce_str qFKEgfig76DF9912fewmkp
        // re_openid oxTWIuGaIt6gTKsQRLau2M0yL16E
        // total_amount 100
        // wxappid wx123456789

        // 第一步: 对参数按照key=value的格式，并按照参数名ASCII字典序排序如下
        // stringA=”act_name=XXX&mch_billno=11111234567890&mch_id=10000098&nonce_str=qFKEgfig76DF9912fewmkp&re_openid=oxTWIuGaIt6gTKsQRLau2M0yL16E&total_amount=100&wxappid=wx123456789
        // 第二步：拼接企业微信支付应用secret（参见企业微信管理端支付应用页面）：
        // stringSignTemp=”stringA&secret=192006250b4c09247ec02edce69f6a2d”
        // sign=MD5(stringSignTemp).toUpperCase()
        $para = array();
        $params4Sign = array();
        if ($sign_type == 1) {
            // 发红包api固定如下几个字段参与签名
            $params4Sign = array(
                'act_name',
                'mch_billno',
                'mch_id',
                'nonce_str',
                're_openid',
                'total_amount',
                'wxappid'
            );
        } elseif ($sign_type == 2) {
            // 付款api固定如下几个字段参与签名：
            $params4Sign = array(
                'amount',
                'appid',
                'desc',
                'mch_id',
                'nonce_str',
                'openid',
                'partner_trade_no',
                'ww_msg_type'
            );
        }
        foreach ($params4Sign as $field) {
            if (isset($params[$field])) {
                $para[$field] = $params[$field];
            }
        }
        // 过滤不参与签名的参数
        $paraFilter = Helpers::paraFilter($para);
        // 对数组进行（字典序）排序
        $paraFilter = Helpers::argSort($paraFilter);
        // 进行URL键值对的格式拼接成字符串string1
        $string1 = Helpers::createLinkstring($paraFilter);
        $sign = $string1 . '&secret=' . $this->getAppSecret();
        $sign = strtoupper(md5($sign));

        return $sign;
    }

    /**
     * 通用通知接口
     * 通知参数： 通知参数： 字段名 变量名 必填 类型 说明
     * 返回状态码return_code是String(16)SUCCESS/FAIL此字段是通信标识，非交易标识，交易是否成功需要查微信公众号支付接口文档看result_code来判断
     * 返回信息return_msg否String(128)返回信息，如非空，为错误原因签名失败参数格式校验错误
     * 以下字段在return_code为SUCCESS的时候有返回
     * 公众账号ID appid是String(32)微信分配的公众账号ID
     * 商户号mch_id是String(32)微信支付分配的商户号
     * 设备号device_info否String(32)微信支付分配的终端设备号，
     * 随机字符串nonce_str是String(32)随机字符串，不长于32位
     * 签名sign是String(32)签名,详细签名方法见3.2节
     * 业务结果result_code是String(16)SUCCESS/FAIL
     * 错误代码err_code否String(32)错误码见第6节
     * 错误代码描述err_code_des否String(128)
     * 结果信息描述
     * 以下字段在return_code 和result_code都为SUCCESS的时候有返回
     * 用户标识openid是String(128)用户在商户appid下的唯一标识
     * 是否关注公众账号is_subscribe是String(1)用户是否关注公众账号，Y-关注，N-未关注，仅在公众账号类型支付有效
     * 交易类型trade_type是String(16)JSAPI、NATIVE、MICROPAY、APP
     * 付款银行bank_type是String(16)银行类型，采用字符串类型的银行标识
     * 总金额total_fee是Int订单总金额，单位为分
     * 现金券金额coupon_fee否Int现金券支付金额<=订单总金额，订单总金额-现金券金额为现金支付金额
     * 货币种类fee_type否String(8)货币类型，符合ISO 4217标准的三位字母代码，默认人民币：CNY
     * 微信支付订单号transaction_id是String(32)微信支付订单号
     * 商户订单号out_trade_no是String(32)商户系统的订单号，与请求一致。
     * 商家数据包attach否String(128)商家数据包，原样返回
     * 支付完成时间time_end是String(14)支付完成时间，格式为yyyyMMddhhmmss，如2009年12月27日9点10分10秒表示为20091227091010。时区为GMT+8beijing。该时间取自微信支付服务器
     * 商户处理后同步返回给微信参数：微信公众号支付接口文档
     * 字段名 变量名 必填 类型 说明
     * 返回状态码return_code是String(16)SUCCESS/FAILSUCCESS表示商户接收通知成功并校验成功
     * 返回信息return_msg否String(128)返回信息，如非空，为错误原因签名失败参数格式校验错误
     */
    public function getNotifyData($xml)
    {
        return Helpers::xmlToArray($xml);
    }

    public function returnResult($rst)
    {
        $api_response_xml = $rst;
        $rst = Helpers::xmlToArray($rst);
        if (!empty($rst['return_code'])) {
            if ($rst['return_code'] == 'FAIL') {
                throw new \Exception($rst['return_msg']);
            } else {
                if ($rst['result_code'] == 'FAIL') {
                    throw new \Exception($rst['err_code'] . ":" . $rst['err_code_des']);
                } else {
                    $rst['api_response_xml'] = $api_response_xml;
                    return $rst;
                }
            }
        } else {
            throw new \Exception("网络请求失败");
        }
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @param array $options            
     * @return mixed
     */
    public function get($url, $params = array(), $options = array())
    {
        $rst = $this->getRequest()->get($url, $params, $options);
        return $rst;
    }

    /**
     * 推送消息给到微信服务器
     *
     * @param string $url            
     * @param string $xml            
     * @param array $options            
     * @return mixed
     */
    public function post($url, $xml, $options = array())
    {
        $rst = $this->getRequest()->post($url, array(), $options, $xml);
        return $rst;
    }

    protected $_request = null;

    /**
     * 初始化认证的http请求对象
     */
    protected function initRequest()
    {
        $this->_request = new Request($this->getAccessToken(), false);
    }

    /**
     * 获取请求对象
     *
     * @return \Weixin\Http\Request
     */
    protected function getRequest()
    {
        if (empty($this->_request)) {
            $this->initRequest();
        }
        return $this->_request;
    }
}
