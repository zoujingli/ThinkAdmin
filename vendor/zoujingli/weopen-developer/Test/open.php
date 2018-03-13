<?php

// +----------------------------------------------------------------------
// | WeOpenDeveloper
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://think.ctolog.com
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/WeOpenDeveloper
// +----------------------------------------------------------------------

try {

    // 1. 手动加载入口文件
    include "../vendor/autoload.php";
    include "../WeOpen/Service.php";

    // 2. 准备配置参数
    $config = [
        'component_appid'          => 'wx4e63e993e222df8d',
        'component_token'          => 'P8QHTIxpBEq88IrxatqhgpBm2OAQROkI',
        'component_appsecret'      => '7cfa1afa87a41e2ea3445cea015c0974',
        'component_encodingaeskey' => 'L5uFIa0U6KLalPyXckyqoVIJYLhsfrg8k9YzybZIHsx',
    ];

    // 注册授权公众号 AccessToken 处理
    $config['GetAccessTokenCallback'] = function ($authorizer_appid) use ($config) {
        $open = new \WeOpen\Service($config);
        $authorizer_refresh_token = ''; // 从数据库去找吧，在授权绑定的时候获取到了
        $authorizer_refresh_token = 'L5uFIa0U6KLalPyXckyqoVIJYLhsfrg8k9YzybZIHsx'; // 从数据库去找吧，在授权绑定的时候获取到了
        $result = $open->refreshAccessToken($authorizer_appid, $authorizer_refresh_token);
        if (empty($result['authorizer_access_token'])) {
            throw new \WeChat\Exceptions\InvalidResponseException($result['errmsg'], '0');
        }
        $data = [
            'authorizer_access_token'  => $result['authorizer_access_token'],
            'authorizer_refresh_token' => $result['authorizer_refresh_token'],
        ];
        // 需要把$data记录到数据库
        return $result['authorizer_access_token'];
    };

    // 3 使用第三方服务创建接口实例
    $open = new \WeOpen\Service($config);
    $wechat = $open->instance('User', 'wx60a43dd8161666d4');
    $list = $wechat->getUserList();
    var_export($list);

} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}