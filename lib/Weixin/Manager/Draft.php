<?php

namespace Weixin\Manager;

use Weixin\Client;

/**
 * 草稿箱管理
 * https://developers.weixin.qq.com/doc/offiaccount/Draft_Box/Add_draft.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Draft
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
     * 草稿箱 /新建草稿
     * 开发者可新增常用的素材到草稿箱中进行使用。上传到草稿箱中的素材被群发或发布后，该素材将从草稿箱中移除。新增草稿可在公众平台官网-草稿箱中查看和管理。
     *
     * 接口请求说明
     * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/add?access_token=ACCESS_TOKEN
     *
     * 调用示例
     *
     * {
     * "articles": [
     * {
     * "title":TITLE,
     * "author":AUTHOR,
     * "digest":DIGEST,
     * "content":CONTENT,
     * "content_source_url":CONTENT_SOURCE_URL,
     * "thumb_media_id":THUMB_MEDIA_ID,
     * "show_cover_pic":1,
     * "need_open_comment":0,
     * "only_fans_can_comment":0
     * }
     * //若新增的是多图文素材，则此处应还有几段articles结构
     * ]
     * }
     * 请求参数说明
     *
     * 参数 是否必须 说明
     * title 是 标题
     * author 否 作者
     * digest 否 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空。如果本字段为没有填写，则默认抓取正文前54个字。
     * content 是 图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS,涉及图片url必须来源 "上传图文消息内的图片获取URL"接口获取。外部图片url将被过滤。
     * content_source_url 否 图文消息的原文地址，即点击“阅读原文”后的URL
     * thumb_media_id 是 图文消息的封面图片素材id（必须是永久MediaID）
     * show_cover_pic 否 是否显示封面，0为false，即不显示，1为true，即显示(默认)
     * need_open_comment 否 Uint32 是否打开评论，0不打开(默认)，1打开
     * only_fans_can_comment 否 Uint32 是否粉丝才可评论，0所有人可评论(默认)，1粉丝才可评论
     * 接口返回说明
     * {
     * "media_id":MEDIA_ID
     * }
     */
    public function add(array $articles)
    {
        $params = array();
        foreach ($articles as $article) {
            $params['articles'][] = $article->getParams();
        }
        $rst = $this->_request->post($this->_url . 'draft/add', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 草稿箱 /获取草稿
     * 新增草稿后，开发者可以根据草稿指定的字段来下载草稿。
     *
     * 接口请求说明
     * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/get?access_token=ACCESS_TOKEN
     *
     * 调用示例
     *
     * {
     * "media_id":MEDIA_ID
     * }
     * 请求参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * media_id 是 要获取的草稿的media_id
     * 接口返回说明
     * {
     * "news_item": [
     * {
     * "title":TITLE,
     * "author":AUTHOR,
     * "digest":DIGEST,
     * "content":CONTENT,
     * "content_source_url":CONTENT_SOURCE_URL,
     * "thumb_media_id":THUMB_MEDIA_ID,
     * "show_cover_pic":1,
     * "need_open_comment":0,
     * "only_fans_can_comment":0,
     * "url":URL
     * }
     * //多图文消息应有多段 news_item 结构
     * ]
     * }
     * 返回参数说明
     *
     * 参数 描述
     * title 标题
     * author 作者
     * digest 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空。
     * content 图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS。
     * content_source_url 图文消息的原文地址，即点击“阅读原文”后的URL
     * thumb_media_id 图文消息的封面图片素材id（一定是永久MediaID）
     * show_cover_pic 是否显示封面，0为false，即不显示，1为true，即显示(默认)
     * need_open_comment Uint32 是否打开评论，0不打开(默认)，1打开
     * only_fans_can_comment Uint32 是否粉丝才可评论，0所有人可评论(默认)，1粉丝才可评论
     * url 草稿的临时链接
     * 错误情况下的返回JSON数据包示例如下（示例为无效媒体错误）：
     *
     * {"errcode":40007,"errmsg":"invalid media_id"}
     */
    public function get($media_id)
    {
        $params = array();
        $params['media_id'] = $media_id;
        $rst = $this->_request->post($this->_url . 'draft/get', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 草稿箱 /删除草稿
     * 新增草稿后，开发者可以根据本接口来删除不再需要的草稿，节省空间。此操作无法撤销，请谨慎操作。
     *
     * 接口请求说明
     * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/delete?access_token=ACCESS_TOKEN
     *
     * 调用示例
     *
     * {
     * "media_id":MEDIA_ID
     * }
     * 请求参数说明
     *
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * media_id 是 要删除的草稿的media_id
     * 接口返回说明
     * {
     * "errcode":ERRCODE,
     * "errmsg":"ERRMSG"
     * }
     * 返回参数说明
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * 正常情况下调用成功时，errcode将为0。错误时微信会返回错误码等信息，请根据错误码查询错误信息。
     *
     * 多次删除同一篇草稿，也返回 0.
     */
    public function delete($media_id)
    {
        $params = array();
        $params['media_id'] = $media_id;
        $rst = $this->_request->post($this->_url . 'draft/delete', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 草稿箱 /修改草稿
     * 开发者可通过本接口对草稿进行修改。
     *
     * 接口请求说明
     * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/update?access_token=ACCESS_TOKEN
     *
     * 调用示例
     *
     * {
     * "media_id":MEDIA_ID,
     * "index":INDEX,
     * "articles":{
     * "title":TITLE,
     * "author":AUTHOR,
     * "digest":DIGEST,
     * "content":CONTENT,
     * "content_source_url":CONTENT_SOURCE_URL,
     * "thumb_media_id":THUMB_MEDIA_ID,
     * "show_cover_pic":1,
     * "need_open_comment":0,
     * "only_fans_can_comment":0
     * }
     * }
     * 请求参数说明
     *
     * 参数 是否必须 说明
     * media_id 是 要修改的图文消息的id
     * index 是 要更新的文章在图文消息中的位置（多图文消息时，此字段才有意义），第一篇为0
     * title 是 标题
     * author 否 作者
     * digest 否 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空。如果本字段为没有填写，则默认抓取正文前54个字。
     * content 是 图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS,涉及图片url必须来源 "上传图文消息内的图片获取URL"接口获取。外部图片url将被过滤。
     * content_source_url 否 图文消息的原文地址，即点击“阅读原文”后的URL
     * thumb_media_id 是 图文消息的封面图片素材id（必须是永久MediaID）
     * show_cover_pic 否 是否显示封面，0为false，即不显示，1为true，即显示(默认)
     * need_open_comment 否 Uint32 是否打开评论，0不打开(默认)，1打开
     * only_fans_can_comment 否 Uint32 是否粉丝才可评论，0所有人可评论(默认)，1粉丝才可评论
     * 接口返回说明
     * {
     * "errcode":ERRCODE,
     * "errmsg":"ERRMSG"
     * }
     * 返回参数说明
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * 正常情况下调用成功时，errcode将为0。错误时微信会返回错误码等信息，请根据错误码查询错误信息
     */
    public function update($media_id, $index, \Weixin\Model\Draft\Article $article)
    {
        $params = array();
        $params['media_id'] = $media_id;
        $params['index'] = $index;
        $params['articles'] = $article->getParams();
        $rst = $this->_request->post($this->_url . 'draft/update', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 草稿箱 /获取草稿总数
     * 开发者可以根据本接口来获取草稿的总数。此接口只统计数量，不返回草稿的具体内容。
     *
     * 接口请求说明
     * http 请求方式：GET（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/count?access_token=ACCESS_TOKEN
     *
     * 接口返回说明
     * {
     * "total_count":TOTAL_COUNT
     * }
     * 即草稿的总数。
     */
    public function draftcount()
    {
        $params = array();
        $rst = $this->_request->get($this->_url . 'draft/count', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 草稿箱 /获取草稿列表
     * 新增草稿之后，开发者可以获取草稿的列表。
     *
     * 接口请求说明
     * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/batchget?access_token=ACCESS_TOKEN
     *
     * 调用示例
     *
     * {
     * "offset":OFFSET,
     * "count":COUNT,
     * "no_content":NO_CONTENT
     * }
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * offset 是 从全部素材的该偏移位置开始返回，0表示从第一个素材返回
     * count 是 返回素材的数量，取值在1到20之间
     * no_content 否 1 表示不返回 content 字段，0 表示正常返回，默认为 0
     * 接口返回说明
     * {
     * "total_count":TOTAL_COUNT,
     * "item_count":ITEM_COUNT,
     * "item":[
     * {
     * "media_id":MEDIA_ID,
     * "content": {
     * "news_item" : [
     * {
     * "title":TITLE,
     * "author":AUTHOR,
     * "digest":DIGEST,
     * "content":CONTENT,
     * "content_source_url":CONTENT_SOURCE_URL,
     * "thumb_media_id":THUMB_MEDIA_ID,
     * "show_cover_pic":1,
     * "need_open_comment":0,
     * "only_fans_can_comment":0,
     * "url":URL
     * },
     * //多图文消息会在此处有多篇文章
     * ]
     * },
     * "update_time": UPDATE_TIME
     * },
     * //可能有多个图文消息item结构
     * ]
     * }
     * 返回参数说明
     *
     * 参数 描述
     * total_count 草稿素材的总数
     * item_count 本次调用获取的素材的数量
     * media_id 图文消息的id
     * title 图文消息的标题
     * author 作者
     * digest 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空。
     * content 图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS。
     * content_source_url 图文消息的原文地址，即点击“阅读原文”后的URL
     * thumb_media_id 图文消息的封面图片素材id（一定是永久MediaID）
     * show_cover_pic 是否显示封面，0为false，即不显示，1为true，即显示(默认)
     * need_open_comment Uint32 是否打开评论，0不打开(默认)，1打开
     * only_fans_can_comment Uint32 是否粉丝才可评论，0所有人可评论(默认)，1粉丝才可评论
     * url 草稿的临时链接
     * update_time 这篇图文消息素材的最后更新时间
     */
    public function batchget($offset = 0, $count = 20, $no_content = 0)
    {
        $params = array();
        $params['offset'] = $offset;
        $params['count'] = $count;
        $params['no_content'] = $no_content;
        $rst = $this->_request->post($this->_url . 'draft/batchget', $params);
        return $this->_client->rst($rst);
    }

    /**
     * 草稿箱 /MP端开关（仅内测期间使用）
     * 由于草稿箱和发布功能仍处于内测阶段，若公众号没有被灰度覆盖，可能无法体验草稿箱和发布功能。为了解决这个问题，我们在上述API接口的基础上，设了这样一个开关：当一个公众号选择开启后，该帐号在微信公众平台后台（mp.weixin.qq.com)上的图文素材库将升级为草稿箱，并可以在微信公众平台后台使用发布功能。
     *
     * 请注意：
     *
     * 内测期间会逐步放量，任何用户都可能会自动打开；
     * 此开关开启后不可逆，换言之，无法从开启的状态回到关闭；
     * 内测期间，无论开关开启与否，旧版的图文素材API，以及新版的草稿箱、发布等API均可以正常使用；
     * 在内测结束之后，所有用户都将自动开启，即草稿箱、发布等功能将对所有用户开放，本开关连同之前的图文素材API也将随后下线。
     * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/draft/switch?access_token=ACCESS_TOKEN
     *
     * 如果只需检查开关状态，请 POST https://api.weixin.qq.com/cgi-bin/draft/switch?access_token=ACCESS_TOKEN&checkonly=1
     *
     * 返回示例
     *
     * {
     * "errcode":ERRCODE,
     * "errmsg":"ERRMSG"
     * "is_open":IS_OPEN
     * }
     * 返回参数说明
     *
     * 参数 说明
     * errcode 错误码
     * errmsg 错误信息
     * is_open 仅 errcode==0 (即调用成功) 时返回，0 表示开关处于关闭，1 表示开启成功（或开关已开启）
     */
    public function draftswitch($is_checkonly = false)
    {
        $params = array();
        // 如果只需检查开关状态
        if (!empty($is_checkonly)) {
            $params['checkonly'] = 1;
        }
        $rst = $this->_request->post($this->_url . 'draft/switch', $params);
        return $this->_client->rst($rst);
    }
}
