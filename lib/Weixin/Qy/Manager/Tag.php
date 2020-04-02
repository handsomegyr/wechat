<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 标签管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Tag
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/tag/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建标签
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/create?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "tagname": "UI",
     * "tagid": 12
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tagname 是 标签名称，长度限制为32个字以内（汉字或英文字母），标签名不可与其他标签重名。
     * tagid 否 标签id，非负整型，指定此参数时新增的标签会生成对应的标签id，不指定时则以目前最大的id自增。
     * 权限说明：
     *
     * 创建的标签属于该应用，只有该应用才可以增删成员。
     *
     * 注意，标签总数不能超过3000个。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "created"
     * "tagid": 12
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * tagid 标签id
     */
    public function create(\Weixin\Qy\Model\Tag $tag)
    {
        $params = $tag->getParams();
        $rst = $this->_request->post($this->_url . 'create', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新标签名字
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/update?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "tagid": 12,
     * "tagname": "UI design"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tagid 是 标签ID
     * tagname 是 标签名称，长度限制为32个字（汉字或英文字母），标签不可与其他标签重名。
     * 权限说明：
     *
     * 调用者必须是指定标签的创建者。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "updated"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function update(\Weixin\Qy\Model\Tag $tag)
    {
        $params = $tag->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除标签
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/delete?access_token=ACCESS_TOKEN&tagid=TAGID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tagid 是 标签ID
     * 权限说明：
     *
     * 调用者必须是指定标签的创建者。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "deleted"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function delete($tagid)
    {
        $params = array();
        $params['tagid'] = $tagid;
        $rst = $this->_request->get($this->_url . 'delete', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取标签成员
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/get?access_token=ACCESS_TOKEN&tagid=TAGID
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tagid 是 标签ID
     * 权限说明：
     *
     * 无限制，但返回列表仅包含应用可见范围的成员；第三方可获取自己创建的标签及应用可见范围内的标签详情
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "tagname": "乒乓球协会",
     * "userlist": [
     * {
     * "userid": "zhangsan",
     * "name": "李四"
     * }
     * ],
     * "partylist": [2]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * tagname 标签名
     * userlist 标签中包含的成员列表
     * userid 成员帐号
     * name 成员名称，此字段从2019年12月30日起，对新创建第三方应用不再返回，2020年6月30日起，对所有历史第三方应用不再返回，后续第三方仅通讯录应用可获取，第三方页面需要通过通讯录展示组件来展示名字
     * partylist 标签中包含的部门id列表
     */
    public function get($tagid)
    {
        $params = array();
        $params['tagid'] = $tagid;
        $rst = $this->_request->get($this->_url . 'get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 增加标签成员
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/addtagusers?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "tagid": 12,
     * "userlist":[ "user1","user2"],
     * "partylist": [4]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tagid 是 标签ID
     * userlist 否 企业成员ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过1000
     * partylist 否 企业部门ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过100
     * 权限说明：
     *
     * 调用者必须是指定标签的创建者；成员属于应用的可见范围。
     *
     * 注意，每个标签下部门、人员总数不能超过3万个。
     *
     * 返回结果：
     *
     * a)正确时返回
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * b)若部分userid、partylist非法，则返回
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "invalidlist"："usr1|usr2|usr",
     * "invalidparty"：[2,4]
     * }
     * c)当包含userid、partylist全部非法时返回
     *
     * {
     * "errcode": 40070,
     * "errmsg": "all list invalid "
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * invalidlist 非法的成员帐号列表
     * invalidparty 非法的部门id列表
     */
    public function addtagusers($tagid, array $userlist = array(), array $partylist = array())
    {
        $params = array();
        $params['tagid'] = $tagid;
        if (empty($userlist) && empty($partylist)) {
            throw new \Exception('userlist和partylist不能同时为空');
        }
        if (!empty($userlist)) {
            $params['userlist'] = $userlist;
        }
        if (!empty($partylist)) {
            $params['partylist'] = $partylist;
        }
        $rst = $this->_request->post($this->_url . 'addtagusers', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除标签成员
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/deltagusers?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "tagid": 12,
     * "userlist":[ "user1","user2"],
     * "partylist":[2,4]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * tagid 是 标签ID
     * userlist 否 企业成员ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过1000
     * partylist 否 企业部门ID列表，注意：userlist、partylist不能同时为空，单次请求长度不超过100
     * 权限说明：
     *
     * 调用者必须是指定标签的创建者；成员属于应用的可见范围。
     *
     * 返回结果：
     *
     * a)正确时返回
     *
     * {
     * "errcode": 0,
     * "errmsg": "deleted"
     * }
     * b)若部分userid、partylist非法，则返回
     *
     * {
     * "errcode": 0,
     * "errmsg": "deleted",
     * "invalidlist"："usr1|usr2|usr",
     * "invalidparty": [2,4]
     * }
     * c)当包含的userid、partylist全部非法时返回
     *
     * {
     * "errcode": 40031,
     * "errmsg": "all list invalid"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * invalidlist 非法的成员帐号列表
     * invalidparty 非法的部门id列表
     */
    public function deltagusers($tagid, array $userlist = array(), array $partylist = array())
    {
        $params = array();
        $params['tagid'] = $tagid;
        if (empty($userlist) && empty($partylist)) {
            throw new \Exception('userlist和partylist不能同时为空');
        }
        if (!empty($userlist)) {
            $params['userlist'] = $userlist;
        }
        if (!empty($partylist)) {
            $params['partylist'] = $partylist;
        }
        $rst = $this->_request->post($this->_url . 'deltagusers', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取标签列表
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/tag/list?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * 权限说明：
     *
     * 自建应用或通讯同步助手可以获取所有标签列表；第三方应用仅可获取自己创建的标签。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "taglist":[
     * {"tagid":1,"tagname":"a"},
     * {"tagid":2,"tagname":"b"}
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * taglist 标签列表
     * tagid 标签id
     * tagname 标签名
     */
    public function list()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }
}
