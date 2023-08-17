## ThinkAdmin 插件生态

》》》更多插件正在开发，敬请期待……《《《

目前插件更新比较频繁，如果有发现 bug，请尝试升级最新版本。

如果问题依旧，请到 [Gitee](https://gitee.com/zoujingli/ThinkAdmin/issues) 提交问题，提交的内容中需要标注插件名称及问题详情，最好附加环境版本信息。

使用插件前请务必认真阅读每个插件的介绍。

**目前已有的插件如下：**

> 后台基础 Admin 管理插件（ 已稳定可用 ）
> * 插件标识：`admin`
> * 插件包名：`zoujingli/think-plugs-admin`
> * 安装方式：`composer require zoujingli/think-plugs-admin`
> * 插件仓库：https://github.com/zoujingli/think-plugs-admin
> * 开源协议：MIT ( 免费开源，支持本地插件化定制 )

> 后台基础 WeChat 微信插件（ 已稳定可用 ）
> * 插件标识：`wechat`
> * 插件包名：`zoujingli/think-plugs-wechat`
> * 安装方式：`composer require zoujingli/think-plugs-wechat`
> * 插件仓库：https://github.com/zoujingli/think-plugs-wechat
> * 开源协议：MIT ( 免费开源，支持本地插件化定制 )

> 后台静态资源初始化插件（通常不需要独立安装）
> * 插件标识：`static`
> * 插件包名：`zoujingli/think-plugs-static`
> * 安装方式：`composer require zoujingli/think-plugs-static`
> * 插件仓库：https://github.com/zoujingli/think-plugs-static
> * 开源协议：MIT ( 免费开源，部分插件包含其他开源协议，具体可以查看源文件，不支持本地插件化定制 )

> 基础插件市场系统 ( 开发中，后期开放 ThinkAdmin 生态市场 )
> * 插件标识：`plugin-center`
> * 插件包名：`zoujingli/think-plugs-center`
> * 安装方式：`composer require zoujingli/think-plugs-center`
> * 插件仓库：https://github.com/zoujingli/think-plugs-center
> * 开源协议：Apache2 ( 免费开源，建议保留版权注释，支持本地插件化定制 )

> 多端用户账号系统 ( 开发中，已发布测试版 )
> * 插件标识：`plugin-account`
> * 插件包名：`zoujingli/think-plugs-account`
> * 安装方式：`composer require zoujingli/think-plugs-account`
> * 插件仓库：https://github.com/zoujingli/think-plugs-account
> * 授权协议：VIP授权 ( 非VIP用户仅可用于学习，不得商用，支持本地插件化定制 )

> 多端支付管理系统 ( 开发中，已发布测试版 )
> * 插件标识：`plugin-payment`
> * 插件包名：`zoujingli/think-plugs-payment`
> * 安装方式：`composer require zoujingli/think-plugs-payment`
> * 插件仓库：https://github.com/zoujingli/think-plugs-payment
> * 授权协议：VIP授权 ( 非VIP用户仅可用于学习，不得商用，支持本地插件化定制 )

> 多端微商城系统 ( 开发中，已发布测试版 )
> * 插件标识：`plugin-wemall`
> * 插件包名：`zoujingli/think-plugs-wemall`
> * 安装方式：`composer require zoujingli/think-plugs-wemall`
> * 插件仓库：https://github.com/zoujingli/think-plugs-wemall
> * 授权协议：VIP授权 ( 非VIP用户仅可用于学习，不得商用，支持本地插件化定制 )

> 一物一码溯源系统 ( 开发中，还未发布 )
> * 插件标识：`plugin-wuma`
> * 插件包名：`zoujingli/think-plugs-wuma`
> * 安装方式：`composer require zoujingli/think-plugs-wuma`
> * 插件仓库：https://github.com/zoujingli/think-plugs-wuma
> * 授权协议：收费授权 ( 未获得授权仅可用于学习，不得商用，支持本地插件化定制 )

> 微信开放平台基础插件（ 已稳定可用 ）
> * 插件标识：`plugin-wechat-service`
> * 插件包名：`zoujingli/think-plugs-wechat-service`
> * 安装方式：`composer require zoujingli/think-plugs-wechat-service`
> * 插件仓库：https://github.com/zoujingli/think-plugs-wechat-service
> * 授权协议：VIP授权 ( 非VIP用户仅可用于学习，不得商用，支持本地插件化定制 )

### 安装测试微商城

```shell
composer create-project zoujingli/thinkadmin

cd thinkadmin

composer require zoujingli/think-plugs-wechat

composer require zoujingli/think-plugs-center 

composer require zoujingli/think-plugs-account 

composer require zoujingli/think-plugs-payment 

composer require zoujingli/think-plugs-wemall

# 启动 web 服务
php think run --host 127.0.0.1
```