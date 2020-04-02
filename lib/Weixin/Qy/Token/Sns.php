<?php

namespace Weixin\Qy\Token;

/**
 * 网页授权登录 https://work.weixin.qq.com/api/doc/90000/90135/91020
 * 扫描授权登录 https://work.weixin.qq.com/api/doc/90000/90135/90988
 */
class Sns
{
    // 企业的CorpID
    private $_appid;

    private $_secret;

    private $_redirect_uri;

    private $_scope = 'snsapi_userinfo';

    private $_state = '';

    private $_request;

    private $_context;

    public function __construct($appid, $secret)
    {
        if (empty($appid)) {
            throw new \Exception('请设定$appid');
        }
        if (empty($secret)) {
            throw new \Exception('请设定$secret');
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
            throw new \Exception('$redirect_uri无效');
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
            'snsapi_base'
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

    /**
     * 获取认证地址的URL
     * 构造网页授权链接
     * 如果企业需要在打开的网页里面携带用户的身份信息，第一步需要构造如下的链接来获取code参数：
     *
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=CORPID&redirect_uri=REDIRECT_URI&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect
     * 参数说明：
     *
     * 参数 必须 说明
     * appid 是 企业的CorpID
     * redirect_uri 是 授权后重定向的回调链接地址，请使用urlencode对链接进行处理
     * response_type 是 返回类型，此时固定为：code
     * scope 是 应用授权作用域。企业自建应用固定填写：snsapi_base
     * state 否 重定向后会带上state参数，企业可以填写a-zA-Z0-9的参数值，长度不可超过128个字节
     * #wechat_redirect 是 终端使用此参数判断是否需要带上身份信息
     * 员工点击后，页面将跳转至 redirect_uri?code=CODE&state=STATE，企业可根据code参数获得员工的userid。code长度最大为512字节。
     *
     * 示例：
     *
     * 假定当前
     * 企业CorpID：wxCorpId
     * 访问链接：http://api.3dept.com/cgi-bin/query?action=get
     * 根据URL规范，将上述参数分别进行UrlEncode，得到拼接的OAuth2链接为：
     * https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxCorpId&redirect_uri=http%3a%2f%2fapi.3dept.com%2fcgi-bin%2fquery%3faction%3dget&response_type=code&scope=snsapi_base&state=#wechat_redirect
     * 员工点击后，页面将跳转至
     * http://api.3dept.com/cgi-bin/query?action=get&code=AAAAAAgG333qs9EdaPbCAP1VaOrjuNkiAZHTWgaWsZQ&state=
     * 企业可根据code参数调用获得员工的userid
     * 注意到，构造OAuth2链接中参数的redirect_uri是经过UrlEncode的
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
     *
     * 获取访问用户身份
     * 调试工具
     * 该接口用于根据code获取成员信息
     *
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN&code=CODE
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * code 是 通过成员授权获取到的code，最大为512字节。每次成员授权带上的code将不一样，code只能使用一次，5分钟未被使用自动过期。
     * 权限说明：
     * 跳转的域名须完全匹配access_token对应应用的可信域名，否则会返回50001错误。
     * 返回结果：
     * a) 当用户为企业成员时返回示例如下：
     *
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "UserId":"USERID",
     * "DeviceId":"DEVICEID"
     * }
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * UserId 成员UserID。若需要获得用户详情信息，可调用通讯录接口：读取成员
     * DeviceId 手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
     * b) 非企业成员授权时返回示例如下：
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
     * OpenId 非企业成员的标识，对当前企业唯一
     * DeviceId 手机设备号(由企业微信在安装时随机生成，删除重装会改变，升级不受影响)
     * 出错返回示例：
     *
     * {
     * "errcode": 40029,
     * "errmsg": "invalid code"
     * }
     *
     * @throws Exception
     * @return array
     */
    public function getUserInfo($access_token)
    {
        $code = isset($_GET['code']) ? trim($_GET['code']) : '';
        if ($code == '') {
            throw new \Exception('code不能为空');
        }
        // https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=ACCESS_TOKEN&code=CODE
        $response = file_get_contents("https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token={$access_token}&code={$code}", false, $this->_context);
        $response = json_decode($response, true);

        return $response;
    }

    /**
     * 构造扫码登录链接
     * 构造独立窗口登录二维码
     * 构造内嵌登录二维码
     * 步骤一：引入JS文件
     * 步骤二：在需要使用微信登录的地方实例JS对象
     * 构造独立窗口登录二维码
     * 开发者需要构造如下的链接来获取code参数：
     *
     * https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=CORPID&agentid=AGENTID&redirect_uri=REDIRECT_URI&state=STATE
     * 参数说明
     *
     * 参数 必须 说明
     * appid 是 企业微信的CorpID，在企业微信管理端查看
     * agentid 是 授权方的网页应用ID，在具体的网页应用中查看
     * redirect_uri 是 重定向地址，需要进行UrlEncode
     * state 否 用于保持请求和回调的状态，授权请求后原样带回给企业。该参数可用于防止csrf攻击（跨站请求伪造攻击），建议企业带上该参数，可设置为简单的随机数加session进行校验
     * 若提示“该链接无法访问”，请检查参数是否填写错误，如redirect_uri的域名与网页应用的可信域名不一致
     *
     * 返回说明
     * 用户允许授权后，将会重定向到redirect_uri的网址上，并且带上code和state参数
     *
     * redirect_uri?code=CODE&state=STATE
     *
     * 若用户禁止授权，则重定向后不会带上code参数，仅会带上state参数
     *
     * redirect_uri?state=STATE
     *
     * 示例：
     *
     * 假定当前
     * 企业CorpID：wxCorpId
     * 开启授权登录的应用ID：1000000
     * 登录跳转链接：http://api.3dept.com
     * state设置为：weblogin@gyoss9
     * 需要配置的授权回调域为：api.3dept.com
     * 根据URL规范，将上述参数分别进行UrlEncode，得到拼接的OAuth2链接为：
     * https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=wxCorpId&agentid=1000000&redirect_uri=http%3A%2F%2Fapi.3dept.com&state=web_login%40gyoss9
     */
    public function getQrConnectUrl($agentid, $is_redirect = true)
    {
        $url = "https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid={$this->_appid}&agentid={$agentid}&redirect_uri={$this->_redirect_uri}&state={$this->_state}";
        if (!empty($is_redirect)) {
            header("location:{$url}");
            exit();
        } else {
            return $url;
        }
    }

    public function __destruct()
    {
    }
}
