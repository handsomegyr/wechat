<?php

namespace Weixin\Wx\Manager\Shop;

use Weixin\Client;

/**
 * 图片接口
 *
 * @author guoyongrong
 *        
 */
class Img
{

    // 接口地址
    private $_url = 'https://api.weixin.qq.com/shop/img/';
    private $_client;
    private $_request;
    public function __construct(Client $client)
    {
        $this->_client = $client;
        $this->_request = $client->getRequest();
    }

    /**
     * 上传图片
     * https://developers.weixin.qq.com/miniprogram/dev/platform-capabilities/business-capabilities/ministore/minishopopencomponent2/API/public/upload_img.html
     * 接口调用请求说明
     * 上传类目、品牌、商品时，需使用图片上传接口换取临时链接用于上传，上传后微信侧会转为永久链接。临时链接在微信侧永久有效，商家侧可以存储临时链接，避免重复换取链接。
     *
     * 微信侧组件图片域名，store.mp.video.tencent-cloud.com,mmbizurl.cn,mmecimage.cn/p/。
     *
     * https://api.weixin.qq.com/shop/img/upload?access_token=xxxxxxxxx
     * 请求示例
     * curl -F media=@test.jpg "https://api.weixin.qq.com/shop/img/upload?access_token=xxxxxxxxx" -F resp_type=0
     * 请求参数说明
     * Content-Type: multipart/form-data， 图片大小限制2MB
     *
     * 参数 类型 是否必填 说明
     * resp_type number 是 0:此参数返回media_id，目前只用于品牌申请品牌和类目，推荐使用1：返回临时链接
     * upload_type number 是 0:图片流，1:图片url
     * img_url string 否 upload_type=1时必传
     * 注：临时链接会在微信侧转为永久链接
     *
     * 回包示例
     * {
     * "errcode": 0,
     * "errmsg":"ok",
     * "img_info":
     * {
     * "temp_img_url": "http://wwww.xxx.com",
     * "media_id": "wxashop_xxxx"
     * }
     * }
     * 回包参数说明
     * 参数 类型 说明
     * errcode number 错误码
     * errmsg string 错误信息
     * img_info.media_id string media_id
     * img_info.temp_img_url string 临时链接
     */
    public function upload($resp_type, $media)
    {
        $query = array(
            'resp_type' => $resp_type
        );
        $options = array(
            'fieldName' => 'media'
        );
        return $this->_request->uploadFile('https://api.weixin.qq.com/shop/img/upload', $media, $options, $query);
    }
}
