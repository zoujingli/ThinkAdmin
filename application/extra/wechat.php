<?php

// +----------------------------------------------------------------------
// | Think.Admin
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/Think.Admin
// +----------------------------------------------------------------------

/**
 * 公众号配置参数
 * @return array
 */
return [
    'token'          => 'mytoken',
    'appid'          => 'wx60a43dd8161666d4',
    'appsecret'      => '5ac28d66f7c4dc20ca9e729ccb09b9b1',
    'encodingaeskey' => 'eHSmk5yJN2vSsuYscC8aHIiXnrgXZSKA4MRL9csEwTv',
    'mch_id'         => '1332187001',
    'partnerkey'     => 'A82DC5BD1F3359081049C568D8502BC5',
    'ssl_cer'        => __DIR__ . '/cert/apiclient_cert.pem',
    'ssl_key'        => __DIR__ . '/cert/apiclient_key.pem',
    'cachepath'      => RUNTIME_PATH . 'wechat/pay',
];