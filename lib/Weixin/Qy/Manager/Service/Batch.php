<?php

/**
 * 批处理对象控制器
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Qy\Manager\Service;

use Weixin\Qy\Service;

class Batch
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/service/batch/';

    private $_service;

    private $_request;

    public function __construct(Service $service)
    {
        $this->_service = $service;
        $this->_request = $service->getRequest();
    }

    /**
     * 获取异步任务结果
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/batch/getresult?provider_access_token=ACCESS_TOKEN&jobid=JOBID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * provider_access_token 是 服务商provider_access_token，获取方法参见服务商的凭证
     * jobid 是 异步任务id，最大长度为64字节
     * 权限说明：
     *
     * 只能查询已经提交过的历史任务。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "status": 1,
     * "type": "contact_id_translate",
     * "result": {
     * "contact_id_translate":{
     * "url":"xxxx"
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * status 任务状态，整型，1表示任务开始，2表示任务进行中，3表示任务已完成
     * type 操作类型，字节串，目前有：id_translate
     * result 详细的处理结果，具体格式参考下面说明。当任务完成后此字段有效
     * url 通讯录转换成功后的url,需要用户通过oauth2授权登录或者单点登录在用户侧打开
     * 注：返回的url参数，开发者在使用时以a标签引用，download属性不可指定（浏览器兼容性问题）
     */
    public function getResult($provider_access_token, $jobid)
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'getresult?provider_access_token=' . $provider_access_token . '&jobid=' . $jobid, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }
}
