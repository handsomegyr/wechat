<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 批量接口
 * 异步批量接口说明
 * 异步批量接口用于大批量数据的处理，提交后接口即返回，企业微信会在后台继续执行任务。
 * 执行完成后，企业微信后台会通过任务事件通知企业获取结果。事件的内容是加密的，解密过程请参考 [消息的加解密处理][signure]，任务事件请参考异步任务完成事件推送。
 * 目前，仅为通讯录更新提供了异步批量接口
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Batch
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 增量更新成员
     * 调试工具
     * 本接口以userid（帐号）为主键，增量更新企业微信通讯录成员。请先下载CSV模板(下载增量更新成员模版)，根据需求填写文件内容。
     *
     * 注意事项：
     *
     * 模板中的部门需填写部门ID，多个部门用分号分隔，部门ID必须为数字，根部门的部门id默认为1
     * 文件中存在、通讯录中也存在的成员，更新成员在文件中指定的字段值
     * 文件中存在、通讯录中不存在的成员，执行添加操作
     * 通讯录中存在、文件中不存在的成员，保持不变
     * 成员字段更新规则：可自行添加扩展字段。文件中有指定的字段，以指定的字段值为准；文件中没指定的字段，不更新
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/batch/syncuser?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "media_id":"xxxxxx",
     * "to_invite": true,
     * "callback":
     * {
     * "url": "xxx",
     * "token": "xxx",
     * "encodingaeskey": "xxx"
     * }
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * media_id 是 上传的csv文件的media_id
     * to_invite 否 是否邀请新建的成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
     * callback 否 回调信息。如填写该项则任务完成后，通过callback推送事件给企业。具体请参考应用回调模式中的相应选项
     * url 否 企业应用接收企业微信推送请求的访问协议和地址，支持http或https协议
     * token 否 用于生成签名
     * encodingaeskey 否 用于消息体的加密，是AES密钥的Base64编码
     * 权限说明：
     * 须拥有通讯录的写权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "jobid": "xxxxx"
     * }
     * 参数说明 ：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * jobid 异步任务id，最大长度为64字节
     */
    public function syncUser($media_id, $to_invite = true, \Weixin\Qy\Model\Callback $callback = null)
    {
        $params = array();
        $params['media_id'] = $media_id;
        $params['to_invite'] = $to_invite;
        if (!empty($callback)) {
            $params['callback'] = $callback->getParams();
        }
        $rst = $this->_request->post($this->_url . 'syncuser', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 全量覆盖成员
     * 调试工具
     * 本接口以userid为主键，全量覆盖企业的通讯录成员，任务完成后企业的通讯录成员与提交的文件完全保持一致。请先下载CSV文件(下载全量覆盖成员模版)，根据需求填写文件内容。
     *
     * 注意事项：
     *
     * 模板中的部门需填写部门ID，多个部门用分号分隔，部门ID必须为数字，根部门的部门id默认为1
     * 文件中存在、通讯录中也存在的成员，完全以文件为准
     * 文件中存在、通讯录中不存在的成员，执行添加操作
     * 通讯录中存在、文件中不存在的成员，执行删除操作。出于安全考虑，下面两种情形系统将中止导入并返回相应的错误码。
     * 需要删除的成员多于50人，且多于现有人数的20%以上
     * 需要删除的成员少于50人，且多于现有人数的80%以上
     * 成员字段更新规则：可自行添加扩展字段。文件中有指定的字段，以指定的字段值为准；文件中没指定的字段，不更新
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/batch/replaceuser?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "media_id":"xxxxxx",
     * "to_invite": true,
     * "callback":
     * {
     * "url": "xxx",
     * "token": "xxx",
     * "encodingaeskey": "xxx"
     * }
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * media_id 是 上传的csv文件的media_id
     * to_invite 否 是否邀请新建的成员使用企业微信（将通过微信服务通知或短信或邮件下发邀请，每天自动下发一次，最多持续3个工作日），默认值为true。
     * callback 否 回调信息。如填写该项则任务完成后，通过callback推送事件给企业。具体请参考应用回调模式中的相应选项
     * url 否 企业应用接收企业微信推送请求的访问协议和地址，支持http或https协议
     * token 否 用于生成签名
     * encodingaeskey 否 用于消息体的加密，是AES密钥的Base64编码
     * 权限说明：
     * 须拥有通讯录的写权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "jobid": "xxxxx"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * jobid 异步任务id，最大长度为64字节
     */
    public function replaceUser($media_id, $to_invite = true, \Weixin\Qy\Model\Callback $callback = null)
    {
        $params = array();
        $params['media_id'] = $media_id;
        $params['to_invite'] = $to_invite;
        if (!empty($callback)) {
            $params['callback'] = $callback->getParams();
        }
        $rst = $this->_request->post($this->_url . 'replaceuser', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 全量覆盖部门
     * 调试工具
     * 本接口以partyid为键，全量覆盖企业的通讯录组织架构，任务完成后企业的通讯录组织架构与提交的文件完全保持一致。请先下载CSV文件(下载全量覆盖部门模版)，根据需求填写文件内容。
     *
     * 注意事项：
     *
     * 文件中存在、通讯录中也存在的部门，执行修改操作
     * 文件中存在、通讯录中不存在的部门，执行添加操作
     * 文件中不存在、通讯录中存在的部门，当部门下没有任何成员或子部门时，执行删除操作
     * 文件中不存在、通讯录中存在的部门，当部门下仍有成员或子部门时，暂时不会删除，当下次导入成员把人从部门移出后自动删除
     * CSV文件中，部门名称、部门ID、父部门ID为必填字段，部门ID必须为数字，根部门的部门id默认为1；排序为可选字段，置空或填0不修改排序, order值大的排序靠前。
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/batch/replaceparty?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "media_id":"xxxxxx",
     * "callback":
     * {
     * "url": "xxx",
     * "token": "xxx",
     * "encodingaeskey": "xxx"
     * }
     * }
     * 参数说明 ：
     *
     * 参数 必须 说明
     * media_id 是 上传的csv文件的media_id
     * callback 否 回调信息。如填写该项则任务完成后，通过callback推送事件给企业。具体请参考应用回调模式中的相应选项
     * url 否 企业应用接收企业微信推送请求的访问协议和地址，支持http或https协议
     * token 否 用于生成签名
     * encodingaeskey 否 用于消息体的加密，是AES密钥的Base64编码
     * 权限说明：
     * 须拥有通讯录的写权限。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "jobid": "xxxxx"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * jobid 异步任务id，最大长度为64字节
     */
    public function replaceParty($media_id, \Weixin\Qy\Model\Callback $callback = null)
    {
        $params = array();
        $params['media_id'] = $media_id;
        if (!empty($callback)) {
            $params['callback'] = $callback->getParams();
        }
        $rst = $this->_request->post($this->_url . 'replaceparty', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取异步任务结果
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/batch/getresult?access_token=ACCESS_TOKEN&jobid=JOBID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
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
     * "type": "replace_user",
     * "total": 3,
     * "percentage": 33,
     * "result": [{},{}]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * status 任务状态，整型，1表示任务开始，2表示任务进行中，3表示任务已完成
     * type 操作类型，字节串，目前分别有：1. sync_user(增量更新成员) 2. replace_user(全量覆盖成员)3. replace_party(全量覆盖部门)
     * total 任务运行总条数
     * percentage 目前运行百分比，当任务完成时为100
     * result 详细的处理结果，具体格式参考下面说明。当任务完成后此字段有效
     * result结构：type为sync_user、replace_user时：
     *
     * "result": [
     * {
     * "userid":"lisi",
     * "errcode":0,
     * "errmsg":"ok"
     * },
     * {
     * "userid":"zhangsan",
     * "errcode":0,
     * "errmsg":"ok"
     * }
     * ]
     * 参数 说明
     * userid 成员UserID。对应管理端的帐号
     * errcode 该成员对应操作的结果错误码
     * errmsg 错误信息，例如无权限错误，键值冲突，格式错误等
     * result结构：type为replace_party时：
     *
     * "result": [
     * {
     * "action":1,
     * "partyid":1,
     * "errcode":0,
     * "errmsg":"ok"
     * },
     * {
     * "action":4,
     * "partyid":2,
     * "errcode":0,
     * "errmsg":"ok"
     * }
     * ]
     * 参数 说明
     * action 操作类型（按位或）：1 新建部门 ，2 更改部门名称， 4 移动部门， 8 修改部门排序
     * partyid 部门ID
     * errcode 该部门对应操作的结果错误码
     * errmsg 错误信息，例如无权限错误，键值冲突，格式错误等
     */
    public function getResult($jobid)
    {
        $params = array();
        $params['jobid'] = $jobid;
        $rst = $this->_request->get($this->_url . 'getresult', $params);
        return $this->_client->rst($rst);
    }
}
