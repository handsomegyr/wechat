<?php

namespace Weixin\Qy\ThirdParty\MsgCrypt;

use Weixin\ThirdParty\MsgCrypt\ErrorCode;

// include_once "errorCode.php";
/**
 * Prpcrypt class
 *
 * 提供接收和推送给公众平台消息的加解密接口.
 */
class Prpcrypt
{

    public $key = null;

    public $iv = null;

    /**
     * Prpcrypt constructor.
     * 
     * @param
     *            $k
     */
    public function __construct($k)
    {
        $this->key = base64_decode($k . '=');
        $this->iv = substr($this->key, 0, 16);
    }

    /**
     * 加密
     *
     * @param
     *            $text
     * @param
     *            $receiveId
     * @return array
     */
    public function encrypt($text, $receiveId)
    {
        try {
            // 拼接
            $text = $this->getRandomStr() . pack('N', strlen($text)) . $text . $receiveId;
            // 添加PKCS#7填充
            $pkc_encoder = new PKCS7Encoder();
            $text = $pkc_encoder->encode($text);
            // 加密
            if (function_exists('openssl_encrypt')) {
                $encrypted = \openssl_encrypt($text, 'AES-256-CBC', $this->key, OPENSSL_ZERO_PADDING, $this->iv);
            } else {
                $encrypted = \mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($text), MCRYPT_MODE_CBC, $this->iv);
            }
            return array(
                ErrorCode::$OK,
                $encrypted
            );
        } catch (\Exception $e) {
            print $e;
            return array(
                MyErrorCode::$EncryptAESError,
                null
            );
        }
    }

    /**
     * 解密
     *
     * @param
     *            $encrypted
     * @param
     *            $receiveId
     * @return array
     */
    public function decrypt($encrypted, $receiveId)
    {
        try {
            // 解密
            if (function_exists('openssl_decrypt')) {
                $decrypted = \openssl_decrypt($encrypted, 'AES-256-CBC', $this->key, OPENSSL_ZERO_PADDING, $this->iv);
            } else {
                $decrypted = \mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($encrypted), MCRYPT_MODE_CBC, $this->iv);
            }
        } catch (\Exception $e) {
            return array(
                ErrorCode::$DecryptAESError,
                null
            );
        }
        try {
            // 删除PKCS#7填充
            $pkc_encoder = new PKCS7Encoder();
            $result = $pkc_encoder->decode($decrypted);
            if (strlen($result) < 16) {
                return array();
            }
            // 拆分
            $content = substr($result, 16, strlen($result));
            $len_list = unpack('N', substr($content, 0, 4));
            $xml_len = $len_list[1];
            $xml_content = substr($content, 4, $xml_len);
            $from_receiveId = substr($content, $xml_len + 4);
        } catch (\Exception $e) {
            print $e;
            return array(
                ErrorCode::$IllegalBuffer,
                null
            );
        }
        if ($from_receiveId != $receiveId) {
            return array(
                ErrorCode::$ValidateCorpidError,
                null
            );
        }
        return array(
            0,
            $xml_content
        );
    }

    /**
     * 生成随机字符串
     *
     * @return string
     */
    private function getRandomStr()
    {
        $str = '';
        $str_pol = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyl';
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }
}
