<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

/**
 * 部门管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Department
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/department/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 创建部门
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "name": "广州研发中心",
     * "name_en": "RDGZ",
     * "parentid": 1,
     * "order": 1,
     * "id": 2
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * name 是 部门名称。同一个层级的部门名称不能重复。长度限制为1~32个字符，字符不能包括\:?”<>｜
     * name_en 否 英文名称，需要在管理后台开启多语言支持才能生效。长度限制为1~32个字符，字符不能包括\:?”<>｜
     * parentid 是 父部门id，32位整型
     * order 否 在父部门中的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * id 否 部门id，32位整型，指定时必须大于1。若不填该参数，将自动生成id
     * 权限说明：
     *
     * 应用须拥有父部门的管理权限。
     * 第三方仅通讯录应用可以调用。
     *
     * 注意，部门的最大层级为15层；部门总数不能超过3万个；每个部门下的节点不能超过3万个。建议保证创建的部门和对应部门成员是串行化处理。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "created",
     * "id": 2
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * id 创建的部门id
     */
    public function create(\Weixin\Qy\Model\Department $department)
    {
        $params = $department->getParams();
        $rst = $this->_request->post($this->_url . 'create', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 更新部门
     * 调试工具
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/department/update?access_token=ACCESS_TOKEN
     *
     * 请求包体（如果非必须的字段未指定，则不更新该字段）：
     *
     * {
     * "id": 2,
     * "name": "广州研发中心",
     * "name_en": "RDGZ",
     * "parentid": 1,
     * "order": 1
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * id 是 部门id
     * name 否 部门名称。长度限制为1~32个字符，字符不能包括\:?”<>｜
     * name_en 否 英文名称，需要在管理后台开启多语言支持才能生效。长度限制为1~32个字符，字符不能包括\:?”<>｜
     * parentid 否 父部门id
     * order 否 在父部门中的次序值。order值大的排序靠前。有效的值范围是[0, 2^32)
     * 权限说明 ：
     *
     * 应用须拥有指定部门的管理权限。如若要移动部门，需要有新父部门的管理权限。
     * 第三方仅通讯录应用可以调用。
     *
     * 注意，部门的最大层级为15层；部门总数不能超过3万个；每个部门下的节点不能超过3万个。
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
    public function update(\Weixin\Qy\Model\Department $department)
    {
        $params = $department->getParams();
        $rst = $this->_request->post($this->_url . 'update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 删除部门
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/department/delete?access_token=ACCESS_TOKEN&id=ID
     *
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * id 是 部门id。（注：不能删除根部门；不能删除含有子部门、成员的部门）
     * 权限说明：
     *
     * 应用须拥有指定部门的管理权限。
     * 第三方仅通讯录应用可以调用。
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
    public function delete($id)
    {
        $params = array();
        $params['id'] = $id;
        $rst = $this->_request->get($this->_url . 'delete', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取部门列表
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=ACCESS_TOKEN&id=ID
     *
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * id 否 部门id。获取指定部门及其下的子部门。 如果不填，默认获取全量组织架构
     * 权限说明：
     *
     * 只能拉取token对应的应用的权限范围内的部门列表
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "department": [
     * {
     * "id": 2,
     * "name": "广州研发中心",
     * "name_en": "RDGZ",
     * "parentid": 1,
     * "order": 10
     * },
     * {
     * "id": 3,
     * "name": "邮箱产品部",
     * "name_en": "mail",
     * "parentid": 2,
     * "order": 40
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * department 部门列表数据。
     * id 创建的部门id
     * name 部门名称，此字段从2019年12月30日起，对新创建第三方应用不再返回，2020年6月30日起，对所有历史第三方应用不再返回，后续第三方仅通讯录应用可获取，第三方页面需要通过通讯录展示组件来展示部门名称
     * name_en 英文名称
     * parentid 父部门id。根部门为1
     * order 在父部门中的次序值。order值大的排序靠前。值范围是[0, 2^32)
     */
    public function list($id = 0)
    {
        $params = array();
        if (!empty($id)) {
            $params['id'] = $id;
        }
        $rst = $this->_request->get($this->_url . 'list', $params);
        return $this->_client->rst($rst);
    }
}
