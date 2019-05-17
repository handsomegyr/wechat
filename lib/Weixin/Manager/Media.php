<?php
/**
 * 媒体上传下载管理器
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */
namespace Weixin\Manager;

use Weixin\Client;
use Weixin;
use Weixin\Exception;

class Media
{

    /**
     * 微信客户端
     *
     * @var Weixin\Client
     */
    private $_client;

    private $_request;

    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 新增临时素材
     * 公众号经常有需要用到一些临时性的多媒体素材的场景，例如在使用接口特别是发送消息时，对多媒体文件、多媒体消息的获取和调用等操作，是通过media_id来进行的。素材管理接口对所有认证的订阅号和服务号开放。通过本接口，公众号可以新增临时素材（即上传临时多媒体文件）。
     * 请注意：
     * 1、对于临时素材，每个素材（media_id）会在开发者上传或粉丝发送到微信服务器3天后自动删除（所以用户发送给开发者的素材，若开发者需要，应尽快下载到本地），以节省服务器资源。
     * 2、media_id是可复用的。
     * 3、素材的格式大小等要求与公众平台官网一致。具体是，图片大小不超过2M，支持bmp/png/jpeg/jpg/gif格式，语音大小不超过5M，长度不超过60秒，支持mp3/wma/wav/amr格式
     * 4、需使用https调用本接口。
     * 本接口即为原“上传多媒体文件”接口。
     * 接口调用请求说明
     * http请求方式: POST/FORM,需使用https
     * https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE
     * 调用示例（使用curl命令，用FORM表单方式上传一个多媒体文件）：
     * curl -F media=@test.jpg "https://api.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE"
     * 参数说明
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * type 是 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb）
     * media 是 form-data中媒体文件标识，有filename、filelength、content-type等信息
     * 返回说明
     * 正确情况下的返回JSON数据包结果如下：
     * {"type":"TYPE","media_id":"MEDIA_ID","created_at":123456789}
     * 参数 描述
     * type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb，主要用于视频与音乐格式的缩略图）
     * media_id 媒体文件上传后，获取时的唯一标识
     * created_at 媒体文件上传时间戳
     * 错误情况下的返回JSON数据包示例如下（示例为无效媒体类型错误）：
     * {"errcode":40004,"errmsg":"invalid media type"}
     * 注意事项
     * 上传的临时多媒体文件有格式和大小限制，如下：
     * 图片（image）: 1M，支持JPG格式
     * 语音（voice）：2M，播放长度不超过60s，支持AMR\MP3格式
     * 视频（video）：10MB，支持MP4格式
     * 缩略图（thumb）：64KB，支持JPG格式
     * 媒体文件在后台保存时间为3天，即3天后media_id失效。
     *
     * @param string $type            
     * @param string $media            
     */
    public function upload($type, $media)
    {
        $query = array(
            'type' => $type
        );
        $options = array(
            'fieldName' => 'media'
        );
        return $this->_request->uploadFile('https://api.weixin.qq.com/cgi-bin/media/upload', $media, $options, $query);
    }

    /**
     * 获取临时素材
     * 公众号可以使用本接口获取临时素材（即下载临时的多媒体文件）。请注意，视频文件不支持https下载，调用该接口需http协议。
     * 本接口即为原“下载多媒体文件”接口。
     * 接口调用请求说明
     * http请求方式: GET,https调用
     * https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID
     * 请求示例（示例为通过curl命令获取多媒体文件）
     * curl -I -G "https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID"
     * 参数说明
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * media_id 是 媒体文件ID
     * 返回说明
     * 正确情况下的返回HTTP头如下：
     * HTTP/1.1 200 OK
     * Connection: close
     * Content-Type: image/jpeg
     * Content-disposition: attachment; filename="MEDIA_ID.jpg"
     * Date: Sun, 06 Jan 2013 10:20:18 GMT
     * Cache-Control: no-cache, must-revalidate
     * Content-Length: 339721
     * curl -G "https://api.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID"
     * 错误情况下的返回JSON数据包示例如下（示例为无效媒体ID错误）：
     * {"errcode":40007,"errmsg":"invalid media_id"}
     *
     * @param string $mediaId            
     */
    public function download($mediaId, $file_ext = "")
    {
        $accessToken = $this->_client->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=' . $accessToken . '&media_id=' . $mediaId;
        return $this->_request->getFileByUrl($url, file_ext);
    }

