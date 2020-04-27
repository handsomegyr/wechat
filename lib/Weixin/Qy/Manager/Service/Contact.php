<?php

/**
 * 通讯录控制器
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Qy\Manager\Service;

use Weixin\Qy\Service;

class Contact
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/service/contact/';

    private $_service;

    private $_request;

    public function __construct(Service $service)
    {
        $this->_service = $service;
        $this->_request = $service->getRequest();
    }

    /**
     * 通讯录搜索
     * 通讯录单个搜索
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/contact/search?provider_access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid":"wwxxxxxx",
     * "query_word": "zhangsan",
     * "query_type":1,
     * "agentid": 1000046,
     * "offset":0,
     * "limit":50
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * provider_access_token 是 应用提供商的provider_access_token，获取方法参见服务商的凭证
     * auth_corpid 是 查询的企业corpid
     * query_word 是 搜索关键词。当查询用户时应为用户名称、名称拼音或者英文名；当查询部门时应为部门名称或者部门名称拼音
     * query_type 否 查询类型 1：查询用户，返回用户userid列表 2：查询部门，返回部门id列表。 不填该字段或者填0代表同时查询部门跟用户
     * agentid 否 应用id，若非0则只返回应用可见范围内的用户或者部门信息
     * offset 否 查询的偏移量，每次调用的offset在上一次offset基础上加上limit
     * limit 否 查询返回的最大数量，默认为50，最多为200，查询返回的数量可能小于limit指定的值
     * 权限说明：
     *
     * agentid为0则返回该服务商授权通讯录权限范围内的用户信息或者部门信息，否则返回指定agentid应用可见范围内的信息
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "is_last":false,
     * "query_result":{
     * "user":{
     * "userid":["zhangshan","lisi"]
     * },
     * "party":{
     * "department_id":[1,2,3]
     * }
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * is_last 根据该字段判断是否是最后一页，若为false，开发者需要使用offset+limit继续调用
     * query_result 查询结果
     * user 返回的用户信息（通过用户名称，拼音匹配）
     * userid 查询到的用户userid
     * party 返回的部门信息 （通过部门名称，拼音匹配）
     * department_id 返回的部门id
     */
    public function contactSearch($provider_access_token, $auth_corpid, $query_word, $query_type = 1, $agentid = 0, $offset = 0, $limit = 200)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'query_word' => $query_word,
            'query_type' => $query_type,
            'agentid' => $agentid,
            'offset' => $offset,
            'limit' => $limit
        );
        $rst = $this->_request->post($this->_url . 'contact/search?provider_access_token=' . $provider_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 通讯录批量搜索
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/contact/batchsearch?provider_access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid":"wwxxxxxx",
     * "agentid": 1000046,
     * "query_request_list":[
     * {
     * "query_word": "zhangsan",
     * "query_type":1,
     * "offset":0,
     * "limit":50
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * provider_access_token 是 应用提供商的provider_access_token，获取方法参见服务商的凭证
     * auth_corpid 是 查询的企业corpid
     * agentid 否 应用id，若非0则只返回应用可见范围内的用户或者部门信息
     * query_request_list 是 搜索请求列表,每次搜索列表数量不超过50
     * query_word 是 搜索关键词。当查询用户时应为用户名称、名称拼音或者英文名；当查询部门时应为部门名称或者部门名称拼音
     * query_type 否 查询类型 1：查询用户，返回用户userid列表 2：查询部门，返回部门id列表。 不填该字段或者填0代表同时查询部门跟用户
     * offset 否 查询的偏移量，每次调用的offset在上一次offset基础上加上limit
     * limit 否 查询返回的最大数量，默认为50，最多为200，查询返回的数量可能小于limit指定的值
     * 权限说明：
     *
     * agentid为0则返回该服务商授权通讯录权限范围内的用户信息或者部门信息，否则返回指定agentid应用可见范围内的信息
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "query_result_list":[
     * {
     * "query_request":
     * {
     * "query_word": "zhangsan",
     * "query_type":1,
     * "offset":0,
     * "limit":50
     * },
     * "is_last":false,
     * "query_result":{
     * "user":{
     * "userid":["zhangshan","lisi"]
     * },
     * "party":{
     * "department_id":[1,2,3]
     * }
     * }
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * is_last 根据该字段判断是否是最后一页，若为false，开发者需要使用offset+limit继续调用
     * query_result_list 搜索结果列表
     * query_request 原搜索请求报文
     * query_result 搜索请求对应的查询结果
     * user 返回的用户信息（通过用户名称，拼音匹配）
     * userid 查询到的用户userid
     * party 返回的部门信息 （通过部门名称，拼音匹配）
     * department_id 返回的部门id
     */
    public function contactBatchSearch($provider_access_token, $auth_corpid, $agentid, array $query_request_list)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'agentid' => $agentid,
            'query_request_list' => $query_request_list
        );
        $rst = $this->_request->post($this->_url . 'contact/batchsearch?provider_access_token=' . $provider_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 异步通讯录id转译
     * 通讯录id替换
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/contact/id_translate?provider_access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid": "wwxxxx",
     * "media_id_list": ["1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0"],
     * "output_file_name": "学习手册"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * provider_access_token 是 服务商provider_access_token，获取方法参见服务商的凭证
     * auth_corpid 是 授权企业corpid
     * media_id_list 是 需要转译的文件的media_id列表，只支持xls/xlsx，doc/docx，csv，txt文件。获取方式参考 上传需要转译的文件
     * output_file_name 否 转译完打包的文件名，不需带后缀。企业微信后台会打包成zip压缩文件，并自动拼接上.zip后缀。若media_id_list中文件个数大于1，则该字段必填。若media_id_list中文件个数等于1，且未填该字段，则转译完不打包成压缩文件
     * 注：若生成的文件不需要压缩，则 media_id_list列表只能指定一项，同时 output_file_name 不需要传值
     *
     * 权限说明：
     *
     * 只替换服务商通讯录权限范围内的用户userid跟部门id。
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
     * jobid 异步任务id，最大长度为64字节。jobid用于接口 获取异步任务结果 传递
     */
    public function contactIdTranslate($provider_access_token, $auth_corpid, $media_id_list, $output_file_name)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'media_id_list' => $media_id_list,
            'output_file_name' => $output_file_name
        );
        $rst = $this->_request->post($this->_url . 'contact/id_translate?provider_access_token=' . $provider_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 通讯录userid排序
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/contact/sort?provider_access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid":"wwxxxxxx",
     * "sort_type":1,
     * "useridlist"["zhangshan","lisi"]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * provider_access_token 是 应用提供商的provider_access_token，获取方法参见服务商的凭证
     * auth_corpid 是 查询的企业corpid
     * sort_type 否 排序方式 0：根据姓名拼音升序排列，返回用户userid列表 1：根据姓名拼音降序排列，返回用户userid列表
     * useridlist 是 要排序的userid列表，最多支持1000个
     * 权限说明：
     *
     * useridlist中的userid必须为该服务商授权通讯录权限范围内的用户
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "useridlist"["lisi","zhangshan"]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * useridlist 排序后的userid列表
     */
    public function sort($provider_access_token, $auth_corpid, $sort_type, array $useridlist)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'sort_type' => $sort_type,
            'useridlist' => $useridlist
        );
        $rst = $this->_request->post($this->_url . 'sort?provider_access_token=' . $provider_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }
}
