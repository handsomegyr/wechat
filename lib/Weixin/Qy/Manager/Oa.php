<?php

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

use Weixin\Qy\Manager\Oa\Calendar;
use Weixin\Qy\Manager\Oa\Schedule;

/**
 * 企业微信审批应用管理
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Oa
{

    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/oa/';

    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 获取日历对象
     *
     * @return \Weixin\Qy\Manager\Oa\Calendar
     */
    public function getGroupChatManager()
    {
        return new Calendar($this->_client);
    }

    /**
     * 获取日程对象
     *
     * @return \Weixin\Qy\Manager\Oa\Schedule
     */
    public function getScheduleManager()
    {
        return new Schedule($this->_client);
    }

    /**
     * 获取审批模板详情
     * 调试工具
     * 企业可通过审批应用或自建应用Secret调用本接口，获取企业微信“审批应用”内指定审批模板的详情。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/oa/gettemplatedetail?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "template_id" : "ZLqk8pcsAoXZ1eYa6vpAgfX28MPdYU3ayMaSPHaaa"
     * }
     * 较早时间创建的模板，id为类似“1910324946027731_1688852032423522_1808577376_15111111111”的数字串。
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证。必须使用审批应用或企业内自建应用的secret获取，获取方式参考：文档-获取access_token
     * template_id 是 模板的唯一标识id。可在“获取审批单据详情”、“审批状态变化回调通知”中获得，也可在审批模板的模板编辑页面浏览器Url链接中获得。
     * 1.审批应用的Secret可获取企业自建模板及第三方服务商添加的模板详情；自建应用的Secret可获取企业自建模板的模板详情。
     * 2.接口调用频率限制为600次/分钟。
     *
     * 返回结果 ：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "template_names": [
     * {
     * "text": "全字段",
     * "lang": "zh_CN"
     * }
     * ],
     * "template_content": {
     * "controls": [
     * {
     * "property": {
     * "control": "Selector",
     * "id": "Selector-15111111111",
     * "title": [
     * {
     * "text": "单选控件",
     * "lang": "zh_CN"
     * }
     * ],
     * "placeholder": [
     * {
     * "text": "这是单选控件的说明",
     * "lang": "zh_CN"
     * }
     * ],
     * "require": 0,
     * "un_print": 0
     * },
     * "config": {
     * "selector": {
     * "type": "single",
     * "exp_type": 0,
     * "options": [
     * {
     * "key": "option-15111111111",
     * "value": [
     * {
     * "text": "选项1",
     * "lang": "zh_CN"
     * }
     * ]
     * },
     * {
     * "key": "option-15222222222",
     * "value": [
     * {
     * "text": "选项2",
     * "lang": "zh_CN"
     * }
     * ]
     * }
     * ]
     * }
     * }
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * template_names 模板名称，若配置了多语言则会包含中英文的模板名称，默认为zh_CN中文
     * template_content 模板控件信息
     * └ controls 模板控件数组。模板详情由多个不同类型的控件组成，控件类型详细说明见附录。
     * └ └ property 模板控件属性，包含了模板内控件的各种属性信息
     * └ └ └ control 控件类型：Text-文本；Textarea-多行文本；Number-数字；Money-金额；Date-日期/日期+时间；Selector-单选/多选；Contact-成员/部门；Tips-说明文字；File-附件；Table-明细；Attendance-假勤控件；Vacation-请假控件
     * └ └ └ id 控件id
     * └ └ └ title 控件名称，若配置了多语言则会包含中英文的控件名称，默认为zh_CN中文
     * └ └ └ placeholder 控件说明，向申请者展示的控件填写说明，若配置了多语言则会包含中英文的控件说明，默认为zh_CN中文
     * └ └ └ require 是否必填：1-必填；0-非必填
     * └ └ └ un_print 是否参与打印：1-不参与打印；0-参与打印
     * └ └ config 模板控件配置，包含了部分控件类型的附加类型、属性，详见附录说明。目前有配置信息的控件类型有：Date-日期/日期+时间；Selector-单选/多选；Contact-成员/部门；Table-明细；Attendance-假勤组件（请假、外出、出差、加班）
     * 附录
     * 附1：Data控件（日期/日期+时间控件）config说明：
     *
     * {
     * "date": {
     * "type": "day"
     * }
     * }
     * 参数 说明
     * date 类型标志，日期/日期+时间控件的config中会包含此参数
     * └ type 时间展示类型：day-日期；hour-日期+时间
     * 附2：Selector控件（单选/多选控件）config说明：
     *
     * {
     * "selector": {
     * "type": "single",
     * "options": [
     * {
     * "key": "option-15111111111",
     * "value": [
     * {
     * "text": "选项1",
     * "lang": "zh_CN"
     * }
     * ]
     * },
     * {
     * "key": "option-15222222222",
     * "value": [
     * {
     * "text": "选项2",
     * "lang": "zh_CN"
     * }
     * ]
     * }
     * ]
     * }
     * }
     * 参数 说明
     * selector 类型标志，单选/多选控件的config中会包含此参数
     * └ type 选择类型：single-单选；multi-多选
     * └ options 选项，包含单选/多选控件中的所有选项，可能有多个
     * └ └ key 选项key，选项的唯一id，可用于发起审批申请，为单选/多选控件赋值
     * └ └ value 选项值，若配置了多语言则会包含中英文的选项值，默认为zh_CN中文
     * 附3：Contact控件（成员/部门控件）config说明：
     *
     * {
     * "contact": {
     * "type": "multi",
     * "mode": "department"
     * }
     * }
     * 参数 说明
     * contact 类型标志，单选/多选控件的config中会包含此参数
     * └ type 选择方式：single-单选；multi-多选
     * └ mode 选择对象：user-成员；department-部门
     * 附4：Table（明细控件）config说明：
     *
     * {
     * "table": {
     * "children": [
     * {
     * "property": {
     * "control": "Text",
     * "id": "Text-15111111111",
     * "title": [
     * {
     * "text": "明细内文本控件",
     * "lang": "zh_CN"
     * }
     * ],
     * "placeholder": [
     * {
     * "text": "这是明细内文本控件的说明",
     * "lang": "zh_CN"
     * }
     * ],
     * "require": 0,
     * "un_print": 0
     * }
     * }
     * ],
     * "stat_field": []
     * }
     * }
     * 参数 说明
     * table 类型标志，明细控件的config中会包含此参数
     * └ children 明细内的子控件，内部结构同controls
     * 附5：Attendance控件（假勤控件）config说明：
     * 说明:【出差】【加班】【外出】模板特有的控件
     *
     * {
     * "attendance": {
     * "date_range": {
     * "type": "hour"
     * },
     * "type": 3
     * }
     * }
     * 参数 说明
     * attendance 类型标志，假勤控件的config中会包含此参数
     * └ date_range 假期控件属性
     * └└ type 时间刻度：hour-精确到分钟, halfday—上午/下午
     * └ type 假勤控件类型：1-请假，3-出差，4-外出，5-加班
     * 附6：Vacation控件（假勤控件）说明：
     * 说明:【请假】模板特有控件, 请假类型强关联审批应用中的假期管理。
     *
     * {
     * "vacation_list": {
     * "item": [{
     * "id": 1,
     * "name": [{
     * "text": "年假",
     * "lang": "zh_CN"
     * }]
     * }, {
     * "id": 2,
     * "name": [{
     * "text": "事假",
     * "lang": "zh_CN"
     * }]
     * }
     * ...//省略
     * ]
     * }
     * }
     * 参数 说明
     * vacation_list 假期类型数组
     * └ item 单个假期类型属性
     * └└ id 假期类型标识id
     * └└ name 假期类型名称，默认zh_CN中文名称
     * 错误说明
     * 错误码 说明
     * 301025 参数错误，请求template_id非法
     * 301026 通用错误码，拉取审批模板内部接口失败
     */
    public function getTemplateDetail($template_id)
    {
        $params = array();
        $params['template_id'] = $template_id;
        $rst = $this->_request->post($this->_url . 'gettemplatedetail', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 提交审批申请
     * 调试工具
     * 企业可通过审批应用或自建应用Secret调用本接口，代应用可见范围内员工在企业微信“审批应用”内提交指定类型的审批申请。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/oa/applyevent?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "creator_userid": "WangXiaoMing",
     * "template_id": "3Tka1eD6v6JfzhDMqPd3aMkFdxqtJMc2ZRioeFXkaaa",
     * "use_template_approver":0,
     * "approver": [
     * {
     * "attr": 2,
     * "userid": ["WuJunJie","WangXiaoMing"]
     * },
     * {
     * "attr": 1,
     * "userid": ["LiuXiaoGang"]
     * }
     * ],
     * "notifyer":[ "WuJunJie","WangXiaoMing" ],
     * "notify_type" : 1,
     * "apply_data": {
     * "contents": [
     * {
     * "control": "Text",
     * "id": "Text-15111111111",
     * "title": [
     * {
     * "text": "文本控件",
     * "lang": "zh_CN"
     * }
     * ],
     * "value": {
     * "text": "文本填写的内容"
     * }
     * }
     * ]
     * },
     * "summary_list": [
     * {
     * "summary_info": [{
     * "text": "摘要第1行",
     * "lang": "zh_CN"
     * }]
     * },
     * {
     * "summary_info": [{
     * "text": "摘要第2行",
     * "lang": "zh_CN"
     * }]
     * },
     * {
     * "summary_info": [{
     * "text": "摘要第3行",
     * "lang": "zh_CN"
     * }]
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证。必须使用审批应用或企业内自建应用的secret获取，获取方式参考：文档-获取access_token
     * creator_userid 是 申请人userid，此审批申请将以此员工身份提交，申请人需在应用可见范围内
     * template_id 是 模板id。可在“获取审批申请详情”、“审批状态变化回调通知”中获得，也可在审批模板的模板编辑页面链接中获得。暂不支持通过接口提交[打卡补卡][调班]模板审批单。
     * use_template_approver 是 审批人模式：0-通过接口指定审批人、抄送人（此时approver、notifyer等参数可用）; 1-使用此模板在管理后台设置的审批流程，支持条件审批。
     * approver 是 审批流程信息，用于指定审批申请的审批流程，支持单人审批、多人会签、多人或签，可能有多个审批节点，仅use_template_approver为0时生效。
     * └ userid 是 审批节点审批人userid列表，若为多人会签、多人或签，需填写每个人的userid
     * └ attr 是 节点审批方式：1-或签；2-会签，仅在节点为多人审批时有效
     * notifyer 否 抄送人节点userid列表，仅use_template_approver为0时生效。
     * notify_type 否 抄送方式：1-提单时抄送（默认值）； 2-单据通过后抄送；3-提单和单据通过后抄送。仅use_template_approver为0时生效。
     * apply_data 是 审批申请数据，可定义审批申请中各个控件的值，其中必填项必须有值，选填项可为空，数据结构同“获取审批申请详情”接口返回值中同名参数“apply_data”
     * └ contents 是 审批申请详情，由多个表单控件及其内容组成，其中包含需要对控件赋值的信息
     * └ └ control 是 控件类型：Text-文本；Textarea-多行文本；Number-数字；Money-金额；Date-日期/日期+时间；Selector-单选/多选；；Contact-成员/部门；Tips-说明文字；File-附件；Table-明细；
     * └ └ id 是 控件id：控件的唯一id，可通过“获取审批模板详情”接口获取
     * └ └ value 是 控件值 ，需在此为申请人在各个控件中填写内容不同控件有不同的赋值参数，具体说明详见附录。模板配置的控件属性为必填时，对应value值需要有值。
     * summary_list 是 摘要信息，用于显示在审批通知卡片、审批列表的摘要信息，最多3行
     * └ summary_info 是 摘要行信息，用于定义某一行摘要显示的内容
     * └ └ text 是 摘要行显示文字，用于记录列表和消息通知的显示，不要超过20个字符
     * └ └ lang 是 摘要行显示语言
     * 接口频率限制 60次/分钟
     * 当模板的控件为必填属性时，表单中对应的控件必须有值。
     *
     * 附录：各控件apply_data/contents/value参数介绍
     * 附1 文本/多行文本控件（control参数为Text或Textarea）
     *
     * {
     * "text": "文本填写的内容"
     * }
     * 参数 说明
     * text 文本内容，在此填写文本/多行文本控件的输入值
     * 附2 数字控件（control参数为Number）
     *
     * {
     * "new_number": "700"
     * }
     * 参数 说明
     * new_number 数字内容，在此填写数字控件的输入值
     * 附3 金额控件（control参数为Money）
     *
     * {
     * "new_money": "700"
     * }
     * 参数 说明
     * new_money 金额内容，在此填写金额控件的输入值
     * 附4 日期/日期+时间控件（control参数为Date）
     *
     * {
     * "date": {
     * "type": "day",
     * "s_timestamp": "1569859200"
     * }
     * }
     * 参数 说明
     * date 日期/日期+时间内容
     * └ type 时间展示类型：day-日期；hour-日期+时间 ，和对应模板控件属性一致
     * └ s_timestamp 时间戳-字符串类型，在此填写日期/日期+时间控件的选择值，以此为准
     * 附5 单选/多选控件（control参数为Selector）
     *
     * {
     * "selector": {
     * "type": "multi",
     * "options": [
     * {
     * "key": "option-15111111111",
     * },
     * {
     * "key": "option-15222222222",
     * }
     * ]
     * }
     * }
     * 参数 说明
     * selector 选择控件内容，即申请人在此控件选择的选项内容
     * └ type 选择方式：single-单选；multi-多选
     * └ options 多选选项，多选属性的选择控件允许输入多个
     * └ └ key 选项key，可通过“获取审批模板详情”接口获得
     * 附6 成员控件（control参数为Contact，且value参数为members）
     *
     * {
     * "members": [
     * {
     * "userid": "WuJunJie",
     * "name": "Jackie"
     * },
     * {
     * "userid": "WangXiaoMing"
     * "name": "Tom"
     * }
     * ]
     * }
     * 参数 说明
     * members 所选成员内容，即申请人在此控件选择的成员，多选模式下可以有多个
     * └ userid 所选成员的userid
     * └ name 成员名
     * 附7 部门控件（control参数为Contact，且value参数为departments）
     *
     * {
     * "departments": [
     * {
     * "openapi_id": "2",
     * "name": "销售部",
     * },
     * {
     * "openapi_id": "3",
     * "name": "生产部",
     * }
     * ]
     * }
     * 参数 说明
     * departments 所选部门内容，即申请人在此控件选择的部门，多选模式下可能有多个
     * └ openapi_id 所选部门id
     * └ name 所选部门名
     * 附8 说明文字控件（control参数为Tips）
     * 此控件不显示在审批详情中，故value为空
     *
     * 附9 附件控件（control参数为File，且value参数为files）
     *
     * {
     * "files": [
     * {
     * "file_id": "1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K1aaa"
     * }
     * ]
     * }
     * 参数 说明
     * files 附件列表
     * └ file_id 文件id，该id为临时素材上传接口返回的的media_id，注：提单后将作为单据内容转换为长期文件存储；目前一个审批申请单，全局仅支持上传6个附件，否则将失败。
     * 附10 明细控件（control参数为Table）
     *
     * {
     * "children": [
     * {
     * "list": [
     * {
     * "control": "Text",
     * "id": "Text-15111111111",
     * "title": [
     * {
     * "text": "明细内文本控件",
     * "lang": "zh_CN"
     * }
     * ],
     * "value": {
     * "text": "明细文本"
     * }
     * }
     * ]
     * }
     * ]
     * }
     * 参数 说明
     * children 明细内容，一个明细控件可能包含多个子明细
     * └ list 子明细列表，在此填写子明细的所有子控件的值，子控件的数据结构同一般控件
     * 附11 假勤组件-请假组件（control参数为Vacation）
     *
     * {
     * "vacation": {
     * "selector": {
     * "type": "single",
     * "options": [
     * {
     * "key": "3",
     * "value": [
     * {
     * "text": "病假",
     * "lang": "zh_CN"
     * }
     * ]
     * }
     * ],
     * "exp_type": 0
     * },
     * "attendance": {
     * "date_range": {
     * "type": "hour",
     * "new_begin": 1568077200,
     * "new_end": 1568368800,
     * "new_duration": 291600
     * },
     * "type": 1
     * }
     * }
     * }
     * 参数 说明
     * vacation 请假内容，即申请人在此组件内选择的请假信息
     * └ selector 请假类型，所选选项与假期管理关联，为假期管理中的假期类型
     * └ └ type 选择方式：single-单选；multi-多选，在假勤控件中固定为单选
     * └ └ options 用户所选选项
     * └ └ └ key 选项key，选项的唯一id，可通过“获取审批模板详情”接口获得vacation_list中item的id值
     * └ └ └ value 选项值，若配置了多语言则会包含中英文的选项值
     * └ attendance 假勤组件
     * └ └ date_range 假勤组件时间选择范围
     * └ └ └ type 时间展示类型：day-日期；hour-日期+时间
     * └ └ └ new_begin 开始时间戳
     * └ └ └ new_end 结束时间戳
     * └ └ └ new_duration 请假时长，单位秒
     * └ └ type 假勤组件类型：1-请假；3-出差；4-外出；5-加班
     * 附12 假勤组件-出差/外出/加班组件（control参数为Attendance）
     *
     * {
     * "attendance": {
     * "date_range": {
     * "type": "halfday",
     * "new_begin": 1570550400,
     * "new_end": 1570593600,
     * "new_duration": 86400
     * },
     * "type": 4
     * }
     * }
     * 参数 说明
     * attendance 假勤内容，即申请人在此组件内选择的假勤信息
     * └ date_range 假勤组件时间选择范围
     * └ └ type 时间展示类型：day-日期；hour-日期+时间
     * └ └ new_begin 开始时间戳，
     * └ └ new_end 结束时间戳
     * └ └ new_duration 请假时长，单位秒
     * └ type 假勤组件类型：1-请假；3-出差；4-外出；5-加班
     * 错误说明
     * 错误码 说明
     * 301055 无审批应用权限,或者提单者不在审批应用/自建应用的可见范围
     * 301056 审批应用已停用
     * 301025 提交审批单请求参数错误
     * 301057 通用错误码，提交审批单内部接口失败
     */
    public function applyEvent($applyevent)
    {
        $params = $applyevent->getParams();
        $rst = $this->_request->post($this->_url . 'applyevent', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 批量获取审批单号
     * 调试工具
     * 审批应用及有权限的自建应用，可通过Secret调用本接口，以获取企业一段时间内企业微信“审批应用”单据的审批编号，支持按模板类型、申请人、部门、申请单审批状态等条件筛选。
     * 自建应用调用此接口，需在“管理后台-应用管理-审批-API-审批数据权限”中，授权应用允许提交审批单据。
     *
     * 一次拉取调用最多拉取100个审批记录，可以通过多次拉取的方式来满足需求，但调用频率不可超过600次/分。
     *
     * 推荐使用此接口获取审批数据，旧接口后续将不再维护。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/oa/getapprovalinfo?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "starttime" : "1569546000",
     * "endtime" : "1569718800",
     * "cursor" : 0 ,
     * "size" : 100 ,
     * "filters" : [
     * {
     * "key": "template_id",
     * "value": "ZLqk8pcsAoaXZ1eY56vpAgfX28MPdYU3ayMaSPHaaa"
     * },
     * {
     * "key" : "creator",
     * "value" : "WuJunJie"
     * },
     * {
     * "key" : "department",
     * "value" : "1688852032415111"
     * },
     * {
     * "key" : "sp_status",
     * "value" : "1"
     * }
     * ]
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证。必须使用审批应用或企业内自建应用的secret获取，获取方式参考：文档-获取access_token
     * starttime 是 开始时间，UNix时间戳
     * endtime 是 结束时间，Unix时间戳
     * cursor 是 分页查询游标，默认为0，后续使用返回的next_cursor进行分页拉取
     * size 是 一次请求拉取审批单数量，默认值为100，上限值为100
     * filters 否 筛选条件，可对批量拉取的审批申请设置约束条件，支持设置多个条件
     * └ key 否 筛选类型，包括：
     * template_id - 模板类型/模板id；
     * creator - 申请人；
     * department - 审批单提单者所在部门；
     * sp_status - 审批状态。
     *
     * 注意:
     * 仅“部门”支持同时配置多个筛选条件。
     * 不同类型的筛选条件之间为“与”的关系，同类型筛选条件之间为“或”的关系
     * └ value 否 筛选值，对应为：template_id-模板id；creator-申请人userid ；department-所在部门id；sp_status-审批单状态（1-审批中；2-已通过；3-已驳回；4-已撤销；6-通过后撤销；7-已删除；10-已支付）
     * 1 接口频率限制 600次/分钟
     * 2 请求的参数endtime需要大于startime， 起始时间跨度不能超过31天；
     *
     * 返回结果 ：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "sp_no_list": [
     * "201909270001",
     * "201909270002",
     * "201909270003"
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * sp_no_list 审批单号列表，包含满足条件的审批申请
     * next_cursor 后续请求查询的游标，当返回结果没有该字段时表示审批单已经拉取完
     * 错误说明
     * 错误码 说明
     * 301055 无审批应用数据拉取权限
     * 301025 请求参数错误
     * 301026 批量拉取审批单内部接口失败
     */
    public function getApprovalInfo($starttime, $endtime, $cursor, $size, array $filters)
    {
        $params = array();
        $params['starttime'] = $starttime;
        $params['endtime'] = $endtime;
        $params['cursor'] = $cursor;
        $params['size'] = $size;
        $params['filters'] = $filters;
        $rst = $this->_request->post($this->_url . 'getapprovalinfo', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取审批申请详情
     * 调试工具
     * 企业可通过审批应用或自建应用Secret调用本接口，根据审批单号查询企业微信“审批应用”的审批申请详情。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/oa/getapprovaldetail?access_token=ACCESS_TOKEN
     *
     * 请求示例：
     *
     * {
     * "sp_no" : 201909270001
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证。必须使用审批应用或企业内自建应用的secret获取，获取方式参考：文档-获取access_token
     * sp_no 是 审批单编号。
     * 接口频率限制 600次/分钟
     *
     * 返回结果 ：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "info": {
     * "sp_no": "201909270002",
     * "sp_name": "全字段",
     * "sp_status": 1,
     * "template_id": "Bs5KJ2NT4ncf4ZygaE8MB3779yUW8nsMaJd3mmE9v",
     * "apply_time": 1569584428,
     * "applyer": {
     * "userid": "WuJunJie",
     * "partyid": "2"
     * },
     * "sp_record": [{
     * "sp_status": 1,
     * "approverattr": 1,
     * "details": [{
     * "approver": {
     * "userid": "WuJunJie"
     * },
     * "speech": "",
     * "sp_status": 1,
     * "sptime": 0,
     * "media_id": []
     * },
     * {
     * "approver": {
     * "userid": "WangXiaoMing"
     * },
     * "speech": "",
     * "sp_status": 1,
     * "sptime": 0,
     * "media_id": []
     * }
     * ]
     * }],
     * "notifyer": [{
     * "userid": "LiuXiaoGang"
     * }],
     * "apply_data": {
     * "contents": [{
     * "control": "Text",
     * "id": "Text-15111111111",
     * "title": [{
     * "text": "文本控件",
     * "lang": "zh_CN"
     * }],
     * "value": {
     * "text": "文本填写的内容",
     * "tips": [],
     * "members": [],
     * "departments": [],
     * "files": [],
     * "children": [],
     * "stat_field": []
     * }
     * }]
     * },
     * "comments": [{
     * "commentUserInfo": {
     * "userid": "WuJunJie"
     * },
     * "commenttime": 1569584111,
     * "commentcontent": "这是备注信息",
     * "commentid": "6741314136717778040",
     * "media_id": [
     * "WWCISP_Xa1dXIyC9VC2vGTXyBjUXh4GQ31G-a7jilEjFjkYBfncSJv0kM1cZAIXULWbbtosVqA7hprZIUkl4GP0DYZKDrIay9vCzeQelmmHiczwfn80v51EtuNouzBhUBTWo9oQIIzsSftjaVmd4EC_dj5-rayfDl6yIIRdoUs1V_Gz6Pi3yH37ELOgLNAPYUSJpA6V190Xunl7b0s5K5XC9c7eX5vlJek38rB_a2K-kMFMiM1mHDqnltoPa_NT9QynXuHi"
     * ]
     * }]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * sp_no 审批编号
     * sp_name 审批申请类型名称（审批模板名称）
     * sp_status 申请单状态：1-审批中；2-已通过；3-已驳回；4-已撤销；6-通过后撤销；7-已删除；10-已支付
     * template_id 审批模板id。可在“获取审批申请详情”、“审批状态变化回调通知”中获得，也可在审批模板的模板编辑页面链接中获得。
     * apply_time 审批申请提交时间,Unix时间戳
     * applyer 申请人信息
     * └ userid 申请人userid
     * └ partyid 申请人所在部门id
     * sp_record 审批流程信息，可能有多个审批节点。
     * └ sp_status 审批节点状态：1-审批中；2-已同意；3-已驳回；4-已转审
     * └ approverattr 节点审批方式：1-或签；2-会签
     * └ details 审批节点详情,一个审批节点有多个审批人
     * └ └ approver 分支审批人
     * └ └ └ userid 分支审批人userid
     * └ └ speech 审批意见
     * └ └ sp_status 分支审批人审批状态：1-审批中；2-已同意；3-已驳回；4-已转审
     * └ └ sptime 节点分支审批人审批操作时间戳，0表示未操作
     * └ └ media_id 节点分支审批人审批意见附件，media_id具体使用请参考：文档-获取临时素材
     * notifyer 抄送信息，可能有多个抄送节点
     * └ userid 节点抄送人userid
     * apply_data 审批申请数据
     * └ contents 审批申请详情，由多个表单控件及其内容组成
     * └ └ control 控件类型：Text-文本；Textarea-多行文本；Number-数字；Money-金额；Date-日期/日期+时间；Selector-单选/多选；；Contact-成员/部门；Tips-说明文字；File-附件；Table-明细；Attendance-假勤；Vacation-请假；PunchCorrection-补卡;DateRange-时长
     * └ └ id 控件id
     * └ └ title 控件名称 ，若配置了多语言则会包含中英文的控件名称
     * └ └ value 控件值 ，包含了申请人在各种类型控件中输入的值，不同控件有不同的值，具体说明详见附录
     * comments 审批申请备注信息，可能有多个备注节点
     * └ commentUserInfo 备注人信息
     * └ └ userid 备注人userid
     * └ commenttime 备注提交时间戳，Unix时间戳
     * └ commentcontent 备注文本内容
     * └ commentid 备注id
     * └ media_id 备注附件id，可能有多个，media_id具体使用请参考：文档-获取临时素材
     * 附录：各控件apply_data/contents/value参数介绍
     * 附1 文本/多行文本控件（control参数为Text或Textarea）
     *
     * {
     * "text": "文本填写的内容"
     * }
     * 参数 说明
     * text 文本内容，即申请人在此控件填写的文本内容
     * 附2 数字控件（control参数为Number）
     *
     * {
     * "new_number": "700"
     * }
     * 参数 说明
     * new_number 数字内容，即申请人在此控件填写的数字内容
     * 附3 金额控件（control参数为Money）
     *
     * {
     * "new_money": "700"
     * }
     * 参数 说明
     * new_money 金额内容，即申请人在此控件填写的金额内容
     * 附4 日期/日期+时间控件（control参数为Date）
     *
     * {
     * "date": {
     * "type": "day",
     * "s_timestamp": "1569859200"
     * }
     * }
     * 参数 说明
     * date 日期/日期+时间内容，即申请人在此控件选择的 日期/日期+时间内容
     * └ type 时间展示类型：day-日期；hour-日期+时间
     * └ s_timestamp 时间戳，字符串类型
     * 附5 单选/多选控件（control参数为Selector）
     *
     * {
     * "selector": {
     * "type": "multi",
     * "options": [
     * {
     * "key": "option-15111111111",
     * "value": [
     * {
     * "text": "选项1",
     * "lang": "zh_CN"
     * }
     * ]
     * },
     * {
     * "key": "option-15222222222",
     * "value": [
     * {
     * "text": "选项2",
     * "lang": "zh_CN"
     * }
     * ]
     * }
     * ]
     * }
     * }
     * 参数 说明
     * selector 选择内容，即申请人在此控件选择的选项内容
     * └ type 选择类型：single-单选；multi-多选
     * └ options 申请人所选择的选项，多选情况下可能有多个（仅包含申请人说选择的选项，并非所有选项，若需要了解所有选项，需使用“获取审批模板详情”接口）
     * └ └ key 选项key，选项的唯一id，可通过“获取审批模板详情”接口获得
     * └ └ value 选项值，若配置了多语言则会包含中英文的选项值
     * 附6 成员控件（control参数为Contact，且value参数为members）
     *
     * {
     * "members": [
     * {
     * "userid": "WuJunJie",
     * "name": "Jackie"
     * },
     * {
     * "userid": "WangXiaoMing"
     * "name": "Tom"
     * }
     * ]
     * }
     * 参数 说明
     * members 成员内容，即申请人在此控件选择的成员，多选模式下可能有多个
     * └ userid 成员的userid
     * └ name 成员名
     * 附7 部门控件（control参数为Contact，且value参数为departments）
     *
     * {
     * "departments": [
     * {
     * "openapi_id": "2",
     * "name": "销售部",
     * },
     * {
     * "openapi_id": "3",
     * "name": "生产部",
     * }
     * ]
     * }
     * 参数 说明
     * departments 部门内容，即申请人在此控件选择的部门，多选模式下可能有多个
     * └ openapi_id 部门id
     * └ name 部门名
     * 附8 说明文字控件（control参数为Tips）
     * 此控件不显示在审批详情中，故value为空
     *
     * 附9 附件控件（control参数为File）
     *
     * {
     * "files": [
     * {
     * "file_id": "WWCISP_v2z8qZENw2qwSiNroVKykbxxMXvmI1lELzG-fo25Y9n1duozezKEu6zSIvOHPCd9_8s934AJncRz5f9G4E_nCQonUHLdiAnCLjfZQQwVaiG7krKzyGB1MpYa9ZVkk0gQ7P8HvO_SOdwzLwpyUZ3Tm2ApyoO_78nTM-iEkf_TILqXuYxKd7ByYL34wMA9Czf6Iy151tHbcYNvbNZZHTnL4UMQdohJ_MPYA2Wz00IebZb3_UuIk5MdJSH_IKlZn9Ms5"
     * },
     * {
     * "file_id": "WWCISP_gZ3BMg5hwI1Adi16NwzJgpi9zp6QQjMdYcuemVWBeHnmMK3QJOYiIIkHvRIh0ysZcAo6gJp069o5tx7qxVzin1Q9LKswff624E1qCCmt088ISBVPScoqEiG4YTI_Kltrqn7b0wvMTudd9lIE3ywgHatPRWKxsHNsSxEY_FuaFWlGHzxcYKNq_LIfVBXZGji-C5bXp23MwpTcCXYfWPfSEpEeXW5c5sQscY_MeW5uc0gITpeFKFXARXmKC62_u7Ln"
     * }
     * ]
     * }
     * 参数 说明
     * files 文件内容，即申请人在此控件上传的文件内容，可能有多个
     * └ file_id 文件的media_id，具体使用请参考：文档-获取临时素材
     * 附10 明细控件（control参数为Table）
     *
     * {
     * "children": [
     * {
     * "list": [
     * {
     * "control": "Text",
     * "id": "Text-15111111111",
     * "title": [
     * {
     * "text": "明细内文本控件",
     * "lang": "zh_CN"
     * }
     * ],
     * "value": {
     * "text": "明细文本"
     * }
     * }
     * ]
     * }
     * ]
     * }
     * 参数 说明
     * children 明细内容，一个明细控件可能包含多个子明细
     * └ list 子明细列表，包含了申请人在子明细的所有子控件中填写的内容，子控件的数据接口同一般控件
     * 附11 假勤组件-请假组件（control参数为Vacation）
     *
     * {
     * "vacation": {
     * "selector": {
     * "type": "single",
     * "options": [
     * {
     * "key": "3",
     * "value": [
     * {
     * "text": "病假",
     * "lang": "zh_CN"
     * }
     * ]
     * }
     * ],
     * "exp_type": 0
     * },
     * "attendance": {
     * "date_range": {
     * "type": "hour",
     * "new_begin": 1568077200,
     * "new_end": 1568368800,
     * "new_duration": 291600
     * },
     * "type": 1
     * }
     * }
     * }
     * 参数 说明
     * vacation 请假内容，即申请人在此组件内选择的请假信息
     * └ selector 请假类型，所选选项与假期管理关联，为假期管理中的假期类型
     * └ └ type 选择类型：single-单选；multi-多选，在假勤控件中固定为单选
     * └ └ options 用户所选选项
     * └ └ └ key 选项key，选项的唯一id，可通过“获取审批模板详情”接口获得
     * └ └ └ value 选项值，若配置了多语言则会包含中英文的选项值
     * └ attendance 假勤组件
     * └ └ date_range 假勤组件时间选择范围
     * └ └ └ type 时间展示类型：day-日期；hour-日期+时间
     * └ └ └ new_begin 开始时间
     * └ └ └ new_end 结束时间
     * └ └ └ new_duration 请假时长
     * └ └ type 假勤组件类型：1-请假；2-补卡；3-出差；4-外出；5-加班
     * 附12 假勤组件-出差/外出/加班组件（control参数为Attendance）
     *
     * {
     * "attendance": {
     * "date_range": {
     * "type": "halfday",
     * "new_begin": 1570550400,
     * "new_end": 1570593600,
     * "new_duration": 86400
     * },
     * "type": 4
     * }
     * }
     * 参数 说明
     * attendance 假勤内容，即申请人在此组件内选择的假勤信息
     * └ date_range 假勤组件时间选择范围
     * └ └ type 时间展示类型：day-日期；hour-日期+时间
     * └ └ new_begin 开始时间，unix时间戳
     * └ └ new_end 结束时间，unix时间戳
     * └ └ new_duration 出差/外出/加时长，单位秒
     * └ type 假勤组件类型：1-请假；2-补卡；3-出差；4-外出；5-加班
     * 附13 补卡组件（control参数为PunchCorrection）
     *
     * {
     * "punch_correction": {
     * "state":"迟到"，
     * "time":1570550400
     * }
     * }
     * 参数 说明
     * punch_correction 补卡信息
     * └ state 异常状态说明
     * └ time 补卡时间，Unix时间戳
     * 附14 时长组件（control参数为DateRange）
     *
     * {
     * "date_range": {
     * "type": "halfday",
     * "new_begin": 1570550400,
     * "new_end": 1570593600,
     * "new_duration": 86400
     * }
     * }
     * 参数 说明
     * date_range 时长组件
     * └ type 时间展示类型：day-日期；hour-日期+时间
     * └ new_begin 开始时间,unix时间戳
     * └ new_end 结束时间，unix时间戳
     * └ new_duration 时长范围， 单位秒
     * 错误说明
     * 错误码 说明
     * 301055 无审批应用数据拉取权限
     * 301025 请求参数错误
     * 301026 拉取审批申请详情内部接口失败
     */
    public function getApprovalDetail($sp_no)
    {
        $params = array();
        $params['sp_no'] = $sp_no;
        $rst = $this->_request->post($this->_url . 'getapprovaldetail', $params);
        return $this->_client->rst($rst);
    }
}
