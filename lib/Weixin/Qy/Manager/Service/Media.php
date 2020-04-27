<?php

/**
 * 媒体控制器
 * @author guoyongrong <handsomegyr@126.com>
 *
 */

namespace Weixin\Qy\Manager\Service;

use Weixin\Qy\Service;

class Media
{
    // 接口地址
    private $_url = 'https://qyapi.weixin.qq.com/cgi-bin/service/media/';

    private $_service;

    private $_request;

    public function __construct(Service $service)
    {
        $this->_service = $service;
        $this->_request = $service->getRequest();
    }

    /**
     * 上传需要转译的文件
     * 素材上传得到media_id，该media_id仅三天内有效
     * media_id在同一企业内应用之间可以共享
     *
     * 请求方式：POST（HTTPS）
     * 请求地址：https://qyapi.weixin.qq.com/cgi-bin/service/media/upload?provider_access_token=ACCESS_TOKEN&type=TYPE
     *
     * 使用multipart/form-data POST上传文件， 文件标识名为”media”
     * 参数说明：
     *
     * 参数 必须 说明
     * provider_access_token 是 服务商provider_access_token，获取方法参见服务商的凭证
     * type 是 媒体文件类型，分别有图片（image）、语音（voice）、视频（video），普通文件（file）
     * POST的请求包中，form-data中媒体文件标识，应包含有 filename、filelength、content-type等信息
     *
     * filename标识文件展示的名称。比如，使用该media_id发消息时，展示的文件名由该字段控制
     *
     * 调用示例
     * curl -F media=@test.csv “https://qyapi.weixin.qq.com/cgi-bin/service/media/upload?provider_access_token=ACCESS_TOKEN&type=TYPE”
     *
     * 请求示例：
     *
     * POST https://qyapi.weixin.qq.com/cgi-bin/service/media/upload?provider_access_token=accesstoken001&type=file HTTP/1.1
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
     */
    public function upload($provider_access_token, $type, $media)
    {
        $query = array(
            'type' => $type
        );
        $options = array(
            'fieldName' => 'media'
        );
        return $this->_request->uploadFile($this->_url . 'upload?provider_access_token=' . $provider_access_token, $media, $options, $query);
    }
}
