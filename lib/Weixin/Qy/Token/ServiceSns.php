<?php

namespace Weixin\QY\Token;

/**
 * 网页授权登录 https://work.weixin.qq.com/api/doc/90001/90143/91118
 * 扫码授权登录 https://work.weixin.qq.com/api/doc/90001/90143/91123
 */
class ServiceSns
{

    private $_appid = "";

    private $_agentid = "";

    private $_redirect_uri = "";

    private $_scope = 'snsapi_userinfo';

    private $_state = '';

    private $_usertype = 'admin';

    public function __construct()
    {
        $this->_state = uniqid();
    }

    /**
     * 设定微信回调地址
     *
     * @param string $redirect_uri            
     * @throws Exception
     */
    public function setRedirectUri($redirect_uri)
    {
        $redirect_uri = trim($redirect_uri);
        if (filter_var($redirect_uri, FILTER_VALIDATE_URL) === false) {
            throw new \Exception('$redirect_uri无效');
        }
        $this->_redirect_uri = urlencode($redirect_uri);
    }

    /**
     * 设定作用域类型
     * scope的特殊情况
     * scope为snsapi_userinfo或snsapi_privateinfo时，必须填agentid参数，否则系统会视为snsapi_base，不会返回敏感信息。
     * 第三方服务商配置scope为snsapi_privateinfo时，agentid所对应的应用必须有“成员敏感信息授权”的权限。“成员敏感信息授权”的开启方法为：登录服务商管理后台->标准应用服务->本地应用->进入应用->点击基本信息栏“编辑”按钮->勾选”成员敏感信息”
     * 企业自建应用调用读取成员接口没有字段限制，可以获取包括敏感字段在内的所有信息。因此，只有第三方应用才有必要使用snsapi_userinfo或snsapi_privateinfo的scope。
     *
     * @param string $scope            
     * @throws \Exception
     */
    public function setScope($scope)
    {
        // snsapi_base：静默授权，可获取成员的基础信息（UserId与DeviceId）；
        // snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱等敏感信息；
        // snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱等敏感信息。
        if (!in_array($scope, array(
            'snsapi_userinfo',
            'snsapi_base',
            'snsapi_privateinfo'
        ), true)) {
            throw new \Exception('$scope无效');
        }
        $this->_scope = $scope;
    }

    /**
     * 设定携带参数信息，请使用rawurlencode编码
     *
     * @param string $state            
     */
    public function setState($state)
    {
        $this->_state = $state;
    }

    public function setAppid($appid)
    {
        $this->_appid = $appid;
    }

    public function setAgentid($agentid)
    {
        $this->_agentid = $agentid;
    }

    public function setUserType($usertype)
    {
        $this->_usertype = $usertype;
    }

