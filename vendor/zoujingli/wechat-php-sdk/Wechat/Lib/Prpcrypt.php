<?php

/**
 * PKCS7算法 加解密
 * @category WechatSDK
 * @subpackage library
 * @date 2016/06/28 11:59
 */
class PKCS7Encoder {

    public static $block_size = 32;

    /**
     * 对需要加密的明文进行填充补位
     * @param $text 需要进行填充补位操作的明文
     * @return 补齐明文字符串
     */
    function encode($text) {
        $block_size = PKCS7Encoder::$block_size;
        $text_length = strlen($text);
        $amount_to_pad = PKCS7Encoder::$block_size - ($text_length % PKCS7Encoder::$block_size);
        if ($amount_to_pad == 0) {
            $amount_to_pad = PKCS7Encoder::block_size;
        }
        $pad_chr = chr($amount_to_pad);
        $tmp = "";
        for ($index = 0; $index < $amount_to_pad; $index++) {
            $tmp .= $pad_chr;
        }
        return $text . $tmp;
    }

    /**
     * 对解密后的明文进行补位删除
     * @param decrypted 解密后的明文
     * @return 删除填充补位后的明文
     */
    function decode($text) {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > PKCS7Encoder::$block_size) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }

}

/**
 * 接收和推送给公众平台消息的加解密
 * @category WechatSDK
 * @subpackage library
 * @date 2016/06/28 11:59
 */
class Prpcrypt {

    public $key;

    function __construct($k) {
        $this->key = base64_decode($k . "=");
    }

    /**
     * 对明文进行加密
     * @param string $text 需要加密的明文
     * @return string 加密后的密文
     */
    public function encrypt($text, $appid) {
        try {
            $random = $this->getRandomStr();
            $text = $random . pack("N", strlen($text)) . $text . $appid;
            $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_CBC);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            $pkc_encoder = new PKCS7Encoder();
            $text = $pkc_encoder->encode($text);
            mcrypt_generic_init($module, $this->key, $iv);
            $encrypted = mcrypt_generic($module, $text);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
            return array(ErrorCode::$OK, base64_encode($encrypted));
        } catch (Exception $e) {
            return array(ErrorCode::$EncryptAESError, ErrorCode::getErrText(ErrorCode::$EncryptAESError));
        }
    }

    /**
     * 对密文进行解密
     * @param string $encrypted 需要解密的密文
     * @return string 解密得到的明文
     */
    public function decrypt($encrypted, $appid) {
        try {
            $ciphertext_dec = base64_decode($encrypted);
            $module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
            $iv = substr($this->key, 0, 16);
            mcrypt_generic_init($module, $this->key, $iv);
            $decrypted = mdecrypt_generic($module, $ciphertext_dec);
            mcrypt_generic_deinit($module);
            mcrypt_module_close($module);
        } catch (Exception $e) {
            return array(ErrorCode::$DecryptAESError, ErrorCode::getErrText(ErrorCode::$DecryptAESError));
        }
        try {
            $pkc_encoder = new PKCS7Encoder();
            $result = $pkc_encoder->decode($decrypted);
            if (strlen($result) < 16) {
                return "";
            }
            $content = substr($result, 16, strlen($result));
            $len_list = unpack("N", substr($content, 0, 4));
            $xml_len = $len_list[1];
            $xml_content = substr($content, 4, $xml_len);
            $from_appid = substr($content, $xml_len + 4);
            if (!$appid) {
                $appid = $from_appid;
            }
        } catch (Exception $e) {
            return array(ErrorCode::$IllegalBuffer, ErrorCode::getErrText(ErrorCode::$IllegalBuffer));
        }
        return array(0, $xml_content, $from_appid);
    }

    /**
     * 随机生成16位字符串
     * @return string 生成的字符串
     */
    function getRandomStr() {
        $str = "";
        $str_pol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($str_pol) - 1;
        for ($i = 0; $i < 16; $i++) {
            $str .= $str_pol[mt_rand(0, $max)];
        }
        return $str;
    }

}

/**
 * 仅用作类内部使用，不用于官方API接口的errCode码
 * @category WechatSDK
 * @subpackage library
 * @date 2016/06/28 11:59
 */
class ErrorCode {

    public static $OK = 0;
    public static $ValidateSignatureError = 40001;
    public static $ParseXmlError = 40002;
    public static $ComputeSignatureError = 40003;
    public static $IllegalAesKey = 40004;
    public static $ValidateAppidError = 40005;
    public static $EncryptAESError = 40006;
    public static $DecryptAESError = 40007;
    public static $IllegalBuffer = 40008;
    public static $EncodeBase64Error = 40009;
    public static $DecodeBase64Error = 40010;
    public static $GenReturnXmlError = 40011;
    public static $errCode = array(
        '0'     => '处理成功',
        '40001' => '校验签名失败',
        '40002' => '解析xml失败',
        '40003' => '计算签名失败',
        '40004' => '不合法的AESKey',
        '40005' => '校验AppID失败',
        '40006' => 'AES加密失败',
        '40007' => 'AES解密失败',
        '40008' => '公众平台发送的xml不合法',
        '40009' => 'Base64编码失败',
        '40010' => 'Base64解码失败',
        '40011' => '公众帐号生成回包xml失败'
    );

    /**
     * 获取错误消息内容
     * @param type $err
     * @return bool
     */
    public static function getErrText($err) {
        if (isset(self::$errCode[$err])) {
            return self::$errCode[$err];
        } else {
            return false;
        }
    }

}
