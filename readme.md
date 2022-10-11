大道至简 · 原生框架
---
> 主仓库地址：https://gitee.com/zoujingli/ThinkAdmin

非常感谢大家一直以来对`ThinkAdmin`的支持，`ThinkAdmin`从`v1`到`v6`经历了几次大的调整，但总体都是基于`ThinkPHP`最新版本为核心在开发，以微信领域及最简后台为目标而设计。

由于现有功能并不能满足所有项目的需求，`ThinkAdmin`只做基础底层的开发，这里包括系统权限管理，系统存储配置，微信授权管理，以及常用功能集成等…… 因此`ThinkAdmin`也被大家定性为外包二开基线项目，目前已经有许多公司及个人在使用。

ThinkAdmin v6 基于`v1-v5`版本的积累，结合`ThinkPHP 6.0`的思维重新构建，减少大量原非必需的组件，自建存储层、服务层及任务机制，增加了许多友好指令！`ThinkAdmin v6`经历了数个项目实践与测试，不停调整，目前系统模块及微信模块已经趋于稳定，现将【系统管理(admin)】及【微信管理(wechat)】定为`v6`内核两大模块并使用`MIT`协议发布，其中【微商商城(data)】仅为参考案例不做技术支持可直接删除，后续可能还有其他模块及相关辅助模块更新发布，敬请期待……

我们致力于二次开发底层框架，提供完整的组件及`API`，基于此框架可以快速开发应用。`ThinkAdmin v6`依赖自制组件`ThinkLibrary v6`，封装了大量常用操作，简化编码成本；默认集成`WechatDeveloper`组件，支持微信公众号、微信小程序、微信企业号、微信商户支付、支付宝支付接口等。`ThinkLibrary`组件实现`ThinkPHP v6`多应用模式及路由支持，另外还支持本地服务文件存储、七牛云对象存储（支持CDN加速）、又拍云USS存储（支持CDN加速）、阿里云OSS存储（支持CDN加速）、腾讯云COS存储（支持CDN加速）。

另外项目安装及二次开发可以先阅读`ThinkPHP`官方文档，数据库 SQL 文件位于项目根目录下，若实在无法解决当下问题可以加入官方微信群获得帮助。

#### 注意事项

* 项目测试需要自行搭建环境导入数据库 SQL 文件并修改配置( config/database.php )；
* 若操作提示“演示系统禁止操作”等字样，需要删除演示路由配置( app/admin/route/demo.php )或清空路由文件；
* 当前版本使用 ThinkPHP 6.0.x，对 PHP 版本标注不低于 PHP 7.1，具体请阅读 ThinkPHP 官方文档；
* 环境需开启 PATHINFO，不再支持 ThinkPHP 的 URL 兼容模式运行（源于如何优雅地展示）；
* 项目默认不带`composer`模块`vendor`目录，下载后需要自行`composer install`安装；

## 技术支持

开发前请认真阅读 ThinkPHP 官方文档会对您有帮助哦！

本地开发请使用`php think run`运行服务，访问`http://127.0.0.1:8000`即可进入项目。

官方地址及开发指南：https://thinkadmin.top ，如果实在无法解决问题可以加入官方群免费交流。

**1.官方QQ交流群：** 513350915

**2.官方QQ交流群：** 866345568

**3.官方微信交流群**

<img src="https://thinkadmin.top/static/img/wx.png"  width="250">

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

ThinkAdmin 为 MIT 协议开源项目，安装使用或二次开发不受约束，欢迎 fork 项目。

部分代码来自互联网，若有异议可以联系作者进行删除。

* 在线体验地址：https://v6.thinkadmin.top （账号和密码都是 admin ）
* Gitee仓库地址：https://gitee.com/zoujingli/ThinkAdmin/tree/v6
* GitHub仓库地址：https://github.com/zoujingli/ThinkAdmin/tree/v6

## 框架指令

* 执行 `build.cmd` 可更新 `composer` 插件，会删除并替换 `vendor` 目录
* 执行 `php think run` 启用本地开发环境，访问 `http://127.0.0.1:8000`
* 执行 `php think xadmin:fansall` 同步微信粉丝数据（依赖于 `wechat` 模块）
* 执行 `php think xadmin:sysmenu` 重写系统菜单并生成新编号并清理已禁用的菜单
* 执行 `php think xadmin:version` 查看当前版本号，显示 `ThinkPHP` 版本及 `ThinkLibrary` 版本

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

## 项目版本

体验账号及密码都是 admin

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