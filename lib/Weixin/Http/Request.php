<?php
/**
 * 处理HTTP请求
 * 
 * 使用Guzzle http client库做为请求发起者，以便日后采用异步请求等方式加快代码执行速度
 *
 */
namespace Weixin\Http;

use Weixin\Exception;

class Request
{

    private $_accessToken = null;

    private $_tmp = null;

    private $_json = true;

    public function __construct($accessToken, $json = true)
    {
        $this->_accessToken = $accessToken;
        if (empty($this->_accessToken)) {
            throw new Exception("access_token为空");
        }
        $this->_json = $json;
    }

    /**
     * 获取微信服务器信息
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function get($url, $params = array(), $options = array())
    {
        $client = new \GuzzleHttp\Client();
        $params['access_token'] = $this->_accessToken;
        $response = $client->get($url, array(
            'query' => $params
        ));
        if ($this->isSuccessful($response)) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 推送消息给到微信服务器
     *
     * @param string $url            
     * @param array $params            
     * @return mixed
     */
    public function post($url, $params = array(), $options = array(), $body = '')
    {
        $client = new \GuzzleHttp\Client();
        $response = $client->post($url, array(
            'query' => array(
                'access_token' => $this->_accessToken
            ),
            'body' => empty($body) ? json_encode($params, JSON_UNESCAPED_UNICODE) : $body
        ));
        if ($this->isSuccessful($response)) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 下载指定路径的文件资源
     *
     * @param string $mediaId            
     * @return array
     */
    public function download($mediaId)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/media/get?access_token=' . $this->_accessToken . '&media_id=' . $mediaId;
        return $this->getFileByUrl($url);
    }

    /**
     * 上传微信多媒体文件
     *
     * @param string $type            
     * @param string $media
     *            url或者filepath
     * @throws Exception
     * @return mixed
     */
    public function upload($type, $media)
    {
        $query = array(
            'type' => $type
        );
        return $this->sendUploadFileRequest('https://api.weixin.qq.com/cgi-bin/media/upload', $query, $media);
    }

    /**
     * 上传客服头像
     *
     * @param string $kf_account            
     * @param string $media
     *            url或者filepath
     * @throws Exception
     * @return mixed
     */
    public function uploadheadimg4KfAcount($kf_account, $media)
    {
        $query = array(
            'kf_account' => $kf_account
        );
        return $this->sendUploadFileRequest('https://api.weixin.qq.com/customservice/kfacount/uploadheadimg', $query, $media);
    }

    /**
     * 上传文件
     *
     * @param string $baseUrl            
     * @param string $uri            
     * @param string $media
     *            url或者filepath
     * @param array $options            
     * @throws Exception
     * @return mixed
     */
    public function uploadFile($baseUrl, $uri, $media, array $options = array('fieldName'=>'media'))
    {
        $query = array();
        return $this->sendUploadFileRequest($baseUrl . $uri, $query, $media, $options);
    }

    /**
     * 上传文件
     *
     * @param string $uri            
     * @param array $fileParams            
     * @param array $extraParams            
     * @throws Exception
     * @return mixed
     */
    public function uploadFiles($uri, array $fileParams, array $extraParams = array())
    {
        $client = new \GuzzleHttp\Client();
        
        $files = array();
        foreach ($fileParams as $fileName => $media) {
            if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
                $fileInfo = $this->getFileByUrl($media);
                $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
                $media = fopen($media, 'r');
            } elseif (is_readable($media)) {
                $media = fopen($media, 'r');
            } else {
                throw new Exception("无效的上传文件");
            }
            $files[$fileName] = $media;
        }
        $multipart = array();
        if (! empty($files)) {
            foreach ($files as $field => $value) {
                $multipart[] = array(
                    'name' => $field,
                    'contents' => $value
                );
            }
        }
        // 如果需要额外的提交参数的话
        if (! empty($extraParams)) {
            $body = json_encode($extraParams, JSON_UNESCAPED_UNICODE);
        }
        
        $response = $client->post($uri, array(
            'query' => array(
                'access_token' => $this->_accessToken
            ),
            'multipart' => $multipart,
            'body' => $body
        ));
        
        if ($this->isSuccessful($response)) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    /**
     * 下载文件
     *
     * @param string $url            
     * @throws Exception
     * @return array
     */
    private function getFileByUrl($url = '')
    {
        $opts = array(
            'http' => array(
                'follow_location' => 3,
                'max_redirects' => 3,
                'timeout' => 10,
                'method' => "GET",
                'header' => "Connection: close\r\n",
                'user_agent' => 'iCatholic R&D'
            )
        );
        $context = stream_context_create($opts);
        $fileBytes = file_get_contents($url, false, $context);
        $filename = uniqid() . '.jpg';
        return array(
            'name' => $filename,
            'bytes' => $fileBytes
        );
    }

    /**
     * 将指定文件名和内容的数据，保存到临时文件中，在析构函数中删除临时文件
     *
     * @param string $fileName            
     * @param bytes $fileBytes            
     * @return string
     */
    private function saveAsTemp($fileName, $fileBytes)
    {
        $this->_tmp = sys_get_temp_dir() . '/temp_files_' . $fileName;
        file_put_contents($this->_tmp, $fileBytes);
        return $this->_tmp;
    }

    private function getJson($response)
    {
        try {
            $body = $response->getBody();
            if ($this->_json) {
                $json = json_decode($body, true);
				if (JSON_ERROR_NONE !== json_last_error()) {
					throw new \InvalidArgumentException(
						'Unable to parse JSON data: '
					);
				}
				return $json;
            } else {
                return $body;
            }
        } catch (\Exception $e) {
            $body = $response->getBody();
            if ($this->_json) {
				$body = substr(str_replace('\"', '"', json_encode($body,JSON_UNESCAPED_SLASHES)), 1, - 1);
                $response->setBody($body);
                return $response->json();
            } else {
                return $body;
            }
        }
    }

    /**
     * Checks if HTTP Status code is Successful (2xx | 304)
     *
     * @return bool
     */
    public function isSuccessful($response)
    {
        $statusCode = $response->getStatusCode();
        return ($statusCode >= 200 && $statusCode < 300) || $statusCode == 304;
    }

    private function sendUploadFileRequest($url, array $otherQuery, $media, array $options = array('fieldName'=>'media'))
    {
        $client = new \GuzzleHttp\Client();
        $query = array(
            'access_token' => $this->_accessToken
        );
        if (! empty($otherQuery)) {
            $query = array_merge($query, $otherQuery);
        }
        if (filter_var($media, FILTER_VALIDATE_URL) !== false) {
            $fileInfo = $this->getFileByUrl($media);
            $media = $this->saveAsTemp($fileInfo['name'], $fileInfo['bytes']);
            $media = fopen($media, 'r');
        } elseif (is_readable($media)) {
            $media = fopen($media, 'r');
        } else {
            throw new Exception("无效的上传文件");
        }
        
        $response = $client->post($url, array(
            'query' => $query,
            'multipart' => array(
                array(
                    'name' => $options['fieldName'],
                    'contents' => $media
                )
            )
        ));
        
        if ($this->isSuccessful($response)) {
            return $this->getJson($response); // $response->json();
        } else {
            throw new Exception("微信服务器未有效的响应请求");
        }
    }

    public function __destruct()
    {
        if (! empty($this->_tmp)) {
            unlink($this->_tmp);
        }
    }
}