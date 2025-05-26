<?php

namespace Weixin\Wx\Manager\Funds;

use Weixin\Client;

/**
 * 提款二维码接口
 * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/funds/qrcode/gen.html
 * 
 * @author guoyongrong
 *        
 */
class Qrcode
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/funds/qrcode/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 小程序支付管理服务 /提款二维码 /生成二维码
     * 生成二维码
     * 接口调用请求说明
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/funds/qrcode/gen?access_token=xxxxxxxxx
     *
     * 请求参数示例
     * {
     * "identity_type":1
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "qrcode_ticket":"xxxxx"
     * }
     *
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * identity_type number 是 需要验证的身份
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * qrcode_ticket string 二维码ticket,可用于获取二维码和检查扫码状态
     * 枚举值-identity_type
     * 枚举值 描述
     * 1 管理员
     * 返回码
     * 返回码 错误类型
     * -1 系统异常
     */
    public function gen($identity_type)
    {
        // identity_type number 是 需要验证的身份
        $params = array();
        $params['identity_type'] = $identity_type;
        $rst = $this->_request->post($this->_url . 'gen', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /提款二维码 /获取二维码
     * 获取二维码
     * 接口调用请求说明
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/funds/qrcode/get?access_token=xxxxxxxxx
     *
     * 请求参数示例
     * {
     * "qrcode_ticket":"05ba627d5b73b6f3ef0dcfc7"
     * }
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "qrcode_buf":"xxxxx"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * qrcode_ticket string 是 二维码ticket
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * qrcode_buf string 二维码(base64编码二进制,需要base64解码)
     * 返回码
     * 返回码 错误类型
     * -1 系统异常
     * -2 token太长
     * 60220 ticket已失效
     * 60208 错误的ticket
     */
    public function infoGet($qrcode_ticket)
    {
        // qrcode_ticket string 是 二维码ticket
        $params = array();
        $params['qrcode_ticket'] = $qrcode_ticket;
        $rst = $this->_request->post($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 小程序支付管理服务 /提款二维码 /查询扫码状态
     * 查询扫码状态
     * 接口调用请求说明
     * 接口强制校验来源IP
     *
     * http请求方式：POST
     * https://api.weixin.qq.com/shop/funds/qrcode/check?access_token=xxxxxxxxx
     * 请求参数示例
     * {
     * "qrcode_ticket":"05ba627d5b73b6f3ef0dcfc7"
     * }
     *
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "status":0,
     * "self_check_err_code":0,
     * "self_check_err_msg":"",
     * "scan_user_type":1
     * }
     *
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * qrcode_ticket string 是 二维码ticket
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * status number 扫码状态
     * self_check_err_code number 业务返回错误码
     * self_check_err_msg string 业务返回错误信息
     * scan_user_type number 扫码者身份
     * 枚举值-status
     * 枚举值 描述
     * 0 未扫码
     * 1 已确认
     * 2 已取消
     * 3 已失效
     * 4 已扫码
     * 枚举值-scan_user_type
     * 枚举值 描述
     * 0 非管理员
     * 1 管理员
     * 2 次管理员
     * 返回码
     * 返回码 错误类型
     * -1 系统异常
     */
    public function check($qrcode_ticket)
    {
        // qrcode_ticket string 是 二维码ticket
        $params = array();
        $params['qrcode_ticket'] = $qrcode_ticket;
        $rst = $this->_request->post($this->_url . 'check', $params);
        return $this->_client->rst($rst);
    }
}
