<?php

namespace Weixin\Token;

use Weixin\Exception;

/**
 * 网页授权
 * https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html
 */
class Sns
{
    private $_appid;
    private $_secret;
    private $_redirect_uri;
    private $_scope = 'snsapi_userinfo';
    private $_state = '';
    private $_forcePopup = false;
    private $_request;
    private $_context;
    public function __construct($appid, $secret)
    {
        if (empty($appid)) {
            throw new Exception('请设定$appid');
        }
        if (empty($secret)) {
            throw new Exception('请设定$secret');
        }
        $this->_state = uniqid();
        $this->_appid = $appid;
        $this->_secret = $secret;

        $opts = array(
            'http' => array(
                'follow_location' => 3,
                'max_redirects' => 3,
                'timeout' => 10,
                'method' => "GET",
                'header' => "Connection: close\r\n",
                'user_agent' => 'R&D'
            ),
            "ssl" => array(
                "verify_peer" => false,
                "verify_peer_name" => false
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
        // $redirect_uri = trim(urldecode($redirect_uri));
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
        if (!in_array($scope, array(
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
     * 强制此次授权需要用户弹窗确认；默认为false；需要注意的是，若用户命中了特殊场景下的静默授权逻辑，则此参数不生效
     *
     * @param string $forcePopup        	
     */
    public function setForcePopup($forcePopup)
    {
        $this->_forcePopup = $forcePopup;
    }
    /**
     * 获取认证地址的URL
     * 用户同意授权，获取code
     * 在确保微信公众账号拥有授权作用域（scope参数）的权限的前提下（已认证服务号，默认拥有scope参数中的snsapi_base和snsapi_userinfo 权限），引导关注者打开如下页面：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect
     *
     * 若提示“该链接无法访问”，请检查参数是否填写错误，是否拥有scope参数对应的授权作用域权限。
     *
     * 尤其注意：由于授权操作安全等级较高，所以在发起授权请求时，微信会对授权链接做正则强匹配校验，如果链接的参数顺序不对，授权页面将无法正常访问
     *
     * 参考链接(请在微信客户端中打开此链接体验)：
     *
     * scope为snsapi_base：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx520c15f417810387&redirect_uri=https%3A%2F%2Fchong.qq.com%2Fphp%2Findex.php%3Fd%3D%26c%3DwxAdapter%26m%3DmobileDeal%26showwxpaytitle%3D1%26vb2ctag%3D4_2030_5_1194_60&response_type=code&scope=snsapi_base&state=123#wechat_redirect
     *
     * scope为snsapi_userinfo：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx807d86fb6b3d4fd2&redirect_uri=http%3A%2F%2Fdevelopers.weixin.qq.com&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect
     *
     * 尤其注意：跳转回调redirect_uri，应当使用https链接来确保授权code的安全性。
     *
     * 参数说明
     *
     * 参数 是否必须 说明
     * appid 是 公众号的唯一标识
     * redirect_uri 是 授权后重定向的回调链接地址， 请使用 urlEncode 对链接进行处理
     * response_type 是 返回类型，请填写code
     * scope 是 应用授权作用域，snsapi_base （不弹出授权页面，直接跳转，只能获取用户openid），snsapi_userinfo （弹出授权页面，可通过openid拿到昵称、性别、所在地。并且， 即使在未关注的情况下，只要用户授权，也能获取其信息 ）
     * state 否 重定向后会带上state参数，开发者可以填写a-zA-Z0-9的参数值，最多128字节
     * #wechat_redirect 是 无论直接打开还是做页面302重定向时候，必须带此参数
     * forcePopup 否 强制此次授权需要用户弹窗确认；默认为false；需要注意的是，若用户命中了特殊场景下的静默授权逻辑，则此参数不生效
     * 下图为scope等于snsapi_userinfo时的授权页面：
     *
     *
     *
     * 用户同意授权后
     *
     * 如果用户同意授权，页面将跳转至 redirect_uri/?code=CODE&state=STATE。
     */
    public function getAuthorizeUrl($is_redirect = true)
    {
        if ($this->_scope != 'snsapi_login') {
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}&forcePopup={$this->_forcePopup}#wechat_redirect";
        } else {
            $url = "https://open.weixin.qq.com/connect/qrconnect?appid={$this->_appid}&redirect_uri={$this->_redirect_uri}&response_type=code&scope={$this->_scope}&state={$this->_state}&forcePopup={$this->_forcePopup}#wechat_redirect";
        }
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    /**
     * 获取access token
     * 通过code换取网页授权access_token
     * 首先请注意，这里通过code换取的是一个特殊的网页授权access_token,与基础支持中的access_token（该access_token用于调用其他接口）不同。公众号可通过下述接口来获取网页授权access_token。如果网页授权的作用域为snsapi_base，则本步骤中获取到网页授权access_token的同时，也获取到了openid，snsapi_base式的网页授权流程即到此为止。
     *
     * 尤其注意：由于公众号的secret和获取到的access_token安全级别都非常高，必须只保存在服务器，不允许传给客户端。后续刷新access_token、通过access_token获取用户信息等步骤，也必须从服务器发起。
     *
     * 请求方法
     *
     * 获取code后，请求以下链接获取access_token：
     *
     * https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code
     *
     * 参数 是否必须 说明
     * appid 是 公众号的唯一标识
     * secret 是 公众号的appsecret
     * code 是 填写第一步获取的code参数
     * grant_type 是 填写为authorization_code
     * 返回说明
     *
     * 正确时返回的JSON数据包如下：
     *
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200,
     * "refresh_token":"REFRESH_TOKEN",
     * "openid":"OPENID",
     * "scope":"SCOPE",
     * "is_snapshotuser": 1,
     * "unionid": "UNIONID"
     * }
     * 参数 描述
     * access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * expires_in access_token接口调用凭证超时时间，单位（秒）
     * refresh_token 用户刷新access_token
     * openid 用户唯一标识，请注意，在未关注公众号时，用户访问公众号的网页，也会产生一个用户和公众号唯一的OpenID
     * scope 用户授权的作用域，使用逗号（,）分隔
     * is_snapshotuser 是否为快照页模式虚拟账号，只有当用户是快照页模式虚拟账号时返回，值为1
     * unionid 用户统一标识（针对一个微信开放平台帐号下的应用，同一用户的 unionid 是唯一的），只有当scope为"snsapi_userinfo"时返回
     * 错误时微信会返回JSON数据包如下（示例为Code无效错误）:
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
        $response = file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->_appid}&secret={$this->_secret}&code={$code}&grant_type=authorization_code", false, $this->_context);
        $response = json_decode($response, true);

        return $response;
    }

    /**
     * 通过refresh token获取新的access token
     * 刷新access_token（如果需要）
     * 由于access_token拥有较短的有效期，当access_token超时后，可以使用refresh_token进行刷新，refresh_token有效期为30天，当refresh_token失效之后，需要用户重新授权。
     *
     * 请求方法
     *
     * 获取第二步的refresh_token后，请求以下链接获取access_token：
     *
     * https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN
     *
     * 参数 是否必须 说明
     * appid 是 公众号的唯一标识
     * grant_type 是 填写为refresh_token
     * refresh_token 是 填写通过access_token获取到的refresh_token参数
     * 返回说明
     *
     * 正确时返回的JSON数据包如下：
     *
     * {
     * "access_token":"ACCESS_TOKEN",
     * "expires_in":7200,
     * "refresh_token":"REFRESH_TOKEN",
     * "openid":"OPENID",
     * "scope":"SCOPE"
     * }
     * 参数 描述
     * access_token 网页授权接口调用凭证,注意：此access_token与基础支持的access_token不同
     * expires_in access_token接口调用凭证超时时间，单位（秒）
     * refresh_token 用户刷新access_token
     * openid 用户唯一标识
     * scope 用户授权的作用域，使用逗号（,）分隔
     * 错误时微信会返回JSON数据包如下（示例为code无效错误）:
     *
     * {"errcode":40029,"errmsg":"invalid code"}
     */
    public function getRefreshToken($refreshToken)
    {
        $response = file_get_contents("https://api.weixin.qq.com/sns/oauth2/refresh_token?appid={$this->_appid}&grant_type=refresh_token&refresh_token={$refreshToken}", false, $this->_context);
        $response = json_decode($response, true);
        return $response;
    }

    /**
     * code 换取 session_key
     *
     * @throws Exception
     * @return array
     */
    public function getJscode2session($js_code)
    {
        if (empty($js_code)) {
            throw new Exception('js_code不能为空');
        }
        $response = file_get_contents("https://api.weixin.qq.com/sns/jscode2session?appid={$this->_appid}&secret={$this->_secret}&js_code={$js_code}&grant_type=authorization_code", false, $this->_context);
        $response = json_decode($response, true);

        return $response;
    }
    public function __destruct()
    {
    }
}
