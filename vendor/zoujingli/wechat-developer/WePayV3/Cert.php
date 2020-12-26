<?php

// +----------------------------------------------------------------------
// | WeChatDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2020 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeChatDeveloper
// +----------------------------------------------------------------------

namespace WePayV3;

use WeChat\Exceptions\InvalidResponseException;
use WePayV3\Contracts\BasicWePay;
use WePayV3\Contracts\DecryptAes;

/**
 * 平台证书管理
 * Class Cert
 * @package WePayV3
 */
class Cert extends BasicWePay
{

    /**
     * 商户平台下载证书
     * @throws InvalidResponseException
     */
    public function download()
    {
        try {
            $aes = new DecryptAes($this->config['mch_v3_key']);
            $result = $this->doRequest('GET', '/v3/certificates');
            foreach ($result['data'] as $vo) {
                $this->tmpFile($vo['serial_no'], $aes->decryptToString(
                    $vo['encrypt_certificate']['associated_data'],
                    $vo['encrypt_certificate']['nonce'],
                    $vo['encrypt_certificate']['ciphertext']
                ));
            }
        } catch (\Exception $exception) {
            throw new InvalidResponseException($exception->getMessage(), $exception->getCode());
        }
    }
}