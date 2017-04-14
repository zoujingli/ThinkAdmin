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
    'token'          => sysconf('wechat_token'),
    'appid'          => sysconf('wechat_appid'),
    'appsecret'      => sysconf('wechat_appsecret'),
    'encodingaeskey' => sysconf('wechat_encodingaeskey'),
    'mch_id'         => sysconf('wechat_mch_id'),
    'partnerkey'     => sysconf('wechat_partnerkey'),
    'ssl_cer'        => sysconf('wechat_cert_cert'),
    'ssl_key'        => sysconf('wechat_cert_key'),
    'cachepath'      => CACHE_PATH . 'wxpay' . DS,
];