    /**
     * 高清语音素材获取接口
     * 公众号可以使用本接口获取从JSSDK的uploadVoice接口上传的临时语音素材，格式为speex，16K采样率。该音频比上文的临时素材获取接口（格式为amr，8K采样率）更加清晰，适合用作语音识别等对音质要求较高的业务。
     * 接口调用请求说明
     * http请求方式: GET,https调用
     * https://api.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN&media_id=MEDIA_ID
     * 请求示例（示例为通过curl命令获取多媒体文件）
     * curl -I -G "https://api.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN&media_id=MEDIA_ID"
     * 参数说明
     * 参数 是否必须 说明
     * access_token 是 调用接口凭证
     * media_id 是 媒体文件ID，即uploadVoice接口返回的serverID
     * 返回说明
     * 正确情况下的返回HTTP头如下：
     * HTTP/1.1 200 OK
     * Connection: close
     * Content-Type: voice/speex
     * Content-disposition: attachment; filename="MEDIA_ID.speex"
     * Date: Sun, 06 Jan 2016 10:20:18 GMT
     * Cache-Control: no-cache, must-revalidate
     * Content-Length: 339721
     * curl -G "https://api.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN&media_id=MEDIA_ID"
     * 错误情况下的返回JSON数据包示例如下（示例为无效媒体ID错误）：
     * {"errcode":40007,"errmsg":"invalid media_id"}
     * 如果speex音频格式不符合业务需求，开发者可在获取后，再自行于本地对该语音素材进行转码。
     * 转码请使用speex的官方解码库 http://speex.org/downloads/ ，并结合微信的解码库（含示例代码：下载地址）。
     */
    public function download4Jssdk($mediaId, $file_ext = "")
    {
        $accessToken = $this->_client->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=' . $accessToken . '&media_id=' . $mediaId;
        return $this->_request->getFileByUrl($url, file_ext);
    }

    /**
     * 上传图文消息素材（用于群发图文消息）
     *
     * 上传图文消息素材【订阅号与服务号认证后均可用】
     * 接口调用请求说明
     * http请求方式: POST
     * https://api.weixin.qq.com/cgi-bin/media/uploadnews?access_token=ACCESS_TOKEN
     * POST数据说明
     * POST数据示例如下：
     * {
     * "articles": [
     * {
     * "thumb_media_id":"qI6_Ze_6PtV7svjolgs-rN6stStuHIjs9_DidOHaj0Q-mwvBelOXCFZiq2OsIU-p",
     * "author":"xxx",
     * "title":"Happy Day",
     * "content_source_url":"www.qq.com",
     * "content":"content",
     * "digest":"digest",
     * "show_cover_pic":1
     * },
     * {
     * "thumb_media_id":"qI6_Ze_6PtV7svjolgs-rN6stStuHIjs9_DidOHaj0Q-mwvBelOXCFZiq2OsIU-p",
     * "author":"xxx",
     * "title":"Happy Day",
     * "content_source_url":"www.qq.com",
     * "content":"content",
     * "digest":"digest",
     * "show_cover_pic":0
     * }
     * ]
     * }
     * 参数 是否必须 说明
     * Articles 是 图文消息，一个图文消息支持1到8条图文
     * thumb_media_id 是 图文消息缩略图的media_id，可以在基础支持-上传多媒体文件接口中获得
     * author 否 图文消息的作者
     * title 是 图文消息的标题
     * content_source_url 否 在图文消息页面点击“阅读原文”后的页面，受安全限制，如需跳转Appstore，可以使用itun.es或appsto.re的短链服务，并在短链后增加 #wechat_redirect 后缀。
     * content 是 图文消息页面的内容，支持HTML标签。具备微信支付权限的公众号，可以使用a标签，其他公众号不能使用
     * digest 否 图文消息的描述
     * show_cover_pic 否 是否显示封面，1为显示，0为不显示
     * 返回说明
     * 返回数据示例（正确时的JSON返回结果）：
     * {
     * "type":"news",
     * "media_id":"CsEf3ldqkAYJAU6EJeIkStVDSvffUJ54vqbThMgplD-VJXXof6ctX5fI6-aYyUiQ",
     * "created_at":1391857799
     * }
     * 参数 说明
     * type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video）和缩略图（thumb），图文消息（news）
     * media_id 媒体文件/图文消息上传后获取的唯一标识
     * created_at 媒体文件上传时间
     * 错误时微信会返回错误码等信息，请根据错误码查询错误信息
     *
     * @param array $articles            
     * @throws Exception
     */
    public function uploadNews(array $articles)
    {
        if (count($articles) < 1 || count($articles) > 10) {
            throw new Exception("一个图文消息只支持1到10条图文");
        }
        return $this->_request->post('https://api.weixin.qq.com/cgi-bin/media/uploadnews', array(
            'articles' => $articles
        ));
    }

    /**
     * 上传视频素材（用于群发视频消息）
     *
     * @param string $media_id            
     * @param string $title            
     * @param string $description            
     */
    public function uploadVideo($media_id, $title, $description)
    {
        $video = array();
        $video["media_id"] = $media_id;
        $video["title"] = $title;
        $video["description"] = $description;
        // return $this->_request->post('https://file.api.weixin.qq.com/cgi-bin/media/uploadvideo', $video);
        return $this->_request->post('https://api.weixin.qq.com/cgi-bin/media/uploadvideo', $video);
    }

    public function uploadImg($img)
    {
        return $this->_request->uploadFile('https://api.weixin.qq.com/cgi-bin/media/uploadimg', $img);
    }

    public function __destruct()
    {}
}