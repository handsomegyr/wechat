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
	 * 音视频内容安全识别
	 * 调试工具
	 *
	 * 接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 接口说明
	 * 接口英文名
	 * mediaCheckAsync
	 *
	 * 功能描述
	 * 本接口用于异步校验图片/音频是否含有违法违规内容。
	 *
	 * 1.0 版本异步接口文档【点击查看】， 1.0 版本同步接口文档【点击查看】，1.0版本在2021年9月1日停止更新，请尽快更新至2.0
	 *
	 * 应用场景举例：
	 *
	 * 语音风险识别：社交类用户发表的语音内容检测；
	 * 图片智能鉴黄：涉及拍照的工具类应用(如美拍，识图类应用)用户拍照上传检测；电商类商品上架图片检测；媒体类用户文章里的图片检测等；
	 * 敏感人脸识别：用户头像；媒体类用户文章里的图片检测；社交类用户上传的图片检测等。 频率限制：单个 appId 调用上限为 2000 次/分钟，200,000 次/天；文件大小限制：单个文件大小不超过10M
	 * 注意事项
	 * media_type 需要准确填写 url 对应的多媒体类型，media_url 需要保证可以被检测服务器下载
	 *
	 * 调用方式
	 * HTTPS 调用
	 *
	 * POST https://api.weixin.qq.com/wxa/media_check_async?access_token=ACCESS_TOKEN
	 *
	 * 云调用
	 * 出入参和 HTTPS 调用相同，调用方式可查看云调用说明文档
	 *
	 * 接口方法为: openapi.security.mediaCheckAsync
	 *
	 * 第三方调用
	 * 调用方式以及出入参和 HTTPS 相同，仅是调用的 token 不同
	 *
	 * 该接口所属的权限集 id 为：18
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
	 * media_url string 是 要检测的图片或音频的url，支持图片格式包括 jpg , jepg, png, bmp, gif（取首帧），支持的音频格式包括mp3, aac, ac3, wma, flac, vorbis, opus, wav
	 * media_type number 是 1:音频;2:图片
	 * version number 是 接口版本号，2.0版本为固定值2
	 * scene number 是 场景枚举值（1 资料；2 评论；3 论坛；4 社交日志）
	 * openid string 是 用户的openid（用户需在近两小时访问过小程序）
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * trace_id string 唯一请求标识，标记单次请求，用于匹配异步推送结果
	 * 其他说明
	 * 异步检测结果推送
	 * 异步检测结果在 30 分钟内会推送到你的消息接收服务器。点击查看消息接收服务器配置
	 * 返回的 JSON 数据包
	 *
	 * 属性 类型 说明
	 * ToUserName string 小程序的username
	 * FromUserName string 平台推送服务UserName
	 * CreateTime number 发送时间
	 * MsgType string 默认为：Event
	 * Event string 默认为：wxa_media_check
	 * appid string 小程序的appid
	 * trace_id string 任务id
	 * version number 可用于区分接口版本
	 * result object 综合结果
	 * detail array 详细检测结果
	 * 调用示例
	 * 示例说明: HTTPS调用
	 *
	 * 请求数据示例
	 *
	 * {"openid": "OPENID",
	 * "scene": 1,
	 * "version":2, "media_url":"https://developers.weixin.qq.com/miniprogram/assets/images/head_global_z_@all.png","media_type":2
	 * }
	 *
	 * 返回数据示例
	 *
	 * {
	 * "errcode" : 0,
	 * "errmsg" : "ok",
	 * "trace_id" : "967e945cd8a3e458f3c74dcb886068e9"
	 * }
	 *
	 * 错误码
	 * 错误码 错误码取值 解决方案
	 * 40001 invalid credential access_token isinvalid or not latest 获取 access_token 时 AppSecret 错误，或者 access_token 无效。请开发者认真比对 AppSecret 的正确性，或查看是否正在为恰当的公众号调用接口
	 */
	public function mediaCheckAsync($media_url, $media_type, $version, $scene, $openid)
	{
		$params = array();
		$params['media_url'] = $media_url;
		$params['media_type'] = $media_type;
		$params['version'] = $version;
		$params['scene'] = $scene;
		$params['openid'] = $openid;
		$rst = $this->_request->post($this->_url . 'wxa/media_check_async', $params);
		return $this->_client->rst($rst);
	}

	/**
	 * 文本内容安全识别
	 * 调试工具
	 *
	 * 接口应在服务器端调用，详细说明参见服务端API。
	 *
	 * 本接口支持云调用。需开发者工具版本 >= 1.02.1904090（最新稳定版下载），wx-server-sdk >= 0.4.0
	 *
	 * 接口说明
	 * 接口英文名
	 * msgSecCheck
	 *
	 * 功能描述
	 * 该接口用于检查一段文本是否含有违法违规内容。
	 *
	 * 应用场景
	 * 用户个人资料违规文字检测；
	 * 媒体新闻类用户发表文章，评论内容检测；
	 * 游戏类用户编辑上传的素材(如答题类小游戏用户上传的问题及答案)检测等。
	 * 注意事项
	 * -1.0 版本接口文档【点击查看】，1.0版本在2021年9月1日停止更新，请尽快更新至2.0
	 *
	 * 频率限制：单个 appId 调用上限为 4000 次/分钟，2,000,000 次/天。
	 * 调用方式
	 * HTTPS 调用
	 *
	 * POST https://api.weixin.qq.com/wxa/msg_sec_check?access_token=ACCESS_TOKEN
	 *
	 * 云调用
	 * 出入参和 HTTPS 调用相同，调用方式可查看云调用说明文档
	 *
	 * 接口方法为: openapi.security.msgSecCheck
	 *
	 * 第三方调用
	 * 调用方式以及出入参和 HTTPS 相同，仅是调用的 token 不同
	 *
	 * 该接口所属的权限集 id 为：18
	 *
	 * 服务商获得其中之一权限集授权后，可通过使用authorizer_access_token代商家进行调用
	 *
	 * 请求参数
	 * 属性 类型 必填 说明
	 * access_token string 是 接口调用凭证，该参数为 URL 参数，非 Body 参数。使用access_token或者authorizer_access_token
	 * content string 是 需检测的文本内容，文本字数的上限为2500字，需使用UTF-8编码
	 * version number 是 接口版本号，2.0版本为固定值2
	 * scene number 是 场景枚举值（1 资料；2 评论；3 论坛；4 社交日志）
	 * openid string 是 用户的openid（用户需在近两小时访问过小程序）
	 * title string 否 文本标题，需使用UTF-8编码
	 * nickname string 否 用户昵称，需使用UTF-8编码
	 * signature string 否 个性签名，该参数仅在资料类场景有效(scene=1)，需使用UTF-8编码
	 * 返回参数
	 * 属性 类型 说明
	 * errcode number 错误码
	 * errmsg string 错误信息
	 * detail array<object> 详细检测结果
	 * 属性 类型 说明
	 * strategy string 策略类型
	 * errcode number 错误码，仅当该值为0时，该项结果有效
	 * suggest string 建议，有risky、pass、review三种值
	 * label number 命中标签枚举值，100 正常；10001 广告；20001 时政；20002 色情；20003 辱骂；20006 违法犯罪；20008 欺诈；20012 低俗；20013 版权；21000 其他
	 * keyword string 命中的自定义关键词
	 * prob number 0-100，代表置信度，越高代表越有可能属于当前返回的标签（label）
	 * trace_id string 唯一请求标识，标记单次请求
	 * result object 综合结果
	 * 属性 类型 说明
	 * suggest string 建议，有risky、pass、review三种值
	 * label number 命中标签枚举值，100 正常；10001 广告；20001 时政；20002 色情；20003 辱骂；20006 违法犯罪；20008 欺诈；20012 低俗；20013 版权；21000 其他
	 * 调用示例
	 * 示例说明: HTTPS调用
	 *
	 * 请求数据示例
	 *
	 * {
	 * "openid": "OPENID",
	 * "scene": 1,
	 * "version": 2,
	 * "content":"hello world!"
	 * }
	 *
	 *
	 * 返回数据示例
	 *
	 * {
	 * "errcode": 0,
	 * "errmsg": "ok",
	 * "result": {
	 * "suggest": "risky",
	 * "label": 20001
	 * },
	 * "detail": [
	 * {
	 * "strategy": "content_model",
	 * "errcode": 0,
	 * "suggest": "risky",
	 * "label": 20006,
	 * "prob": 90
	 * },
	 * {
	 * "strategy": "keyword",
	 * "errcode": 0,
	 * "suggest": "pass",
	 * "label": 20006,
	 * "level": 20,
	 * "keyword": "命中的关键词1"
	 * },
	 * {
	 * "strategy": "keyword",
	 * "errcode": 0,
	 * "suggest": "risky",
	 * "label": 20006,
	 * "level": 90,
	 * "keyword": "命中的关键词2"
	 * }
	 * ],
	 * "trace_id": "60ae120f-371d5872-7941a05b"
	 * }
	 */
	public function msgSecCheck($content, $version, $scene, $openid, $title = "", $nickname = "", $signature = "")
	{
		$params = array();
		$params['content'] = $content;
		$params['version'] = $version;
		$params['scene'] = $scene;
		$params['openid'] = $openid;
		$params['title'] = $title;
		$params['nickname'] = $nickname;
		$params['signature'] = $signature;
		$rst = $this->_request->post($this->_url . 'wxa/msg_sec_check', $params);
		return $this->_client->rst($rst);
	}
}