    /**
     * 构造第三方应用oauth2链接
     * 如果第三方应用需要在打开的网页里面携带用户的身份信息，第一步需要构造如下的链接来获取code：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
     * 参数说明：
     *
     * 参数 必须 说明
     * appid 是 第三方应用id（即ww或wx开头的suite_id）。注意与企业的网页授权登录不同
     * redirect_uri 是 授权后重定向的回调链接地址，请使用urlencode对链接进行处理 ，注意域名需要设置为第三方应用的可信域名
     * response_type 是 返回类型，此时固定为：code
     * scope 是 应用授权作用域。
     * snsapi_base：静默授权，可获取成员的基础信息（UserId与DeviceId）；
     * snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱等敏感信息；
     * snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱等敏感信息（已废弃）。
     * state 否 重定向后会带上state参数，企业可以填写a-zA-Z0-9的参数值，长度不可超过128个字节
     * #wechat_redirect 是 固定内容
     * 企业员工点击后，页面将跳转至 redirect_uri?code=CODE&state=STATE，第三方应用可根据code参数获得企业员工的corpid与userid。code长度最大为512字节。
     *
     * 权限说明：
     * 使用snsapi_privateinfo的scope时，第三方应用必须有“成员敏感信息授权”的权限。
     */
    public function getAuthorizeUrl($is_redirect = true)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}#wechat_redirect";
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    /**
     * 构造企业oauth2链接
     * 如果企业需要在打开的网页里面携带用户的身份信息，第一步需要构造如下的链接来获取code参数：
     *
     * 参数说明：
     *
     * 参数 必须 说明
     * appid 是 企业的CorpID
     * redirect_uri 是 授权后重定向的回调链接地址，请使用urlencode对链接进行处理
     * response_type 是 返回类型，此时固定为：code
     * scope 是 应用授权作用域。
     * snsapi_base：静默授权，可获取成员的的基础信息（UserId与DeviceId）；
     * snsapi_userinfo：静默授权，可获取成员的详细信息，但不包含手机、邮箱；
     * snsapi_privateinfo：手动授权，可获取成员的详细信息，包含手机、邮箱
     * 注意：企业自建应用可以根据userid获取成员详情，无需使用snsapi_userinfo和snsapi_privateinfo两种scope。更多说明见scope
     * agentid 否 企业应用的id。
     * 当scope是snsapi_userinfo或snsapi_privateinfo时，该参数必填
     * 注意redirect_uri的域名必须与该应用的可信域名一致。
     * state 否 重定向后会带上state参数，企业可以填写a-zA-Z0-9的参数值，长度不可超过128个字节
     * #wechat_redirect 是 终端使用此参数判断是否需要带上身份信息
     * 员工点击后，页面将跳转至 redirect_uri?code=CODE&state=STATE，企业可根据code参数获得员工的userid。code长度最大为512字节。
     */
    public function getAuthorizeUrl4Corp($is_redirect = true)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}&agentid={$this->_agentid}#wechat_redirect";
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    /**
     * 从第三方单点登录
     * 此功能可方便的让用户使用企业微信管理员或成员帐号登录第三方网站，该登录授权基于OAuth2.0协议标准构建。
     * 使用前，请登录服务商管理后台进行登录授权配置，如下图。
     *
     * 登录授权设置说明：
     *
     * 参数 说明
     * 登录授权发起域名 在该域名下发起的登录授权请求才可被通过，企业点击授权链接时，企业微信会检查该域名是否已登记
     * 授权完成回调域名 登录授权成功之后会回调到该域名下的URL，返回授权码和过期时间，开发者即可使用该授权码获取登录授权信息
     * 登录授权进入服务商网站流程：
     *
     *
     * 步骤说明：
     * 1、用户进入服务商网站
     * 2、服务商网站引导用户进入登录授权页
     * 服务商可以在自己的网站首页中放置“企业微信登录”的入口，引导用户进入登录授权页。网址为:
     *
     * https://open.work.weixin.qq.com/wwopen/sso/3rd_qrConnect?appid=ww100000a5f2191&redirect_uri=http%3A%2F%2Fwww.oa.com&state=web_login@gyoss9&usertype=admin
     * 参数说明：
     *
     * 参数 是否必须 说明
     * appid 是 服务商的CorpID
     * redirect_uri 是 授权登录之后目的跳转网址，需要做urlencode处理。所在域名需要与授权完成回调域名一致
     * state 否 用于企业或服务商自行校验session，防止跨域攻击
     * usertype 否 支持登录的类型。admin代表管理员登录（使用微信扫码）,member代表成员登录（使用企业微信扫码），默认为admin
     * 3、用户确认并同意授权
     * 用户进入登录授权页后，需要确认并同意将自己的企业微信和登录账号信息授权给企业或服务商，完成授权流程。
     * 4、授权后回调URI，得到授权码和过期时间
     * 授权流程完成后，会进入回调URI，并在URL参数中返回授权码，跳转地址
     *
     * redirect_url?auth_code=xxx
     * 5、利用授权码调用企业微信的相关API
     * 在得到登录授权码后，企业或服务商即可使用该授权码换取登录授权信息。
     */
    public function getAuthorizeUrl4Sso($is_redirect = true)
    {
        // https://open.work.weixin.qq.com/wwopen/sso/3rd_qrConnect?appid=ww100000a5f2191&redirect_uri=http%3A%2F%2Fwww.oa.com&state=web_login@gyoss9&usertype=admin
        $url = "https://open.work.weixin.qq.com/wwopen/sso/3rd_qrConnect?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&state={$this->_state}&usertype={$this->_usertype}";
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }
}
