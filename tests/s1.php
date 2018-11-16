<?php
/*
 * This file is part of the php-code-coverage package.
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
require_once '../vendor/autoload.php';

try {
    // 集资购
    $openid = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';
    // appid
    $appid = 'wxbf9165206b992f39'; // appID

    $secret = '08f81abfab87863a1de2cf13af417a55'; // appsecret

    // 获得access_token

    // doGetAccessTokenTest($appid, $secret);
    $access_token = 'yMzBpLlUQFcQhjwEgv0AVeMhRc6pFu0mV0XOqCje7EKNgzTrQKh-Byj-IWRvktEiA4QOfiHI-W8xQR6AAObi_364UwQSHTNo272Ix6OW9jEFAGgADAOJP';

    // JSSDK

    // doJssdkTest($appid, $secret, $access_token)

    $client = new \Weixin\Client();
    $client->setAccessToken($access_token);

    // 获取微信服务器IP地址接口 -----测试全通过了
    doIpTest($client);

    // 分组管理接口 -----测试全通过了
    doGroupTest($client);

    // 长链接转短链接接口 -----测试全通过了
    doShortUrlTest($client);

    // 语义理解接口 -----测试全通过了
    doSemanticTest($client);

    // 推广支持接口 -----测试全通过了
    doQrcodeTest($client);

    // 自定义菜单接口 -----测试全通过了
    doMenuTest($client);

    // 客服消息 -----测试全通过了
    doCustomServiceTest($client);

    // 数据统计接口 -----测试全通过了
    doDatacubeTest($client);

    // 用户管理 -----测试全通过了
    doUserTest($client);

    // 素材管理 -----测试全通过了
    doMaterialTest($client);

    // 多媒体管理 -----测试全通过了
    doMediaTest($client);

    // SNS用户管理 -----测试全通过了
    doSnsUserTest($client);

    // POI 门店管理接口 -----测试全通过了
    doPoiTest($client);

    // 消息控制器
    doMsgTest($client);

    // 微信卡券
    doCardTest($client);

    die('<br/>OK');
} catch (Exception $e) {
    die('<br/>ERROR:' . $e->getMessage());
}

function doGetAccessTokenTest($appid, $secret): void
{
    // $server = new \Weixin\Token\Server($appid, $secret);
    // $access_token = $server->getAccessToken();
    // $access_token = ($access_token['access_token']);
    // die($access_token);
}

function doJssdkTest($appid, $secret, $access_token): void
{
    // echo "<br/>获得jsapi_ticket接口<br/>";
    // $jssdk = new \Weixin\Jssdk();
    // $jssdk->setAppId($appid);
    // $jssdk->setAppSecret($secret);
    // $jssdk->setAccessToken($access_token);
    // $ret = $jssdk->getJsApiTicket();
    // print_r($ret);
}

function doIpTest($client): void
{
    // echo "<br/>获取微信服务器IP地址接口<br/>";
    // $ret = $client->getIpManager()->getcallbackip();
    // print_r($ret);
}

function doGroupTest($client): void
{
    $openid     = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';
    $to_groupid = 100;

    // echo "<br/>获取创建分组接口<br/>";
    // $ret = $client->getGroupManager()->create('测试组' . uniqid());
    // print_r($ret);

    // echo "<br/>获取修改分组名接口<br/>";
    // $ret = $client->getGroupManager()->update($to_groupid, '修改测试组' . uniqid());
    // print_r($ret);

    // echo "<br/>移动用户分组接口<br/>";

    // $ret = $client->getGroupManager()->membersUpdate($openid, $to_groupid);
    // print_r($ret);

    // echo "<br/>批量移动用户分组接口<br/>";
    // $openid_list = array(
    // $openid
    // );
    // $ret = $client->getGroupManager()->membersBatchUpdate($openid_list, $to_groupid);
    // print_r($ret);

    // echo "<br/>获取查询分组接口<br/>";
    // $ret = $client->getGroupManager()->get();
    // print_r($ret);

    // echo "<br/>获取查询用户所在分组接口<br/>";
    // $ret = $client->getGroupManager()->getid($openid);
    // print_r($ret);
}

function doShortUrlTest($client): void
{
    // echo "<br/>将一条长链接转成短链接接口<br/>";
    // $long_url = 'http://www.baidu.com/?a=1&b=2&c=3';
    // $ret = $client->getShortUrlManager()->long2short($long_url);
    // print_r($ret);
}

function doSemanticTest($client): void
{
    // echo "<br/>发送语义理解请求接口<br/>";
    // $query = "查一下明天从北京到上海的南航机票";
    // $latitude = $longitude = 0;
    // $city = "北京";
    // $region = '';
    // $category = "flight,hotel";
    // // $appid="wxaaaaaaaaaaaaaaaa";
    // $uid = $openid;
    // $ret = $client->getSemanticManager()->search($query, $category, $latitude, $longitude, $city, $region, $appid, $uid);
    // print_r($ret);
}

function doQrcodeTest($client): void
{
    // echo "<br/>创建二维码ticket<br/>";
    // $scene_id = 123;
    // $isTemporary = true;
    // $expire_seconds = 1800;
    // $ret = $client->getQrcodeManager()->create($scene_id, $isTemporary, $expire_seconds);
    // print_r($ret);

    // echo "<br/>通过ticket换取二维码<br/>";
    // $ticket = $ret['ticket'];
    // $ret = $client->getQrcodeManager()->getQrcodeUrl($ticket);
    // echo "<br/>创建二维码ticket:{$ret}<br/>";
}

function doMsgTest($client): void
{
    $toUser = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';

    // echo "<br/>获取自动回复规则<br/>";
    // $ret = $client->getMsgManager()->getCurrentAutoreplyInfo();
    // print_r($ret);

    // echo "<br/>发送客服消息接口<br/>";
    $content = '<a href="http://wwww.baidu.com/">我是郭永荣</a>';
    $ret     = $client->getMsgManager()
        ->getCustomSender()
        ->sendText($toUser, $content);
    \print_r($ret);

    // echo "<br/>获取设置的行业信息<br/>";
    // $ret = $client->getMsgManager()
    // ->getTemplateSender()
    // ->getIndustry();
    // print_r($ret);
    // echo "<br/>获取模板列表<br/>";
    // $ret = $client->getMsgManager()
    // ->getTemplateSender()
    // ->getAllPrivateTemplate();
    // print_r($ret);

    // echo "<br/>模板消息接口<br/>";
    // $touser = $toUser;
    // $template_id = 'McTMKUJT9nJlg7O0qhwbvuwntvab7IrQ9I61OsbsHNI';
    // $url = 'http://www.baidu.com/';
    // $topcolor = '#0A0A0A';
    // $data = array(
    // 'name' => array(
    // 'value' => "郭永荣",
    // 'color' => "#0A0A0A"
    // ),
    // 'remark' => array(
    // 'value' => "备注remark",
    // 'color' => "#0A0A0A"
    // )
    // );
    // $ret = $client->getMsgManager()
    // ->getTemplateSender()
    // ->send($touser, $template_id, $url, $topcolor, $data);
    // print_r($ret);

    // echo "<br/>发送群发消息接口<br/>";
    // $content = '我是郭永荣';
    // $ret = $client->getMsgManager()
    // ->getMassSender()
    // ->sendTextByOpenid($toUser, $content);
    // print_r($ret);
}

function doMenuTest($client): void
{
    // echo "<br/>删除个性化菜单接口<br/>";
    // $menuid = '411954054';
    // $ret = $client->getMenuManager()->delconditional($menuid);
    // print_r($ret);

    // echo "<br/>自定义菜单删除接口<br/>";
    // $ret = $client->getMenuManager()->delete(array());
    // print_r($ret);

    // echo "<br/>自定义菜单创建接口<br/>";
    // $strmenu = '{"button":[
    // {
    // "type":"click",
    // "name":"今日歌曲",
    // "key":"V1001_TODAY_MUSIC"
    // },
    // {
    // "name":"菜单",
    // "sub_button":[
    // {
    // "type":"view",
    // "name":"搜索",
    // "url":"http://www.soso.com/"
    // },
    // {
    // "type":"view",
    // "name":"视频",
    // "url":"http://v.qq.com/"
    // },
    // {
    // "type":"click",
    // "name":"赞一下我们",
    // "key":"V1001_GOOD"
    // }]
    // }]
    // }';
    // $menus = json_decode($strmenu, true);
    // $ret = $client->getMenuManager()->create($menus);
    // print_r($ret);

    // echo "<br/>创建个性化菜单接口<br/>";
    // $strconditionalmenu = '{
    // "button":[
    // {
    // "type":"click",
    // "name":"个性化歌曲",
    // "key":"V1001_TODAY_MUSIC"
    // },
    // {
    // "name":"个性化菜单",
    // "sub_button":[
    // {
    // "type":"view",
    // "name":"搜索",
    // "url":"http://www.soso.com/"
    // },
    // {
    // "type":"view",
    // "name":"视频",
    // "url":"http://v.qq.com/"
    // },
    // {
    // "type":"click",
    // "name":"赞一下我们",
    // "key":"V1001_GOOD"
    // }]
    // }],
    // "matchrule":{
    // "client_platform_type":"1"
    // }
    // }';
    // $menusWithMatchrule = json_decode($strconditionalmenu, true);
    // $ret = $client->getMenuManager()->addconditional($menusWithMatchrule);
    // print_r($ret);

    // echo "<br/>获取自定义菜单配置接口<br/>";
    // $ret = $client->getMenuManager()->getCurrentSelfMenuInfo();
    // print_r($ret);

    // echo "<br/>自定义菜单查询接口<br/>";
    // $ret = $client->getMenuManager()->get();
    // print_r($ret);

    // echo "<br/>测试个性化菜单匹配结果<br/>";
    // $openid = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';
    // $ret = $client->getMenuManager()->trymatch($openid);
    // print_r($ret);
}

function doCustomServiceTest($client): void
{
    // // 客服消息
    $openid = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';

    // echo "<br/>上传客服头像接口<br/>";
    // $media = __DIR__ . '/111.jpg';
    // $ret = $client->getCustomServiceManager()->kfacountUploadheadimg("kf2001@gh_abc8231997cb", $media);
    // print_r($ret);

    // $kf_account = "kf2002@gh_abc8231997cb";
    // echo "<br/> 添加客服帐号接口<br/>";
    // $nickname = "郭永荣测试";
    // $password = md5("123456");
    // $ret = $client->getCustomServiceManager()->kfaccountAdd($kf_account, $nickname, $password);
    // print_r($ret);

    // echo "<br/> 设置客服信息接口<br/>";
    // $nickname = "郭永荣2";
    // $password = md5("12345678");
    // $ret = $client->getCustomServiceManager()->kfaccountUpdate($kf_account, $nickname, $password);
    // print_r($ret);

    // echo "<br/> 邀请绑定客服帐号接口<br/>";
    // $ret = $client->getCustomServiceManager()->inviteWorker($kf_account, "Guo-YR");
    // print_r($ret);

    // echo "<br/> 获取客服基本信息接口<br/>";
    // $ret = $client->getCustomServiceManager()->getkflist();
    // print_r($ret);

    // echo "<br/> 获取在线客服接待信息接口<br/>";
    // $ret = $client->getCustomServiceManager()->getonlinekflist();
    // print_r($ret);

    // echo "<br/>获取客服聊天记录接口<br/>";
    // $ret = $client->getCustomServiceManager()->getRecord("", time() - 3600 * 24, time(), 1, 50);
    // print_r($ret);

    // echo "<br/> 删除客服账号接口<br/>";
    // $ret = $client->getCustomServiceManager()->kfaccountDel($kf_account);
    // print_r($ret);
}

function doDatacubeTest($client): void
{
    // echo "<br/>获取 用户分析数据接口<br/>";
    // $begin_date = '2016-06-13';
    // $end_date = '2016-06-14';
    // $ret = $client->getDatacubeManager()->getUserSummary($begin_date, $end_date);
    // print_r($ret);
}

function doUserTest($client): void
{
    // $openid = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';
    // echo "<br/>获取用户基本信息接口<br/>";
    // $ret = $client->getUserManager()->getUserInfo($openid);
    // print_r($ret);

    // echo "<br/>获取关注者列表接口<br/>";
    // $ret = $client->getUserManager()->getUser();
    // print_r($ret);

    // echo "<br/>设置备注名接口<br/>";
    // $remark = '郭永荣备注';
    // $ret = $client->getUserManager()->updateRemark($openid, $remark);
    // print_r($ret);
}

function doPoiTest($client): void
{
    // echo "<br/>上传图片接口<br/>";
    // $img = __DIR__ . '/111.jpg';
    // $ret = $client->getPoiManager()->uploadImg($img);
    // [url] => http:\/\/mmbiz.qpic.cn\/mmbiz\/OEUan7AibOibQiaVJKrsNHwsS1sib1XRPYTx5qJCmL8fwT5iarYiaxhG5fDDric0UiayUia89ibf1PgfW1UbTsktqHMuotFQ\/0 )
    // print_r($ret);

    // echo "<br/>创建门店接口<br/>";
    // $sid = "33788392";
    // $business_name = "麦当劳";
    // $branch_name = "艺苑路店";
    // $province = "广东省";
    // $city = "广州市";
    // $district = "海珠区";
    // $address = "艺苑路 11 号";
    // $telephone = "020-12345678";
    // $categories = array(
    // "美食,火锅"
    // );
    // $offset_type = 1;
    // $longitude = 115.32375;
    // $latitude = 25.097486;
    // $photo_list = array(
    // array(
    // "photo_url" => "http://mmbiz.qpic.cn/mmbiz/OEUan7AibOibQiaVJKrsNHwsS1sib1XRPYTx5qJCmL8fwT5iarYiaxhG5fDDric0UiayUia89ibf1PgfW1UbTsktqHMuotFQ/0"
    // )
    // );
    // $recommend = "麦辣鸡腿堡套餐，麦乐鸡，全家桶";
    // $special = "免费 wifi，外卖服务";
    // $introduction = "麦当劳是全球大型跨国连锁餐厅，1940 年创立于美国，在世界上大约拥有 3 万间分店。主要售卖汉堡包，以及薯条、炸鸡、汽水、冰品、沙拉、水果等快餐食品";
    // $open_time = "8:00-20:00";
    // $avg_price = 35;
    // $poi = new \Weixin\Model\Poi($sid, $business_name, $branch_name, $province, $city, $district, $address, $telephone, $categories, $offset_type, $longitude, $latitude, $photo_list, $recommend, $special, $introduction, $open_time, $avg_price);
    // $ret = $client->getPoiManager()->addPoi($poi);
    // // [poi_id] => 461549648
    // print_r($ret);

    // echo "<br/>修改门店服务信息接口<br/>";
    // $poi_id = '461549648';
    // $ret = $client->getPoiManager()->updatePoi($poi_id, "020-56781234");
    // print_r($ret);

    // echo "<br/>查询门店信息接口<br/>";
    // $poi_id = '461549648';
    // $ret = $client->getPoiManager()->getPoi($poi_id);
    // print_r($ret);

    // echo "<br/>查询门店列表接口<br/>";
    // $begin = 0;
    // $limit = 20;
    // $ret = $client->getPoiManager()->getPoiList($begin, $limit);
    // print_r($ret);

    // echo "<br/>删除门店接口<br/>";
    // $poi_id = '461549648';
    // $ret = $client->getPoiManager()->delPoi($poi_id);
    // print_r($ret);
}

function doMaterialTest($client): void
{
    // echo "<br/>获取素材总数接口<br/>";
    // $ret = $client->getMaterialManager()->getMaterialCount();
    // print_r($ret);

    // echo "<br/>获取素材总数接口<br/>";
    // $type = 'image';
    // $offset = 0;
    // $count = 20;
    // $ret = $client->getMaterialManager()->batchGetMaterial($type, $offset, $count);
    // print_r($ret);
    // echo "<br/>新增其他类型永久素材接口<br/>";
    // $type = 'image';
    // $media = __DIR__ . '/111.jpg';
    // $description = array(
    // "title" => 'VIDEO_TITLE',
    // "introduction" => 'INTRODUCTION'
    // );
    // $ret = $client->getMaterialManager()->addMaterial($type, $media, $description);
    // print_r($ret);
    // // [media_id] => 9hlY6SpfMJHSxL7ZUJ3v9kZLCp0AamZ904uNkp4jkzA [url] => https:\/\/mmbiz.qlogo.cn\/mmbiz\/OEUan7AibOibQiaVJKrsNHwsS1sib1XRPYTx5qJCmL8fwT5iarYiaxhG5fDDric0UiayUia89ibf1PgfW1UbTsktqHMuotFQ\/0?wx_fmt=jpeg

    // echo "<br/>新增永久图文素材接口<br/>";
    // $media_id = "9hlY6SpfMJHSxL7ZUJ3v9kZLCp0AamZ904uNkp4jkzA";
    // $articles[] = array(
    // "title" => 'TITLE',
    // "thumb_media_id" => $media_id,
    // "author" => 'AUTHOR',
    // "digest" => 'DIGEST',
    // "show_cover_pic" => 0,
    // "content" => 'CONTENT',
    // "content_source_url" => 'www.baidu.com'
    // );
    // $ret = $client->getMaterialManager()->addNews($articles);
    // print_r($ret);

    // echo "<br/>修改永久图文素材接口<br/>";
    // $media_id = '9hlY6SpfMJHSxL7ZUJ3v9uLHEZbgxclHXSeNHIPMab8';
    // $article = array(
    // "title" => 'TITLE2',
    // "thumb_media_id" => $media_id,
    // "author" => 'AUTHOR2',
    // "digest" => 'DIGEST2',
    // "show_cover_pic" => 0,
    // "content" => 'CONTENT2',
    // "content_source_url" => 'www.baidu.com'
    // );
    // $ret = $client->getMaterialManager()->updateNews($media_id, 0, $article);
    // print_r($ret);

    // echo "<br/>获取永久素材接口<br/>";
    // $media_id = "9hlY6SpfMJHSxL7ZUJ3v9uLHEZbgxclHXSeNHIPMab8";
    // $ret = $client->getMaterialManager()->getMaterial($media_id);
    // print_r($ret);

    // echo "<br/>删除永久素材接口<br/>";
    // $media_id = "9hlY6SpfMJHSxL7ZUJ3v9uLHEZbgxclHXSeNHIPMab8";
    // $ret = $client->getMaterialManager()->delMaterial($media_id);
    // print_r($ret);
}

function doCardTest($client): void
{
    $openid = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';
    // echo "<br/>获取颜色列表接口<br/>";
    // $ret = $client->getCardManager()->getcolors();
    // print_r($ret);

    // echo "<br/>获取api_ticket接口<br/>";
    // $ret = $client->getCardManager()->getApiTicket();
    // // [ticket] => IpK_1T69hDhZkLQTlwsAX6NKjT3f-mDEFC5b0gdbHWwj1dvR0aMO51gDDdNsQYmatg3f5qYwlAXuL4W-Pb9i2g
    // print_r($ret);

    // echo "<br/>上传LOGO接口<br/>";
    // $logo = __DIR__ . '/111.jpg';
    // $ret = $client->getCardManager()->uploadLogoUrl($logo);
    // // [url] => http:\/\/mmbiz.qpic.cn\/mmbiz\/OEUan7AibOibQiaVJKrsNHwsS1sib1XRPYTx5qJCmL8fwT5iarYiaxhG5fDDric0UiayUia89ibf1PgfW1UbTsktqHMuotFQ\/0
    // print_r($ret);

    // echo "<br/>创建卡券接口<br/>";
    // $logo_url = 'http://mmbiz.qpic.cn/mmbiz/OEUan7AibOibQiaVJKrsNHwsS1sib1XRPYTx5qJCmL8fwT5iarYiaxhG5fDDric0UiayUia89ibf1PgfW1UbTsktqHMuotFQ/0';
    // $brand_name = '集资购';
    // $code_type = 'CODE_TYPE_TEXT';
    // $title = '132元双人火锅套餐';
    // $color = 'Color010';
    // $notice = '使用时向服务员出示此券';
    // $description = '不可与其他优惠同享\n如需团购券发票，请在消费时向商户提出\n店内均可使用，仅限堂食';
    // $date_info = new \Weixin\Model\DateInfo(1, time(), time() + 3600 * 24 * 30, 0, 0);
    // $sku = new \Weixin\Model\Sku(100);
    // $base_info = new \Weixin\Model\BaseInfo($logo_url, $brand_name, $code_type, $title, $color, $notice, $description, $date_info, $sku);
    // $card = new \Weixin\Model\Gift($base_info, '礼品测试券');
    // $ret = $client->getCardManager()->create($card);
    // // [card_id] => p4ELSv7NKJSlAJkfahZv9Ksp-jp4
    // print_r($ret);

    // echo "<br/>生成卡券二维码接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->qrcodeCreate($card_id);
    // // [ticket] => gQE58ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0hFVDNvU0RsRzFWaThCNTlubThrAAIE6u5tVwMEgDPhAQ== [expire_seconds] => 31536000 [url] => http:\/\/weixin.qq.com\/q\/HET3oSDlG1Vi8B59nm8k [show_qrcode_url] => https:\/\/mp.weixin.qq.com\/cgi-bin\/showqrcode?ticket=gQE58ToAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0hFVDNvU0RsRzFWaThCNTlubThrAAIE6u5tVwMEgDPhAQ%3D%3D
    // print_r($ret);

    // echo "<br/>生成卡券二维码接口2<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $card_list = array(
    // array(
    // 'card_id' => $card_id
    // )
    // );
    // $ret = $client->getCardManager()->qrcodeCreate4Multiple($card_list);
    // // [ticket] => gQHU7joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FrVGd5c1BsTWxWTGFnd29pV01rAAIEWe9tVwMEAKd2AA== [expire_seconds] => 7776000 [url] => http:\/\/weixin.qq.com\/q\/AkTgysPlMlVLagwoiWMk [show_qrcode_url] => https:\/\/mp.weixin.qq.com\/cgi-bin\/showqrcode?ticket=gQHU7joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL0FrVGd5c1BsTWxWTGFnd29pV01rAAIEWe9tVwMEAKd2AA%3D%3D
    // print_r($ret);

    // echo "<br/>消耗code接口<br/>";
    // $code = "351024475330";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->codeConsume($code, $card_id);
    // // [card] => Array ( [card_id] => p4ELSv7NKJSlAJkfahZv9Ksp-jp4 ) [openid] => o4ELSvz-B4_DThF0Vpfrverk3IpY )
    // print_r($ret);

    // echo "<br/>code 解码接口<br/>";
    // $encrypt_code = "XXIzTtMqCxwOaawoE91+VJdsFmv7b8g0VZIZkqf4GWA60Fzpc8ksZ/5ZZ0DVkXdE";
    // $ret = $client->getCardManager()->codeDecrypt($encrypt_code);
    // print_r($ret);

    // echo "<br/>删除卡券接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->delete($card_id);
    // print_r($ret);

    // echo "<br/>批量查询卡列表接口<br/>";
    // $ret = $client->getCardManager()->batchget(0, 50);
    // print_r($ret);

    // echo "<br/>查询卡券详情接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->get($card_id);
    // print_r($ret);

    // echo "<br/>查询code接口<br/>";
    // $code = "158392864911";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->codeGet($code, $card_id);
    // print_r($ret);

    // echo "<br/>更改code接口<br/>";
    // $code = "158392864911";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $new_code = "899924475330";
    // $ret = $client->getCardManager()->codeUpdate($code, $card_id, $new_code);
    // print_r($ret);

    // echo "<br/>设置卡券失效接口<br/>";
    // $code = "899924475330";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->codeUnavailable($code, $card_id);
    // print_r($ret);

    // echo "<br/>更改卡券信息接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $logo_url = 'http://mmbiz.qpic.cn/mmbiz/OEUan7AibOibQiaVJKrsNHwsS1sib1XRPYTx5qJCmL8fwT5iarYiaxhG5fDDric0UiayUia89ibf1PgfW1UbTsktqHMuotFQ/0';
    // $brand_name = '集资购2';
    // $code_type = 'CODE_TYPE_TEXT';
    // $title = '132元双人火锅套餐2';
    // $color = 'Color020';
    // $notice = '使用时向服务员出示此券2';
    // $description = '不可与其他优惠同享如需团购券发票，请在消费时向商户提出店内均可使用，仅限堂食';
    // $date_info = new \Weixin\Model\DateInfo(1, time(), time() + 3600 * 24 * 30, 0, 0);
    // $sku = new \Weixin\Model\Sku(200);
    // $base_info = new \Weixin\Model\BaseInfo($logo_url, $brand_name, $code_type, $title, $color, $notice, $description, $date_info, $sku);
    // $base_info->card_id = $card_id;
    // $card = new \Weixin\Model\Gift($base_info, '礼品测试券2');
    // $ret = $client->getCardManager()->update($card);
    // print_r($ret);

    // echo "<br/>库存修改接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $increase_stock_value = 2;
    // $reduce_stock_value = 0;
    // $ret = $client->getCardManager()->modifyStock($card_id, $increase_stock_value, $reduce_stock_value);
    // print_r($ret);

    // echo "<br/>设置测试用户白名单接口<br/>";
    // $openids = array(
    // $openid
    // );
    // $ret = $client->getCardManager()->testwhitelistSet($openids, array());
    // print_r($ret);

    // echo "<br/>导入code 接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $codes = array(
    // '7897979797'
    // );
    // $ret = $client->getCardManager()->codeDeposit($card_id, $codes);
    // print_r($ret);

    // echo "<br/>查询导入code数目接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $ret = $client->getCardManager()->codeGetDepositCount($card_id);
    // print_r($ret);

    // echo "<br/>核查code接口<br/>";
    // $card_id = 'p4ELSv7NKJSlAJkfahZv9Ksp-jp4';
    // $codes = array(
    // '7897979797',
    // '158392864911'
    // );
    // $ret = $client->getCardManager()->codeCheck($card_id, $codes);
    // print_r($ret);
}

function doMediaTest($client): void
{
    // echo "<br/>新增临时素材接口<br/>";
    // $media = __DIR__ . '/111.jpg';
    // $ret = $client->getMediaManager()->upload('image', $media);
    // print_r($ret);
    // die('sfsd');
    // echo "<br/>上传图片接口-本地文件<br/>";
    // $media = __DIR__ . '/111.jpg';
    // $ret = $client->getMediaManager()->uploadImg($media);
    // print_r($ret);
    // (
    // [url] => http://mmbiz.qpic.cn/mmbiz/OEUan7AibOibTLQIuXPI9KZ7cLnOadiaMI76DI7gT4XTM2vyu9G3G6cqtiaAQUUfIxDOErgZq94ShwX6aovNRZdTHw/0
    // )
    // echo "<br/>上传图片接口-网络文件<br/>";
    // $media = 'http://mmbiz.qpic.cn/mmbiz/OEUan7AibOibTLQIuXPI9KZ7cLnOadiaMI76DI7gT4XTM2vyu9G3G6cqtiaAQUUfIxDOErgZq94ShwX6aovNRZdTHw/0';
    // $ret = $client->getMediaManager()->uploadImg($media);
    // print_r($ret);
    // echo "<br/>获取临时素材接口<br/>";
    // // $mediaId = $ret['media_id'];
    // $mediaId = 'mucsxFRCO8pglwMZbvX9LA6lEeWiXZCxzcK6ZEsSLWGCL0PDOQTxN4KukTcZotLb';
    // $ret = $client->getMediaManager()->download($mediaId);
    // print_r($ret);

    // echo "<br/>上传图文消息素材（用于群发图文消息）接口<br/>";
    // $articles[] = array(
    // "thumb_media_id" => 'HWtby8qXD5ClD1VAfkCVo5Yf-e3b6e7GCBKqth542D8qqeYt7iTEfdCaWjQ3O3dr',
    // "author" => "郭永荣",
    // "title" => "Happy Day",
    // "content_source_url" => "www.qq.com",
    // "content" => "content",
    // "digest" => "digest",
    // "show_cover_pic" => 1
    // );
    // $ret = $client->getMediaManager()->uploadNews($articles);
    // print_r($ret);
    // // [media_id] => 0xJYpNdMuzDkoJ1iO3Hl1URzOSTwGQFx_ZTjxXblxhC3JeoIX6pmR2H7LboI_uM-
}

function doSnsUserTest($client): void
{
    // echo "<br/>检验授权凭证（access_token）是否有效接口<br/>";
    // $accessToken = '';
    // $openid = 'o4ELSvz-B4_DThF0Vpfrverk3IpY';
    // $ret = $client->setSnsAccessToken($accessToken)
    // ->getSnsManager()
    // ->auth($openid);
    // print_r($ret);
}
