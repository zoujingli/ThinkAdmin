# 🚀 ThinkAdmin v6.1 - 现代化后台管理系统

[![star](https://gitcode.com/ThinkAdmin/ThinkAdmin/star/badge.svg)](https://gitcode.com/ThinkAdmin/ThinkAdmin)
[![star](https://gitee.com/zoujingli/ThinkAdmin/badge/star.svg?theme=gvp)](https://gitee.com/zoujingli/ThinkAdmin)

[![Latest Stable Version](https://poser.pugx.org/zoujingli/thinkadmin/v/stable)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Total Downloads](https://poser.pugx.org/zoujingli/thinkadmin/downloads)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Monthly Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/monthly)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Daily Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/daily)](https://packagist.org/packages/zoujingli/thinkadmin)
[![License](https://poser.pugx.org/zoujingli/thinkadmin/license)](https://packagist.org/packages/zoujingli/thinkadmin)

## 📖 项目介绍

**ThinkAdmin v6.1** 是一款基于 **ThinkPHP 6 & 8** 的现代化后台管理系统，遵循 **MIT** 开源协议，专为快速开发而设计。系统采用全新的 **PaaS 插件架构**，提供类似 **PaaS** 的组件升级更新服务，支持本地化定制开发。

### 🌟 核心特性

-   **🚀 自由扩展的组件生态** - 基于最新 ThinkPHP 框架开发，遵循 Composer 标准管理依赖组件，可自由安装各种开源组件及插件生态程序
-   **💾 标准化文件存储引擎** - 支持本地存储、自建 Alist 存储、多种云存储，基于文件 HASH 实现文件秒传，节省服务器空间
-   **🔐 注解 RBAC 权限管理** - 通过控制器方法注释实现功能节点自动生成，配合后台权限管理实现最简注解权限控制
-   **🔧 可升级 PaaS 插件微架构** - 深度定制 Composer 插件，实现专属 PaaS 插件生态管理架构，可将应用模块封装成独立插件包
-   **⚡ 独立进程异步执行任务** - 兼容多平台动态创建 PHP 进程，并列启动多个独立任务进程处理大数据或长时性任务，实时显示执行进度
-   **🛠️ 常用操作及工具库封装** - 核心组件封装各种常用 CRUD 操作及工具库，快速实现数据增删改查，后台 UI 基于最新 Layui 构建

### 🎯 适用场景

-   **快速原型开发** - 5 分钟内搭建完整后台管理系统
-   **企业级应用** - 提供完整的权限管理和系统配置
-   **SaaS 平台开发** - 支持多租户和插件扩展
-   **学习研究** - 学习现代化后台管理系统开发
-   **商业项目** - 快速交付高质量的后台管理功能

### 🔧 技术栈

-   **后端框架**: ThinkPHP 6 & 8
-   **前端框架**: LayUI + RequireJS
-   **数据库**: 支持 MySQL、PostgreSQL、SQLite
-   **缓存**: 支持 Redis、文件缓存
-   **存储**: 本地存储、云存储（七牛云、阿里云、腾讯云等）
-   **队列**: 自建异步任务处理机制

### 📊 项目统计

-   **在线运行项目**: 50,000+
-   **GitHub Stars**: 持续增长中
-   **社区活跃度**: 高活跃度开发社区
-   **更新频率**: 定期更新和功能增强

#### 注意事项

-   **ThinkAdmin** 是基于国内最流行的 **ThinkPHP6** 框架开发，要求在不低于 **PHP 7.2.5** 的版本上运行，如果使用低版本的 **PHP** 可能会影响 **Composer** 依赖组件的安装，或将存在一定的安全隐患；
-   运行环境必需开启 **PATHINFO** 并将对应的 **rewrite** 规则配置到站点才能访问，系统已不再支持 **ThinkPHP** 的 **URL** 兼容模式运行 ( 源于如何优雅地展示 )，可以阅读 **ThinkAdmin** 的文档[安装部署](https://thinkadmin.top/guide/install.html)章节；
-   代码仓库下载的文件不包含 **Composer** 组件的 **vendor** 目录，下载后需要执行 **composer install** 安装依赖组件，同时会触发执行 **php think migrate:run** 安装数据库 **Phinx** 脚本，如需切换数据库只需要先配置再执行指令即可完成初始化安装数据；
-   为保持系统可持续在线升级，建议不要在 **app/admin**、**app/wechat** 、**public/static** 这三个目录创建或修改文件，可以自行创建其他模块再编写自己的业务代码，自定义样式及脚本可以放置在 **public/static/extra** 目录里面。
-   系统是基于严格类型 **PHP** 新特性开发，务必使用专业的 **IDE** ( 如：**PhpStorm**、**NetBeans**、**VsCode**、**Eclipse for PHP** 等 ) 进行项目开发以达到更好的体验与更高的效率！

## 🚀 快速开始

### ⚙️ 环境要求

-   **PHP 版本**: 7.1 或更高版本（推荐 PHP 8.0+）
-   **Composer**: 必须安装 Composer 包管理工具
-   **数据库**: 支持 Sqlite、MySQL 和 SQL Server
-   **Web 服务器**: Apache、Nginx 或 PHP 内置服务器

### 📦 一键安装

#### 方式一：Composer 安装（推荐）

```bash
# 创建项目（需要在英文目录下执行）
composer create-project zoujingli/thinkadmin my-project

# 进入项目目录
cd my-project

# 数据库初始化（默认使用 Sqlite）
php think migrate:run

# 安装微信管理模块（可选）
composer require zoujingli/think-plugs-wechat

# 启动内置服务器
php think run --host 127.0.0.1 --port 8000
```

#### 方式二：源码安装

```bash
# 下载项目（需要在英文目录下执行）
git clone https://gitee.com/zoujingli/ThinkAdmin
cd ThinkAdmin

# 安装项目依赖组件
composer install --optimize-autoloader

# 数据库初始化（默认使用 Sqlite）
php think migrate:run

# 启动内置服务器
php think run --host 127.0.0.1 --port 8000
```

### 🌐 访问系统

打开浏览器访问：`http://127.0.0.1:8000`

-   **后台管理**: `http://127.0.0.1:8000/admin`
-   **默认账号**: `admin`
-   **默认密码**: `admin`

### 🔧 基础配置

1. **系统参数配置**

    - 登录后台 → 系统管理 → 系统参数配置
    - 设置网站名称、文件上传参数等

2. **用户管理**

    - 修改默认管理员密码
    - 创建新的管理员账号

3. **菜单管理**
    - 查看系统菜单结构
    - 添加自定义菜单

## 🗄️ 数据库配置

### 支持的数据库

-   **SQLite**（默认）- 无需额外配置，开箱即用
-   **MySQL** - 推荐用于生产环境
-   **PostgreSQL** - 支持企业级应用
-   **SQL Server** - 支持 Windows 环境

### 数据库配置

#### 使用 SQLite（默认，推荐开发环境）

无需额外配置，系统默认使用 SQLite 数据库，开箱即用。

#### 使用 MySQL（推荐生产环境）

1. **创建数据库**

```sql
CREATE DATABASE thinkadmin DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. **修改配置文件** `config/database.php`

```php
return [
    // 数据库类型 - 修改为 mysql
    'default' => 'mysql',
    // 数据库连接参数
    'connections' => [
        'mysql' => [
            'type' => 'mysql',
            'hostname' => '127.0.0.1',
            'database' => 'thinkadmin',
            'username' => 'root',
            'password' => 'your_password',
            'hostport' => '3306',
            'charset' => 'utf8mb4',
        ],
        'sqlite' => [
            'type' => 'sqlite',
            'database' => 'database/sqlite.db',
        ],
    ]
];
```

3. **执行数据库迁移**

```bash
# 自动创建数据表和初始数据
php think migrate:run
```

#### 使用 PostgreSQL

1. **创建数据库**

```sql
CREATE DATABASE thinkadmin;
```

2. **修改配置文件** `config/database.php`

```php
return [
    // 数据库类型 - 修改为 pgsql
    'default' => 'pgsql',
    'connections' => [
        'pgsql' => [
            'type' => 'pgsql',
            'hostname' => '127.0.0.1',
            'database' => 'thinkadmin',
            'username' => 'postgres',
            'password' => 'your_password',
            'hostport' => '5432',
            'charset' => 'utf8',
        ],
    ]
];
```

### 💡 重要提示

-   **ThinkAdmin v6.1** 使用 Phinx 数据库迁移工具
-   无需手动导入 SQL 脚本
-   支持数据库版本管理和回滚
-   自动创建系统必需的数据表

### 🔄 数据库切换步骤

1. **修改默认数据库类型**

    - 将 `'default' => 'sqlite'` 改为 `'default' => 'mysql'`（或其他数据库类型）

2. **配置数据库连接参数**

    - 填写正确的数据库连接信息（主机、用户名、密码等）

3. **执行数据库迁移**

    - 运行 `php think migrate:run` 创建数据表

4. **验证配置**
    - 访问系统确认数据库连接正常

## 🎯 核心功能

### 🔐 权限管理系统

-   **注解权限控制** - 通过方法注释实现功能节点自动生成
-   **RBAC 权限模型** - 支持角色、用户、权限的灵活配置
-   **菜单权限管理** - 动态菜单生成和权限控制
-   **操作日志记录** - 完整的用户操作审计日志

### 📁 文件存储系统

-   **多存储支持** - 本地存储、云存储（七牛云、阿里云、腾讯云等）
-   **文件秒传** - 基于文件 HASH 实现重复文件秒传
-   **CDN 加速** - 支持云存储 CDN 加速
-   **安全上传** - 文件类型验证和安全存储

### 🔌 插件生态

-   **PaaS 架构** - 类似 PaaS 的组件升级更新服务
-   **Composer 管理** - 统一的依赖包管理
-   **热插拔** - 支持插件的动态安装和卸载
-   **版本控制** - 插件版本管理和升级

### ⚡ 异步任务系统

-   **多进程处理** - 支持并列多进程执行任务
-   **实时进度** - 任务执行进度实时显示
-   **跨平台支持** - 兼容 Windows 和 Linux
-   **任务队列** - 支持任务队列和优先级管理

### 🛠️ 开发工具

-   **CRUD 生成器** - 快速生成增删改查代码
-   **代码生成器** - 自动生成控制器、模型、视图
-   **API 文档** - 自动生成 API 文档
-   **调试工具** - 完善的调试和日志系统

## 📚 开发指南

### 快速创建模块

```php
<?php
namespace app\admin\controller;

use think\admin\Controller;

class UserController extends Controller
{
    /**
     * 用户列表
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '用户管理';
        // 使用 QueryHelper 进行数据查询和分页
        $this->_query('SystemUser')
            ->like('username,nickname,phone')
            ->equal('status')
            ->dateBetween('create_at')
            ->order('id desc')
            ->page();
    }

    /**
     * 添加用户
     * @auth true
     * @menu true
     */
    public function add()
    {
        $this->title = '添加用户';
        $this->_form('SystemUser', 'form');
    }
}
```

### 权限注解说明

```php
/**
 * 操作名称
 * @auth true    # 需要权限验证
 * @menu true    # 显示在菜单中
 * @login true   # 需要强制登录
 */
public function index()
{
    // 控制器代码
}
```

### 数据库操作

```php
// 使用 QueryHelper 进行数据查询
$this->_query('user')
    ->like('username,email')
    ->equal('status')
    ->dateBetween('create_time')
    ->order('id desc')
    ->page();

// 使用 FormHelper 处理表单
$this->_form('user', 'form');

// 使用 SaveHelper 更新状态
$this->_save('user', $this->_vali([
    'status.require' => '状态不能为空',
    'status.in:0,1' => '状态值无效'
]));
```

## 🚀 性能优化

### 缓存配置

```php
// config/cache.php
'default' => 'redis',
'stores' => [
    'redis' => [
        'type' => 'redis',
        'host' => '127.0.0.1',
        'port' => 6379,
        'password' => '',
        'select' => 0,
        'timeout' => 0,
        'expire' => 0,
        'persistent' => false,
        'prefix' => '',
    ],
],
```

### 数据库优化

```sql
-- 为常用查询字段添加索引
CREATE INDEX idx_user_status ON user(status);
CREATE INDEX idx_user_create_time ON user(create_time);
CREATE INDEX idx_user_status_time ON user(status, create_time);
```

## 🛠️ 系统指令

### 基础指令

```bash
# 启动开发服务器
php think run --host 127.0.0.1 --port 8000

# 数据库迁移
php think migrate:run

# 重写系统菜单
php think xadmin:sysmenu

# 同步微信粉丝数据
php think xadmin:fansall
```

### 任务管理指令

```bash
# 启动异步任务监听
php think xadmin:queue listen

# 检查任务监听状态
php think xadmin:queue status

# 停止所有任务进程
php think xadmin:queue stop
```

## 📞 技术支持

### 官方资源

-   **官方网站**: https://thinkadmin.top
-   **在线演示**: https://v6.thinkadmin.top（账号密码：admin）
-   **开发文档**: https://thinkadmin.top/guide/
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin

### 社区交流

-   **QQ 群 1**: 513350915
-   **QQ 群 2**: 866345568
-   **微信群**: 扫描下方二维码

<img alt="微信群二维码" src="https://thinkadmin.top/static/img/wx.png" width="250">

### 学习资源

-   **ThinkPHP 官方文档**: https://www.kancloud.cn/manual/thinkphp6_0
-   **LayUI 官方文档**: https://www.layui.com/doc/
-   **Composer 文档**: https://getcomposer.org/doc/

## 🔌 插件生态

### 核心插件

-   **think-plugs-admin** - 后台管理核心插件
-   **think-plugs-wechat** - 微信管理插件
-   **think-plugs-static** - 静态资源管理插件
-   **think-plugs-account** - 账号管理插件
-   **think-plugs-payment** - 支付管理插件

### 安装插件

```bash
# 安装微信管理模块
composer require zoujingli/think-plugs-wechat

# 安装账号管理模块
composer require zoujingli/think-plugs-account

# 安装支付管理模块
composer require zoujingli/think-plugs-payment
```

### 插件开发

```php
// 插件服务注册
class Service extends \think\Service
{
    public function register()
    {
        // 注册服务
    }

    public function boot()
    {
        // 启动服务
    }
}
```

## 📦 代码仓库

### 主要仓库

-   **GitHub**: https://github.com/zoujingli/ThinkAdmin（主要开发仓库）
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin（国内镜像仓库）
-   **Gitcode**: https://gitcode.com/ThinkAdmin/ThinkAdmin

### 贡献代码

-   **提交 PR**: 请在 [ThinkAdminDeveloper](https://github.com/zoujingli/ThinkAdminDeveloper) 仓库提交
-   **问题反馈**: 使用 GitHub Issues 反馈问题
-   **代码规范**: 遵循 PSR-4 自动加载规范

### 在线体验

-   **演示地址**: https://v6.thinkadmin.top
-   **账号密码**: admin / admin
-   **功能演示**: 完整的后台管理功能演示

## 🛠️ 系统指令详解

### 基础管理指令

```bash
# 启动开发服务器
php think run --host 127.0.0.1 --port 8000

# 数据库迁移
php think migrate:run

# 重写系统菜单
php think xadmin:sysmenu

# 同步微信粉丝数据
php think xadmin:fansall

# 数据库打包为 Phinx 脚本
php think xadmin:package

# 批量替换数据库字段内容
php think xadmin:replace

# 数据库优化和修复
php think xadmin:database

# 安装模块或插件
php think xadmin:publish --migrate
```

### 任务管理指令

#### 任务进程管理

```bash
# 启动异步任务监听服务
php think xadmin:queue listen

# 检查创建任务监听服务（建议定时任务执行）
php think xadmin:queue start

# 查询当前任务相关的进程
php think xadmin:queue query

# 查看异步任务监听状态
php think xadmin:queue status

# 平滑停止所有任务进程
php think xadmin:queue stop
```

#### 本地调试管理

```bash
# 停止本地调试服务
php think xadmin:queue webstop

# 开启本地调试服务（建议定时任务执行）
php think xadmin:queue webstart

# 查看本地调试状态
php think xadmin:queue webstatus
```

### 定时任务配置

#### Linux Crontab

```bash
# 编辑定时任务
crontab -e

# 添加以下任务（每分钟检查一次）
* * * * * cd /path/to/thinkadmin && php think xadmin:queue start
* * * * * cd /path/to/thinkadmin && php think xadmin:queue webstart
```

#### Windows 任务计划程序

1. 打开任务计划程序
2. 创建基本任务
3. 设置触发器为每分钟
4. 操作设置为运行程序：`php think xadmin:queue start`

## 🔧 问题修复

### 安全修复

-   **CORS 跨域配置** - 增加跨域规则配置，配置参数位于 `config/app.php`
-   **XSS 防护** - 修复模板输出自动转义机制，防止 XSS 攻击
-   **文件上传安全** - 增强文件后缀验证，阻止非法文件上传
-   **CSRF 防护** - 自动为表单添加 CSRF 安全验证字段
-   **SQL 注入防护** - 使用参数化查询防止 SQL 注入

### 功能优化

-   **模板引擎优化** - 修复模板取值问题，使用 `{$get.NAME|default=''}` 替代 `{:input(NAME)}`
-   **编辑器安全** - 禁用 CKEditor 中所有标签的 `on` 事件，阻止脚本注入
-   **接口异常处理** - 优化 JsonRpc 接口异常处理机制
-   **主题配置** - 支持全局默认+用户个性配置
-   **地图数据更新** - 行政区域数据更新为百度地图最新数据

### 性能优化

-   **缓存机制** - 优化缓存策略，提升系统性能
-   **数据库优化** - 优化数据库查询和索引
-   **静态资源** - 优化静态资源加载和压缩
-   **异步任务** - 优化异步任务处理机制

## 📄 版权信息

### 开源协议

**ThinkAdmin** 遵循 [**MIT**](license) 开源协议发布，免费提供使用。

### 版权声明

-   **版权所有**: Copyright © 2014-2025 by ThinkAdmin
-   **官方网站**: https://thinkadmin.top
-   **开源协议**: MIT License
-   **第三方代码**: 项目中包含的第三方源码和二进制文件的版权信息另行标注

### 免责声明

在使用 **ThinkAdmin** 前请认真阅读[《免责声明》](https://thinkadmin.top/disclaimer)并同意该声明。

更多细节请参阅 [`LICENSE`](license) 文件。

## 📚 历史版本

> 以下系统的体验账号及密码都是 `admin`

### 🚀 ThinkAdmin v6.1（当前版本）

-   **技术栈**: ThinkPHP 6 & 8 + PaaS 插件架构
-   **特色功能**: 插件生态、注解权限、异步任务
-   **在线体验**: https://v6.thinkadmin.top ✅
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v6.1
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v6.1

### 📦 ThinkAdmin v6.0

-   **技术栈**: ThinkPHP 6.0 + 注解权限
-   **特色功能**: 注解权限、多应用支持
-   **在线体验**: https://v6.thinkadmin.top ✅
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v6
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v6

### 📱 ThinkAdmin v5

-   **技术栈**: ThinkPHP 5.1 + 注解权限
-   **特色功能**: 注解权限、LayUI 界面
-   **在线体验**: https://v5.thinkadmin.top ❌（已停用）
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v5
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v5

### 🔧 ThinkAdmin v4

-   **技术栈**: ThinkPHP 5.1
-   **状态**: 不建议继续使用
-   **在线体验**: https://v4.thinkadmin.top ❌（已停用）
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v4
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v4

### 📋 ThinkAdmin v3

-   **技术栈**: ThinkPHP 5.1
-   **状态**: 不建议继续使用
-   **在线体验**: https://v3.thinkadmin.top ❌（已停用）
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v3
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v3

### 📊 ThinkAdmin v2

-   **技术栈**: ThinkPHP 5.0
-   **状态**: 不建议继续使用
-   **在线体验**: https://v2.thinkadmin.top ❌（已停用）
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v2
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v2

### 🎯 ThinkAdmin v1

-   **技术栈**: ThinkPHP 5.0
-   **状态**: 不建议继续使用
-   **在线体验**: https://v1.thinkadmin.top ❌（已停用）
-   **GitHub**: https://github.com/zoujingli/ThinkAdmin/tree/v1
-   **Gitee**: https://gitee.com/zoujingli/ThinkAdmin/tree/v1

## 🎉 结语

**ThinkAdmin v6.1** 是一个功能强大、易于使用的现代化后台管理系统。无论您是初学者还是经验丰富的开发者，都能快速上手并构建出高质量的后台管理应用。

### 开始您的开发之旅

1. **快速体验** - 访问在线演示了解系统功能
2. **本地安装** - 按照安装指南搭建本地环境
3. **学习开发** - 阅读开发文档和最佳实践
4. **参与社区** - 加入官方群组交流学习
5. **贡献代码** - 为项目贡献您的代码和想法

---

**感谢您选择 ThinkAdmin！** 🎊
