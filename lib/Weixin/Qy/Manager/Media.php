<?php

/**
 * 素材管理
 * 
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Qy\Manager;

use Weixin\Qy\Client;

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
     * 上传临时素材
     * 调试工具
     * 素材上传得到media_id，该media_id仅三天内有效
     * media_id在同一企业内应用之间可以共享
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token=ACCESS_TOKEN&type=TYPE
     *
     * 使用multipart/form-data POST上传文件， 文件标识名为”media”
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * type 是 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件（file）
     * POST的请求包中，form-data中媒体文件标识，应包含有 filename、filelength、content-type等信息
     *
     * filename标识文件展示的名称。比如，使用该media_id发消息时，展示的文件名由该字段控制
     *
     * 请求示例：
     *
     * POST https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token=accesstoken001&type=file HTTP/1.1
     * Content-Type: multipart/form-data; boundary=-------------------------acebdf13572468
     * Content-Length: 220
     * ---------------------------acebdf13572468
     * Content-Disposition: form-data; name="media";filename="wework.txt"; filelength=6
     * Content-Type: application/octet-stream
     * mytext
     * ---------------------------acebdf13572468--
     * 返回数据：
     *
     * {
     * "errcode": 0,
     * "errmsg": ""，
     * "type": "image",
     * "media_id": "1G6nrLmr5EC3MMb_-zK1dDdzmd0p7cNliYu9V5w7o8K0",
     * "created_at": "1380000000"
     * }
     * 参数说明：
     *
     * 参数 说明
     * type 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件(file)
     * media_id 媒体文件上传后获取的唯一标识，3天内有效
     * created_at 媒体文件上传时间戳
     * 上传的媒体文件限制
     * 所有文件size必须大于5个字节
     *
     * 图片（image）：2MB，支持JPG,PNG格式
     * 语音（voice） ：2MB，播放长度不超过60s，仅支持AMR格式
     * 视频（video） ：10MB，支持MP4格式
     * 普通文件（file）：20MB
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
        return $this->_request->uploadFile('https://qyapi.weixin.qq.com/cgi-bin/media/upload', $media, $options, $query);
    }

    /**
     * 上传图片
     * 调试工具
     * 上传图片得到图片URL，该URL永久有效
     * 返回的图片URL，仅能用于图文消息正文中的图片展示；若用于非企业微信域名下的页面，图片将被屏蔽。
     * 每个企业每天最多可上传100张图片
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/media/uploadimg?access_token=ACCESS_TOKEN
     *
     * 使用multipart/form-data POST上传文件。
     * 参数说明：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * POST的请求包中，form-data中媒体文件标识，应包含有filename、content-type等信息
     *
     * 请求示例：
     *
     * ---------------------------acebdf13572468
     * Content-Disposition: form-data; name="fieldNameHere"; filename="20180103195745.png"
     * Content-Type: image/png
     * Content-Length: 220
     * <@INCLUDE *C:\Users\abelzhu\Pictures\企业微信截图_20180103195745.png*@>
     * ---------------------------acebdf13572468--
     * 返回数据：
     *
     * {
     * "errcode": 0,
     * "errmsg": ""，
     * "url" : "http://p.qpic.cn/pic_wework/3474110808/7a7c8471673ff0f178f63447935d35a5c1247a7f31d9c060/0"
     * }
     * 参数说明：
     *
     * 参数 说明
     * errcode 返回码
     * errmsg 对返回码的文本描述内容
     * url 上传后得到的图片URL。永久有效
     * 上传的图片大小限制
     * 图片文件大小应在 5B ~ 2MB 之间
     */
    public function uploadImg($img)
    {
        return $this->_request->uploadFile('https://qyapi.weixin.qq.com/cgi-bin/media/uploadimg', $img);
    }

    /**
     * 获取临时素材
     * 调试工具
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID
     *
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * media_id 是 媒体文件id, 见上传临时素材
     * 权限说明：
     * 完全公开，media_id在同一企业内所有应用之间可以共享。
     *
     * 返回说明 ：
     * 正确时返回（和普通的http下载相同，请根据http头做相应的处理）：
     *
     * HTTP/1.1 200 OK
     * Connection: close
     * Content-Type: image/jpeg
     * Content-disposition: attachment; filename="MEDIA_ID.jpg"
     * Date: Sun, 06 Jan 2013 10:20:18 GMT
     * Cache-Control: no-cache, must-revalidate
     * Content-Length: 339721
     * Xxxx
     * 错误时返回（这里省略了HTTP首部）：
     *
     * {
     * "errcode": 40007,
     * "errmsg": "invalid media_id"
     * }
     * 附注：支持断点下载（分块下载）
     * 本接口支持通过在http header里指定Range来分块下载。
     * 在文件很大，可能下载超时的情况下，推荐使用分块下载。
     * 以curl命令进行测试为例，假如我有一个2048字节的文件，
     * 下面是获取文件前1024字节：
     *
     * curl ‘https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID’ -i -H “Range: bytes=0-1023”
     *
     * 生成如下http请求：
     *
     * GET /cgi-bin/media/get?access_token=ACCESS_TOKEN&media_id=MEDIA_ID HTTP/1.1
     * Host: qyapi.weixin.qq.com
     * Range: bytes 0-1023
     *
     * 服务器端会返回状态码为 206 Partial Content 的响应：
     *
     * HTTP/1.1 206 Partial Content
     * Accept-Ranges: bytes
     * Content-Range: bytes 0-1023/2048
     * Content-Length: 1024
     * …
     * (1024 Bites binary content)
     *
     * 可以看到响应中有如下特点：
     *
     * 状态码是206 Partial Content，而非200 ok
     * 返回的header中，Accept-Ranges首部表示可用于定义范围的单位
     * 返回的header中，Content-Range首部表示这一部分内容在整个资源中所处的位置
     * 更多协议详情参考RFC: Range Requests
     *
     * @param string $mediaId            
     */
    public function download($mediaId, $file_ext = "")
    {
        $accessToken = $this->_client->getAccessToken();
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=' . $accessToken . '&media_id=' . $mediaId;
        return $this->_request->getFileByUrl($url, $file_ext);
    }

    /**
     * 获取高清语音素材
     * 调试工具
     * 可以使用本接口获取从JSSDK的uploadVoice接口上传的临时语音素材，格式为speex，16K采样率。该音频比上文的临时素材获取接口（格式为amr，8K采样率）更加清晰，适合用作语音识别等对音质要求较高的业务。
     * 请求方式：GET（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=ACCESS_TOKEN&media_id=MEDIA_ID
     *
     * 仅企业微信2.4及以上版本支持。
     *
     * 参数说明 ：
     *
     * 参数 必须 说明
     * access_token 是 调用接口凭证
     * media_id 是 通过JSSDK的uploadVoice接口上传的语音文件id
     * 权限说明：
     * 完全公开，media_id在同一企业内所有应用之间可以共享。
     *
     * 返回说明 ：
     * 正确时返回（和普通的http下载相同，请根据http头做相应的处理）：
     *
     * HTTP/1.1 200 OK
     * Connection: close
     * Content-Type: voice/speex
     * Content-disposition: attachment; filename="XXX"
     * Date: Sun, 06 Jan 2013 10:20:18 GMT
     * Cache-Control: no-cache, must-revalidate
     * Content-Length: 339721
     * Xxxx
     * 错误时返回（这里省略了HTTP首部）：
     *
     * {
     * "errcode": 40007,
     * "errmsg": "invalid media_id"
     * }
     */
    public function download4Jssdk($mediaId, $file_ext = "")
    {
        $accessToken = $this->_client->getAccessToken();
        $url = 'https://qyapi.weixin.qq.com/cgi-bin/media/get/jssdk?access_token=' . $accessToken . '&media_id=' . $mediaId;
        return $this->_request->getFileByUrl($url, $file_ext);
    }

    public function __destruct()
    {
    }
}
