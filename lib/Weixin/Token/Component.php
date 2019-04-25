<?php
namespace Weixin\Token;

use Weixin\Exception;

/**
 * 代公众号发起网页授权
 * https://open.weixin.qq.com/cgi-bin/showdocument?action=dir_list&t=resource/res_list&verify=1&id=open1419318590&token=&lang=
 *
 * 作为第三方平台开发商，需要拥有自己的appid以及secret（在创建第三方平台并获得审核成功后可以获取），以及确保授权的公众号具备授权作用域的权限，以及用于回调的域名。
 */
class Component
{

    private $_appid;

    private $_component_appid;

    private $_component_access_token;

    private $_redirect_uri;

    private $_scope = 'snsapi_userinfo';

    private $_state = '';

    private $_request;

    private $_context;

    public function __construct($appid, $component_appid, $component_access_token)
    {
        if (empty($appid)) {
            throw new Exception('请设定$appid');
        }
        if (empty($component_appid)) {
            throw new Exception('请设定$component_appid');
        }
        if (empty($component_access_token)) {
            throw new Exception('请设定$component_access_token');
        }
        
        $this->_state = uniqid();
        $this->_appid = $appid;
        $this->_component_appid = $component_appid;
        $this->_component_access_token = $component_access_token;
        
        $opts = array(
            'http' => array(
                'follow_location' => 3,
                'max_redirects' => 3,
                'timeout' => 10,
                'method' => "GET",
                'header' => "Connection: close\r\n",
                'user_agent' => 'iCatholic R&D'
            )
        );
        $this->_context = stream_context_create($opts);
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
            throw new Exception('$redirect_uri无效');
        }
        $this->_redirect_uri = urlencode($redirect_uri);
    }

    /**
     * 设定作用域类型
     *
     * @param string $scope            
     * @throws Exception
     */
    public function setScope($scope)
    {
        if (! in_array($scope, array(
            'snsapi_userinfo',
            'snsapi_base',
            'snsapi_login'
        ), true)) {
            throw new Exception('$scope无效');
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

    /**
     * 获取认证地址的URL
     * 在确保微信公众账号拥有授权作用域（scope参数）的权限的前提下（一般而言，已微信认证的服务号拥有snsapi_base和snsapi_userinfo），使用微信客户端打开以下链接（严格按照以下格式，包括顺序和大小写，并请将参数替换为实际内容）：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE&component_appid=component_appid#wechat_redirect
     * 若提示“该链接无法访问”，请检查参数是否填写错误，是否拥有scope参数对应的授权作用域权限。
     *
     * 参数说明
     * 参数 是否必须 说明
     * appid 是 公众号的appid
     * redirect_uri 是 重定向地址，需要urlencode，这里填写的应是服务开发方的回调地址
     * response_type 是 填code
     * scope 是 授权作用域，拥有多个作用域用逗号（,）分隔
     * state 否 重定向后会带上state参数，开发者可以填写任意参数值，最多128字节
     * component_appid 是 服务方的appid，在申请创建公众号服务成功后，可在公众号服务详情页找到
     * 返回说明
     * 用户允许授权后，将会重定向到redirect_uri的网址上，并且带上code, state以及appid
     *
     * redirect_uri?code=CODE&state=STATE&appid=APPID
     * 若用户禁止授权，则重定向后不会带上code参数，仅会带上state参数
     *
     * redirect_uri?state=STATE
     */
    public function getAuthorizeUrl($is_redirect = true)
    {
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}&component_appid={$this->_component_appid}#wechat_redirect";
        if (! empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    /**
     * 获取access token
     * 通过code换取access_token
     * 请求方法
     * 获取第一步的code后，请求以下链接获取access_token：
     *
     * https://api.weixin.qq.com/sns/oauth2/component/access_token?appid=APPID&code=CODE&grant_type=authorization_code&component_appid=COMPONENT_APPID&component_access_token=COMPONENT_ACCESS_TOKEN
     * 需要注意的是，由于安全方面的考虑，对访问该链接的客户端有IP白名单的要求。
     *
     * 参数说明
     * 参数 是否必须 说明
     * appid 是 公众号的appid
     * code 是 填写第一步获取的code参数
     * grant_type 是 填authorization_code
     * component_appid 是 服务开发方的appid
     * component_access_token 是 服务开发方的access_token
     * 返回说明
     * 正确的返回：
     *
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200,
     * "refresh_token":"REFRESH_TOKEN",
     * "openid":"OPENID",
     * "scope":"SCOPE"
     * }
     * 参数 说明
     * access_token 接口调用凭证
     * expires_in access_token接口调用凭证超时时间，单位（秒）
     * refresh_token 用户刷新access_token
     * openid 授权用户唯一标识
     * scope 用户授权的作用域，使用逗号（,）分隔
     * 错误返回样例：
     *
     * {"errcode":40029,"errmsg":"invalid code"}
     *
     * @throws Exception
     * @return array
     */
    public function getAccessToken()
    {
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';
        if ($code == '') {
            throw new Exception('code不能为空');
        }
        
        $response = file_get_contents("https://api.weixin.qq.com/sns/oauth2/component/access_token?appid={$this->_appid}&code={$code}&grant_type=authorization_code&component_appid={$this->_component_appid}&component_access_token={$this->_component_access_token}", false, $this->_context);
        $response = json_decode($response, true);
        
        return $response;
    }

    /**
     * 通过refresh token获取新的access token
     * 刷新access_token（如果需要）
     * 由于access_token拥有较短的有效期，当access_token超时后，可以使用refresh_token进行刷新，refresh_token拥有较长的有效期（30天），当refresh_token失效的后，需要用户重新授权。
     *
     * 请求方法
     * 获取第一步的code后，请求以下链接获取access_token：
     *
     * https://api.weixin.qq.com/sns/oauth2/component/refresh_token?appid=APPID&grant_type=refresh_token&component_appid=COMPONENT_APPID&component_access_token=COMPONENT_ACCESS_TOKEN&refresh_token=REFRESH_TOKEN
     * 参数说明
     * 参数 是否必须 说明
     * appid 是 公众号的appid
     * grant_type 是 填refresh_token
     * refresh_token 是 填写通过access_token获取到的refresh_token参数
     * component_appid 是 服务开发商的appid
     * component_access_token 是 服务开发方的access_token
     * 返回说明
     * 正确的返回：
     *
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200,
     * "refresh_token":"REFRESH_TOKEN",
     * "openid":"OPENID",
     * "scope":"SCOPE"
     * }
     * 参数 说明
     * access_token 接口调用凭证
     * expires_in access_token接口调用凭证超时时间，单位（秒）
     * refresh_token 用户刷新access_token
     * openid 授权用户唯一标识
     * scope 用户授权的作用域，使用逗号（,）分隔
     * 错误返回样例：:
     *
     * {"errcode":40029,"errmsg":"invalid code"}
     */
    public function getRefreshToken($refreshToken)
    {
        $response = file_get_contents("https://api.weixin.qq.com/sns/oauth2/component/refresh_token?appid={$this->_appid}&grant_type=refresh_token&component_appid={$this->_component_appid}&component_access_token={$this->_component_access_token}&refresh_token={$refreshToken}", false, $this->_context);
        $response = json_decode($response, true);
        return $response;
    }

    public function __destruct()
    {}
}