大道至简 · 原生框架
---
> 代码主仓库：
> https://gitee.com/zoujingli/ThinkAdmin

### 项目介绍

当前`ThinkAdmin`的最新版本为`v6.1`，从这个版本开始正式进入插件时代，基础组件及扩展插件统一使用`Composer`管理，因此在项目的初始目录下面是没有代码的，需要执行`composer install`或`composer update`安装后才会创建目录并初始化代码。`ThinkAdmin`与传统`ThinkPHP`多应用模式无差别，用户可以自行开发自己的模块，此次升级可完美兼容`ThinkAdmin v6.0`应用。我们强烈建议不要占用或修改`admin`和`wechat`两个目录里面的代码，这些未来可以通过`Composer`进行功能及安全升级。

**温馨提示：** 如果需要直接查看代码，请切换到`v6`分支查看，`v6.1`暂不直接提供源代码和数据库`SQL`文件，初始化及安装都由插件实现。

[`ThinkAdmin`](https://thinkadmin.top)从`v1`到`v6`经历了几次大的调整，但总体都是基于`ThinkPHP`最新版本并以最简后台为目标而设计，目前`ThinkAdmin`已通过`Composer`深度开发实现了插件自动安装机制，大大减少了项目初始化安装的成本。

**特别提醒：** 使用`Composer`时建议安装最版本版本并使用官方源，目前国内大部分镜像经常出现`404`导致组件下载失败或安装不完整等异常情况！

任何一个系统都不能完全满足所有的业务场景，[`ThinkAdmin`](https://thinkadmin.top)
只做最基础底层的功能，这里包括系统权限管理，系统存储配置，微信授权管理，以及其他常用功能集成等……
因此[`ThinkAdmin`](https://thinkadmin.top)也被大家定性为外包二开基线系统，目前已经有许多公司及个人在使用（通过数据聚合统计已有3万多在线运行的项目）。

ThinkAdmin v6 是基于`v1-v5`大版本的积累，结合`ThinkPHP6`
的思维重新构建，减少大量原非必需的组件，自建存储层、服务层及队列任务机制，另外还增加了许多友好指令！`ThinkAdmin v6`
经历了数个系统实践与测试，不停的调整与优化，目前系统模块及微信模块已经趋于稳定，现将系统管理[admin]及微信管理[wechat]
定为`v6`内核两大模块并以`MIT`协议发布，后续可能还有其他模块及相关辅助模块更新发布，敬请期待……

我们致力于二开底层框架，提供完善的基础组件及对应的`API`支持，基于此框架可以快速开发各种`WEB`应用。`ThinkAdmin v6`
依赖核心组件`ThinkLibrary v6`，其内封装了大量常用操作方法，简化编码成本；可自行选择集成`WechatDeveloper`
组件 ( 支持微信公众号、微信小程序、微信企业号、微信商户支付、支付宝支付接口等 ) 及`QRcode`二维码生成工具。`ThinkLibrary`
组件实现`ThinkPHP v6`多应用模式及路由支持，另外还支持本地服务文件存储、七牛云对象存储（支持CDN加速）、又拍云USS存储（支持CDN加速）、阿里云OSS存储（支持CDN加速）、腾讯云COS存储（支持CDN加速）。

在使用`ThinkAdmin`开发应用时，建议先阅读`ThinkPHP`官方文档和`ThinkAdmin`开发文档，若实在无法解决当下问题可以加入官方微信群获得帮助。

### 注意事项

* [`ThinkAdmin`](https://thinkadmin.top)是基于国内最流行的`ThinkPHP6`框架开发，目前对`PHP`版本要求不得低于`PHP 7.2.5`
  ，如果使用低版本的`PHP`可能会影响`composer`依赖组件的安装，或将存在一定的安全隐患，具体请阅读`ThinkPHP`更新日志及相关文档；
* 系统的运行环境必需开启`PATHINFO`支持并配置对应的`rewrite`规则才能访问，不再支持`ThinkPHP`的`URL`兼容模式运行 (
  源于如何优雅地展示 )，可以阅读文档部署章节；
* 代码仓库下载的文件不包含`composer`组件包的`vendor`目录，下载后需要执行`composer install`或`composer update`
  安装依赖组件，同时会触发执行数据库`Phinx`安装脚本；
* 为保持系统可持续在线升级功能，开发时建议不要在`admin`,`wechat`,`public/static`
  这三个目录创建或修改文件，可以自行创建其他模块再编写自己的业务代码，自定义样式及脚本可以放置在目录`public/static/extra`
  里面。系统是基于严格类型`PHP`新特性开发，务必使用专业的`IDE` ( 如：`PhpStorm`,`NetBeans`,`VsCode`,`Eclipse for PHP`等 )
  进行项目开发以达到更好的体验与更高的效率！
* 若后台操作提示 “演示系统禁止操作” 等字样，需要删除演示路由的配置文件(`app/admin/route/demo.php`)；

## 插件生态

更多插件正在开发，敬请期待……

**目前已有的插件如下：**

> 后台基础 Admin 管理插件
> * 插件标识：`admin`
> * 插件包名：`zoujingli/think-plugs-admin`
> * 安装方式：`composer require zoujingli/think-plugs-admin`
> * 插件仓库：https://gitee.com/zoujingli/think-plugs-admin
> * 开源协议：MIT ( 免费开放 )

> 后台基础 WeChat 微信插件
> * 插件标识：`wechat`
> * 插件包名：`zoujingli/think-plugs-wechat`
> * 安装方式：`composer require zoujingli/think-plugs-wechat`
> * 插件仓库：https://gitee.com/zoujingli/think-plugs-wechat
> * 开源协议：MIT ( 免费开放 )

> 后台静态资源初始化插件（通常不需要独立安装）
> * 插件标识：`static`
> * 插件包名：`zoujingli/think-plugs-static`
> * 安装方式：`composer require zoujingli/think-plugs-static`
> * 插件仓库：https://gitee.com/zoujingli/think-plugs-static
> * 开源协议：MIT ( 免费开放，里面有部分其他开源协议，具体可以查看源文件 )

> 基础在线插件市场 ( 开发中，未来会成为 ThinkAdmin 生态市场 )
> * 插件标识：`plugin-center`
> * 插件包名：`zoujingli/think-plugs-center`
> * 安装方式：`composer require zoujingli/think-plugs-center`
> * 插件仓库：https://gitee.com/zoujingli/think-plugs-center
> * 开源协议：目前不开源，待定

> 基础商品管理插件（目前处于重构中，可以安装体验用）
> * 插件标识：`plugin-base-goods`
> * 插件包名：`zoujingli/think-plugin-base-goods`
> * 安装方式：`composer require zoujingli/think-plugin-base-goods dev-master`
> * 插件仓库：https://gitee.com/zoujingli/think-plugin-base-goods
> * 开源协议：MIT ( 免费开放 )

## 数据管理

> **A. 注意事项**
>
> 数据库是使用`Phinx`工具管理的，在未配置数据库时默认使用`Sqlite`，数据库文件位于`database/sqlite.db`，使用`Sqlite`
> 数据库时仅限用于体验与测试，建议不要用于生产环境，生产环境建议使用免费开源的`MySQL`数据库；

> **B. 数据库初始化安装**
>
> 使用`MySql`,`SqlServer`,`Postgres`等服务型数据库时，需要先创建空的数据库并将参数配置到`config/database.php`
> ，然后执行`composer install`或`composer update`或`php think migrate:run`
> 安装并初始化数据库；开发部署系统时，如果要对数据库添加数据表或修改数据表，可以直接修改数据库或创建`Phinx`
> 脚本后执行`composer update`进行数据库更新升级。另外系统也提供`php think xadmin:package`指令可以把现有`MySQl`
> 数据库打包为`Phinx`脚本，迁移系统时只需要执行前面的安装步骤即可。

## 系统安装

> **安装方式一：**
> 1. 下载仓库源代码，关键需要包含`composer.json`文件；
> 2. 执行`composer install`或`composer update`安装组件并初始化数据库；

> **安装方式二：**
> 1. 执行`composer create-project zoujingli/thinkadmin`安装项目；
> 2. 执行`cd thinkadmin`进入到已安装的`ThinkAdmin`根目录；
> 3. 执行`php think migrate:run`安装并初始化数据库；

> **A. 测试或体验环境**
>
> 系统默认使用`Sqlite`数据库，不需要配置任何参数，特别要注意使用`Sqlite`
> 数据库时是没有密码的，容易造成数据丢失或泄露。执行上面的安装操作初始化并安装系统依赖组件，
> 并自动安装数据库并初始化数据；执行`php think run`启动系统内置的`WEB`服务，用浏览器访问
> `http://127.0.0.1:8000`进入后台登录界面后，使用系统默认的账号`admin`和密码`admin`登录管理后台；也可以使用其他`Web`服务软件方案实现。

> **B. 开发或线上环境**
>
> 执行上面的安装操作初始化并安装系统依赖组件，通过数据库管理工具创建空数据库，并将数据库参数配置到`config/database.php`；
> 然后执行`php think migrate:run`完成数据库初始化安装；线上环境还需要安装`Nginx`或`Apache`等`Web`服务 (
> 推荐使用[宝塔](https://www.bt.cn/?invite_code=MV90a3Z6dmI=)集成环境 )，并按照`ThinkPHP6`系统要求配置网站参数。

## 技术支持

开发前请认真阅读 ThinkPHP 官方文档和 ThinkAdmin 开发文档，相信会对您有所帮助哦！

如果实在无法解决您所遇到的问题，可以加入官方群免费交流（需要提交认证信息）。

**1.官方QQ交流群：** 513350915

**2.官方QQ交流群：** 866345568

**3.官方微信交流群**

<img src="https://thinkadmin.top/static/img/wx.png" width="250">

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

* 在线体验地址：https://v6.thinkadmin.top （账号和密码都是 admin ）
* Gitee仓库地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v6
* GitHub仓库地址：https://github.com/zoujingli/ThinkAdmin/tree/v6

## 版权信息

[`ThinkAdmin`](https://thinkadmin.top)循[`MIT`](license)开源协议发布，并免费提供使用。

本项目包含的第三方源码和二进制文件的版权信息另行标注。

版权所有 Copyright © 2014-2023 by ThinkAdmin (https://thinkadmin.top) All rights reserved。

更多细节参阅[`lisense`](license)文件

## 框架指令

* 执行 `build.cmd` 可更新 `composer` 插件，会删除并替换 `vendor` 目录
* 执行 `php think run` 启用本地开发环境，访问 `http://127.0.0.1:8000`
* 执行 `php think xadmin:fansall` 同步微信粉丝数据（依赖于 `wechat` 模块）
* 执行 `php think xadmin:sysmenu` 重写系统菜单并生成新编号并清理已禁用的菜单
* 执行 `php think xadmin:package` 将现有`MySQL`数据库打包为`Phinx`数据库迁移脚本【新增】
* 执行 `php think xadmin:replace` 可以批量替换数据库指定字符字段内容，通常用于文档地址替换
* 执行 `php think xadmin:version` 查看当前版本号，显示 `ThinkPHP` 版本及 `ThinkLibrary` 版本
* 执行 `php think xadmin:database` 对数据库的所有表`repair|optimize`操作，优化并整理数据库碎片

#### 1. 线上代码更新

* 执行 `php think xadmin:install admin` 从线上服务更新 `admin` 模块的所有文件（注意文件安全）
* 执行 `php think xadmin:install wechat` 从线上服务更新 `wechat` 模块的所有文件（注意文件安全）
* 执行 `php think xadmin:install static` 从线上服务更新 `static` 静态资料文件（注意文件安全）
* 执行 `php think xadmin:install config` 从线上服务更新 `config` 常用配置文件（注意文件安全）

#### 2. 守护进程管理（可自建定时任务去守护监听主进程）

* 执行 `php think xadmin:queue listen` [监听]启动异步任务监听服务
* 执行 `php think xadmin:queue start`  [控制]检查创建任务监听服务（建议定时任务执行）
* 执行 `php think xadmin:queue query`  [控制]查询当前任务相关的进程
* 执行 `php think xadmin:queue status`  [控制]查看异步任务监听状态
* 执行 `php think xadmin:queue stop`   [控制]平滑停止所有任务进程

#### 3. 本地调试管理（可自建定时任务去守护监听主进程）

* 执行 `php think xadmin:queue webstop` [调试]停止本地调试服务
* 执行 `php think xadmin:queue webstart` [调试]开启本地调试服务（建议定时任务执行）
* 执行 `php think xadmin:queue webstatus` [调试]查看本地调试状态

## 问题修复

* 增加`CORS`跨域规则配置，配置参数置放于`config/app.php`，需要更新`ThinkLibrary`。
* 修复`layui.table`导致基于`ThinkPHP`模板输出自动转义`XSS`过滤机制失效，需要更新`ThinkLibrary`。
* 修复在模板中使用`{:input(NAME)}`取值而产生的`XSS`问题，模板取值更换为`{$get.NAME|default=''}`。
* 修复`CKEDITOR`配置文件，禁用所有标签的`on`事件，阻止`xss`脚本注入，需要更新`ckeditor/config.js`。
* 修复文件上传入口的后缀验证，读取真实文件后缀与配置对比，阻止不合法的文件上传并存储到本地服务器。
* 修改`JsonRpc`接口异常处理机制，当服务端绑定`Exception`时，客户端将能收到`error`消息及异常数据。
* 修改`location.hash`访问机制，禁止直接访问外部`URL`资源链接，防止外部`XSS`攻击读取本地缓存数据。
* 增加后台主题样式配置，支持全局默认+用户个性配置，需要更新`ThinkLibrary`,`static`,`admin`组件及模块。
* 后台行政区域数据更新，由原来的腾讯地图数据切换为百度地图最新数据，需要更新`static`，数据库版需另行更新。
* 增加`Phinx`数据库迁移脚本支持，可根据自己的需求安装对应模块，其中`admin`为改选模块！
* 从分离`SystemService`分离出`RuntimeService`服务，精减服务启动入口，优化性能！
* 增加插件模式，支持独立封装应用，可以通过`composer`管理并自动安装应用模块！

## 系统版本

体验账号及密码都是 admin

### ThinkAdmin v6 基于 ThinkPHP6 开发（后台权限基于注解实现）

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