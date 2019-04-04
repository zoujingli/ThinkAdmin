大道至简 · 原生框架
--
ThinkAdmin V4.0 是一个基于 ThinkPHP5.1 开发的后台管理系统。

我们致力于二次开发底层框架，提供完整的组件及API，基于此框架可以快速开发应用。

另外项目安装及二次开发可以参考 ThinkPHP 官方文档，数据库文件摆放在项目根目录下。

#### 注意事项
* 项目测试需要自行搭建环境导入数据库( admin_v4.sql )并修改配置( config/database.php )；
* 若操作提示“测试系统禁止操作”等字样，需要删除演示路由配置( route/demo.php )或清空路由文件；
* 当前版本使用 ThinkPHP5.1.x，对 PHP 版本标注不低于 PHP5.6，具体请阅读 ThinkPHP 官方文档；
* 环境需开启 PATHINFO，不再支持 ThinkPHP 的 URL 兼容模式运行（源于如何优雅的展示）；

技术支持
--
开发前请认真阅读 ThinkPHP 官方文档会对您有帮助哦！

本地开发命令`php think run`，使用`http://127.0.0.1:8000`访问项目。

PHP 开发技术交流（ QQ 群 513350915）

[![PHP微信开发群 (SDK)](http://pub.idqqimg.com/wpa/images/group.png)](http://shang.qq.com/wpa/qunwpa?idkey=ae25cf789dafbef62e50a980ffc31242f150bc61a61164458216dd98c411832a) 


代码仓库
--
 framework 为 MIT 协议开源项目，安装使用或二次开发不受约束，欢迎 fork 项目。
 
 部分代码来自互联网，若有异议可以联系作者进行删除。
 
 * 在线体验地址：https://demo.thinkadmin.top （账号和密码都是 admin ）
 * Gitee仓库地址：https://gitee.com/zoujingli/ThinkAdmin
 * GitHub仓库地址：https://github.com/zoujingli/ThinkAdmin
 
框架指令
--
* 执行 `build.cmd` 可更新 `Composer` 插件，会删除并替换 `vendor` 目录
* 执行 `php think run` 启用本地开发环境，访问 `http://127.0.0.1:8000`

* 线上代码更新
>* 执行 `php think xsync:admin` 从线上服务更新 `admin` 模块的所有文件（注意文件安全）
>* 执行 `php think xsync:wechat` 从线上服务更新 `wechat` 模块的所有文件（注意文件安全）
>* 执行 `php think xsync:service` 从线上服务更新 `service` 模块的所有文件（注意文件安全）
>* 执行 `php think xsync:plugs` 从线上服务更新 `plugs` 静态插件的部分文件（注意文件安全）
>* 执行 `php think xsync:config` 从线上服务更新 `config` 项目配置的部分文件（注意文件安全）

* 微信资料管理
>* 执行 `php think xfans:all` 更新已经对接的公众号全部列表
>* 执行 `php think xfans:list` 更新已经对接的公众号粉丝列表
>* 执行 `php think xfans:tags` 更新已经对接的公众号标签列表
>* 执行 `php think xfans:black` 更新已经对接的公众号黑名单列表

* 守护进程管理
>* 执行 `php think xtask:reset` 重启消息任务守护进程
>* 执行 `php think xtask:start` 启动消息任务守护进程
>* 执行 `php think xtask:state` 查询消息任务守护进程
>* 执行 `php think xtask:stop` 暂停消息任务守护进程

* 其它自定工具
>* 执行 `php think xclean:session` 清理无效的会话SESSION文件
>* 执行 `php think xclean:store` 清理无效的订单信息及定时任务
 
特别感谢
--
|名称|版本|描述|链接|
|---|---|---|---|
|Layui|2.4.5|UI组件库|https://github.com/sentsin/layui|
|Ckeditor|4.10.1|富文件编辑器|https://github.com/ckeditor/ckeditor-dev|
|PluPloader|3.1.2|文件上传工具1|https://www.plupload.com|
|WebUploader|0.1.5|文件上传工具2|https://github.com/fex-team/webuploader|
|Font-Awesome|4.7.0|字体图标库|https://github.com/FortAwesome/Font-Awesome|
|ThinkPHP|5.1.35|PHP基础框架|https://github.com/top-think/framework|
|ThinkLibrary|5.1.x-dev|ThinkPHP扩展组件|https://github.com/zoujingli/ThinkLibrary|
|WeChatDeveloper|1.2.9|微信公众号组件|https://github.com/zoujingli/WeChatDeveloper|
|WeOpenDeveloper|dev-master|微信开放平台组件|https://github.com/zoujingli/WeOpenDeveloper|

赞助打赏
--
![赞助](http://zoujingli.oschina.io/static/pay.png)

