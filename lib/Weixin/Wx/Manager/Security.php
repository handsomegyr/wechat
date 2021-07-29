<?php

namespace Weixin\Wx\Manager;

use Weixin\Client;

/**
 * 内容安全
 * https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/sec-check/security.imgSecCheck.html
 *
 * @author guoyongrong <handsomegyr@126.com>
 */
class Security
{
	// 接口地址
	private $_url = 'https://api.weixin.qq.com/';
	private $_client;
	private $_request;
	public function __construct(Client $client)
	{
		$this->_client = $client;
		$this->_request = $client->getRequest();
	}

	/**
	 * security.imgSecCheck
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 校验一张图片是否含有违法违规内容。详见内容安全解决方案
	 *
	 * 应用场景举例：
	 *
	 * 图片智能鉴黄：涉及拍照的工具类应用(如美拍，识图类应用)用户拍照上传检测；电商类商品上架图片检测；媒体类用户文章里的图片检测等；
	 * 敏感人脸识别：用户头像；媒体类用户文章里的图片检测；社交类用户上传的图片检测等。 ** 频率限制：单个 appId 调用上限为 2000 次/分钟，200,000 次/天 （ 图片大小限制：1M **）
	 * 调用方式：
	 *
	 * HTTPS 调用
	 * 云调用
	 *
	 * HTTPS 调用
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/img_sec_check?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * media FormData 是 要检测的图片文件，格式支持PNG、JPEG、JPG、GIF，图片尺寸不超过 750px x 1334px
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * errcode 的合法值
	 *
	 * 值 说明 最低版本
	 * 0 内容正常
	 * 87014 内容可能潜在风险
	 * errmsg 的合法值
	 *
	 * 值 说明 最低版本
	 * "ok" 内容正常
	 * "risky content" 内容可能潜在风险
	 * 调用示例
	 * curl -F media=@test.jpg 'https://api.weixin.qq.com/wxa/img_sec_check?access_token=ACCESS_TOKEN'
	 * 调用过程中如遇到问题，可在官方社区发帖交流。
	 */
	public function imgSecCheck($media)
	{
		$query = array();
		$options = array(
			'fieldName' => 'media'
		);
		$rst = $this->_request->uploadFile($this->_url . 'wxa/img_sec_check', $media, $options, $query);
		return $this->_client->rst($rst);
	}

	/**
	 * security.mediaCheckAsync
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 异步校验图片/音频是否含有违法违规内容。
	 *
	 * 应用场景举例：
	 *
	 * 语音风险识别：社交类用户发表的语音内容检测；
	 * 图片智能鉴黄：涉及拍照的工具类应用(如美拍，识图类应用)用户拍照上传检测；电商类商品上架图片检测；媒体类用户文章里的图片检测等；
	 * 敏感人脸识别：用户头像；媒体类用户文章里的图片检测；社交类用户上传的图片检测等。 频率限制：单个 appId 调用上限为 2000 次/分钟，200,000 次/天；文件大小限制：单个文件大小不超过10M
	 *
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/media_check_async?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * media_url string 是 要检测的多媒体url
	 * media_type number 是 1:音频;2:图片
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * trace_id string 任务id，用于匹配异步推送结果
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * errcode 的合法值
	 *
	 * 值 说明 最低版本
	 * 0 检测请求已接收
	 * Object
	 * 异步检测结果在 30 分钟内会推送到你的消息接收服务器。点击查看消息接收服务器配置
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * ToUserName string 小程序的username
	 * FromUserName string 平台推送服务UserName
	 * CreateTime number 发送时间
	 * MsgType string 默认为：Event
	 * Event string 默认为：wxa_media_check
	 * isrisky number 检测结果，0：暂未检测到风险，1：风险
	 * extra_info_json string 附加信息，默认为空
	 * appid string 小程序的appid
	 * trace_id string 任务id
	 * status_code number 默认为：0，4294966288(-1008)为链接无法下载
	 * 调用示例
	 * curl -d '{ "media_url":"https://developers.weixin.qq.com/miniprogram/assets/images/head_global_z_@all.png","media_type":2 }' 'https://api.weixin.qq.com/wxa/media_check_async?access_token=ACCESS_TOKEN'
	 * 注意
	 * media_type 需要准确填写 url 对应的多媒体类型，media_url 需要保证可以被检测服务器下载
	 *
	 * 接口返回示例
	 * {
	 * "errcode" : 0,
	 * "errmsg" : "ok",
	 * "trace_id" : "967e945cd8a3e458f3c74dcb886068e9"
	 * }
	 * 异步检测结果推送示例
	 * {
	 * "ToUserName" : "gh_38cc49f9733b",
	 * "FromUserName" : "oH1fu0FdHqpToe2T6gBj0WyB8iS1",
	 * "CreateTime" : 1552465698,
	 * "MsgType" : "event",
	 * "Event" : "wxa_media_check",
	 * "isrisky" : 0,
	 * "extra_info_json" : "",
	 * "appid" : "wxd8c59133dfcbfc71",
	 * "trace_id" : "967e945cd8a3e458f3c74dcb886068e9",
	 * "status_code" : 0
	 * }
	 * 调用过程中如遇到问题，可在官方社区发帖交流。
	 */
	public function mediaCheckAsync($media_url, $media_type)
	{
		$params = array();
		$params['media_url'] = $media_url;
		$params['media_type'] = $media_type;
		$rst = $this->_request->post($this->_url . 'wxa/media_check_async', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * security.msgSecCheck
	 * 本接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 检查一段文本是否含有违法违规内容。
	 *
	 * 应用场景举例：
	 *
	 * 用户个人资料违规文字检测；
	 * 媒体新闻类用户发表文章，评论内容检测；
	 * 游戏类用户编辑上传的素材(如答题类小游戏用户上传的问题及答案)检测等。 频率限制：单个 appId 调用上限为 4000 次/分钟，2,000,000 次/天*
	 * 调用方式：
	 *
	 * HTTPS 调用
	 * 云调用
	 *
	 * HTTPS 调用
	 * 请求地址
	 * POST https://api.weixin.qq.com/wxa/msg_sec_check?access_token=ACCESS_TOKEN
	 * 请求参数
	 * 属性 类型 默认值 必填 说明
	 * access_token / cloudbase_access_token string 是 接口调用凭证
	 * content string 是 要检测的文本内容，长度不超过 500KB
	 * 返回值
	 * Object
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * errcode 的合法值
	 *
	 * 值 说明 最低版本
	 * 0 内容正常
	 * 87014 内容可能潜在风险
	 * errmsg 的合法值
	 *
	 * 值 说明 最低版本
	 * "ok" 内容正常
	 * "risky content" 内容可能潜在风险
	 * 调用示例
	 * curl -d '{ "content":"hello world!" }' 'https://api.weixin.qq.com/wxa/msg_sec_check?access_token=ACCESS_TOKEN'
	 * 测试用例
	 * 特3456书yuuo莞6543李zxcz蒜7782法fgnv级
	 * 完2347全dfji试3726测asad感3847知qwez到
	 * 开发者可使用以上两段文本进行测试，若接口errcode返回87014(内容可能潜在风险)，则对接成功。
	 *
	 * 调用过程中如遇到问题，可在官方社区发帖交流。
	 */
	public function msgSecCheck($content)
	{
		$params = array();
		$params['content'] = $content;
		$rst = $this->_request->post($this->_url . 'wxa/msg_sec_check', $params);
		return $this->_client->rst($rst);
	}
}
