<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 数据分析接口
 *
 * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-retain/getWeeklyRetain.html
 * 
 * @author guoyongrong <handsomegyr@126.com>
 */
class Datacube
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-retain/getWeeklyRetain.html
     * 获取用户访问小程序周留存
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getWeeklyRetain
     *
     * 功能描述
     * 该接口用于获取用户访问小程序周留存。
     *
     * 注意事项
     * 请求json和返回json与天的一致，这里限定查询一个自然周的数据，时间必须按照自然周的方式输入： 如：20170306(周一), 20170312(周日)
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappidweeklyretaininfo?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getWeeklyRetain
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期，为周一日期。格式为 yyyymmdd
     * end_date string 是 结束日期，为周日日期，限定查询一周数据。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * ref_date string 时间，如："20170306-20170312"
     * visit_uv_new array<object> 新增用户留存
     * 属性 类型 说明
     * key number 标识，0开始，表示当周，1表示1周后。依此类推，取值分别是：0,1,2,3,4
     * value number key对应日期的新增用户数/活跃用户数（key=0时）或留存用户数（k>0时）
     * visit_uv array<object> 活跃用户留存
     * 属性 类型 说明
     * key number 标识，0开始，表示当周，1表示1周后。依此类推，取值分别是：0,1,2,3,4
     * value number key对应日期的新增用户数/活跃用户数（key=0时）或留存用户数（k>0时）
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170306",
     * "end_date" : "20170312"
     * }
     *
     * 返回数据示例
     *
     * {
     * "ref_date": "20170306-20170312",
     * "visit_uv_new": [
     * {
     * "key": 0,
     * "value": 0
     * },
     * {
     * "key": 1,
     * "value": 16853
     * }
     * ],
     * "visit_uv": [
     * {
     * "key": 0,
     * "value": 0
     * },
     * {
     * "key": 1,
     * "value": 99310
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getWeeklyRetain({
     * "beginDate": '20170306',
     * "endDate": '20170312'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "refDate": "20170306-20170312",
     * "visitUvNew": [
     * {
     * "key": 0,
     * "value": 0
     * },
     * {
     * "key": 1,
     * "value": 16853
     * }
     * ],
     * "visitUv": [
     * {
     * "key": 0,
     * "value": 0
     * },
     * {
     * "key": 1,
     * "value": 99310
     * }
     * ],
     * "errMsg": "openapi.analysis.getWeeklyRetain:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getWeeklyRetain($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappidweeklyretaininfo', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-retain/getMonthlyRetain.html
     * 获取用户访问小程序月留存
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getMonthlyRetain
     *
     * 功能描述
     * 该接口用于获取用户访问小程序月留存。
     *
     * 注意事项
     * 请求json和返回json与天的一致，这里限定查询一个自然月的数据，时间必须按照自然月的方式输入： 如：20170201(月初), 20170228(月末)
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappidmonthlyretaininfo?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getMonthlyRetain
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期，为自然月第一天。格式为 yyyymmdd
     * end_date string 是 结束日期，为自然月最后一天，限定查询一个月数据。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * ref_date string 时间，如："201702"
     * visit_uv_new array<object> 新增用户留存
     * 属性 类型 说明
     * key number 标识，0开始，表示当月，1表示1月后。key取值分别是：0,1
     * value number key对应日期的新增用户数/活跃用户数（key=0时）或留存用户数（k>0时）
     * visit_uv array<object> 活跃用户留存
     * 属性 类型 说明
     * key number 标识，0开始，表示当月，1表示1月后。key取值分别是：0,1
     * value number key对应日期的新增用户数/活跃用户数（key=0时）或留存用户数（k>0时）
     * 调用示例
     * 示例说明: HTTPS调用示例
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170201",
     * "end_date" : "20170228"
     * }
     *
     *
     * 返回数据示例
     *
     * {
     * "ref_date": "201702",
     * "visit_uv_new": [
     * {
     * "key": 0,
     * "value": 346249
     * }
     * ],
     * "visit_uv": [
     * {
     * "key": 0,
     * "value": 346249
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getMonthlyRetain({
     * "beginDate": '20170201',
     * "endDate": '20170228'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "refDate": "201702",
     * "visitUvNew": [
     * {
     * "key": 0,
     * "value": 346249
     * }
     * ],
     * "visitUv": [
     * {
     * "key": 0,
     * "value": 346249
     * }
     * ],
     * "errMsg": "openapi.analysis.getMonthlyRetain:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getMonthlyRetain($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappidmonthlyretaininfo', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-retain/getDailyRetain.html
     * 获取用户访问小程序日留存
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getDailyRetain
     *
     * 功能描述
     * 该接口用于获取用户访问小程序日留存。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappiddailyretaininfo?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.undefined
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期。格式为 yyyymmdd
     * end_date string 是 结束日期，限定查询1天数据，允许设置的最大值为昨日。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * ref_date string 日期
     * visit_uv_new array<object> 新增用户留存
     * 属性 类型 说明
     * key number 标识，0开始，表示当天，1表示1天后。依此类推，key取值分别是：0,1,2,3,4,5,6,7,14,30
     * value number key对应日期的新增用户数/活跃用户数（key=0时）或留存用户数（k>0时）
     * visit_uv array<object> 活跃用户留存
     * 属性 类型 说明
     * key number 标识，0开始，表示当天，1表示1天后。依此类推，key取值分别是：0,1,2,3,4,5,6,7,14,30
     * value number key对应日期的新增用户数/活跃用户数（key=0时）或留存用户数（k>0时）
     * 调用示例
     * 示例说明: HTTPS请求
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170313",
     * "end_date" : "20170313"
     * }
     *
     * 返回数据示例
     *
     * {
     * "ref_date": "20170313",
     * "visit_uv_new": [
     * {
     * "key": 0,
     * "value": 5464
     * }
     * ],
     * "visit_uv": [
     * {
     * "key": 0,
     * "value": 55500
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用示例
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getDailyRetain({
     * "beginDate": '20170313',
     * "endDate": '20170313'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "refDate": "20170313",
     * "visitUvNew": [
     * {
     * "key": 0,
     * "value": 5464
     * }
     * ],
     * "visitUv": [
     * {
     * "key": 0,
     * "value": 55500
     * }
     * ],
     * "errMsg": "openapi.analysis.getDailyRetain:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     */
    public function getDailyRetain($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappiddailyretaininfo', $params);
        return $this->_client->rst($rst);
    }
    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-trend/getMonthlyVisitTrend.html
     * 获取用户访问小程序数据月趋势
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getMonthlyVisitTrend
     *
     * 功能描述
     * 该接口用于获取用户访问小程序数据月趋势(能查询到的最新数据为上一个自然月的数据)。
     *
     * 注意事项
     * 限定查询一个自然月的数据，时间必须按照自然月的方式输入： 如：20170301, 20170331
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappidmonthlyvisittrend?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getMonthlyVisitTrend
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期，为自然月第一天。格式为 yyyymmdd
     * end_date string 是 结束日期，为自然月最后一天，限定查询一个月的数据。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * list array<object> 数据列表
     * 属性 类型 说明
     * ref_date string 时间，格式为 yyyymm，如："201702"
     * session_cnt number 打开次数（自然月内汇总）
     * visit_pv number 访问次数（自然月内汇总）
     * visit_uv number 访问人数（自然月内去重）
     * visit_uv_new number 新用户数（自然月内去重）
     * stay_time_uv number 人均停留时长 (浮点型，单位：秒)
     * stay_time_session number 次均停留时长 (浮点型，单位：秒)
     * visit_depth number 平均访问深度 (浮点型)
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170301",
     * "end_date" : "20170331"
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "ref_date": "201703",
     * "session_cnt": 126513,
     * "visit_pv": 426113,
     * "visit_uv": 48659,
     * "visit_uv_new": 6726,
     * "stay_time_session": 56.4112,
     * "visit_depth": 2.0189
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getMonthlyVisitTrend({
     * "beginDate": '20170301',
     * "endDate": '20170331'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "refDate": "201703",
     * "sessionCnt": 126513,
     * "visitPv": 426113,
     * "visitUv": 48659,
     * "visitUvNew": 6726,
     * "stayTimeSession": 56.4112,
     * "visitDepth": 2.0189
     * }
     * ],
     * "errMsg": "openapi.analysis.getMonthlyVisitTrend:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getMonthlyVisitTrend($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappidmonthlyvisittrend', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-trend/getDailyVisitTrend.html
     * 获取用户访问小程序数据日趋势
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getDailyVisitTrend
     *
     * 功能描述
     * 该接口用于获取用户访问小程序数据日趋势。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappiddailyvisittrend?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getDailyVisitTrend
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期。格式为 yyyymmdd
     * end_date string 是 结束日期，限定查询1天数据，允许设置的最大值为昨日。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * list array<object> 数据列表
     * 属性 类型 说明
     * ref_date string 日期，格式为 yyyymmdd
     * session_cnt number 打开次数
     * visit_pv number 访问次数
     * visit_uv number 访问人数
     * visit_uv_new number 新用户数
     * stay_time_uv number 人均停留时长 (浮点型，单位：秒)
     * stay_time_session number 次均停留时长 (浮点型，单位：秒)
     * visit_depth number 平均访问深度 (浮点型)
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170313",
     * "end_date" : "20170313"
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "ref_date": "20170313",
     * "session_cnt": 142549,
     * "visit_pv": 472351,
     * "visit_uv": 55500,
     * "visit_uv_new": 5464,
     * "stay_time_session": 0,
     * "visit_depth": 1.9838
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getDailyVisitTrend({
     * "beginDate": '20170313',
     * "endDate": '20170313'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "refDate": "20170313",
     * "sessionCnt": 142549,
     * "visitPv": 472351,
     * "visitUv": 55500,
     * "visitUvNew": 5464,
     * "stayTimeSession": 0,
     * "visitDepth": 1.9838
     * }
     * ],
     * "errMsg": "openapi.analysis.getDailyVisitTrend:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getDailyVisitTrend($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappiddailyvisittrend', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/visit-trend/getWeeklyVisitTrend.html
     * 获取用户访问小程序数据周趋势
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getWeeklyVisitTrend
     *
     * 功能描述
     * 该接口用于获取用户访问小程序数据周趋势
     *
     * 注意事项
     * 限定查询一个自然周的数据，时间必须按照自然周的方式输入： 如：20170306(周一), 20170312(周日)
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappidweeklyvisittrend?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getWeeklyVisitTrend
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期，为周一日期。格式为 yyyymmdd
     * end_date string 是 结束日期，为周日日期，限定查询一周数据。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * list array<object> 数据列表
     * 属性 类型 说明
     * ref_date string 时间，格式为 yyyymmdd-yyyymmdd，如："20170306-20170312"
     * session_cnt number 打开次数（自然周内汇总）
     * visit_pv number 访问次数（自然周内汇总）
     * visit_uv number 访问人数（自然周内去重）
     * visit_uv_new number 新用户数（自然周内去重）
     * stay_time_uv number 人均停留时长 (浮点型，单位：秒)
     * stay_time_session number 次均停留时长 (浮点型，单位：秒)
     * visit_depth number 平均访问深度 (浮点型)
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170306",
     * "end_date" : "20170312"
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "ref_date": "20170306-20170312",
     * "session_cnt": 986780,
     * "visit_pv": 3251840,
     * "visit_uv": 189405,
     * "visit_uv_new": 45592,
     * "stay_time_session": 54.5346,
     * "visit_depth": 1.9735
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getWeeklyVisitTrend({
     * "beginDate": '20170306',
     * "endDate": '20170312'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "refDate": "20170306-20170312",
     * "sessionCnt": 986780,
     * "visitPv": 3251840,
     * "visitUv": 189405,
     * "visitUvNew": 45592,
     * "stayTimeSession": 54.5346,
     * "visitDepth": 1.9735
     * }
     * ],
     * "errMsg": "openapi.analysis.getWeeklyVisitTrend:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getWeeklyVisitTrend($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappidweeklyvisittrend', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/others/getDailySummary.html
     * 获取用户访问小程序数据概况
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getDailySummary
     *
     * 功能描述
     * 该接口用于获取用户访问小程序数据概况。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappiddailysummarytrend?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getDailySummary
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期。格式为 yyyymmdd
     * end_date string 是 结束日期，限定查询1天数据，允许设置的最大值为昨日。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * list array<object> 数据列表
     * 属性 类型 说明
     * ref_date string 日期，格式为 yyyymmdd
     * visit_total number 累计用户数
     * share_pv number 转发次数
     * share_uv number 转发人数
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170313",
     * "end_date" : "20170313"
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "ref_date": "20170313",
     * "visit_total": 391,
     * "share_pv": 572,
     * "share_uv": 383
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getDailySummary({
     * "beginDate": '20170313',
     * "endDate": '20170313'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "list": [
     * {
     * "refDate": "20170313",
     * "visitTotal": 391,
     * "sharePv": 572,
     * "shareUv": 383
     * }
     * ],
     * "errMsg": "openapi.analysis.getDailySummary:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getDailySummary($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappiddailysummarytrend', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/others/getVisitPage.html
     * 获取访问页面数据
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getVisitPage
     *
     * 功能描述
     * 该接口用于访问页面。目前只提供按 page_visit_pv 排序的 top200。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappidvisitpage?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getVisitPage
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期。格式为 yyyymmdd
     * end_date string 是 结束日期，限定查询1天数据，允许设置的最大值为昨日。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * ref_date string 日期，格式为 yyyymmdd
     * list array<object> 数据列表
     * 属性 类型 说明
     * page_path string 页面路径
     * page_visit_pv number 访问次数
     * page_visit_uv number 访问人数
     * page_staytime_pv number 次均停留时长
     * entrypage_pv number 进入页次数
     * exitpage_pv number 退出页次数
     * page_share_pv number 转发次数
     * page_share_uv number 转发人数
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170313",
     * "end_date" : "20170313"
     * }
     *
     * 返回数据示例
     *
     * {
     * "ref_date": "20170313",
     * "list": [
     * {
     * "page_path": "pages/main/main.html",
     * "page_visit_pv": 213429,
     * "page_visit_uv": 55423,
     * "page_staytime_pv": 8.139198,
     * "entrypage_pv": 117922,
     * "exitpage_pv": 61304,
     * "page_share_pv": 180,
     * "page_share_uv": 166
     * },
     * {
     * "page_path": "pages/linedetail/linedetail.html",
     * "page_visit_pv": 155030,
     * "page_visit_uv": 42195,
     * "page_staytime_pv": 35.462395,
     * "entrypage_pv": 21101,
     * "exitpage_pv": 47051,
     * "page_share_pv": 47,
     * "page_share_uv": 42
     * },
     * {
     * "page_path": "pages/search/search.html",
     * "page_visit_pv": 65011,
     * "page_visit_uv": 24716,
     * "page_staytime_pv": 6.889634,
     * "entrypage_pv": 1811,
     * "exitpage_pv": 3198,
     * "page_share_pv": 0,
     * "page_share_uv": 0
     * },
     * {
     * "page_path": "pages/stationdetail/stationdetail.html",
     * "page_visit_pv": 29953,
     * "page_visit_uv": 9695,
     * "page_staytime_pv": 7.558508,
     * "entrypage_pv": 1386,
     * "exitpage_pv": 2285,
     * "page_share_pv": 0,
     * "page_share_uv": 0
     * },
     * {
     * "page_path": "pages/switch-city/switch-city.html",
     * "page_visit_pv": 8928,
     * "page_visit_uv": 4017,
     * "page_staytime_pv": 9.22659,
     * "entrypage_pv": 748,
     * "exitpage_pv": 1613,
     * "page_share_pv": 0,
     * "page_share_uv": 0
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getVisitPage({
     * "beginDate": '20170313',
     * "endDate": '20170313'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "refDate": "20170313",
     * "list": [
     * {
     * "pagePath": "pages/main/main.html",
     * "pageVisitPv": 213429,
     * "pageVisitUv": 55423,
     * "pageStaytimePv": 8.139198,
     * "entrypagePv": 117922,
     * "exitpagePv": 61304,
     * "pageSharePv": 180,
     * "pageShareUv": 166
     * },
     * {
     * "pagePath": "pages/linedetail/linedetail.html",
     * "pageVisitPv": 155030,
     * "pageVisitUv": 42195,
     * "pageStaytimePv": 35.462395,
     * "entrypagePv": 21101,
     * "exitpagePv": 47051,
     * "pageSharePv": 47,
     * "pageShareUv": 42
     * },
     * {
     * "pagePath": "pages/search/search.html",
     * "pageVisitPv": 65011,
     * "pageVisitUv": 24716,
     * "pageStaytimePv": 6.889634,
     * "entrypagePv": 1811,
     * "exitpagePv": 3198,
     * "pageSharePv": 0,
     * "pageShareUv": 0
     * },
     * {
     * "pagePath": "pages/stationdetail/stationdetail.html",
     * "pageVisitPv": 29953,
     * "pageVisitUv": 9695,
     * "pageStaytimePv": 7.558508,
     * "entrypagePv": 1386,
     * "exitpagePv": 2285,
     * "pageSharePv": 0,
     * "pageShareUv": 0
     * },
     * {
     * "pagePath": "pages/switch-city/switch-city.html",
     * "pageVisitPv": 8928,
     * "pageVisitUv": 4017,
     * "pageStaytimePv": 9.22659,
     * "entrypagePv": 748,
     * "exitpagePv": 1613,
     * "pageSharePv": 0,
     * "pageShareUv": 0
     * }
     * ],
     * "errMsg": "openapi.analysis.getVisitPage:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getVisitPage($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappidvisitpage', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/others/getUserPortrait.html
     * 获取小程序用户画像分布
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
     *
     * 接口说明
     * 接口英文名
     * getUserPortrait
     *
     * 功能描述
     * 该接口用于获取小程序新增或活跃用户的画像分布数据。时间范围支持昨天、最近7天、最近30天。其中，新增用户数为时间范围内首次访问小程序的去重用户数，活跃用户数为时间范围内访问过小程序的去重用户数。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappiduserportrait?access_token=ACCESS_TOKEN
     *
     * 云调用
     * 出入参和HTTPS调用相同，调用方式可查看云调用说明文档
     *
     * 接口方法为: openapi.analysis.getUserPortrait
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期。格式为 yyyymmdd
     * end_date string 是 结束日期，开始日期与结束日期相差的天数限定为0/6/29，分别表示查询最近1/7/30天数据，允许设置的最大值为昨日。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * ref_date string 时间范围，如："20170611-20170617"
     * visit_uv_new object 新用户画像
     * 属性 类型 说明
     * province array<object> 分布类型
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * city array<object> 省份，如北京、广东等
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * genders array<object> 城市，如北京、广州等
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * platforms array<object> 性别，包括男、女、未知
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * devices array<object> 终端类型，包括 iPhone，android，其他
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * ages array<object> 年龄，包括17岁以下、18-24岁等区间
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * visit_uv object 活跃用户画像
     * 属性 类型 说明
     * province array<object> 分布类型
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * city array<object> 省份，如北京、广东等
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * genders array<object> 城市，如北京、广州等
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * platforms array<object> 性别，包括男、女、未知
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * devices array<object> 终端类型，包括 iPhone，android，其他
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * ages array<object> 年龄，包括17岁以下、18-24岁等区间
     * 属性 类型 说明
     * id number 属性值id
     * name string 属性值名称，与id对应。属性值为province、 city、 genders 、 platforms、devices 、 ages。
     * value number 该场景访问uv
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170611",
     * "end_date" : "20170617"
     * }
     *
     * 返回数据示例
     *
     * {
     * "ref_date": "20170611",
     * "visit_uv_new": {
     * "province": [
     * {
     * "id": 31,
     * "name": "广东省",
     * "value": 215
     * }
     * ],
     * "city": [
     * {
     * "id": 3102,
     * "name": "广州",
     * "value": 78
     * }
     * ],
     * "genders": [
     * {
     * "id": 1,
     * "name": "男",
     * "value": 2146
     * }
     * ],
     * "platforms": [
     * {
     * "id": 1,
     * "name": "iPhone",
     * "value": 27642
     * }
     * ],
     * "devices": [
     * {
     * "name": "OPPO R9",
     * "value": 61
     * }
     * ],
     * "ages": [
     * {
     * "id": 1,
     * "name": "17岁以下",
     * "value": 151
     * }
     * ]
     * },
     * "visit_uv": {
     * "province": [
     * {
     * "id": 31,
     * "name": "广东省",
     * "value": 1341
     * }
     * ],
     * "city": [
     * {
     * "id": 3102,
     * "name": "广州",
     * "value": 234
     * }
     * ],
     * "genders": [
     * {
     * "id": 1,
     * "name": "男",
     * "value": 14534
     * }
     * ],
     * "platforms": [
     * {
     * "id": 1,
     * "name": "iPhone",
     * "value": 21750
     * }
     * ],
     * "devices": [
     * {
     * "name": "OPPO R9",
     * "value": 617
     * }
     * ],
     * "ages": [
     * {
     * "id": 1,
     * "name": "17岁以下",
     * "value": 3156
     * }
     * ]
     * }
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getUserPortrait({
     * "beginDate": '20170611',
     * "endDate": '20170617'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "refDate": "20170611",
     * "visitUvNew": {
     * "province": [
     * {
     * "id": 31,
     * "name": "广东省",
     * "value": 215
     * }
     * ],
     * "city": [
     * {
     * "id": 3102,
     * "name": "广州",
     * "value": 78
     * }
     * ],
     * "genders": [
     * {
     * "id": 1,
     * "name": "男",
     * "value": 2146
     * }
     * ],
     * "platforms": [
     * {
     * "id": 1,
     * "name": "iPhone",
     * "value": 27642
     * }
     * ],
     * "devices": [
     * {
     * "name": "OPPO R9",
     * "value": 61
     * }
     * ],
     * "ages": [
     * {
     * "id": 1,
     * "name": "17岁以下",
     * "value": 151
     * }
     * ]
     * },
     * "visitUv": {
     * "province": [
     * {
     * "id": 31,
     * "name": "广东省",
     * "value": 1341
     * }
     * ],
     * "city": [
     * {
     * "id": 3102,
     * "name": "广州",
     * "value": 234
     * }
     * ],
     * "genders": [
     * {
     * "id": 1,
     * "name": "男",
     * "value": 14534
     * }
     * ],
     * "platforms": [
     * {
     * "id": 1,
     * "name": "iPhone",
     * "value": 21750
     * }
     * ],
     * "devices": [
     * {
     * "name": "OPPO R9",
     * "value": 617
     * }
     * ],
     * "ages": [
     * {
     * "id": 1,
     * "name": "17岁以下",
     * "value": 3156
     * }
     * ]
     * },
     * "errMsg": "openapi.analysis.getUserPortrait:ok"
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getUserPortrait($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappiduserportrait', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/others/getPerformanceData.html
     * 获取小程序性能数据
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 接口说明
     * 接口英文名
     * getPerformanceData
     *
     * 功能描述
     * 该接口用于获取小程序启动性能，运行性能等数据
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/wxa/business/performance/boot?access_token=ACCESS_TOKEN
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用getAccessToken 或者 authorizer_access_token
     * module number 是 查询数据的类型
     * time object 是 开始和结束日期的时间戳，时间跨度不能超过30天
     * 属性 类型 必填 说明
     * begin_timestamp number 是 开始日期时间戳
     * end_timestamp number 是 结束日期时间戳
     * params array<object> 是 查询条件，比如机型，网络类型等等
     * 属性 类型 必填 说明
     * field string 是 查询条件
     * value string 是 查询条件值
     * 返回参数
     * 属性 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * data object 返回的性能数据
     * 属性 类型 说明
     * body object 返回的性能数据
     * 属性 类型 说明
     * tables array<object> 返回的数据数组
     * 属性 类型 说明
     * id string 性能数据指标id
     * lines array<object> 按时间排列的性能数据
     * 属性 类型 说明
     * fields array<object> 单天的性能数据
     * 属性 类型 说明
     * refdate string 日期
     * value string 性能数据值
     * zh string 性能数据指标中文名
     * count number 数组大小
     * 其他说明
     * module 的合法值
     * 值 说明
     * 10016 打开率, params字段可传入网络类型和机型
     * 10017 启动各阶段耗时，params字段可传入网络类型和机型
     * 10021 页面切换耗时，params数组字段可传入机型
     * 10022 内存指标，params数组字段可传入机型
     * 10023 内存异常，params数组字段可传入机型
     * field 的合法值
     * 值 说明
     * networktype 网络类型作为查询条件，value=“-1,3g,4g,wifi”分别表示 全部网络类型，3G，4G，WIFI,不传networktype默认为全部网络类型
     * device_level 机型作为查询条件，此时value=“-1,1,2,3”分别表示 全部机型，高档机，中档机，低档机,不传device_level默认为全部机型
     * device 平台作为查询条件，此时value="-1,1,2"分别表示 全部平台，IOS平台，安卓平台,不传device默认为全部平台
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "time": {
     * "end_timestamp": 1609689600,
     * "begin_timestamp": 1609603200
     * },
     * "module": "10022",
     * "params": [{
     * "field": "networktype",
     * "value": "wifi"
     * }, {
     * "field": "device_level",
     * "value": "1"
     * }, {
     * "field": "device",
     * "value": "1"
     * }]
     * }
     *
     * 返回数据示例
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "data": {
     * "body": {
     * "tables": [
     * {
     * "id": "memorydiff",
     * "lines": [
     * {
     * "fields": [
     * {
     * "refdate": "20210103",
     * "value": "70.7778"
     * },
     * {
     * "refdate": "20210104",
     * "value": "72.0446"
     * }
     * ]
     * }
     * ],
     * "zh": "内存增长均值"
     * },
     * {
     * "id": "memory",
     * "lines": [
     * {
     * "fields": [
     * {
     * "refdate": "20210103",
     * "value": "314"
     * },
     * {
     * "refdate": "20210104",
     * "value": "302.3218"
     * }
     * ]
     * }
     * ],
     * "zh": "内存均值"
     * }
     * ],
     * "count": 2
     * }
     * }
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getPerformanceData({
     * "time": {
     * "endTimestamp": 1609689600,
     * "beginTimestamp": 1609603200
     * },
     * "module": '10022',
     * "params": [
     * {
     * "field": 'networktype',
     * "value": 'wifi'
     * },
     * {
     * "field": 'device_level',
     * "value": '1'
     * },
     * {
     * "field": 'device',
     * "value": '1'
     * }
     * ]
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "errCode": 0,
     * "errMsg": "openapi.analysis.getPerformanceData:ok",
     * "data": {
     * "body": {
     * "tables": [
     * {
     * "id": "memorydiff",
     * "lines": [
     * {
     * "fields": [
     * {
     * "refdate": "20210103",
     * "value": "70.7778"
     * },
     * {
     * "refdate": "20210104",
     * "value": "72.0446"
     * }
     * ]
     * }
     * ],
     * "zh": "内存增长均值"
     * },
     * {
     * "id": "memory",
     * "lines": [
     * {
     * "fields": [
     * {
     * "refdate": "20210103",
     * "value": "314"
     * },
     * {
     * "refdate": "20210104",
     * "value": "302.3218"
     * }
     * ]
     * }
     * ],
     * "zh": "内存均值"
     * }
     * ],
     * "count": 2
     * }
     * }
     * }
     *
     * 错误码
     * 错误码 错误码取值 解决方案
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getPerformanceData($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'wxa/business/performance/boot', $params);
        return $this->_client->rst($rst);
    }

    /**
     * https://developers.weixin.qq.com/miniprogram/dev/OpenApiDoc/data-analysis/others/getVisitDistribution.html
     * 获取用户小程序访问分布数据
     * 调试工具
     *
     * 接口应在服务器端调用，详细说明参见服务端API。
     *
     * 接口说明
     * 接口英文名
     * getVisitDistribution
     *
     * 功能描述
     * 该接口用于获取用户小程序访问分布数据。
     *
     * 调用方式
     * HTTPS 调用
     *
     * POST https://api.weixin.qq.com/datacube/getweanalysisappidvisitdistribution?access_token=ACCESS_TOKEN
     *
     * 第三方调用
     * 调用方式以及出入参和HTTPS相同，仅是调用的token不同
     *
     * 该接口所属的权限集id为：18、21
     *
     * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
     *
     * 请求参数
     * 属性 类型 必填 说明
     * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
     * begin_date string 是 开始日期。格式为 yyyymmdd
     * end_date string 是 结束日期，限定查询 1 天数据，允许设置的最大值为昨日。格式为 yyyymmdd
     * 返回参数
     * 属性 类型 说明
     * ref_date string 日期，格式为 yyyymmdd
     * list array<object> 数据列表
     * 属性 类型 说明
     * index string 分布类型。枚举值为：access_source_session_cnt（访问来源分布）、access_staytime_info（访问时长分布）、access_depth_info（访问深度的分布 ）
     * item_list array<object> 分布数据列表
     * 属性 类型 说明
     * key number 场景 id，定义在各个 index 下不同，具体参见下方表格
     * value number 该场景 id 访问 pv
     * 其他说明
     * index 的合法值
     * 值 说明
     * access_source_session_cnt 访问来源分布
     * access_staytime_info 访问时长分布
     * access_depth_info 访问深度的分布
     * 访问来源 key 对应关系（index='access_source_session_cnt')，场景值说明参见场景值
     * key 访问来源 对应场景值
     * 1 小程序历史列表 1001 1002 1004
     * 2 搜索 1005 1006 1027 1042 1053 1106 1108 1132
     * 3 会话 1007 1008 1044 1093 1094 1096
     * 4 扫一扫二维码 1011 1025 1047 1105 1124 1150
     * 5 公众号主页 1020
     * 6 聊天顶部 1022
     * 7 系统桌面 1023 1113 1114 1117
     * 8 小程序主页 1024 1135
     * 9 附近的小程序 1026 1033 1068
     * 11 模板消息 1014 1043 1107 1162
     * 12 客服消息 1021
     * 13 公众号菜单 1035 1102 1130
     * 14 APP分享 1036
     * 15 支付完成页 1034 1060 1072 1097 1109 1137 1149
     * 16 长按识别二维码 1012 1048 1050 1125
     * 17 相册选取二维码 1013 1049 1126
     * 18 公众号文章 1058 1091
     * 19 钱包 1019 1057 1061 1066 1070 1071
     * 20 卡包 1028 1128 1148
     * 21 小程序内卡券 1029 1062
     * 22 其他小程序 1037
     * 23 其他小程序返回 1038
     * 24 卡券适用门店列表 1052
     * 25 搜索框快捷入口 1054
     * 26 小程序客服消息 1073 1081
     * 27 公众号下发 1074 1076 1082 1152
     * 28 系统会话菜单 1080 1083 1088
     * 29 任务栏-最近使用 1089
     * 30 长按小程序菜单圆点 1085 1090 1147
     * 31 连wifi成功页 1064 1078
     * 32 城市服务 1092
     * 33 微信广告 1045 1046 1067 1084 1095
     * 34 其他移动应用 1065 1069 1111 1140
     * 35 发现入口-我的小程序 1003 1103
     * 36 任务栏-我的小程序 1104
     * 37 微信圈子 1138 1163
     * 38 手机充值 1098
     * 39 H5 1018 1055
     * 40 插件 1040 1041 1099
     * 41 大家在用 1118 1145
     * 42 发现页 1112 1141 1142 1143
     * 43 浮窗 1131
     * 44 附近的人 1075 1134
     * 45 看一看 1115
     * 46 朋友圈 1009 1110 1154 1155
     * 47 企业微信 1119 1120 1121 1122 1123 1156
     * 48 视频 1136 1144
     * 49 收藏 1010
     * 50 微信红包 1100
     * 51 微信游戏中心 1079 1127
     * 52 摇一摇 1039 1077
     * 53 公众号导购消息 1157
     * 54 识物 1153
     * 55 小程序订单 1151
     * 56 小程序直播 1161
     * 57 群工具 1158 1159 1160
     * 10 其他 除上述外其余场景值
     * 访问来源 key 对应关系（index='access_staytime_info')
     * key 访问时长
     * 1 0-2s
     * 2 3-5s
     * 3 6-10s
     * 4 11-20s
     * 5 20-30s
     * 6 30-50s
     * 7 50-100s
     * 8 >100s
     * 平均访问深度 key 对应关系（index='access_depth_info'）
     * key 访问时长
     * 1 1 页
     * 2 2 页
     * 3 3 页
     * 4 4 页
     * 5 5 页
     * 6 6-10 页
     * 7 >10 页
     * 调用示例
     * 示例说明: HTTPS调用
     *
     * 请求数据示例
     *
     * {
     * "begin_date" : "20170313",
     * "end_date" : "20170313"
     * }
     *
     * 返回数据示例
     *
     * {
     * "ref_date": "20170313",
     * "list": [
     * {
     * "index": "access_source_session_cnt",
     * "item_list": [
     * {
     * "key": 10,
     * "value": 5
     * },
     * {
     * "key": 8,
     * "value": 687
     * },
     * {
     * "key": 7,
     * "value": 10740
     * },
     * {
     * "key": 6,
     * "value": 1961
     * },
     * {
     * "key": 5,
     * "value": 677
     * },
     * {
     * "key": 4,
     * "value": 653
     * },
     * {
     * "key": 3,
     * "value": 1120
     * },
     * {
     * "key": 2,
     * "value": 10243
     * },
     * {
     * "key": 1,
     * "value": 116578
     * }
     * ]
     * },
     * {
     * "index": "access_staytime_info",
     * "item_list": [
     * {
     * "key": 8,
     * "value": 16329
     * },
     * {
     * "key": 7,
     * "value": 19322
     * },
     * {
     * "key": 6,
     * "value": 21832
     * },
     * {
     * "key": 5,
     * "value": 19539
     * },
     * {
     * "key": 4,
     * "value": 29670
     * },
     * {
     * "key": 3,
     * "value": 19667
     * },
     * {
     * "key": 2,
     * "value": 11794
     * },
     * {
     * "key": 1,
     * "value": 4511
     * }
     * ]
     * },
     * {
     * "index": "access_depth_info",
     * "item_list": [
     * {
     * "key": 5,
     * "value": 217
     * },
     * {
     * "key": 4,
     * "value": 3259
     * },
     * {
     * "key": 3,
     * "value": 32445
     * },
     * {
     * "key": 2,
     * "value": 63542
     * },
     * {
     * "key": 1,
     * "value": 43201
     * }
     * ]
     * }
     * ]
     * }
     *
     * 示例说明: 云函数调用
     *
     * 请求数据示例
     *
     * const cloud = require('wx-server-sdk')
     * cloud.init({
     * env: cloud.DYNAMIC_CURRENT_ENV,
     * })
     * exports.main = async (event, context) => {
     * try {
     * const result = await cloud.openapi.analysis.getVisitDistribution({
     * "beginDate": '20170313',
     * "endDate": '20170313'
     * })
     * return result
     * } catch (err) {
     * return err
     * }
     * }
     *
     * 返回数据示例
     *
     * {
     * "refDate": "20170313",
     * "list": [
     * {
     * "index": "access_source_session_cnt",
     * "itemList": [
     * {
     * "key": 10,
     * "value": 5
     * },
     * {
     * "key": 8,
     * "value": 687
     * },
     * {
     * "key": 7,
     * "value": 10740
     * },
     * {
     * "key": 6,
     * "value": 1961
     * },
     * {
     * "key": 5,
     * "value": 677
     * },
     * {
     * "key": 4,
     * "value": 653
     * },
     * {
     * "key": 3,
     * "value": 1120
     * },
     * {
     * "key": 2,
     * "value": 10243
     * },
     * {
     * "key": 1,
     * "value": 116578
     * }
     * ]
     * },
     * {
     * "index": "access_staytime_info",
     * "itemList": [
     * {
     * "key": 8,
     * "value": 16329
     * },
     * {
     * "key": 7,
     * "value": 19322
     * },
     * {
     * "key": 6,
     * "value": 21832
     * },
     * {
     * "key": 5,
     * "value": 19539
     * },
     * {
     * "key": 4,
     * "value": 29670
     * },
     * {
     * "key": 3,
     * "value": 19667
     * },
     * {
     * "key": 2,
     * "value": 11794
     * },
     * {
     * "key": 1,
     * "value": 4511
     * }
     * ]
     * },
     * {
     * "index": "access_depth_info",
     * "itemList": [
     * {
     * "key": 5,
     * "value": 217
     * },
     * {
     * "key": 4,
     * "value": 3259
     * },
     * {
     * "key": 3,
     * "value": 32445
     * },
     * {
     * "key": 2,
     * "value": 63542
     * },
     * {
     * "key": 1,
     * "value": 43201
     * }
     * ]
     * }
     * ],
     * "errMsg": "openapi.analysis.getVisitDistribution:ok"
     * }
     *
     * 错误码
     * 错误码 错误描述 解决方案
     * -1 system error 系统繁忙，此时请开发者稍候再试
     * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
     */
    public function getVisitDistribution($begin_date, $end_date)
    {
        $params = array();
        $params['begin_date'] = $begin_date;
        $params['end_date'] = $end_date;
        $rst = $this->_request->post($this->_url . 'datacube/getweanalysisappidvisitdistribution', $params);
        return $this->_client->rst($rst);
    }
}
