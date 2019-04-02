[![Latest Stable Version](https://poser.pugx.org/zoujingli/weopen-developer/v/stable)](https://packagist.org/packages/zoujingli/weopen-developer) 
[![Latest Unstable Version](https://poser.pugx.org/zoujingli/weopen-developer/v/unstable)](https://packagist.org/packages/zoujingli/weopen-developer) 
[![Total Downloads](https://poser.pugx.org/zoujingli/weopen-developer/downloads)](https://packagist.org/packages/zoujingli/weopen-developer) 
[![License](https://poser.pugx.org/zoujingli/weopen-developer/license)](https://packagist.org/packages/zoujingli/weopen-developer)

# WeOpenDeveloper
WeOpenDeveloper 为微信开放平台服务开发工具，基于 WeChatDeveloper 可对公众号进行管理。
更多功能可以参考下面的文档。

Documentation
--
PHP开发技术交流（QQ群 513350915）

[![PHP微信开发群 (SDK)](http://pub.idqqimg.com/wpa/images/group.png)](http://shang.qq.com/wpa/qunwpa?idkey=ae25cf789dafbef62e50a980ffc31242f150bc61a61164458216dd98c411832a) 

> WeChatDeveloper 是基于官方接口封装，在做微信开发前，必需先阅读微信官方文档。
>* 微信官方文档：http://mp.weixin.qq.com/wiki
>* 开放平台文档：https://open.weixin.qq.com
>* 商户支付文档：https://pay.weixin.qq.com/wiki/doc/api/index.html

> 针对 WeChatDeveloper 也有一准备了帮助资料可供参考。
>* WeChatDeveloper 文档：http://www.kancloud.cn/zoujingli/wechat-developer

Repository
--
 WeOpenDeveloper 为开源项目，允许把它用于任何地方，不受任何约束，欢迎 fork 项目。
>* GitHub 托管地址：https://github.com/zoujingli/WeOpenDeveloper
>* OSChina 托管地址：http://git.oschina.net/zoujingli/WeOpenDeveloper

更多开发可以参考项目 [ThinkService](https://github.com/zoujingli/ThinkService) 。
此项目已经实现对接，[ThinkAdmin](https://github.com/zoujingli/ThinkAdmin) + [ThinkService](https://github.com/zoujingli/ThinkService) 组合。

Install
--
* 通过 Composer 来管理安装
```shell
# 首次安装 线上版本（稳定）
composer require zoujingli/weopen-developer

# 首次安装 开发版本 
composer require zoujingli/weopen-developer dev-master

# 更新 WeChatDeveloper
composer update zoujingli/weopen-developer
```

* 接口实例所需参数
```php

// 配置参数（可以公众号服务平台获取）
$config = [
    'component_appid'          => 'wx4e63e993e222df8d',
    'component_token'          => 'P8QHTIxpBEq88IrxatqhgpBm2OAQROkI',
    'component_appsecret'      => '7cfa1afa87a41e2ea3445cea015c0974',
    'component_encodingaeskey' => 'L5uFIa0U6KLalPyXckyqoVIJYLhsfrg8k9YzybZIHsx',
];

// 注册授权公众号 AccessToken 处理
$config['GetAccessTokenCallback'] = function ($authorizer_appid) use ($config) {
    $open = new \WeOpen\Service($config);
    $authorizer_refresh_token = ''; // 通过$authorizer_appid从数据库去找吧，在授权绑定的时候获取
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
```

* Ticket 接收处理
```php

try{

    // 实例公众号服务接口
    $server = new \WeOpen\Service($config);
    
    // 获取并更新Ticket推送
    if (!($data = $server->getComonentTicket())) {
        return "Ticket event handling failed.";
    }
    
} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}
```

* 实例指定接口
```php
try{

    // 实例公众号服务接口
    $open = new \WeOpen\Service($config);
    
    // 获取公众号接口操作实例
    $wechat = $open->instance('User', 'wx60a43dd8161666d4');
    
    // 获取公众号粉丝列表
    $list = $wechat->getUserList();
    var_export($list);
    
} catch (Exception $e) {

    // 出错啦，处理下吧
    echo $e->getMessage() . PHP_EOL;

}

```

Copyright
--
* WeOpenDeveloper 基于`MIT`协议发布，任何人可以用在任何地方，不受约束
* WeOpenDeveloper 部分代码来自互联网，若有异议，可以联系作者进行删除


Sponsor
--
![赞助](http://zoujingli.oschina.io/static/pay.png)
