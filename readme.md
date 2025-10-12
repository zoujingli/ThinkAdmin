# ThinkAdmin

[![Latest Stable Version](https://poser.pugx.org/zoujingli/thinkadmin/v/stable)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Total Downloads](https://poser.pugx.org/zoujingli/thinkadmin/downloads)](https://packagist.org/packages/zoujingli/thinkadmin)
[![Monthly Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/monthly)](https://poser.pugx.org/zoujingli/thinkadmin)
[![Daily Downloads](https://poser.pugx.org/zoujingli/thinkadmin/d/daily)](https://poser.pugx.org/zoujingli/thinkadmin)
[![License](https://poser.pugx.org/zoujingli/thinkadmin/license)](https://packagist.org/packages/zoujingli/thinkadmin)
[![PHP Version](https://img.shields.io/badge/php-%3E%3D7.1-blue.svg)](https://www.php.net/)
[![ThinkPHP](https://img.shields.io/badge/ThinkPHP-6%20%7C%208-brightgreen.svg)](https://www.thinkphp.cn/)

基于 **ThinkPHP 6 & 8** 的现代化后台管理系统，采用 **Composer 插件定制**，提供完整的后台管理解决方案。系统遵循 **MIT** 开源协议，专为快速开发而设计，深度定制 Composer 插件，实现专属插件生态管理架构，可将应用模块封装成独立插件包。

## 项目简介

**ThinkAdmin** 是一个功能强大的后台管理系统，基于最新的 **ThinkPHP 6 & 8** 框架开发，专为简化后台管理流程而设计。系统采用现代化的技术栈，提供丰富的功能模块和插件生态，帮助开发者快速构建企业级后台管理系统。

### 核心优势

- **🚀 快速开发** - 基于 ThinkPHP 6 & 8 框架，提供完整的后台管理功能，开箱即用
- **🔌 插件生态** - 支持 Composer 插件管理，可扩展性强，支持热插拔
- **⚡ 稳定可靠** - 经过多个项目实践验证，系统稳定，性能优异
- **🛡️ 安全完善** - 内置 RBAC 权限管理、操作日志、数据加密等安全机制
- **📚 文档齐全** - 提供完整的开发文档和使用指南，学习成本低
- **🚀 现代化架构** - 支持多应用模式、异步任务、文件存储等现代特性

### 适用场景

- **快速原型开发** - MVP 产品、概念验证、演示系统
- **企业管理系统** - CRM、ERP、OA、财务系统
- **SaaS 平台** - 多租户应用、订阅服务、API 管理
- **学习研究** - 技术学习、框架研究、最佳实践

## 在线演示

- **演示地址**: [https://v6.thinkadmin.top](https://v6.thinkadmin.top)
- **默认账号**: admin
- **默认密码**: admin

## 特性

- 🚀 **快速开发** - 基于 ThinkPHP 6 & 8，开箱即用
- 🔌 **插件生态** - 支持 Composer 插件管理，热插拔
- 💾 **文件存储** - 支持多种存储方案，文件秒传
- 🔐 **权限管理** - 基于注解的 RBAC 权限控制
- ⚡ **异步任务** - 多进程异步任务处理
- 🛠️ **开发工具** - 丰富的开发工具和内置函数
- 📱 **响应式** - 基于 LayUI 2.x，支持多设备
- 🌐 **多语言** - 支持多语言包管理
- 🔧 **易扩展** - 支持自定义插件开发

## 环境要求

### 基础要求

| 组件 | 最低要求 | 推荐版本 | 说明 |
|------|----------|----------|------|
| **PHP** | 7.1+ | 8.0+ | 支持最新 PHP 特性 |
| **Composer** | 2.0+ | 2.5+ | 包管理工具 |
| **数据库** | SQLite 3 | MySQL 8.0+ | 支持多种数据库 |
| **Web 服务器** | PHP 内置 | Nginx/Apache | 生产环境推荐 |
| **内存** | 128MB | 512MB+ | 推荐更大内存 |
| **磁盘空间** | 100MB | 1GB+ | 包含依赖和文件 |

### 必需的 PHP 扩展

- `gd` - 图像处理
- `mbstring` - 多字节字符串处理
- `openssl` - 加密功能
- `pdo` - 数据库抽象层
- `curl` - HTTP 客户端
- `fileinfo` - 文件类型检测
- `json` - JSON 处理
- `zip` - 压缩文件处理

### 环境检测

在安装前，请确保您的环境满足以下要求：

```bash
# 检查 PHP 版本
php -v

# 检查 Composer
composer -v

# 检查 PHP 扩展
php -m | grep -E "(gd|mbstring|openssl|pdo|curl|fileinfo|json|zip)"
```

## 快速开始

### 快速安装体验

```bash
# 创建项目（需要在英文目录下执行，默认只安装 admin 和 static 模块）
composer create-project zoujingli/thinkadmin

# 进入项目根目录
cd thinkadmin

# 数据库初始化并安装
# 默认使用 Sqlite 数据库，若使用其他数据库请修改配置后再执行
php think migrate:run

# 安装微信管理模块（可选模块）
composer require zoujingli/think-plugs-wechat

# 🚀 开启 PHP 内置 WEB 服务
# 默认后台登录账号及密码都是 admin
php think run --host 127.0.0.1
```

### 访问系统

安装完成后，打开浏览器访问系统：

| 访问地址 | 说明 | 默认账号 |
|---------|------|----------|
| `http://127.0.0.1:8000` | 系统首页 | - |
| `http://127.0.0.1:8000/admin` | 后台管理 | admin/admin |
| `http://127.0.0.1:8000/api` | API 接口 | - |

### 首次使用指南

1. **登录后台管理**
   - 访问 `http://127.0.0.1:8000/admin`
   - 使用默认账号 `admin` / `admin` 登录

2. **修改默认密码**
   - 进入"系统管理" → "用户管理"
   - 修改管理员密码

3. **配置系统参数**
   - 进入"系统管理" → "系统参数配置"
   - 设置网站名称、Logo 等基本信息

4. **创建业务模块**
   - 使用代码生成器创建 CRUD 功能
   - 开发自定义插件实现业务逻辑

### 安装 ThinkLibrary

ThinkAdmin 基于 ThinkLibrary 核心工具库，如需单独安装：

```bash
# 安装 ThinkLibrary
composer require zoujingli/think-library

# 确保控制器继承自 think\admin\Controller
class MyController extends \think\admin\Controller {
    protected $dbQuery = '数据表名';
    // 使用 ThinkLibrary 提供的功能
}
```

## 核心功能

### 🚀 自由扩展的组件生态

基于最新 ThinkPHP 框架开发，遵循 Composer 标准管理依赖组件，可自由安装各种开源组件及插件生态程序。系统将功能模块封装为独立的插件包，支持通过 Composer 进行安装和更新，让开发者可以根据项目需求选择性地安装所需的功能模块。

### 💾 标准化文件存储引擎

支持本地存储、自建 Alist 存储、多种云存储，基于文件 HASH 实现文件秒传，节省服务器空间。提供统一的文件存储引擎，支持多种存储方案，满足不同场景下的数据存储需求。

**支持的存储方案**:
- 本地服务器存储
- 自建 Alist 存储
- 七牛云空间存储
- 阿里云 OSS 存储
- 腾讯云 COS 存储
- 又拍云 USS 存储

### 🔐 注解 RBAC 权限管理

通过控制器方法注释实现功能节点自动生成，配合后台权限管理实现最简注解权限控制。系统实现了基于注解的简化 RBAC 权限模型，支持精确到按钮级别的权限控制。

**权限系统特点**:
- **注解驱动** - 通过控制器注释自动生成权限节点，简化权限配置
- **精确控制** - 权限控制精确到按钮级别，提供最大灵活性
- **自动维护** - 功能节点由系统自动维护，根据控制器代码注释进行刷新
- **动态菜单** - 根据用户权限动态显示功能菜单，支持三级菜单结构
- **操作日志** - 完整记录用户操作行为，支持安全审计

### 🔧 可升级 Composer 插件微架构

深度定制 Composer 插件，实现专属插件生态管理架构，可将应用模块封装成独立插件包。系统强制要求使用插件架构，所有业务功能都必须通过自定义插件实现。

### ⚡ 独立进程异步执行任务

兼容多平台动态创建 PHP 进程，并列启动多个独立任务进程处理大数据或长时性任务，实时显示执行进度。支持多进程异步任务处理，显著提高任务处理效率。

**任务系统特性**:
- **多进程架构** - 支持多进程并发执行任务，提高处理效率
- **跨平台支持** - 兼容 Windows 和 Linux 系统
- **自动监控** - 每 0.5 秒扫描任务数据表，自动执行待处理任务
- **进程管理** - 支持 START、STOP、QUERY、LISTEN 等进程管理指令
- **进度跟踪** - 支持任务完成状态跟进和进度显示
- **异常恢复** - 支持自动重启和异常处理
- **守护进程** - 支持后台守护进程模式运行

### 🛠️ 常用操作及工具库封装

核心组件封装各种常用 CRUD 操作及工具库，快速实现数据增删改查，后台 UI 基于最新 Layui 构建。基于 ThinkLibrary 核心工具库，提供完整的 CRUD 操作和一系列常用工具。

**核心功能模块**:
1. **数据列表展示组件** - 展示数据列表，支持分页、排序和高级搜索
2. **表单处理模块** - 用于创建、展示和提交表单数据，完善的表单验证和错误处理机制
3. **数据状态快速处理模块** - 根据业务需求快速更新数据状态，支持多字段同时更新
4. **数据安全删除模块** - 安全删除数据，支持软删除和硬删除
5. **文件存储通用组件** - 支持多种文件存储方式，统一接口和配置
6. **通用数据保存更新模块** - 基于 key 和条件判断数据存在性，进行更新或新增
7. **通用网络请求模块** - 支持 GET、POST 和 PUT 请求，统一接口
8. **系统参数配置模块** - 快速配置并保存系统参数
9. **UTF-8 加密算法支持** - 提供 UTF-8 字符串加密和解密功能
10. **接口 CORS 跨域支持** - 默认支持跨域请求，输出标准化 JSON 数据
11. **表单 CSRF 安全验证** - 自动为表单添加 CSRF 安全验证字段

## 核心功能详解

### 插件生态架构

基于 Composer 标准管理依赖组件，支持插件热插拔和在线升级。

```php
<?php
namespace app\plugin\example;

use think\admin\Plugin;

class ExamplePlugin extends Plugin
{
    public function install()
    {
        // 安装插件时的操作
        $this->createTables();
        $this->createMenus();
    }
    
    public function uninstall()
    {
        // 卸载插件时的操作
        $this->dropTables();
        $this->removeMenus();
    }
}
```

### 注解权限管理

通过控制器方法注释实现功能节点自动生成，简化权限配置。

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
        $this->_query('SystemUser')
            ->like('username,nickname,phone')
            ->equal('status')
            ->dateBetween('create_at')
            ->order('id desc')
            ->page();
    }
}
```

### 文件存储系统

支持多种存储方案，基于文件 HASH 实现文件秒传。

```php
<?php
namespace app\admin\service;

use think\admin\Storage;

class FileService
{
    public function upload($file, $type = 'local')
    {
        $storage = Storage::instance($type);
        
        // 文件去重检查
        $hash = md5_file($file->getPathname());
        $exists = $this->checkFileExists($hash);
        
        if ($exists) {
            return $exists['url'];
        }
        
        // 上传文件
        $result = $storage->upload($file);
        return $result['url'];
    }
}
```

### 异步任务系统

支持多进程异步任务处理，实时显示执行进度。

```php
<?php
namespace app\admin\service;

use think\admin\service\QueueService;

class TaskService
{
    // 注册邮件发送任务
    public function sendEmail($to, $subject, $content)
    {
        $name = "发送邮件到 {$to}";
        $command = "xadmin:service email {$to} {$subject}";
        
        return QueueService::register($name, $command, 0);
    }
}

// 邮件队列处理类
class EmailQueue extends QueueService
{
    public function execute(array $data = [])
    {
        $this->setQueueProgress('开始发送邮件...', 10.00);
        
        try {
            // 发送邮件逻辑
            $result = $this->sendMail($data['to'], $data['subject'], $data['content']);
            
            if ($result) {
                $this->setQueueProgress('邮件发送成功', 100.00);
                $this->setQueueSuccess('邮件发送成功');
            } else {
                $this->setQueueError('邮件发送失败');
            }
        } catch (\Exception $e) {
            $this->setQueueError('邮件发送异常: ' . $e->getMessage());
        }
    }
}
```

### 开发工具

基于 ThinkLibrary 核心工具库，提供完整的 CRUD 操作。

```php
<?php
namespace app\admin\controller;

use think\admin\Controller;

class ProductController extends Controller
{
    protected $dbQuery = 'Product';
    
    public function index()
    {
        $this->title = '商品管理';
        $this->_query($this->dbQuery)
            ->like('name,description')
            ->equal('category_id,status')
            ->dateBetween('create_at')
            ->order('id desc')
            ->page();
    }
    
    public function add()
    {
        $this->title = '添加商品';
        $this->_form($this->dbQuery, 'form');
    }
    
    public function save()
    {
        $this->_save($this->dbQuery, $this->_vali([
            'status.require' => '状态不能为空',
            'status.in:0,1' => '状态值无效'
        ]));
    }
}
```

## 技术栈

### 后端技术

ThinkAdmin 基于 **ThinkPHP 6 & 8** 框架开发，支持 **PHP 7.1+** 版本，充分利用现代 PHP 特性：

- **框架版本**: ThinkPHP 6 & 8 (支持最新 PHP 8.x)
- **核心依赖**: ThinkLibrary v6.1+ (核心工具库)
- **插件生态**: ThinkPlugsAdmin v1.0+ (后台管理)、ThinkPlugsWechat v1.0+ (微信管理)
- **数据库支持**: MySQL、PostgreSQL、SQLite、SQL Server
- **ORM 支持**: ThinkORM 2.0+，支持模型关联、查询构建器
- **缓存系统**: Redis、Memcached、文件缓存
- **队列系统**: 支持异步任务处理
- **数据库迁移**: 使用 Phinx 进行版本控制
- **多语言支持**: 支持全局、应用、动态三种语言包类型
- **路由管理**: 支持全局路由和应用路由，模块化管理
- **运行模式**: 支持开发模式和生产模式切换
- **内置函数**: 提供 20+ 个内置函数，简化开发流程

### 前端技术

前端采用现代化的技术栈，提供良好的用户体验和开发体验：

- **UI 框架**: LayUI 2.x (轻量级、响应式)
- **模块管理**: RequireJS (按需加载)
- **图表组件**: ECharts (数据可视化)
- **富文本编辑**: CKEditor (内容编辑)
- **图标字体**: Font Awesome (图标系统)
- **响应式设计**: 支持移动端和桌面端
- **表格组件**: LayUI Table 组件，支持动态高度、搜索绑定
- **表单组件**: 支持自动提交、数据验证
- **弹层组件**: LayUI Layer 弹层组件
- **工具函数**: 内置 jQuery 扩展和工具函数

### 第三方集成

系统提供了丰富的第三方服务集成，支持主流云服务和平台：

- **云存储**: 七牛云、阿里云 OSS、腾讯云 COS、又拍云 USS、自建 Alist 存储
- **微信生态**: 公众号管理、小程序管理、微信支付、用户管理、素材管理
- **支付集成**: 微信支付、支付宝等主流支付方式
- **消息推送**: 邮件发送、短信发送等基础消息推送功能

## 插件生态

ThinkAdmin 采用 Composer 插件定制架构，提供丰富的插件生态：

### 核心插件

- **ThinkLibrary v6.1+** - 核心工具库，提供完整的 CRUD 操作和一系列常用工具，特别注重多应用支持
- **ThinkPlugsAdmin v1.0+** - 后台基础管理模块，提供用户、权限、菜单、系统配置等核心功能
- **ThinkPlugsWechat v1.0+** - 微信平台管理，支持公众号、小程序、微信支付等完整功能

### 扩展插件

- **ThinkPlugsAccount** - 账号管理插件
- **ThinkPlugsPayment** - 支付管理插件
- **ThinkPlugsWorker** - 高性能 Worker 运行插件
- **ThinkPlugsStatic** - 静态资源管理插件

### 插件特点

- **热插拔** - 支持插件的动态安装和卸载
- **统一管理** - 通过 Composer 进行插件依赖管理
- **本地化开发** - 支持插件本地化定制开发
- **版本控制** - 支持插件版本管理和更新

### 插件开发

系统强制要求使用插件架构，所有业务功能都必须通过自定义插件实现。开发者必须基于统一的插件接口规范开发自定义插件来实现具体的业务功能。

**插件开发示例**:
```php
<?php
namespace app\plugin\example;

use think\admin\Plugin;

class ExamplePlugin extends Plugin
{
    public function install()
    {
        // 安装插件时的操作
        $this->createTables();
        $this->createMenus();
    }
    
    public function uninstall()
    {
        // 卸载插件时的操作
        $this->dropTables();
        $this->removeMenus();
    }
}
```

## 数据库配置

### SQLite (默认)
```php
// config/database.php
return [
    'default' => 'sqlite',
    'connections' => [
        'sqlite' => [
            'type' => 'sqlite',
            'database' => 'database/sqlite.db',
        ],
    ]
];
```

### MySQL
```php
// config/database.php
return [
    'default' => 'mysql',
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
    ]
];
```

## 系统命令

```bash
# 启动开发服务器
php think run --host 127.0.0.1 --port 8000

# 数据库迁移
php think migrate:run

# 清除缓存
php think clear

# 异步任务管理
php think xadmin:queue start    # 启动守护进程
php think xadmin:queue stop     # 停止进程
php think xadmin:queue query    # 查询任务
php think xadmin:queue listen   # 监听进程
```

## 开发指南

### 创建控制器
```php
<?php
namespace app\admin\controller;

use think\admin\Controller;

class MyController extends Controller
{
    /**
     * 我的页面
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->title = '我的页面';
        $this->fetch();
    }
}
```

### 权限控制
```php
/**
 * 需要权限验证的方法
 * @auth true    # 需要权限验证
 * @menu true    # 添加到菜单
 * @login true   # 需要登录
 */
public function myMethod()
{
    // 方法内容
}
```

### 数据操作
```php
// 查询数据
$this->_query('user')
    ->like('username,email')
    ->equal('status')
    ->dateBetween('create_time')
    ->order('id desc')
    ->page();

// 表单处理
$this->_form('user', 'form');

// 状态更新
$this->_save('user', $this->_vali([
    'status.require' => '状态不能为空',
    'status.in:0,1' => '状态值无效'
]));
```

## 常见问题

### 安装部署

**Q: 安装时提示 Composer 错误怎么办？**

A: 请检查以下几点：
1. **PHP 版本**: 确保 PHP 版本 ≥ 7.1
2. **Composer 版本**: 执行 `composer self-update` 更新到最新版本
3. **网络问题**: 如果网络不稳定，可以配置国内镜像

**Q: 数据库初始化失败怎么办？**

A: 请检查：
1. **数据库配置**: 检查 `config/database.php` 配置是否正确
2. **数据库权限**: 确保数据库用户有创建表的权限
3. **数据库连接**: 测试数据库连接是否正常

**Q: 无法访问后台管理页面？**

A: 可能的原因：
1. **URL 路径**: 确保访问的是 `/admin` 或 `/admin.html`
2. **Web 服务器配置**: 检查伪静态规则是否正确配置
3. **PHP 扩展**: 确保安装了必要的 PHP 扩展

### 功能使用

**Q: 如何修改后台登录入口？**

A: 在后台 **系统管理** → **系统参数配置** 中修改：
1. 找到"后台入口地址"配置项
2. 设置新的入口地址（如：`/myadmin`）
3. 保存配置，原入口将自动失效

**Q: 文件上传失败怎么办？**

A: 检查以下配置：
1. **上传目录权限**: 确保 `public/upload` 目录可写
2. **PHP 配置**: 检查 `upload_max_filesize` 和 `post_max_size`
3. **系统参数**: 在后台配置正确的文件上传参数

**Q: 如何添加自定义菜单？**

A: 在后台 **系统管理** → **菜单管理** 中：
1. 点击"添加菜单"
2. 填写菜单名称和链接地址
3. 选择父级菜单
4. 设置菜单图标和排序

### 开发相关

**Q: 如何创建新的控制器？**

A: 在 `app/admin/controller/` 目录下创建控制器文件，继承 `think\admin\Controller`。

**Q: 如何添加权限控制？**

A: 在控制器方法上添加注释：`@auth true`、`@menu true`、`@login true`。

**Q: 如何自定义主题样式？**

A: 可以通过以下方式自定义：
1. **CSS 文件**: 在 `public/static/css/` 目录下添加自定义样式
2. **系统参数**: 在后台配置主题相关参数
3. **模板文件**: 修改 `app/admin/view/` 下的模板文件

### 插件相关

**Q: 如何安装插件？**

A: 使用 Composer 安装：
```bash
# 安装免费插件
composer require zoujingli/think-plugs-wechat

# 安装付费插件（需要授权）
composer require zoujingli/think-plugs-account
```

**Q: 插件安装后没有显示怎么办？**

A: 检查以下几点：
1. **插件状态**: 在后台插件管理中查看插件状态
2. **权限配置**: 确保当前用户有访问插件的权限
3. **缓存清理**: 清除系统缓存后重新访问

**Q: 如何卸载插件？**

A: 使用 Composer 卸载：
```bash
composer remove zoujingli/plugin-name
```

**注意**: 卸载插件不会自动删除相关数据表，需要手动清理。

### 性能优化

**Q: 系统运行缓慢怎么办？**

A: 可以尝试以下优化：
1. **开启缓存**: 在后台切换到生产模式
2. **数据库优化**: 为常用查询字段添加索引
3. **文件存储**: 使用云存储提升文件访问速度
4. **服务器配置**: 优化 PHP 和 Web 服务器配置

**Q: 如何开启生产模式？**

A: 在后台 **系统管理** → **系统参数配置** 中：
1. 找到"运行模式"配置项
2. 选择"生产模式"
3. 保存配置并清理缓存

### 错误排查

**Q: 页面显示 500 错误？**

A: 检查以下内容：
1. **错误日志**: 查看 `runtime/log/` 目录下的错误日志
2. **PHP 错误**: 检查 PHP 错误日志
3. **权限问题**: 确保目录权限正确
4. **配置问题**: 检查配置文件是否正确

**Q: 数据库连接失败？**

A: 检查数据库配置：
1. **连接参数**: 检查 `config/database.php` 中的连接参数
2. **数据库服务**: 确保数据库服务正在运行
3. **网络连接**: 检查网络连接是否正常
4. **用户权限**: 确保数据库用户有相应权限

## 贡献

我们欢迎所有形式的贡献，包括但不限于：

### 如何贡献

1. **报告问题**
   - 在 [GitHub Issues](https://github.com/zoujingli/ThinkAdmin/issues) 或 [Gitee Issues](https://gitee.com/zoujingli/ThinkAdmin/issues) 报告 Bug
   - 提供详细的问题描述和复现步骤
   - 包含系统环境信息

2. **提交代码**
   - Fork 项目到您的 GitHub 账户
   - 创建功能分支：`git checkout -b feature/AmazingFeature`
   - 提交更改：`git commit -m 'Add some AmazingFeature'`
   - 推送分支：`git push origin feature/AmazingFeature`
   - 创建 Pull Request

3. **改进文档**
   - 完善 README 文档
   - 添加使用示例
   - 翻译文档到其他语言

4. **分享经验**
   - 分享使用心得
   - 编写教程文章
   - 参与社区讨论

### 开发计划

- [ ] 支持更多数据库类型
- [ ] 优化前端界面
- [ ] 增加更多插件
- [ ] 完善 API 文档
- [ ] 支持 Docker 部署

### 社区支持

- **GitHub**: [https://github.com/zoujingli/ThinkAdmin](https://github.com/zoujingli/ThinkAdmin)
- **Gitee**: [https://gitee.com/zoujingli/ThinkAdmin](https://gitee.com/zoujingli/ThinkAdmin)
- **官方网站**: [https://thinkadmin.top](https://thinkadmin.top)
- **在线演示**: [https://v6.thinkadmin.top](https://v6.thinkadmin.top)
- **技术交流群**: 请访问官网获取群号

### 赞助支持

如果这个项目对您有帮助，欢迎通过以下方式支持我们：

- ⭐ Star 项目
- 🍴 Fork 项目
- 📢 分享给更多人
- 💰 赞助开发（请访问官网了解详情）

## 许可证

本项目基于 [MIT](https://mit-license.org) 许可证开源。

## 版权

版权所有 Copyright © 2018-2025 by ThinkAdmin (https://thinkadmin.top) All rights reserved.

**备案信息**: [粤ICP备16006642号](https://beian.miit.gov.cn)

---

**提示**: 遇到问题时，建议先查看错误日志，大多数问题都能通过日志找到原因。