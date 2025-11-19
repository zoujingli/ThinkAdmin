## 大道至简 · 原生框架

[![Latest Stable Version](https://poser.pugx.org/zoujingli/thinkadmin/v/stable)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Total Downloads](https://poser.pugx.org/zoujingli/thinkadmin/downloads)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Monthly Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/monthly)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Daily Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/daily)](https://packagist.org/packages/zoujingli/thinkadmin)
[![License](https://poser.pugx.org/zoujingli/thinkadmin/license)](https://packagist.org/packages/zoujingli/thinkadmin)

### 项目介绍

**ThinkAdmin** 是一个基于 **ThinkPHP** 框架构建的强大后台管理平台，遵循 **MIT** 协议开源，基于最新版本的 **ThinkPHP8**（兼容 **ThinkPHP6**）构建。历经 **10 年**的版本积累，从 2014 年维护更新至今，已发展成为成熟稳定的后台管理框架。它专门为简化和加速后台开发而设计，为开发者提供了坚实的基础架构和丰富的预构建组件，涵盖从用户权限管理到数据处理界面的完整功能。通过抽象化常见的复杂性和重复性编码任务，**ThinkAdmin** 让开发团队能够以更少的精力和时间构建可扩展、安全且高效的管理面板，从而专注于实现核心业务逻辑。

**ThinkAdmin** 内置注解权限、异步多任务、应用插件生态等核心功能，支持通过 Composer 插件定制更新公共模块和应用插件，插件可本地化定制开发。

## ⚠️ 重要提示

> **免责声明**: 在使用 **ThinkAdmin** 之前，请务必阅读[《免责声明》](https://thinkadmin.top/disclaimer)并同意相关条款。

### 核心优势

* **🚀 快速开发** - 基于 ThinkPHP8（兼容 ThinkPHP6）框架，提供完整的后台管理功能，开箱即用
* **🔌 插件生态** - 支持 Composer 插件管理，可扩展性强，支持热插拔
* **⚡ 稳定可靠** - 历经 10 年版本积累，经过多个项目实践验证，系统稳定，性能优异
* **🛡️ 安全完善** - 内置 RBAC 权限管理、操作日志、数据加密等安全机制
* **📚 文档齐全** - 提供完整的开发文档和使用指南，学习成本低
* **🚀 现代化架构** - 支持多应用模式、异步任务、文件存储等现代特性

### 版本历程

**ThinkAdmin** 历经 **10 年**的版本积累，从 2014 年维护更新至今，已发展成为成熟稳定的后台管理框架。**ThinkAdmin v6** 是基于 **v1** 到 **v5** 大版本深厚积累的重构之作。在历经数次重大调整后，我们结合了 **ThinkPHP8**（兼容 **ThinkPHP6**）的设计思路，对系统进行了彻底的改造同时保留了原生 **ThinkPHP** 生态支持。在此过程中，我们精简了大量非必需的组件，同时自建了存储层、服务层以及高效的队列任务机制。此外，我们还新增了众多用户友好的指令，以提升操作体验。

经过严格的实践与测试，**v6.1** 版本展现出卓越的稳定性和可靠性。为确保系统能够满足各种复杂场景的需求，我们持续优化和调整。目前，系统模块和微信模块均已达到高稳定水平。为保证用户的使用体验和数据安全，我们将系统管理（app/admin）和微信管理（app/wechat）作为核心模块，并以 **MIT** 协议进行发布。

当前 **ThinkAdmin** 的最新版本为 **v6.1**，从这个版本开始正式进入插件时代，基础组件及扩展插件统一使用 **Composer** 管理。现在通过对 **Composer** 深度开发已实现了插件自动安装机制，可以大大减少项目初始化安装的成本。**ThinkAdmin** 与传统 **ThinkPHP** 多应用模式无差别，用户可以自行开发自己的模块，此次升级可完美兼容 **ThinkAdmin v6.0** 应用。我们强烈建议不要占用或修改 **`app/admin`** 和 **`app/wechat`** 两个目录里面的代码，这些未来可以通过 **Composer** 进行功能及安全升级。

### 应用场景

**ThinkAdmin** 提供完备的基础组件和 **API** 支持，助力快速开发各类 **WEB** 应用。框架免费提供基础功能，涵盖系统权限管理、存储配置、微信授权管理以及常用功能集成等，这使得 **ThinkAdmin** 成为外包开发团队的得力助手。目前，已有众多公司和个人采纳 **ThinkAdmin** 框架，据统计已有数万个项目在此框架上运行。

### 技术栈

**后端技术**

* **PHP 框架**: **ThinkPHP8**（兼容 **ThinkPHP6**）
* **核心组件**: ThinkLibrary - 封装了众多常用操作和多应用组件，完全兼容原有的 **ThinkPHP** 生态，显著降低了编码的复杂性和成本
* **UI 框架**: LayUI + RequireJs - 后台界面基于最新版本的 **LayUI** 前端框架和 **RequireJs** 组件加载方式，默认加载所有 **LayUI** 组件，开发者可直接使用

**扩展组件**

* **微信开发**: **WechatDeveloper** 组件全面支持微信公众号、微信小程序、微信企业号、微信商户支付以及支付宝支付接口等功能，同时还集成了 **QRcode** 二维码生成工具
* **文件存储**: 支持本地服务器存储、自建 **Alist** 存储，以及与七牛云、又拍云、阿里云和腾讯云等主流云服务商的对象存储服务无缝对接，并支持 CDN 加速
* **异步任务**: 自带异步任务处理机制，能够并行处理多个任务，任务响应延时低于 0.5 秒，兼容 **Windows** 和 **Linux** 平台

> **💡 开发提示**: 使用 **ThinkAdmin** 需要具备一定的开发技能，包括 **ThinkPHP**、**jQuery**、**LayUI** 和 **RequireJs**。使用 **RequireJs** 可以方便地加载和管理插件，互联网上有丰富的资源可供下载并进行二次扩展。目前后台大部分页面为单页程序，页面加载速度非常快速，也因此后台不再支持选项卡模式。

> **⚠️ 升级提示**: 为确保未来的功能和安全升级，强烈建议不要占用或修改 **app/admin** 和 **app/wechat** 两个目录及代码。所有未来的功能和安全更新将通过 **Composer** 进行管理和发布。请确保您的项目遵循这一规则，以便顺利享受未来的升级服务。

> **📝 温馨提示**: 如果需要直接查看源代码和数据库 **SQL** 文件，请切换到 `v6` 分支，从 `v6.1` 开始不再直接提供源代码和数据库 **SQL** 文件，其初始化及安装都由插件实现。使用 **Composer** 时建议安装新版本并使用官方源，目前国内大部分镜像经常出现`404` 导致组件下载失败或安装不完整等异常情况！

### 注意事项

* **ThinkAdmin** 是基于国内最流行的 **ThinkPHP8**（兼容 **ThinkPHP6**）框架开发，要求在不低于 **PHP 7.2.5** 的版本上运行，如果使用低版本的 **PHP** 可能会影响 **Composer** 依赖组件的安装，或将存在一定的安全隐患；
* 运行环境必需开启 **PATHINFO** 并将对应的 **rewrite** 规则配置到站点才能访问，系统已不再支持 **ThinkPHP** 的 **URL** 兼容模式运行 ( 源于如何优雅地展示 )，可以阅读 **ThinkAdmin** 的文档[安装部署](https://thinkadmin.top/install)章节；
* 代码仓库下载的文件不包含 **Composer** 组件的 **vendor** 目录，下载后需要执行 **composer install** 安装依赖组件，同时会触发执行 **php think migrate:run** 安装数据库 **Phinx** 脚本，如需切换数据库只需要先配置再执行指令即可完成初始化安装数据；
* 为保持系统可持续在线升级，建议不要在 **app/admin**、**app/wechat** 、**public/static** 这三个目录创建或修改文件，可以自行创建其他模块再编写自己的业务代码，自定义样式及脚本可以放置在 **public/static/extra** 目录里面。
* 系统是基于严格类型 **PHP** 新特性开发，务必使用专业的 **IDE** ( 如：**PhpStorm**、**NetBeans**、**VsCode**、**Eclipse for PHP** 等 ) 进行项目开发以达到更好的体验与更高的效率！

## 插件生态

了解更多插件信息请阅读 [《ThinkAdmin 插件生态》](plugin.md)

## 系统安装

通过 Composer 工具安装系统, 创建并进入 **ThinkAdmin** 根目录，运行指令安装依赖组件。

```shell
### 创建项目（ 需要在英文目录下面执行 ）
composer create-project zoujingli/thinkadmin

### 进入项目根目录
cd thinkadmin

### 数据库初始化并安装
php think migrate:run
```

> **A. 测试或体验环境**
>
> 系统默认使用`Sqlite`数据库，不需要配置任何参数，特别要注意使用`Sqlite`
> 数据库时是没有密码的，容易造成数据丢失或泄露。执行上面的安装操作初始化并安装系统依赖组件，
> 并自动安装数据库并初始化数据；执行`php think run`启动系统内置的`WEB`服务，用浏览器访问
> `http://127.0.0.1:8000`进入后台登录界面后，使用系统默认的账号`admin`和密码`admin`登录管理后台；也可以使用其他`Web`
> 服务软件方案实现。

> **B. 开发或线上环境**
>
> 执行上面的安装操作初始化并安装系统依赖组件，通过数据库管理工具创建空数据库，并将数据库参数配置到`config/database.php`；
> 然后执行`php think migrate:run`完成数据库初始化安装；线上环境还需要安装`Nginx`或`Apache`等`Web`服务 (
> 推荐使用[宝塔](https://www.bt.cn/?invite_code=MV90a3Z6dmI=)集成环境 )，并按照`ThinkPHP6`系统要求配置网站参数。

## 数据管理

> **A. 注意事项**
>
> 数据库是使用 `Phinx` 工具管理的，在未配置数据库时默认使用 `Sqlite`，数据库文件位于 `database/sqlite.db`，使用 `Sqlite`
> 数据库时仅限用于体验与测试，建议不要用于生产环境，生产环境建议使用开源免费的 `MySQL` 数据库；

> **B. 数据库初始化安装**
>
> 使用 `MySql`, `SqlServer`, `Postgres` 等服务型数据库时，需要先创建空的数据库并将参数配置到 `config/database.php`
> ，然后执行 `composer update` 或 `php think migrate:run`
> 安装并初始化数据库；开发部署系统时，如果要对数据库添加数据表或修改数据表，可以直接修改数据库或创建 `Phinx`
> 脚本后执行 `php think migrate:run` 进行数据库更新升级。另外系统提供 `php think xadmin:package` 指令可以把现有 `MySQl`
> 数据库打包为 `Phinx` 脚本，迁移系统时只需要执行前面的安装步骤即可。

## 注解权限

注解权限是指通过方法注释来实现后台 RBAC 授权管理，用注解来管理功能节点。

开发人员只需要写好注释，RBAC 的节点会自动生成，只需要配置角色及用户就可以使用RBAC权限。

* 此版本的权限使用注解实现
* 注释必须标准的块注释，如下案例
* 其中`@auth true`表示访问需要权限验证
* 其中`@menu true`菜单编辑显示可选节点
* 其中`@login true`需要强制登录才可访问

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

主仓库放置于`Gitee`, `Github`为镜像仓库。

部分代码来自互联网，若有异议可以联系作者进行删除。

* **在线体验地址**: https://v6.thinkadmin.top （账号和密码都是 `admin`）
* **Gitee仓库地址**: https://gitee.com/zoujingli/ThinkAdmin
* **GitHub仓库地址**: https://github.com/zoujingli/ThinkAdmin
* **官方文档地址**: https://thinkadmin.top/guide/

> **注意**: 体验环境部分数据不能保存，需自行安装再测试！

## 技术支持

开发前请认真阅读 ThinkPHP 官方文档，会对您有帮助哦！

本地开发请使用 `php think run` 运行服务，访问 `http://127.0.0.1:8000` 即可进入项目。

**官方地址及开发指南**: https://thinkadmin.top ，如果实在无法解决问题，可以加入官方群免费交流。

**问题反馈**

推荐在 **Gitee** 的 **Issue** 提交反馈问题，回复响应速度最快。

* **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/issues
* **GitHub**: https://github.com/zoujingli/ThinkAdmin/issues

**技术支持**

强烈推荐加入微信群，目前 QQ 群不常用，由热心群友维护。

> 由于近期加群发广告的人较多，已严重影响社区技术交流，因此在添加好友时会询问一些问题，我们会根据情况决定是否邀请入群，若有处置不周望请予以谅解！添加好友后建议不要删除此微信账号。在使用我们的框架开发遇到问题可以直接咨询该微信，若有需要还可以提供有偿技术支持和定制服务。

* **QQ 免费交流群 ①**: 513350915
* **QQ 免费交流群 ②**: 866345568
* **微信免费交流群**: 加群需要验证基本信息，需要适当写明加群原因

<img src="https://thinkadmin.top/static/img/wx.png"  width="250">

## 框架指令

* 执行 `php think run` 启用本地开发环境，访问 `http://127.0.0.1:8000`
* 执行 `php think xadmin:package` 将现有 `MySQL` 数据库打包为 `Phinx` 数据库脚本
* 执行 `php think xadmin:sysmenu` 重写系统菜单并生成新编号，同时会清理已禁用的菜单数据
* 执行 `php think xadmin:fansall` 同步微信粉丝数据，依赖于 `ThinkPlugsWechat` 应用插件
* 执行 `php think xadmin:replace` 可以批量替换数据库指定字符字段内容，通常用于文件地址替换
* 执行 `php think xadmin:database` 对数据库的所有表 `repair|optimize` 操作，优化并整理数据库碎片
* 执行 `php think xadmin:publish` 可自动安装现在模块或已安装应用插件，参数 `--migrate` 执行数据库脚本

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

* 增加 `CORS` 跨域规则配置，配置参数置放于 `config/app.php`，需要更新 `ThinkLibrary`。
* 修复 `layui.table` 导致基于 `ThinkPHP` 模板输出自动转义 `XSS` 过滤机制失效，需要更新 `ThinkLibrary`。
* 修复在模板中使用 `{:input(NAME)}` 取值而产生的 `XSS` 问题，模板取值更换为 `{$get.NAME|default=''}`。
* 修复 `CKEDITOR` 配置文件，禁用所有标签的 `on` 事件，阻止 `xss` 脚本注入，需要更新 `ckeditor/config.js`。
* 修复文件上传入口的后缀验证，读取真实文件后缀与配置对比，阻止不合法的文件上传并存储到本地服务器。
* 修改 `JsonRpc` 接口异常处理机制，当服务端绑定 `Exception` 时，客户端将能收到 `error` 消息及异常数据。
* 修改 `location.hash` 访问机制，禁止直接访问外部 `URL` 资源链接，防止外部 `XSS` 攻击读取本地缓存数据。
* 增加后台主题样式配置，支持全局默认+用户个性配置，需要更新 `admin`, `static`, `ThinkLibrary` 组件及模块。
* 后台行政区域数据更新，由原来的腾讯地图数据切换为百度地图最新数据，需要更新`static`，数据库版需另行更新。
* 增加`Phinx`数据库迁移脚本支持，可根据自己的需求安装对应模块，其中 `admin` 为改选模块！
* 从分离 `SystemService` 分离出 `RuntimeService` 服务，精减服务启动入口，优化性能！
* 增加插件模式，支持独立封装应用，可以通过 `composer` 管理并自动安装应用模块！

## 版权信息

[**ThinkAdmin**](https://thinkadmin.top) 遵循 [**MIT**](license) 开源协议发布，并免费提供使用。

本项目包含的第三方源码和二进制文件的版权信息另行标注。

版权所有 Copyright © 2014-2025 by ThinkAdmin (https://thinkadmin.top) All rights reserved。

更多细节参阅 [`LISENSE`](license) 文件

## 系统版本

以下系统的体验账号及密码都是 admin

### ThinkAdmin v6 基于 ThinkPHP8（兼容 ThinkPHP6）开发（后台权限基于注解实现）

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
