<?php

/**
 * 自定义菜单接口
 * 自定义菜单能够帮助公众号丰富界面，
 * 让用户更好更快地理解公众号的功能。
 * https://developers.weixin.qq.com/doc/offiaccount/Custom_Menus/Creating_Custom-Defined_Menu.html
 * @author guoyongrong <handsomegyr@126.com>
 */

namespace Weixin\Manager;

use Weixin\Client;

class Menu
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/cgi-bin/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 自定义菜单创建接口
     * 接口调用请求说明
     * http请求方式：POST（请使用https协议） https://api.weixin.qq.com/cgi-bin/menu/create?access_token=ACCESS_TOKEN
     * click和view的请求示例
     * {
     * "button":[
     * {
     * "type":"click",
     * "name":"今日歌曲",
     * "key":"V1001_TODAY_MUSIC"
     * },
     * {
     * "name":"菜单",
     * "sub_button":[
     * {
     * "type":"view",
     * "name":"搜索",
     * "url":"http://www.soso.com/"
     * },
     * {
     * "type":"view",
     * "name":"视频",
     * "url":"http://v.qq.com/"
     * },
     * {
     * "type":"click",
     * "name":"赞一下我们",
     * "key":"V1001_GOOD"
     * }]
     * }]
     * }
     * 其他新增按钮类型的请求示例
     * {
     * "button": [
     * {
     * "name": "扫码",
     * "sub_button": [
     * {
     * "type": "scancode_waitmsg",
     * "name": "扫码带提示",
     * "key": "rselfmenu_0_0",
     * "sub_button": [ ]
     * },
     * {
     * "type": "scancode_push",
     * "name": "扫码推事件",
     * "key": "rselfmenu_0_1",
     * "sub_button": [ ]
     * }
     * ]
     * },
     * {
     * "name": "发图",
     * "sub_button": [
     * {
     * "type": "pic_sysphoto",
     * "name": "系统拍照发图",
     * "key": "rselfmenu_1_0",
     * "sub_button": [ ]
     * },
     * {
     * "type": "pic_photo_or_album",
     * "name": "拍照或者相册发图",
     * "key": "rselfmenu_1_1",
     * "sub_button": [ ]
     * },
     * {
     * "type": "pic_weixin",
     * "name": "微信相册发图",
     * "key": "rselfmenu_1_2",
     * "sub_button": [ ]
     * }
     * ]
     * },
     * {
     * "name": "发送位置",
     * "type": "location_select",
     * "key": "rselfmenu_2_0"
     * },
     * {
     * "type": "media_id",
     * "name": "图片",
     * "media_id": "MEDIA_ID1"
     * },
     * {
     * "type":"miniprogram",
     * "name":"wxa",
     * "url":"http://mp.weixin.qq.com",
     * "appid":"wx286b93c14bbf93aa",
     * "pagepath":"pages/lunar/index"
     * },
     * {
     * "type": "view_limited",
     * "name": "图文消息",
     * "media_id": "MEDIA_ID2"
     * },
     * {
     * "type": "article_id",
     * "name": "发布后的图文消息",
     * "article_id": "ARTICLE_ID1"
     * },
     * {
     * "type": "article_view_limited",
     * "name": "发布后的图文消息",
     * "article_id": "ARTICLE_ID2"
     * }
     * ]
     * }
     * 参数说明
     * 参数 是否必须 说明
     * button 是 一级菜单数组，个数应为1~3个
     * sub_button 否 二级菜单数组，个数应为1~5个
     * type 是 菜单的响应动作类型
     * name 是 菜单标题，不超过16个字节，子菜单不超过40个字节
     * key click等点击类型必须 菜单KEY值，用于消息接口推送，不超过128字节
     * url view类型必须 网页链接，用户点击菜单可打开链接，不超过1024字节
     * media_id media_id类型和view_limited类型必须 调用新增永久素材接口返回的合法media_id
     * appid miniprogram类型必须 小程序的appid（仅认证公众号可配置）
     * pagepath miniprogram类型必须 小程序的页面路径
     * article_id article_id类型和article_view_limited类型必须 发布后获得的合法 article_id
     *
     * 返回结果
     * 正确时的返回JSON数据包如下：
     * {"errcode":0,"errmsg":"ok"}
     * 错误时的返回JSON数据包如下（示例为无效菜单名长度）：
     * {"errcode":40018,"errmsg":"invalid button name size"}
     *
     * @param array $menus        	
     */
    public function create($menus)
    {
        $rst = $this->_request->post($this->_url . 'menu/create', $menus);
        return $this->_client->rst($rst);
    }

    /**
     * 自定义菜单查询接口
     *
     * 使用接口创建自定义菜单后，开发者还可使用接口查询自定义菜单的结构。另外请注意，在设置了个性化菜单后，使用本自定义菜单查询接口可以获取默认菜单和全部个性化菜单信息。
     * 请求说明
     * http请求方式：GET
     * https://api.weixin.qq.com/cgi-bin/menu/get?access_token=ACCESS_TOKEN
     * 返回说明（无个性化菜单时）
     * 对应创建接口，正确的Json返回结果:
     * {
     * "menu": {
     * "button": [
     * {
     * "type": "click",
     * "name": "今日歌曲",
     * "key": "V1001_TODAY_MUSIC",
     * "sub_button": [ ]
     * },
     * {
     * "type": "click",
     * "name": "歌手简介",
     * "key": "V1001_TODAY_SINGER",
     * "sub_button": [ ]
     * },
     * {
     * "name": "菜单",
     * "sub_button": [
     * {
     * "type": "view",
     * "name": "搜索",
     * "url": "http://www.soso.com/",
     * "sub_button": [ ]
     * },
     * {
     * "type": "view",
     * "name": "视频",
     * "url": "http://v.qq.com/",
     * "sub_button": [ ]
     * },
     * {
     * "type": "click",
     * "name": "赞一下我们",
     * "key": "V1001_GOOD",
     * "sub_button": [ ]
     * }
     * ]
     * }
     * ]
     * }
     * }
     * 返回说明（有个性化菜单时）
     * {
     * "menu": {
     * "button": [
     * {
     * "type": "click",
     * "name": "今日歌曲",
     * "key": "V1001_TODAY_MUSIC",
     * "sub_button": [ ]
     * }
     * ],
     * "menuid": 208396938
     * },
     * "conditionalmenu": [
     * {
     * "button": [
     * {
     * "type": "click",
     * "name": "今日歌曲",
     * "key": "V1001_TODAY_MUSIC",
     * "sub_button": [ ]
     * },
     * {
     * "name": "菜单",
     * "sub_button": [
     * {
     * "type": "view",
     * "name": "搜索",
     * "url": "http://www.soso.com/",
     * "sub_button": [ ]
     * },
     * {
     * "type": "view",
     * "name": "视频",
     * "url": "http://v.qq.com/",
     * "sub_button": [ ]
     * },
     * {
     * "type": "click",
     * "name": "赞一下我们",
     * "key": "V1001_GOOD",
     * "sub_button": [ ]
     * }
     * ]
     * }
     * ],
     * "matchrule": {
     * "group_id": 2,
     * "sex": 1,
     * "country": "中国",
     * "province": "广东",
     * "city": "广州",
     * "client_platform_type": 2
     * },
     * "menuid": 208396993
     * }
     * ]
     * }
     * 注：menu为默认菜单，conditionalmenu为个性化菜单列表。字段说明请见个性化菜单接口页的说明。
     * 使用网页调试工具调试该接口
     */
    public function get()
    {
        $rst = $this->_request->post($this->_url . 'menu/get');
        return $this->_client->rst($rst);
    }

    /**
     * 自定义菜单删除接口
     * 使用接口创建自定义菜单后，开发者还可使用接口删除当前使用的自定义菜单。另请注意，在个性化菜单时，调用此接口会删除默认菜单及全部个性化菜单。
     * 请求说明
     * http请求方式：GET
     * https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=ACCESS_TOKEN
     * 返回说明
     * 对应创建接口，正确的Json返回结果:
     * {"errcode":0,"errmsg":"ok"}
     */
    public function delete($menus = array())
    {
        $rst = $this->_request->post($this->_url . 'menu/delete', $menus);
        return $this->_client->rst($rst);
    }
    private function validateSubbutton($menus)
    {
        $ret = 0;
        foreach ($menus as $menu) {
            if (key_exists("sub_button", $menu)) {
                $sub_button_num = count($menu['sub_button']);
                if ($sub_button_num > 5 || $sub_button_num < 1) {
                    $ret = 40023;
                    break;
                }
                $ret = $this->validateSubbutton($menu['sub_button']);
                if ($ret)
                    break;
            }
        }
        return $ret;
    }
    private function validateKey($menu)
    {
        // click等点击类型必须
        if (in_array(strtolower($menu['type']), array(
            'click',
            'scancode_push',
            'scancode_waitmsg',
            'pic_sysphoto',
            'pic_photo_or_album',
            'pic_weixin',
            'location_select'
        ))) {
            if (strlen(trim($menu['key'])) < 1)
                return 40019;
        }
        // 按钮KEY值，用于消息接口(event类型)推送，不超过128字节
        if (strlen(trim($menu['key'])) > 128)
            return 40019;
        return 0;
    }
    private function validateName($menu)
    {
        // 按钮描述，既按钮名字，不超过16个字节，子菜单不超过40个字节
        if ($menu['fatherNode']) // 子菜单
        {
            if (strlen($menu['name']) > 40)
                return 40018;
        } else // 按钮
        {
            if (strlen($menu['name']) > 16)
                return 40018;
        }
        return 0;
    }
    public function validateMenu($menu)
    {
        $errcode = $this->validateName($menu);
        if ($errcode) {
            return $errcode;
        }
        $errcode = $this->validateKey($menu);
        if ($errcode) {
            return $errcode;
        }
        return 0;
    }
    public function validateAllMenus($menus)
    {
        // 按钮数组，按钮个数应为1~3个
        $button_num = count($menus);
        if ($button_num > 3 || $button_num < 1) {
            return 40017;
        }

        // 子按钮数组，按钮个数应为1~5个
        if ($this->validateSubbutton($menus)) {
            return 40023;
        }
    }

    /**
     * 获取自定义菜单配置接口
     * 本接口将会提供公众号当前使用的自定义菜单的配置，如果公众号是通过API调用设置的菜单，则返回菜单的开发配置，而如果公众号是在公众平台官网通过网站功能发布菜单，则本接口返回运营者设置的菜单配置。
     *
     * 请注意：
     *
     * 1、第三方平台开发者可以通过本接口，在旗下公众号将业务授权给你后，立即通过本接口检测公众号的自定义菜单配置，并通过接口再次给公众号设置好自动回复规则，以提升公众号运营者的业务体验。
     * 2、本接口与自定义菜单查询接口的不同之处在于，本接口无论公众号的接口是如何设置的，都能查询到接口，而自定义菜单查询接口则仅能查询到使用API设置的菜单配置。
     * 3、认证/未认证的服务号/订阅号，以及接口测试号，均拥有该接口权限。
     * 4、从第三方平台的公众号登录授权机制上来说，该接口从属于消息与菜单权限集。
     * 5、本接口中返回的mediaID均为临时素材（通过素材管理-获取临时素材接口来获取这些素材），每次接口调用返回的mediaID都是临时的、不同的，在每次接口调用后3天有效，若需永久使用该素材，需使用素材管理接口中的永久素材。
     * 接口调用请求说明
     *
     * http请求方式: GET（请使用https协议）
     * https://api.weixin.qq.com/cgi-bin/get_current_selfmenu_info?access_token=ACCESS_TOKEN
     * 返回结果说明
     *
     * 如果公众号是在公众平台官网通过网站功能发布菜单，则本接口返回的自定义菜单配置样例如下：
     *
     * {
     * "is_menu_open": 1,
     * "selfmenu_info": {
     * "button": [
     * {
     * "name": "button",
     * "sub_button": {
     * "list": [
     * {
     * "type": "view",
     * "name": "view_url",
     * "url": "http://www.qq.com"
     * },
     * {
     * "type": "news",
     * "name": "news",
     * "news_info": {
     * "list": [
     * {
     * "title": "MULTI_NEWS",
     * "author": "JIMZHENG",
     * "digest": "text",
     * "show_cover": 0,
     * "cover_url": "http://mmbiz.qpic.cn/mmbiz/GE7et87vE9vicuCibqXsX9GPPLuEtBfXfK0HKuBIa1A1cypS0uY1wickv70iaY1gf3I1DTszuJoS3lAVLvhTcm9sDA/0",
     * "content_url": "http://mp.weixin.qq.com/s?__biz=MjM5ODUwNTM3Ng==&mid=204013432&idx=1&sn=80ce6d9abcb832237bf86c87e50fda15#rd",
     * "source_url": ""
     * },
     * {
     * "title": "MULTI_NEWS1",
     * "author": "JIMZHENG",
     * "digest": "MULTI_NEWS1",
     * "show_cover": 1,
     * "cover_url": "http://mmbiz.qpic.cn/mmbiz/GE7et87vE9vicuCibqXsX9GPPLuEtBfXfKnmnpXYgWmQD5gXUrEApIYBCgvh2yHsu3ic3anDUGtUCHwjiaEC5bicd7A/0",
     * "content_url": "http://mp.weixin.qq.com/s?__biz=MjM5ODUwNTM3Ng==&mid=204013432&idx=2&sn=8226843afb14ecdecb08d9ce46bc1d37#rd",
     * "source_url": ""
     * }
     * ]
     * }
     * },
     * {
     * "type": "video",
     * "name": "video",
     * "value": "http://61.182.130.30/vweixinp.tc.qq.com/1007_114bcede9a2244eeb5ab7f76d951df5f.f10.mp4?vkey=77A42D0C2015FBB0A3653D29C571B5F4BBF1D243FBEF17F09C24FF1F2F22E30881BD350E360BC53F&sha=0&save=1"
     * },
     * {
     * "type": "voice",
     * "name": "voice",
     * "value": "nTXe3aghlQ4XYHa0AQPWiQQbFW9RVtaYTLPC1PCQx11qc9UB6CiUPFjdkeEtJicn"
     * }
     * ]
     * }
     * },
     * {
     * "type": "text",
     * "name": "text",
     * "value": "This is text!"
     * },
     * {
     * "type": "img",
     * "name": "photo",
     * "value": "ax5Whs5dsoomJLEppAvftBUuH7CgXCZGFbFJifmbUjnQk_ierMHY99Y5d2Cv14RD"
     * }
     * ]
     * }
     * }
     * 如果公众号是通过API调用设置的菜单，自定义菜单配置样例如下：
     *
     * {
     * "is_menu_open": 1,
     * "selfmenu_info": {
     * "button": [
     * {
     * "type": "click",
     * "name": "今日歌曲",
     * "key": "V1001_TODAY_MUSIC"
     * },
     * {
     * "name": "菜单",
     * "sub_button": {
     * "list": [
     * {
     * "type": "view",
     * "name": "搜索",
     * "url": "http://www.soso.com/"
     * },
     * {
     * "type": "view",
     * "name": "视频",
     * "url": "http://v.qq.com/"
     * },
     * {
     * "type": "click",
     * "name": "赞一下我们",
     * "key": "V1001_GOOD"
     * }
     * ]
     * }
     * }
     * ]
     * }
     * }
     * 参数说明
     *
     * 参数 说明
     * is_menu_open 菜单是否开启，0代表未开启，1代表开启
     * selfmenu_info 菜单信息
     * button 菜单按钮
     * type 菜单的类型，公众平台官网上能够设置的菜单类型有view（跳转网页）、text（返回文本，下同）、img、photo、video、voice。使用API设置的则有8种，详见《自定义菜单创建接口》
     * name 菜单名称
     * value、url、key等字段 对于不同的菜单类型，value的值意义不同。官网上设置的自定义菜单：
     * Text:保存文字到value； Img、voice：保存mediaID到value； Video：保存视频下载链接到value； News：保存图文消息到news_info； View：保存链接到url。
     *
     * 使用API设置的自定义菜单： click、scancode_push、scancode_waitmsg、pic_sysphoto、pic_photo_or_album、 pic_weixin、location_select：保存值到key；view：保存链接到url
     *
     * news_info 图文消息的信息
     * title 图文消息的标题
     * digest 摘要
     * author 作者
     * show_cover 是否显示封面，0为不显示，1为显示
     * cover_url 封面图片的URL
     * content_url 正文的URL
     * source_url 原文的URL，若置空则无查看原文入口
     */
    public function getCurrentSelfMenuInfo()
    {
        $rst = $this->_request->get($this->_url . 'get_current_selfmenu_info', array());
        return $this->_client->rst($rst);
    }

    /**
     * 创建个性化菜单
     *
     * http请求方式：POST（请使用https协议）
     *
     * https://api.weixin.qq.com/cgi-bin/menu/addconditional?access_token=ACCESS_TOKEN
     * 请求示例
     *
     * {
     * "button":[
     * {
     * "type":"click",
     * "name":"今日歌曲",
     * "key":"V1001_TODAY_MUSIC"
     * },
     * {
     * "name":"菜单",
     * "sub_button":[
     * {
     * "type":"view",
     * "name":"搜索",
     * "url":"http://www.soso.com/"
     * },
     * {
     * "type":"view",
     * "name":"视频",
     * "url":"http://v.qq.com/"
     * },
     * {
     * "type":"click",
     * "name":"赞一下我们",
     * "key":"V1001_GOOD"
     * }]
     * }],
     * "matchrule":{
     * "tag_id": "2",
     * "sex": "1",
     * "country": "中国",
     * "province": "广东",
     * "city": "广州",
     * "client_platform_type": "2",
     * "language": "zh_CN"
     * }
     * }
     * 参数说明
     *
     * 参数 是否必须 说明
     * button 是 一级菜单数组，个数应为1~3个
     * sub_button 否 二级菜单数组，个数应为1~5个
     * type 是 菜单的响应动作类型
     * name 是 菜单标题，不超过16个字节，子菜单不超过40个字节
     * key click等点击类型必须 菜单KEY值，用于消息接口推送，不超过128字节
     * url view类型必须 网页链接，用户点击菜单可打开链接，不超过1024字节
     * media_id media_id类型和view_limited类型必须 调用新增永久素材接口返回的合法media_id
     * article_id article_id类型和article_view_limited类型必须 发布后获得的合法 article_id
     * appid miniprogram类型必须 小程序的appid
     * pagepath miniprogram类型必须 小程序的页面路径
     * matchrule 是 菜单匹配规则
     * tag_id 否 用户标签的id，可通过用户标签管理接口获取
     * sex 已废除 性别：男（1）女（2），不填则不做匹配
     * client_platform_type 否 客户端版本，当前只具体到系统型号：IOS(1), Android(2),Others(3)，不填则不做匹配
     * country 已废除 国家信息，是用户在微信中设置的地区，具体请参考地区信息表
     * province 已废除 省份信息，是用户在微信中设置的地区，具体请参考地区信息表
     * city 已废除 城市信息，是用户在微信中设置的地区，具体请参考地区信息表
     * language 已废除 语言信息，是用户在微信中设置的语言，具体请参考语言表： 1、简体中文 "zh_CN" 2、繁体中文TW "zh_TW"
     * matchrule共七个字段，均可为空，但不能全部为空，至少要有一个匹配信息是不为空的。 country、province、city组成地区信息，将按照country、province、city的顺序进行验证，要符合地区信息表的内容。地区信息从大到小验证，小的可以不填，即若填写了省份信息，则国家信息也必填并且匹配，城市信息可以不填。 例如 “中国 广东省 广州市”、“中国 广东省”都是合法的地域信息，而“中国 广州市”则不合法，因为填写了城市信息但没有填写省份信息。 地区信息表请点击下载。
     *
     * 返回结果
     *
     * 正确时的返回JSON数据包如下，错误时的返回码请见接口返回码说明。
     *
     * {
     * "menuid":"208379533"
     * }
     */
    public function addconditional($menusWithMatchrule)
    {
        $rst = $this->_request->post($this->_url . 'menu/addconditional', $menusWithMatchrule);
        return $this->_client->rst($rst);
    }

    /**
     * 删除个性化菜单
     *
     * http请求方式：POST（请使用https协议）
     *
     * https://api.weixin.qq.com/cgi-bin/menu/delconditional?access_token=ACCESS_TOKEN
     * 请求示例
     *
     * {
     * "menuid":"208379533"
     * }
     * menuid为菜单id，可以通过自定义菜单查询接口获取。
     *
     * 正确时的返回JSON数据包如下，错误时的返回码请见接口返回码说明。：
     *
     * {"errcode":0,"errmsg":"ok"}
     */
    public function delconditional($menuid)
    {
        $params = array(
            "menuid" => $menuid
        );
        $rst = $this->_request->post($this->_url . 'menu/delconditional', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 测试个性化菜单匹配结果
     *
     * http请求方式：POST（请使用https协议）
     *
     * https://api.weixin.qq.com/cgi-bin/menu/trymatch?access_token=ACCESS_TOKEN
     * 请求示例
     *
     * {
     * "user_id":"weixin"
     * }
     * user_id可以是粉丝的OpenID，也可以是粉丝的微信号。
     *
     * 返回结果 该接口将返回菜单配置，示例如下：
     *
     * {
     * "button": [
     * {
     * "type": "view",
     * "name": "tx",
     * "url": "http://www.qq.com/",
     * "sub_button": [ ]
     * },
     * {
     * "type": "view",
     * "name": "tx",
     * "url": "http://www.qq.com/",
     * "sub_button": [ ]
     * },
     * {
     * "type": "view",
     * "name": "tx",
     * "url": "http://www.qq.com/",
     * "sub_button": [ ]
     * }
     * ]
     * }
     * 错误时的返回码请见接口返回码说明。
     *
     * @param string $user_id        	
     */
    public function trymatch($user_id)
    {
        $params = array(
            "user_id" => $user_id
        );
        $rst = $this->_request->post($this->_url . 'menu/trymatch', $params);
        return $this->_client->rst($rst);
    }
}
