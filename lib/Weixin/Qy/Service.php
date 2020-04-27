<?php

/**
 * 企业授权应用
 * 企业微信的系统管理员可以授权安装第三方应用，安装后企业微信后台会将授权凭证、授权信息等推送给服务商后台。
 * 授权可以有两种发起方式：
 
 * 从服务商网站发起
 * 从企业微信应用市场发起
 * 以上两种授权发起方式并不冲突，服务商可以同时支持。
 * @author guoyongrong <handsomegyr@126.com>
 * https://work.weixin.qq.com/api/doc/90001/90143/90597
 * https://work.weixin.qq.com/api/doc/10975
 *
 */

namespace Weixin\Qy;

use Weixin\Http\Request;
use \Weixin\Qy\Manager\Service\Contact;
use \Weixin\Qy\Manager\Service\Media;
use \Weixin\Qy\Manager\Service\Batch;

class Service
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/service/';

    protected $_request = null;

    public function __construct()
    {
        $this->_request = $this->getRequest();
    }

    /**
     * 初始化认证的http请求对象
     */
    protected function initRequest()
    {
        $this->_request = new Request();
    }

    /**
     * 获取请求对象
     *
     * @return \Weixin\Http\Request
     */
    public function getRequest()
    {
        if (empty($this->_request)) {
            $this->initRequest();
        }
        return $this->_request;
    }

    /**
     * 获取服务商凭证
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_provider_token
     *
     * 请求包体：
     *
     * {
     * "corpid":"xxxxx",
     * "provider_secret":"xxx"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * corpid 是 服务商的corpid
     * provider_secret 是 服务商的secret，在服务商管理后台可见
     * 返回结果：
     *
     * {
     * "provider_access_token":"enLSZ5xxxxxxJRL",
     * "expires_in":7200
     * }
     * 参数说明：
     *
     * 参数 说明
     * provider_access_token 服务商的access_token，最长为512字节。
     * expires_in provider_access_token有效期（秒）
     * 若调用失败，会返回errcode及errmsg字段。（开发者根据errcode字段存在且值非0，可认为是调用失败）
     *
     * 注意事项：
     * 开发者需要缓存provider_access_token，用于后续接口的调用（注意：不能频繁调用get_provider_token接口，否则会受到频率拦截）。当provider_access_token失效或过期时，需要重新获取。
     *
     * provider_access_token的有效期通过返回的expires_in来传达，正常情况下为7200秒（2小时），有效期内重复获取返回相同结果，过期后获取会返回新的provider_access_token。
     * provider_access_token至少保留512字节的存储空间。
     * 企业微信可能会出于运营需要，提前使provider_access_token失效，开发者应实现provider_access_token失效时重新获取的逻辑。
     */
    public function getProviderToken($corpid, $provider_secret)
    {
        $params = array();
        $params['corpid'] = $corpid;
        $params['provider_secret'] = $provider_secret;
        $rst = $this->_request->post($this->_url . 'get_provider_token', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 获取第三方应用凭证
     * 该API用于获取第三方应用凭证（suite_access_token）。
     *
     * 由于第三方服务商可能托管了大量的企业，其安全问题造成的影响会更加严重，故API中除了合法来源IP校验之外，还额外增加了suite_ticket作为安全凭证。
     * 获取suite_access_token时，需要suite_ticket参数。suite_ticket由企业微信后台定时推送给“指令回调URL”，每十分钟更新一次，见推送suite_ticket。
     * suite_ticket实际有效期为30分钟，可以容错连续两次获取suite_ticket失败的情况，但是请永远使用最新接收到的suite_ticket。
     * 通过本接口获取的suite_access_token有效期为2小时，开发者需要进行缓存，不可频繁获取。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_suite_token
     *
     * 请求包体：
     *
     * {
     * "suite_id":"id_value" ,
     * "suite_secret": "secret_value",
     * "suite_ticket": "ticket_value"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * suite_id 是 以ww或wx开头应用id（对应于旧的以tj开头的套件id）
     * suite_secret 是 应用secret
     * suite_ticket 是 企业微信后台推送的ticket
     * 返回结果：
     *
     * {
     * "errcode":0 ,
     * "errmsg":"ok" ,
     * "suite_access_token":"61W3mEpU66027wgNZ_MhGHNQDHnFATkDa9-2llMBjUwxRSNPbVsMmyD-yq8wZETSoE5NQgecigDrSHkPtIYA",
     * "expires_in":7200
     * }
     * 参数说明：
     *
     * 参数 说明
     * suite_access_token 第三方应用access_token,最长为512字节
     * expires_in 有效期
     *
     * @return mixed
     */
    public function getSuiteToken($suite_id, $suite_secret, $suite_ticket)
    {
        $params = array(
            'suite_id' => $suite_id,
            'suite_secret' => $suite_secret,
            'suite_ticket' => $suite_ticket
        );
        $rst = $this->_request->post($this->_url . 'get_suite_token', $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取预授权码
     * 该API用于获取预授权码。预授权码用于企业授权时的第三方服务商安全验证。
     *
     * 请求方式：GET（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_pre_auth_code?suite_access_token=SUITE_ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * suite_access_token 是 第三方应用access_token,最长为512字节
     * 返回结果：
     *
     * {
     * "errcode":0 ,
     * "errmsg":"ok" ,
     * "pre_auth_code":"Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw",
     * "expires_in":1200
     * }
     * 参数说明：
     *
     * 参数 说明
     * pre_auth_code 预授权码,最长为512字节
     * expires_in 有效期
     */
    public function getPreAuthCode($suite_access_token)
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'get_pre_auth_code?suite_access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 设置授权配置
     * 该接口可对某次授权进行配置。可支持测试模式（应用未发布时）。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/set_session_info?suite_access_token=SUITE_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "pre_auth_code":"xxxxx",
     * "session_info":
     * {
     * "appid":[1,2,3],
     * "auth_type":1
     * }
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * suite_access_token 是 第三方应用access_token
     * pre_auth_code 是 预授权码
     * session_info 是 本次授权过程中需要用到的会话信息
     * appid 否 允许进行授权的应用id，如1、2、3， 不填或者填空数组都表示允许授权套件内所有应用（仅旧的多应用套件可传此参数，新开发者可忽略）
     * auth_type 否 授权类型：0 正式授权， 1 测试授权。 默认值为0。注意，请确保应用在正式发布后的授权类型为“正式授权”
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     */
    public function setSessionInfo($suite_access_token, $pre_auth_code, array $session_info)
    {
        $params = array(
            'pre_auth_code' => $pre_auth_code,
            'session_info' => $session_info
        );
        $rst = $this->_request->post($this->_url . 'set_session_info?suite_access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取企业永久授权码
     * 该API用于使用临时授权码换取授权方的永久授权码，并换取授权信息、企业access_token，临时授权码一次有效。建议第三方以userid为主键，来建立自己的管理员账号。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_permanent_code?suite_access_token=SUITE_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_code": "auth_code_value"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * auth_code 是 临时授权码，会在授权成功时附加在redirect_uri中跳转回第三方服务商网站，或通过回调推送给服务商。长度为64至512个字节
     * 返回结果：
     *
     * {
     * "errcode":0 ,
     * "errmsg":"ok" ,
     * "access_token": "xxxxxx",
     * "expires_in": 7200,
     * "permanent_code": "xxxx",
     * "auth_corp_info":
     * {
     * "corpid": "xxxx",
     * "corp_name": "name",
     * "corp_type": "verified",
     * "corp_square_logo_url": "yyyyy",
     * "corp_user_max": 50,
     * "corp_agent_max": 30,
     * "corp_full_name":"full_name",
     * "verified_end_time":1431775834,
     * "subject_type": 1,
     * "corp_wxqrcode": "zzzzz",
     * "corp_scale": "1-50人",
     * "corp_industry": "IT服务",
     * "corp_sub_industry": "计算机软件/硬件/信息服务",
     * "location":"广东省广州市"
     * },
     * "auth_info":
     * {
     * "agent" :
     * [
     * {
     * "agentid":1,
     * "name":"NAME",
     * "round_logo_url":"xxxxxx",
     * "square_logo_url":"yyyyyy",
     * "appid":1,
     * "privilege":
     * {
     * "level":1,
     * "allow_party":[1,2,3],
     * "allow_user":["zhansan","lisi"],
     * "allow_tag":[1,2,3],
     * "extra_party":[4,5,6],
     * "extra_user":["wangwu"],
     * "extra_tag":[4,5,6]
     * }
     * },
     * {
     * "agentid":2,
     * "name":"NAME2",
     * "round_logo_url":"xxxxxx",
     * "square_logo_url":"yyyyyy",
     * "appid":5
     * }
     * ]
     * },
     * "auth_user_info":
     * {
     * "userid":"aa",
     * "name":"xxx",
     * "avatar":"http://xxx"
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * access_token 授权方（企业）access_token,最长为512字节
     * expires_in 授权方（企业）access_token超时时间
     * permanent_code 企业微信永久授权码,最长为512字节
     * auth_corp_info 授权方企业信息
     * corpid 授权方企业微信id
     * corp_name 授权方企业微信名称
     * corp_type 授权方企业微信类型，认证号：verified, 注册号：unverified
     * corp_square_logo_url 授权方企业微信方形头像
     * corp_user_max 授权方企业微信用户规模
     * corp_full_name 所绑定的企业微信主体名称(仅认证过的企业有)
     * subject_type 企业类型，1. 企业; 2. 政府以及事业单位; 3. 其他组织, 4.团队号
     * verified_end_time 认证到期时间
     * corp_wxqrcode 授权企业在微工作台（原企业号）的二维码，可用于关注微工作台
     * corp_scale 企业规模。当企业未设置该属性时，值为空
     * corp_industry 企业所属行业。当企业未设置该属性时，值为空
     * corp_sub_industry 企业所属子行业。当企业未设置该属性时，值为空
     * location 企业所在地信息, 为空时表示未知
     * auth_info 授权信息。如果是通讯录应用，且没开启实体应用，是没有该项的。通讯录应用拥有企业通讯录的全部信息读写权限
     * agent 授权的应用信息，注意是一个数组，但仅旧的多应用套件授权时会返回多个agent，对新的单应用授权，永远只返回一个agent
     * agentid 授权方应用id
     * name 授权方应用名字
     * square_logo_url 授权方应用方形头像
     * round_logo_url 授权方应用圆形头像
     * appid 旧的多应用套件中的对应应用id，新开发者请忽略
     * privilege 应用对应的权限
     * allow_party 应用可见范围（部门）
     * allow_tag 应用可见范围（标签）
     * allow_user 应用可见范围（成员）
     * extra_party 额外通讯录（部门）
     * extra_user 额外通讯录（成员）
     * extra_tag 额外通讯录（标签）
     * level 权限等级。
     * 1:通讯录基本信息只读
     * 2:通讯录全部信息只读
     * 3:通讯录全部信息读写
     * 4:单个基本信息只读
     * 5:通讯录全部信息只写
     * auth_user_info 授权管理员的信息
     * userid 授权管理员的userid，可能为空（内部管理员一定有，不可更改）
     * name 授权管理员的name，可能为空（内部管理员一定有，不可更改）
     * avatar 授权管理员的头像url
     */
    public function getPermanentCode($suite_access_token, $auth_code)
    {
        $params = array(
            'auth_code' => $auth_code
        );
        $rst = $this->_request->post($this->_url . 'get_permanent_code?suite_access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取企业授权信息
     * 该API用于通过永久授权码换取企业微信的授权信息。 永久code的获取，是通过临时授权码使用get_permanent_code 接口获取到的permanent_code。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_auth_info?suite_access_token=SUITE_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid": "auth_corpid_value",
     * "permanent_code": "code_value"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * auth_corpid 是 授权方corpid
     * permanent_code 是 永久授权码，通过get_permanent_code获取
     * 返回结果：
     *
     * {
     * "errcode":0 ,
     * "errmsg":"ok" ,
     * "auth_corp_info":
     * {
     * "corpid": "xxxx",
     * "corp_name": "name",
     * "corp_type": "verified",
     * "corp_square_logo_url": "yyyyy",
     * "corp_user_max": 50,
     * "corp_agent_max": 30,
     * "corp_full_name":"full_name",
     * "verified_end_time":1431775834,
     * "subject_type": 1，
     * "corp_wxqrcode": "zzzzz",
     * "corp_scale": "1-50人",
     * "corp_industry": "IT服务",
     * "corp_sub_industry": "计算机软件/硬件/信息服务"
     * "location":"广东省广州市"
     * },
     * "auth_info":
     * {
     * "agent" :
     * [
     * {
     * "agentid":1,
     * "name":"NAME",
     * "round_logo_url":"xxxxxx",
     * "square_logo_url":"yyyyyy",
     * "appid":1,
     * "privilege":
     * {
     * "level":1,
     * "allow_party":[1,2,3],
     * "allow_user":["zhansan","lisi"],
     * "allow_tag":[1,2,3],
     * "extra_party":[4,5,6],
     * "extra_user":["wangwu"],
     * "extra_tag":[4,5,6]
     * }
     * },
     * {
     * "agentid":2,
     * "name":"NAME2",
     * "round_logo_url":"xxxxxx",
     * "square_logo_url":"yyyyyy",
     * "appid":5
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * auth_corp_info 授权方企业信息
     * corpid 授权方企业微信id
     * corp_name 授权方企业微信名称
     * corp_type 授权方企业微信类型，认证号：verified, 注册号：unverified
     * corp_square_logo_url 授权方企业微信方形头像
     * corp_user_max 授权方企业微信用户规模
     * corp_full_name 所绑定的企业微信主体名称（仅认证过的企业有）
     * subject_type 企业类型，1. 企业; 2. 政府以及事业单位; 3. 其他组织, 4.团队号
     * verified_end_time 认证到期时间
     * corp_wxqrcode 授权企业在微工作台（原企业号）的二维码，可用于关注微工作台
     * corp_scale 企业规模。当企业未设置该属性时，值为空
     * corp_industry 企业所属行业。当企业未设置该属性时，值为空
     * corp_sub_industry 企业所属子行业。当企业未设置该属性时，值为空
     * location 企业所在地信息, 为空时表示未知
     * auth_info 授权信息。如果是通讯录应用，且没开启实体应用，是没有该项的。通讯录应用拥有企业通讯录的全部信息读写权限
     * agent 授权的应用信息，注意是一个数组，但仅旧的多应用套件授权时会返回多个agent，对新的单应用授权，永远只返回一个agent
     * agentid 授权方应用id
     * name 授权方应用名字
     * square_logo_url 授权方应用方形头像
     * round_logo_url 授权方应用圆形头像
     * appid 旧的多应用套件中的对应应用id，新开发者请忽略
     * privilege 应用对应的权限
     * allow_party 应用可见范围（部门）
     * allow_tag 应用可见范围（标签）
     * allow_user 应用可见范围（成员）
     * extra_party 额外通讯录（部门）
     * extra_user 额外通讯录（成员）
     * extra_tag 额外通讯录（标签）
     * level 权限等级。
     * 1:通讯录基本信息只读
     * 2:通讯录全部信息只读
     * 3:通讯录全部信息读写
     * 4:单个基本信息只读
     * 5:通讯录全部信息只写
     */
    public function getAuthInfo($suite_access_token, $auth_corpid, $permanent_code)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'permanent_code' => $permanent_code
        );
        $rst = $this->_request->post($this->_url . 'get_auth_info?suite_access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取企业access_token
     * 第三方服务商在取得企业的永久授权码后，通过此接口可以获取到企业的access_token。
     * 获取后可通过通讯录、应用、消息等企业接口来运营这些应用。
     *
     * 此处获得的企业access_token与企业获取access_token拿到的token，本质上是一样的，只不过获取方式不同。获取之后，就跟普通企业一样使用token调用API接口
     *
     * 调用企业接口所需的access_token获取方法如下。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_corp_token?suite_access_token=SUITE_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid": "auth_corpid_value",
     * "permanent_code": "code_value"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * auth_corpid 是 授权方corpid
     * permanent_code 是 永久授权码，通过get_permanent_code获取
     * 返回结果：
     *
     * {
     * "errcode":0 ,
     * "errmsg":"ok" ,
     * "access_token": "xxxxxx",
     * "expires_in": 7200
     * }
     * 参数说明：
     *
     * 参数 说明
     * access_token 授权方（企业）access_token,最长为512字节
     * expires_in 授权方（企业）access_token超时时间
     */
    public function getCorpToken($suite_access_token, $auth_corpid, $permanent_code)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'permanent_code' => $permanent_code
        );
        $rst = $this->_request->post($this->_url . 'get_corp_token?suite_access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取应用的管理员列表
     * 第三方服务商可以用此接口获取授权企业中某个第三方应用的管理员列表(不包括外部管理员)，以便服务商在用户进入应用主页之后根据是否管理员身份做权限的区分。
     *
     * 该应用必须与SUITE_ACCESS_TOKEN对应的suiteid对应，否则没权限查看
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_admin_list?suite_access_token=SUITE_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_corpid": "auth_corpid_value",
     * "agentid": 1000046
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * auth_corpid 是 授权方corpid
     * agentid 是 授权方安装的应用agentid
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "admin":[
     * {"userid":"zhangsan","auth_type":1},
     * {"userid":"lisi","auth_type":0}
     * ]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码，0表示正常返回，可读取admin的管理员列表
     * errmsg 错误说明
     * admin 应用的管理员列表（不包括外部管理员）
     * userid 管理员的userid
     * auth_type 该管理员对应用的权限：0=发消息权限，1=管理权限
     */
    public function getAdminList($suite_access_token, $auth_corpid, $agentid)
    {
        $params = array(
            'auth_corpid' => $auth_corpid,
            'agentid' => $agentid
        );
        $rst = $this->_request->post($this->_url . 'get_admin_list?suite_access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * https://work.weixin.qq.com/api/doc/90001/90143/90597
     * 引导用户进入授权页
     * 第三方服务商在自己的网站中放置“企业微信应用授权”的入口，引导企业微信管理员进入应用授权页。授权页网址为:
     * https://open.work.weixin.qq.com/3rdapp/install?suite_id=SUITE_ID&pre_auth_code=PRE_AUTH_CODE&redirect_uri=REDIRECT_URI&state=STATE
     * 跳转链接中，第三方服务商需提供suite_id、预授权码、授权完成回调URI和state参数。
     * 其中redirect_uri是授权完成后的回调网址，redirect_uri需要经过一次urlencode作为参数；state可填a-zA-Z0-9的参数值（不超过128个字节），用于第三方自行校验session，防止跨域攻击。
     *
     * 授权成功，返回临时授权码
     * 用户确认授权后，会进入回调URI(即redirect_uri)，并在URI参数中带上临时授权码、过期时间以及state参数。第三方服务商据此获得临时授权码。回调地址为：
     * redirect_uri?auth_code=xxx&expires_in=600&state=xx
     * 临时授权码10分钟后会失效，第三方服务商需尽快使用临时授权码换取永久授权码及授权信息。
     * 每个企业授权的每个应用的永久授权码、授权信息都是唯一的，第三方服务商需妥善保管。后续可以通过永久授权码获取企业access_token，进而调用企业微信相关API为授权企业提供服务。
     */
    public function getThirdappInstallUrl($suite_id, $pre_auth_code, $redirect_uri, $state, $is_redirect = true)
    {
        $redirect_uri = trim($redirect_uri);
        if (filter_var($redirect_uri, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('$redirect_uri无效');
        }
        $redirect_uri = urlencode($redirect_uri);
        // https://open.work.weixin.qq.com/3rdapp/install?suite_id=SUITE_ID&pre_auth_code=PRE_AUTH_CODE&redirect_uri=REDIRECT_URI&state=STATE
        $url = "https://open.work.weixin.qq.com/3rdapp/install?suite_id={$suite_id}&pre_auth_code={$pre_auth_code}&redirect_uri={$redirect_uri}&state={$state}";

        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    /**
     * 第三方根据code获取企业成员信息
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/getuserinfo3rd?access_token=SUITE_ACCESS_TOKEN&code=CODE
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 第三方应用的suite_access_token，参见“获取第三方应用凭证”
     * code 是 通过成员授权获取到的code，最大为512字节。每次成员授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
     * 权限说明：
     * 跳转的域名须完全匹配access_token对应第三方应用的可信域名，否则会返回50001错误。
     *
     * 返回结果：
     * a) 当用户属于某个企业，返回示例如下：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "CorpId":"CORPID",
     * "UserId":"USERID",
     * "DeviceId":"DEVICEID",
     * "user_ticket": "USER_TICKET"，
     * "expires_in":7200
     * }
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * CorpId 用户所属企业的corpid
     * UserId 用户在企业内的UserID，如果该企业与第三方应用有授权关系时，返回明文UserId，否则返回密文UserId
     * DeviceId 手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
     * user_ticket 成员票据，最大为512字节。
     * scope为snsapi_userinfo或snsapi_privateinfo，且用户在应用可见范围之内时返回此参数。
     * 后续利用该参数可以获取用户信息或敏感信息，参见“第三方使用user_ticket获取成员详情”。
     * expires_in user_ticket的有效时间（秒），随user_ticket一起返回
     * b) 若用户不属于任何企业，返回示例如下：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "OpenId":"OPENID",
     * "DeviceId":"DEVICEID"
     * }
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * OpenId 非企业成员的标识，对当前服务商唯一
     * DeviceId 手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
     * 出错返回示例：
     *
     * {
     * "errcode": 40029,
     * "errmsg": "invalid code"
     * }
     */
    public function getUserInfo3rd($suite_access_token, $code)
    {
        if (empty($code)) {
            throw new \Exception('code不能为空');
        }
        $params = array();
        $rst = $this->_request->get($this->_url . "getuserinfo3rd?access_token={$suite_access_token}&code={$code}", $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 第三方使用user_ticket获取成员详情
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/getuserdetail3rd?access_token=SUITE_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "user_ticket": "USER_TICKET"
     * }
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 第三方应用的suite_access_token，参见“获取第三方应用凭证”
     * user_ticket 是 成员票据
     * 权限说明：
     * 成员必须在授权应用的可见范围内。
     *
     * 返回结果：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "corpid":"wwxxxxxxyyyyy",
     * "userid":"lisi",
     * "name":"李四",
     * "mobile":"15913215421",
     * "gender":"1",
     * "email":"xxx@xx.com",
     * "avatar":"http://shp.qpic.cn/bizmp/xxxxxxxxxxx/0",
     * "qr_code":"https://open.work.weixin.qq.com/wwopen/userQRCode?vcode=vcfc13b01dfs78e981c"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * corpid 用户所属企业的corpid
     * userid 成员UserID
     * name 成员姓名
     * mobile 成员手机号，仅在用户同意snsapi_privateinfo授权时返回
     * gender 性别。0表示未定义，1表示男性，2表示女性
     * email 成员邮箱，仅在用户同意snsapi_privateinfo授权时返回
     * avatar 头像url。注：如果要获取小图将url最后的”/0”改成”/100”即可。仅在用户同意snsapi_privateinfo授权时返回
     * qr_code 员工个人二维码（扫描可添加为外部联系人），仅在用户同意snsapi_privateinfo授权时返回
     */
    public function getUserDetail3rd($suite_access_token, $user_ticket)
    {
        $params = array(
            'user_ticket' => $user_ticket
        );
        $rst = $this->_request->post($this->_url . 'getuserdetail3rd?access_token=' . $suite_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取登录用户信息
     * 第三方可通过如下接口，获取登录用户的信息。建议用户以返回信息中的corpid及userid为主键匹配用户。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_login_info?access_token=PROVIDER_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "auth_code":"xxxxx"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 授权登录服务商的网站时，使用应用提供商的provider_access_token，获取方法参见服务商的凭证
     * auth_code 是 oauth2.0授权企业微信管理员登录产生的code，最长为512字节。只能使用一次，5分钟未被使用自动过期
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "usertype": 1,
     * "user_info":{
     * "userid":"xxxx",
     * "name":"xxxx",
     * "avatar":"xxxx"
     * },
     * "corp_info":{
     * "corpid":"wxCorpId",
     * },
     * "agent":[
     * {"agentid":0,"auth_type":1},
     * {"agentid":1,"auth_type":1},
     * {"agentid":2,"auth_type":1}
     * ],
     * "auth_info":{
     * "department":[
     * {
     * "id":2,
     * "writable":true
     * }
     * ]
     * }
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码。
     * 若返回该字段，并且errcode!=0，为调用失败；
     * 无此errcode字段，或者errcode=0，为调用成功
     * errmsg 对返回码的文本描述内容。仅当errcode字段返回时，同时返回errmsg
     * usertype 登录用户的类型：1.创建者 2.内部系统管理员 3.外部系统管理员 4.分级管理员 5.成员
     * user_info 登录用户的信息
     * userid 登录用户的userid，登录用户在通讯录中时返回
     * name 登录用户的名字，登录用户在通讯录中时返回，此字段从2019年12月30日起，对新创建服务商不再返回，2020年6月30日起，对所有历史服务商不再返回，第三方页面需要通过通讯录展示组件来展示名字
     * avatar 登录用户的头像，登录用户在通讯录中时返回
     * corp_info 授权方企业信息
     * corpid 授权方企业id
     * agent 该管理员在该提供商中能使用的应用列表，当登录用户为管理员时返回
     * agentid 应用id
     * auth_type 该管理员对应用的权限：1.管理权限，0.使用权限
     * auth_info 该管理员拥有的通讯录权限，当登录用户为管理员时返回
     */
    public function getLoginInfo($provider_access_token, $auth_code)
    {
        $params = array(
            'auth_code' => $auth_code
        );
        $rst = $this->_request->post($this->_url . 'get_login_info?provider_access_token=' . $provider_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取注册码
     * 该API用于根据注册推广包生成注册码（register_code）。
     *
     * 请求方式： POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/service/get_register_code?provider_access_token=PROVIDER_ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "template_id":"TEMPLATEID" ,
     * "corp_name":"腾讯科技",
     * "admin_name":"张三",
     * "admin_mobile":"12345678901",
     * "state":"TestState123",
     * "follow_user": "lisi"
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * provider_access_token 是 服务商provider_access_token，获取方法参见服务商的凭证
     * template_id 是 推广包ID，最长为128个字节
     * corp_name 否 企业名称
     * admin_name 否 管理员姓名
     * admin_mobile 否 管理员手机号
     * state 否 用户自定义的状态值。只支持英文字母和数字，最长为128字节。若指定该参数， 接口 查询注册状态 及 注册完成回调事件 会相应返回该字段值
     * follow_user 否 跟进人的userid，必须是服务商所在企业的成员。若配置该值，则由该注册码创建的企业，在服务商管理后台，该企业的报备记录会自动标注跟进人员为指定成员
     * 调用若传递corp_name/admin_name/admin_mobile参数，则在进入注册企业填写信息时，相应的值会自动填到表格中。
     *
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "register_code":"pIKi3wRPNWCGF-pyP-YU5KWjDDD",
     * "expires_in": 600
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误码对应的描述
     * register_code 注册码，只能消费一次。在访问注册链接时消费。最长为512个字节
     * expires_in register_code有效期，生成链接需要在有效期内点击跳转
     */
    public function getRegisterCode($provider_access_token, \Weixin\Qy\Model\Service\Register $register)
    {
        $params = $register->getParams();
        $rst = $this->_request->post($this->_url . 'get_register_code?provider_access_token=' . $provider_access_token, $params);
        if (!empty($rst['errcode'])) {
            // 如果有异常，会在errcode 和errmsg 描述出来。
            throw new \Exception($rst['errmsg'], $rst['errcode']);
        } else {
            return $rst;
        }
    }

    /**
     * 获取媒体处理对象
     *
     * @return \Weixin\Qy\Manager\Service\Media
     */
    public function getMediaManager()
    {
        return new Media($this);
    }

    /**
     * 获取批量处理对象
     *
     * @return \Weixin\Qy\Manager\Service\Batch
     */
    public function getBatchManager()
    {
        return new Batch($this);
    }

    /**
     * 获取通讯录对象
     *
     * @return \Weixin\Qy\Manager\Service\Contact
     */
    public function getContactManager()
    {
        return new Contact($this);
    }

    /**
     * 设置授权应用可见范围
     * 调用该接口前提是开启通讯录迁移，收到授权成功通知后可调用。企业注册初始化安装应用后，应用默认可见范围为根部门。如需修改应用可见范围，服务商可以调用该接口设置授权应用的可见范围。该接口只能使用注册完成回调事件或者查询注册状态返回的access_token，调用设置通讯录同步完成后或者access_token超过30分钟失效（即解除通讯录锁定状态）则不能继续调用该接口。
     *
     * 请求方式：POST（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/agent/set_scope?access_token=ACCESS_TOKEN
     *
     * 请求包体：
     *
     * {
     * "agentid":1 ,
     * "allow_user":["zhansan","lisi"],
     * "allow_party":[1,2,3],
     * "allow_tag":[1,2,3]
     * }
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 查询注册状态接口返回的access_token（跟注册完成回调事件的AccessToken参数一致，请注意与provider_access_token的区别）
     * agentid 是 授权方应用id
     * allow_user 否 应用可见范围（成员）若未填该字段，则清空可见范围中成员列表
     * allow_party 否 应用可见范围（部门）若未填该字段，则清空可见范围中部门列表
     * allow_tag 否 应用可见范围（标签）若未填该字段，则清空可见范围中标签列表
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok",
     * "invaliduser":["zhangshan","lisi"],
     * "invalidparty":[2,3],
     * "invalidtag":[2,3]
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误码对应的描述
     * invaliduser 非法成员列表
     * invalidparty 非法部门列表
     * invalidtag 非法标签列表
     */
    public function agentSetScope($access_token, $agentid, array $allow_user, array $allow_party, array $allow_tag)
    {
        $params = array();
        $params['agentid'] = $agentid;
        $params['allow_user'] = $allow_user;
        $params['allow_party'] = $allow_party;
        $params['allow_tag'] = $allow_tag;

        $rst = $this->_request->post('https://qyapi.weixin.qq.com/cgi-bin/agent/set_scope?access_token=' . $access_token, $params);
        return $this->_client->rst($rst);
    }

    /**
     * 设置通讯录同步完成
     * 该API用于设置通讯录同步完成，解除通讯录锁定状态，同时使通讯录迁移access_token失效。
     *
     * 请求方式：GET（HTTPS）
     * 请求地址： https://qyapi.weixin.qq.com/cgi-bin/sync/contact_sync_success?access_token=ACCESS_TOKEN
     *
     * 参数说明：
     *
     * 参数 是否必须 说明
     * access_token 是 查询注册状态接口返回的access_token（跟注册完成回调事件的AccessToken参数一致，请注意与provider_access_token的区别）
     * 返回结果：
     *
     * {
     * "errcode":0,
     * "errmsg":"ok"
     * }
     */
    public function syncContactSyncSuccess($access_token)
    {
        $params = array();
        $rst = $this->_request->get('https://qyapi.weixin.qq.com/cgi-bin/sync/contact_sync_success?access_token=' . $access_token, $params);
        return $this->_client->rst($rst);
    }
}
