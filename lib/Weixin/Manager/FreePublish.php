<?php

namespace Weixin\Manager;

use Weixin\Client;

/**
 * 发布能力管理
 * https://developers.weixin.qq.com/doc/offiaccount/Publish/Publish.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class FreePublish
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
	 * 发布能力 /发布接口
	 * 开发者需要先将图文素材以草稿的形式保存（见“草稿箱/新建草稿”，如需从已保存的草稿中选择，见“草稿箱/获取草稿列表”），选择要发布的草稿 media_id 进行发布
	 *
	 * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/freepublish/submit?access_token=ACCESS_TOKEN
	 *
	 * 调用示例
	 *
	 * {
	 * "media_id": MEDIA_ID
	 * }
	 * 请求参数说明
	 *
	 * 参数 是否必须 说明
	 * access_token 是 调用接口凭证
	 * media_id 是 要发布的草稿的media_id
	 * 返回示例
	 *
	 * {
	 * "errcode":0,
	 * "errmsg":"ok",
	 * "publish_id":"100000001",
	 * }
	 * 返回参数说明
	 *
	 * 参数 说明
	 * errcode 错误码
	 * errmsg 错误信息
	 * publish_id 发布任务的id
	 * 请注意：正常情况下调用成功时，errcode将为0，此时只意味着发布任务提交成功，并不意味着此时发布已经完成，所以，仍有可能在后续的发布过程中出现异常情况导致发布失败，如原创声明失败、平台审核不通过等。
	 */
	public function submit($media_id)
	{
		$params = array();
		$params['media_id'] = $media_id;
		$rst = $this->_request->post($this->_url . 'freepublish/submit', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 发布能力 /发布状态轮询接口
	 * 开发者可以尝试通过下面的发布状态轮询接口获知发布情况。
	 *
	 * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/freepublish/get?access_token=ACCESS_TOKEN
	 *
	 * 调用示例
	 *
	 * {
	 * "publish_id":"100000001"
	 * }
	 * 请求参数说明
	 *
	 * 参数 是否必须 说明
	 * access_token 是 调用接口凭证
	 * publish_id 是 发布任务id
	 * 返回示例1（成功）
	 *
	 * {
	 * "publish_id":"100000001",
	 * "publish_status":0,
	 * "article_id":ARTICLE_ID,
	 * "article_detail":{
	 * "count":1,
	 * "item":[
	 * {
	 * "idx":1,
	 * "article_url": ARTICLE_URL
	 * }
	 * //如果 count 大于 1，此处会有多篇文章
	 * ]
	 * },
	 * "fail_idx": []
	 * }
	 * 返回示例2（发布中）
	 *
	 * {
	 * "publish_id":"100000001",
	 * "publish_status":1,
	 * "fail_idx": []
	 * }
	 * 返回示例3（原创审核不通过时）
	 *
	 * {
	 * "publish_id":"100000001",
	 * "publish_status":2,
	 * "fail_idx":[1,2]
	 * }
	 * 返回参数说明
	 *
	 * 参数 说明
	 * publish_id 发布任务id
	 * publish_status 发布状态，0:成功, 1:发布中，2:原创失败, 3: 常规失败, 4:平台审核不通过, 5:成功后用户删除所有文章, 6: 成功后系统封禁所有文章
	 * article_id 当发布状态为0时（即成功）时，返回图文的 article_id，可用于“客服消息”场景
	 * count 当发布状态为0时（即成功）时，返回文章数量
	 * idx 当发布状态为0时（即成功）时，返回文章对应的编号
	 * article_url 当发布状态为0时（即成功）时，返回图文的永久链接
	 * fail_idx 当发布状态为2或4时，返回不通过的文章编号，第一篇为 1；其他发布状态则为空
	 */
	public function get($publish_id)
	{
		$params = array();
		$params['publish_id'] = $publish_id;
		$rst = $this->_request->post($this->_url . 'freepublish/get', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 发布能力 /删除发布
	 * 发布成功之后，随时可以通过该接口删除。此操作不可逆，请谨慎操作。
	 *
	 * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/freepublish/delete?access_token=ACCESS_TOKEN
	 *
	 * 调用示例
	 *
	 * {
	 * "article_id":ARTICLE_ID,
	 * "index":1
	 * }
	 * 请求参数说明
	 *
	 * 参数 是否必须 说明
	 * access_token 是 调用接口凭证
	 * article_id 是 成功发布时返回的 article_id
	 * index 否 要删除的文章在图文消息中的位置，第一篇编号为1，该字段不填或填0会删除全部文章
	 * 返回示例
	 *
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
	public function delete($article_id, $index = 0)
	{
		$params = array();
		$params['article_id'] = $article_id;
		$params['index'] = $index;
		$rst = $this->_request->post($this->_url . 'freepublish/delete', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 发布能力 /通过 article_id 获取已发布文章
	 * 开发者可以通过 article_id 获取已发布的图文信息。
	 *
	 * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/freepublish/getarticle?access_token=ACCESS_TOKEN
	 *
	 * 调用示例
	 *
	 * {
	 * "article_id":ARTICLE_ID
	 * }
	 * 请求参数说明
	 *
	 * 参数 是否必须 说明
	 * access_token 是 调用接口凭证
	 * article_id 是 要获取的草稿的article_id
	 * 返回示例
	 *
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
	 * "url":URL,
	 * "is_deleted":false
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
	 * url 图文消息的URL
	 * is_deleted 该图文是否被删除
	 * 错误情况下的返回JSON数据包示例如下（示例为无效的 article_id）：
	 *
	 * {"errcode":53600,"errmsg":"Article ID 无效"}
	 */
	public function getarticle($article_id)
	{
		$params = array();
		$params['article_id'] = $article_id;
		$rst = $this->_request->post($this->_url . 'freepublish/getarticle', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 发布能力 /获取成功发布列表
	 * 开发者可以获取已成功发布的消息列表。
	 *
	 * http 请求方式：POST（请使用https协议）https://api.weixin.qq.com/cgi-bin/freepublish/batchget?access_token=ACCESS_TOKEN
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
	 * 返回示例
	 *
	 * {
	 * "total_count":TOTAL_COUNT,
	 * "item_count":ITEM_COUNT,
	 * "item":[
	 * {
	 * "article_id":ARTICLE_ID,
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
	 * "url":URL,
	 * "is_deleted":false
	 * }
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
	 * total_count 成功发布素材的总数
	 * item_count 本次调用获取的素材的数量
	 * article_id 成功发布的图文消息id
	 * title 图文消息的标题
	 * author 作者
	 * digest 图文消息的摘要，仅有单图文消息才有摘要，多图文此处为空。
	 * content 图文消息的具体内容，支持HTML标签，必须少于2万字符，小于1M，且此处会去除JS。
	 * content_source_url 图文消息的原文地址，即点击“阅读原文”后的URL
	 * thumb_media_id 图文消息的封面图片素材id（一定是永久MediaID）
	 * show_cover_pic 是否显示封面，0为false，即不显示，1为true，即显示(默认)
	 * need_open_comment Uint32 是否打开评论，0不打开(默认)，1打开
	 * only_fans_can_comment Uint32 是否粉丝才可评论，0所有人可评论(默认)，1粉丝才可评论
	 * url 图文消息的URL
	 * is_deleted 该图文是否被删除
	 * update_time 这篇图文消息素材的最后更新时间
	 */
	public function batchget($offset = 0, $count = 20, $no_content = 0)
	{
		$params = array();
		$params['offset'] = $offset;
		$params['count'] = $count;
		$params['no_content'] = $no_content;
		$rst = $this->_request->post($this->_url . 'freepublish/batchget', $params);
		return $this->_client->rst($rst);
	}
}
