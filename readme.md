## 大道至简 · 原生框架

[![Latest Stable Version](https://poser.pugx.org/zoujingli/thinkadmin/v/stable)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Total Downloads](https://poser.pugx.org/zoujingli/thinkadmin/downloads)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Monthly Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/monthly)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Daily Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/daily)](https://packagist.org/packages/zoujingli/thinkadmin)
[![License](https://poser.pugx.org/zoujingli/thinkadmin/license)](https://packagist.org/packages/zoujingli/thinkadmin)

### 项目介绍

**ThinkAdmin** 是一款遵循 **MIT** 协议开源的快速开发框架，基于最新版本 **ThinkPHP6** 的极简后台管理系统，在使用 **ThinkAdmin** 前请认真阅读[《免责声明》](https://doc.thinkadmin.top/disclaimer)并同意该声明。

当前 **ThinkAdmin** 的最新版本为[ **v6.1** ](https://gitee.com/zoujingli/ThinkAdmin/tree/v6.1)，从这个版本开始正式进入插件时代，提供类似 **PaaS** 的组件升级更新服务，也可以本地化定制开发，基础组件及扩展插件统一使用 **Composer** 管理。**ThinkAdmin** 与传统 **ThinkPHP** 多应用模式无差别，用户可以自行开发自己的模块，此次升级可完美兼容 **ThinkAdmin v6.0** 应用，原 **ThinkAdmin v6.0** 只需安装 **ThinkPlugsAdmin** 组件即可升级到 **v6.1** 的插件模式。想要了解更多 **ThinkAdmin** 插件生态请阅读 [《ThinkAdmin 插件生态》](https://gitee.com/zoujingli/ThinkAdmin/blob/v6.1/plugin.md)

**[查看 ThinkAdmin v6.1 详细介绍请切换至 v6.1 分支](https://gitee.com/zoujingli/ThinkAdmin/tree/v6.1)！！**

**ThinkAdmin v6** 是基于 **v1**-**v5** 大版本的积累，经历了几次大的调整，结合 **ThinkPHP6** 的思维重新构建，减少大量原非必需的组件，自建存储层、服务层及队列任务机制，另外还增加了许多友好指令！当前 **v6** 版本已经通过了数个系统实践与测试，过程中不停调整与优化，目前系统模块及微信模块已经趋于稳定，现将系统管理 **`app/admin`** 及微信管理 **`app/wechat`** 定为 **v6** 内核两大模块并以 **MIT** 协议发布，后续可能还有其他模块及相关辅助模块更新发布，敬请期待……

系统核心组件 **ThinkLibrary** 封装了大量常用操作以及多应用组件，可快速开发各种应用程序，且不影响原 **ThinkPHP** 生态，大大简化编码成本；可自行选择集成 **WechatDeveloper** 组件 ( 支持微信公众号、微信小程序、微信企业号、微信商户支付、支付宝支付等 ) 及 **QRcode** 二维码生成工具等。里面还内置了 **ThinkPHP6** 多应用组件并且完美支持路由；文件存储支持本地服务器存储、自建Alist存储、七牛云对象存储（支持CDN加速）、又拍云USS存储（支持CDN加速）、阿里云OSS存储（支持CDN加速）、腾讯云COS存储（支持CDN加速）等存储方式；自带异步任务处理机制，可以并列多进程执行任务，任务响应延时小于 **0.5** 秒，兼容 **windows** 及 **linux**。

使用 **ThinkAdmin** 需要掌握 **ThinkPHP**、**jQuery**、**LayUI**、**RequireJs** 等开发技能，后台 **UI** 界面基于最新版本的 **LayUI** 前端框架以及 **RequireJs** 组件加载方式，默认加载了所有 **LayUI** 的组件，框架中可以直接使用组件（独立页面需要注意 **js** 加载顺序哦），使用 **RequireJs** 加载插件，互联网上资源非常多，可自行下载进行二次扩展。目前后台大部分页面为单页程序，页面加载速度非常快速，也因此后台不再支持选项卡模式。

我们致力于快速开发的底层框架，让项目开发变得更容易。框架提供完善的基础组件以及对应的 **API** 支持，基于此框架可以快速开发各种 **WEB** 应用。任何一个系统都不能完全满足所有的业务场景，**ThinkAdmin** 免费提供基础底层的功能，这里包括系统权限管理，系统存储配置，微信授权管理，以及其他常用功能集成等…… 因此 **ThinkAdmin** 也被大家定性为外包二开基线系统。从 **v6.1** 开始我们提供会员尊享组件和定制业务插件服务。目前已经有许多公司及个人在使用 **ThinkAdmin**，通过数据聚合统计已有 **5** 万多在线运行的项目。

#### 注意事项

* **ThinkAdmin** 是基于国内最流行的 **ThinkPHP6** 框架开发，要求在不低于 **PHP 7.2.5** 的版本上运行，如果使用低版本的 **PHP** 可能会影响 **Composer** 依赖组件的安装，或将存在一定的安全隐患；
* 运行环境必需开启 **PATHINFO** 并将对应的 **rewrite** 规则配置到站点才能访问，系统已不再支持 **ThinkPHP** 的 **URL** 兼容模式运行 ( 源于如何优雅地展示 )，可以阅读 **ThinkAdmin** 的文档[安装部署](https://doc.thinkadmin.top/install)章节；
* 代码仓库下载的文件不包含 **Composer** 组件的 **vendor** 目录，下载后需要执行 **composer install** 安装依赖组件，同时会触发执行 **php think migrate:run** 安装数据库 **Phinx** 脚本，如需切换数据库只需要先配置再执行指令即可完成初始化安装数据；
* 为保持系统可持续在线升级，建议不要在 **app/admin**、**app/wechat** 、**public/static** 这三个目录创建或修改文件，可以自行创建其他模块再编写自己的业务代码，自定义样式及脚本可以放置在 **public/static/extra** 目录里面。
* 系统是基于严格类型 **PHP** 新特性开发，务必使用专业的 **IDE** ( 如：**PhpStorm**、**NetBeans**、**VsCode**、**Eclipse for PHP** 等 ) 进行项目开发以达到更好的体验与更高的效率！

## 系统安装

下载并进入 **ThinkAdmin** 根目录，运行指令安装依赖组件。

打开命令行窗口（ Windows 用户 ）或控制台（ Linux 和 Mac 用户 ）并执行如下命令：

**1. 通过 Composer 安装：**( 推荐方式，仅安装 admin 模块 )

```shell
### 创建项目（ 需要在英文目录下面执行 ）
composer create-project zoujingli/thinkadmin

### 进入项目根目录
cd thinkadmin

### 数据库初始化并安装 
### 默认使用 Sqlite 数据库，若使用其他数据库请修改配置后再执行
php think migrate:run

### 开启PHP内置WEB服务
### 默认后台登录账号及密码都是 admin
php think run --host 127.0.0.1
```

**2. 通过源码安装：**（ 安装 admin、wechat、data 三个模块 ）

```shell
### 下载项目（ 需要在英文目录下面执行 ）
git clone https://github.com/zoujingli/ThinkAdmin

### 进入项目根目录
cd ThinkAdmin

### 安装项目依赖组件
composer install --optimize-autoloader

### 数据库初始化并安装
### 默认使用 Sqlite 数据库，若使用其他数据库请修改配置后再执行
php think migrate:run

### 开启PHP内置WEB服务
### 默认后台登录账号及密码都是 admin
php think run --host 127.0.0.1
```

## 数据库安装

1. 创建空的数据库并将参数配置到 **config/database.php** 文件；
2. 导入数据库 **SQL** 文件或执行数据库初始化操作，视版本情况操作；

**温馨提示：** 当前下载的代码已经是 **v6.1** 版本！

* 版本是 **v6.0** 的项目需要导入项目根目录下的 `SQL01-数据表结构.sql` 和 `SQL02-数据初始化.sql` 文件；
* 版本是 **v6.1** 的项目不需要导入数据库 `SQL` 文件，修改数据库配置后执行 `php think migrate:run` 即可；

## 技术支持

开发前请认真阅读 ThinkPHP 官方文档，会对您有帮助哦！

本地开发请使用 `php think run` 运行服务，访问 `http://127.0.0.1:8000` 即可进入项目。

官方地址及开发指南：https://doc.thinkadmin.top ，如果实在无法解决问题，可以加入官方群免费交流。

**1.官方QQ交流群：** 513350915

**2.官方QQ交流群：** 866345568

**3.官方微信交流群**

<img alt="" src="https://doc.thinkadmin.top/static/img/wx.png" width="250">

## 注解权限

注解权限是指通过方法注释来实现后台 **RBAC** 授权管理，用注解来管理功能节点。

开发人员只需要写好注释，会自动生成功能的节点，只需要配置角色及用户就可以使用 **RBAC** 权限。

* 此版本的权限使用注解实现
* 注释必须是标准的块注释，案例如下展示
* 其中 `@auth true` 表示访问需要权限验证
* 其中 `@menu true` 菜单编辑显示可选节点
* 其中 `@login true` 需要强制登录才可访问

```php
/**
 * 操作的名称
 * @auth true  # 表示访问需要权限验证
 * @menu true  # 菜单编辑显示可选节点
 * @login true # 需要强制登录才可访问 
 */
public function index(){
   // @todo
}
```

## 代码仓库

主仓库放置于 **Gitee**, **Github** 为镜像仓库。

部分代码来自互联网，若有异议可以联系作者进行删除。

* 在线体验地址：https://v6.thinkadmin.top （账号和密码都是 admin ）
* Gitee 仓库地址：https://gitee.com/zoujingli/ThinkAdmin
* Github 仓库地址：https://github.com/zoujingli/ThinkAdmin

## 框架指令

* 执行 `php think run` 启用本地开发环境，访问 `http://127.0.0.1:8000`
* 执行 `php think xadmin:package` 将现有 `MySQL` 数据库打包为 `Phinx` 数据库脚本
* 执行 `php think xadmin:sysmenu` 重写系统菜单并生成新编号，同时会清理已禁用的菜单数据
* 执行 `php think xadmin:fansall` 同步微信粉丝数据，依赖于 `ThinkPlugsWechat` 应用插件
* 执行 `php think xadmin:replace` 可以批量替换数据库指定字符字段内容，通常用于文件地址替换
* 执行 `php think xadmin:database` 对数据库的所有表 `repair|optimize` 操作，优化并整理数据库碎片
* 执行 `php think xadmin:publish` 可自动安装现在模块或已安装应用插件，增加 `--migrate` 参数执行数据库脚本

#### 1. 守护进程管理（可自建定时任务去守护监听主进程）

* 执行 `php think xadmin:queue listen` [监听]启动异步任务监听服务
* 执行 `php think xadmin:queue start`  [控制]检查创建任务监听服务（建议定时任务执行）
* 执行 `php think xadmin:queue query`  [控制]查询当前任务相关的进程
* 执行 `php think xadmin:queue status`  [控制]查看异步任务监听状态
* 执行 `php think xadmin:queue stop`   [控制]平滑停止所有任务进程

#### 2. 本地调试管理（可自建定时任务去守护监听主进程）

* 执行 `php think xadmin:queue webstop` [调试]停止本地调试服务
* 执行 `php think xadmin:queue webstart` [调试]开启本地调试服务（建议定时任务执行）
* 执行 `php think xadmin:queue webstatus` [调试]查看本地调试状态

## 问题修复

* 增加 **CORS** 跨域规则配置，配置参数置放于 `config/app.php`，需要更新 `ThinkLibrary`。
* 修复 `layui.table` 导致基于 `ThinkPHP` 模板输出自动转义 `XSS` 过滤机制失效，需要更新 `ThinkLibrary`。
* 修复在模板中使用 `{:input(NAME)}` 取值而产生的 `XSS` 问题，模板取值更换为 `{$get.NAME|default=''}`。
* 修复 `CKEDITOR` 配置文件，禁用所有标签的 `on` 事件，阻止 `xss` 脚本注入，需要更新 `ckeditor/config.js`。
* 修复文件上传入口的后缀验证，读取真实文件后缀与配置对比，阻止不合法的文件上传并存储到本地服务器。
* 修改 `JsonRpc` 接口异常处理机制，当服务端绑定 `Exception` 时，客户端将能收到 `error` 消息及异常数据。
* 修改 `location.hash` 访问机制，禁止直接访问外部 `URL` 资源链接，防止外部 `XSS` 攻击读取本地缓存数据。
* 增加后台主题样式配置，支持全局默认+用户个性配置，需要更新 `admin`, `static`, `ThinkLibrary` 组件及模块。
* 后台行政区域数据更新，由原来的腾讯地图数据切换为百度地图最新数据，需要更新 `static`，数据库版需另行更新。

## 版权信息

[**ThinkAdmin**](https://thinkadmin.top) 遵循 [**MIT**](license) 开源协议发布，并免费提供使用。

本项目包含的第三方源码和二进制文件的版权信息另行标注。

版权所有 Copyright © 2014-2023 by ThinkAdmin (https://thinkadmin.top) All rights reserved。

更多细节参阅 [`LISENSE`](license) 文件

## 历史版本

以下系统的体验账号及密码都是 admin

### ThinkAdmin v6 基于 ThinkPHP 6.0 开发（后台权限基于注解实现）

* 在线体验地址：https://v6.thinkadmin.top (运行中)
* Gitee 代码地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v6
* Github 代码地址：https://github.com/zoujingli/ThinkAdmin/tree/v6

### ThinkAdmin v5 基于 ThinkPHP 5.1 开发（后台权限基于注解实现）

* 在线体验地址：https://v5.thinkadmin.top (已停用)
* Gitee 代码地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v5
* Github 代码地址：https://github.com/zoujingli/ThinkAdmin/tree/v5

### ThinkAdmin v4 基于 ThinkPHP 5.1 开发（不建议继续使用）

* 在线体验地址：https://v4.thinkadmin.top (已停用)
* Gitee 代码地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v4
* Github 代码地址：https://github.com/zoujingli/ThinkAdmin/tree/v4

### ThinkAdmin v3 基于 ThinkPHP 5.1 开发（不建议继续使用）

* 在线体验地址：https://v3.thinkadmin.top (已停用)
* Gitee 代码地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v3
* Github 代码地址：https://github.com/zoujingli/ThinkAdmin/tree/v3

### ThinkAdmin v2 基于 ThinkPHP 5.0 开发（不建议继续使用）

* 在线体验地址：https://v2.thinkadmin.top (已停用)
* Gitee 代码地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v2
* Github 代码地址：https://github.com/zoujingli/ThinkAdmin/tree/v2

### ThinkAdmin v1 基于 ThinkPHP 5.0 开发（不建议继续使用）

* 在线体验地址：https://v1.thinkadmin.top (已停用)
* Gitee 代码地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v1
* Github 代码地址：https://github.com/zoujingli/ThinkAdmin/tree/v1
