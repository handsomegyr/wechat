<?php

namespace Weixin\Channels\Ec\Manager;

use Weixin\Client;

/**
 * 分享员管理API
 * https://developers.weixin.qq.com/doc/store/API/sharer/bindsharer.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Sharer
{
    // 接口地址
    private $_url = 'https://api.weixin.qq.com/channels/ec/sharer/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 微信小店API /分享员API /邀请分享员
     * 邀请分享员
     * 接口说明
     * 可通过此接口邀请小店普通分享员
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/bind?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * username string 否 邀请的用户微信号，非必填。若填写则生成的二维码为一人一码，仅允许该微信号用户扫码绑定；若不填写则生成的二维码为多人一码，允许多人扫码绑定
     * 请求参数示例
     * {
     * "username": "XXXXXX"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * qrcode_img string 邀请二维码的图片二进制，15天有效
     * qrcode_img_base64 string 邀请二维码的图片二进制base64编码，15天有效
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "qrcode_img": "@test.jpg",
     * "qrcode_img_base64": "6YKA6K+35LqM57u056CB55qE5Zu+54mH5LqM6L+b5Yi2YmFzZTY057yW56CB77yMM+WkqeacieaViA=="
     * }
     */
    public function bind($username)
    {
        $params = array();
        $params['username'] = $username;
        $rst = $this->_request->post($this->_url . 'bind', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /分享员API /获取绑定的分享员
     * 获取绑定的分享员
     * 接口说明
     * 可通过该接口获取绑定的分享员
     *
     * 注意事项
     * 当获取的分享员未绑定时，返回空值；
     * 店铺分享员在店铺管理页邀请；
     * 普通分享员通过邀请分享员接口邀请。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/search_sharer?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * openid string 否 分享员openid(填openid与username其中一个即可)
     * username string 否 分享员微信号(填openid与username其中一个即可)
     * 请求参数示例
     * {
     * "openid": "OPENID",
     * "username": "USERNAME"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * openid string 分享员openid
     * nickname string 分享员昵称
     * bind_time number 绑定时间
     * sharer_type number 分享员类型，枚举值详情请参考SharerType
     * unionid string 分享员unionid
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "openid": "OPENID",
     * "nickname": "NICKNAME",
     * "bind_time": 1624082155,
     * "sharer_type": 0,
     * "unionid": "UNIONID"
     * }
     */
    public function searchSharer($openid, $username)
    {
        $params = array();
        if (!empty($openid)) {
            $params['openid'] = $openid;
        }
        if (!empty($username)) {
            $params['username'] = $username;
        }
        $rst = $this->_request->post($this->_url . 'search_sharer', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /分享员API /获取绑定的分享员列表
     * 获取绑定的分享员列表
     * 接口说明
     * 该接口用于获取已绑定的分享员列表
     *
     * 注意事项
     * 店铺分享员在店铺管理页邀请；
     * 普通分享员通过邀请分享员接口邀请。
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_sharer_list?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * page number 是 分页参数，页数
     * page_size number 否 分页参数，每页分享员数（不超过100）
     * sharer_type number 是 分享员类型
     * 请求参数示例
     * {
     * "page": 1,
     * "page_size": 10,
     * "sharer_type": 0
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * sharer_info_list array object SharerInfo 分享员信息，结构体详情请参考SharerInfo
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "sharer_info_list": [
     * {
     * "openid": "OPENID",
     * "nickname": "NICKNAME",
     * "bind_time": 1624082155,
     * "sharer_type": 0,
     * "unionid": "UNIONID"
     * }
     * ]
     * }
     */
    public function getSharerList($sharer_type, $page = 1, $page_size = 100)
    {
        $params = array();
        $params['sharer_type'] = $sharer_type;
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        $rst = $this->_request->post($this->_url . 'get_sharer_list', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /分享员API /获取分享员订单列表
     * 获取分享员订单列表
     * 接口说明
     * 该接口用于获取分享员订单列表
     *
     * 注意事项
     * 只有分享视频号相关场景（如橱窗、直播间、视频号主页和短视频）成交的订单才会带上视频号场景信息。
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_sharer_order_list?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * openid string 否 分享员openid
     * share_scene number 否 分享场景，枚举值详情请参考ShareScene
     * page number 是 分页参数，页数
     * page_size number 否 分页参数，每页订单数（不超过100）
     * start_time number 否 订单创建开始时间
     * end_time number 否 订单创建结束时间
     * 请求参数示例
     * {
     * "openid": "XXXXXX",
     * "share_scene": 3,
     * "page": 1,
     * "page_size": 10,
     * "start_time": 1658505600,
     * "end_time": 1658509200
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * order_list array object SharerOrder 分享员订单，结构体详情请参考SharerOrder
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "order_list": [
     * {
     * "order_id": "3704612354559743232",
     * "share_scene": 3,
     * "sharer_openid": "SHAHER_OPENID",
     * "sharer_type": 1,
     * "sku_id": "1251651",
     * "product_id": "124124123121",
     * "from_wecom": false,
     * "finder_scene_info": {
     * "promoter_id": "PROMOTER_ID",
     * "finder_nickname": "FINDER_NICKNAME",
     * "live_export_id": "",
     * "video_export_id": "export/UzFfAgtgekIEAQAAAAAA6ycVwRPnFgAAAAstQy6ubaLX4KHWvLEZgBPE-4MsDn4MarGBzNPgMIo75qdR2YgQS2eoy7YeFsRJ",
     * "video_title": "TITLE",
     * }
     * }
     * ]
     * }
     */
    public function getSharerOrderList($openid, $share_scene, $page = 1, $page_size = 100, $start_time = null, $end_time = null)
    {
        $params = array();
        if (!empty($openid)) {
            $params['openid'] = $openid;
        }
        $params['share_scene'] = $share_scene;
        $params['page'] = $page;
        $params['page_size'] = $page_size;
        $params['start_time'] = $start_time;
        $params['end_time'] = $end_time;
        $rst = $this->_request->post($this->_url . 'get_sharer_order_list', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /分享员API /获取分享员专属的商品H5短链
     * 获取分享员专属的商品H5短链
     * 接口说明
     * 可通过该接口获取分享员专属的商品H5短链
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_sharer_product_h5url?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * openid string 是 分享员openid
     * 请求参数示例
     * {
     * "openid": "OPENID",
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_h5url string 商品h5短链
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_h5url": "https://channels.weixin.qq.com/shop/a/xsgVVZtSGpqwd45"
     * }
     */
    public function getSharerProductH5url($product_id, $openid)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . 'get_sharer_product_h5url', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /分享员API /获取分享员专属的商品口令
     * 获取分享员专属的商品口令
     * 接口说明
     * 可通过该接口获取分享员专属的商品口令
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_sharer_product_taglink?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * openid string 是 分享员openid
     * 请求参数示例
     * {
     * "openid": "OPENID",
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_taglink string 商品微信口令（只支持微信内打开）
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_taglink": "#微信小店://微信小店/jMv2lqYonCP1qqv"
     * }
     */
    public function getSharerProductTaglink($product_id, $openid)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . 'get_sharer_product_taglink', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 微信小店API /分享员API /获取分享员专属的商品二维码
     * 获取分享员专属的商品二维码
     * 接口说明
     * 可通过该接口获取分享员专属的商品二维码
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_sharer_product_qrcode?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * product_id string(uint64) 是 商品ID
     * openid string 是 分享员openid
     * 请求参数示例
     * {
     * "openid": "OPENID",
     * "product_id": "324545"
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * product_qrcode string 商品二维码链接
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "product_qrcode": "https://store.mp.video.tencent-cloud.com/161/20304/snscosdownload/SH/reserved/642a2b730001a542dbe0b846bcc4b00b002000a1000f4f50"
     * }
     */
    public function getSharerProductQrcode($product_id, $openid)
    {
        $params = array();
        $params['product_id'] = $product_id;
        $params['openid'] = $openid;
        $rst = $this->_request->post($this->_url . 'get_sharer_product_qrcode', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /分享员API /解绑分享员
     * 解绑分享员
     * 接口说明
     * 该接口用于解除已绑定的小店普通分享员
     *
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/unbind?access_token=ACCESS_TOKEN
     * 请求参数说明
     * 参数 类型 是否必填 描述
     * openid_list array string 是 需要解绑的分享员openid列表
     * 请求参数示例
     * {
     * "openid_list": ["XXXXXX1","XXXXXX2"]
     * }
     * 返回参数说明
     * 参数 类型 描述
     * errcode number 错误码
     * errmsg string 错误信息
     * success_openid array string 成功列表
     * fail_openid array string 失败列表，可重试
     * refuse_openid array string 拒绝列表，不可重试（openid错误，解绑时间距离绑定成功时间不足1天等）
     * 返回参数示例
     * {
     * "errcode": 0,
     * "errmsg": "ok",
     * "success_openid": [],
     * "fail_openid": [],
     * "refuse_openid": []
     * }
     */
    public function unbind(array $openid_list)
    {
        $params = array();
        $params['openid_list'] = $openid_list;
        $rst = $this->_request->post($this->_url . 'unbind', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /分享员API /获取分享员推广店铺视频号的直播预约url
     * 小店给分享员生成推广直播间预告的url
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_shop_finder_live_notice_sharer_url?access_token=ACCESS_TOKEN
     * 请求参数示例
     * {
     * "notice_id": "XXXXXX",
     * "finder_id": "XXXXXX"
     * }
     * 回包示例
     * {
     * "errcode": "0",
     * "errmsg": "ok",
     * "url": "http"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * notice_id string 是 视频号的预告id【获取来源当前直播预告API】
     * finder_id string 是 视频号的id【以sp开头的】
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * url string 获取的url内容，给到分享员打开
     */
    public function getShopFinderLiveNoticeSharerUrl($notice_id, $finder_id)
    {
        $params = array();
        $params['notice_id'] = $notice_id;
        $params['finder_id'] = $finder_id;
        $rst = $this->_request->post($this->_url . 'get_shop_finder_live_notice_sharer_url', $params);
        return $this->_client->rst($rst);
    }
    /**
     * 微信小店API /分享员API /获取分享员推广店铺视频号的当前直播url
     * 小店给分享员生成推广直播间的url
     * 接口调用请求说明
     * POST https://api.weixin.qq.com/channels/ec/sharer/get_shop_finder_live_sharer_url?access_token=ACCESS_TOKEN
     * 请求参数示例
     * {
     * "export_id": "XXXXXX",
     * "finder_id": "XXXXXX"
     * }
     * 回包示例
     * {
     * "errcode": "0",
     * "errmsg": "ok",
     * "url": "http"
     * }
     * 请求参数说明
     * 参数 类型 是否必填 说明
     * export_id string 是 视频号的直播id【获取来源当前直播API】
     * finder_id string 是 视频号的id【以sp开头的】
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * url string 获取的url内容，给到分享员打开
     * 错误码
     */
    public function getShopFinderLiveSharerUrl($export_id, $finder_id)
    {
        $params = array();
        $params['export_id'] = $export_id;
        $params['finder_id'] = $finder_id;
        $rst = $this->_request->post($this->_url . 'get_shop_finder_live_sharer_url', $params);
        return $this->_client->rst($rst);
    }
}
