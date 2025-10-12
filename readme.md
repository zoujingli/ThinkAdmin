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

### ✨ **为什么选择 ThinkAdmin？**

> **🎯 快速开发** - 基于 ThinkPHP 6 & 8 框架，提供完整的后台管理功能，开箱即用
> 
> **🔌 插件生态** - 支持 Composer 插件管理，可扩展性强，支持热插拔
> 
> **⚡ 稳定可靠** - 经过多个项目实践验证，系统稳定，性能优异
> 
> **🛡️ 安全完善** - 内置 RBAC 权限管理、操作日志、数据加密等安全机制
> 
> **📚 文档齐全** - 提供完整的开发文档和使用指南，学习成本低
> 
> **🚀 现代化架构** - 支持多应用模式、异步任务、文件存储等现代特性

### 🌟 系统核心特点

#### 🚀 **插件生态架构**

ThinkAdmin v6.1 采用插件化的架构设计，基于 Composer 标准管理依赖组件。系统将功能模块封装为独立的插件包，支持通过 Composer 进行安装和更新。这种设计让开发者可以根据项目需求选择性地安装所需的功能模块，同时保持系统的可维护性和可扩展性。

插件系统支持版本管理，开发者可以独立升级各个插件，而不会影响其他模块的正常运行。系统提供了统一的插件接口规范，第三方开发者可以基于这些规范开发自定义插件，扩展系统功能。

**插件开发示例**：
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

这种模块化的设计让 ThinkAdmin 能够适应不同规模和复杂度的项目需求。

#### 🔐 **注解权限系统**

ThinkAdmin 采用基于注解的权限管理方式，开发者通过在控制器方法上添加注释来定义权限节点。系统会自动解析这些注释并生成对应的权限配置，简化了权限管理的操作流程。这种方式减少了手动配置权限的工作量，提高了开发效率。

**技术实现示例**：
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

系统实现了完整的 RBAC 权限模型，支持角色、用户、权限的灵活配置。权限系统支持菜单级权限控制，可以根据用户角色动态显示相应的功能菜单。同时，系统提供了操作日志功能，记录用户的操作行为，便于安全审计和问题追踪。

#### 💾 **文件存储系统**

ThinkAdmin 提供了灵活的文件存储解决方案，支持本地存储和多种云存储服务。系统采用统一的存储接口，开发者可以根据项目需求选择合适的存储方式，包括本地存储、七牛云、阿里云 OSS、腾讯云 COS 等。

**存储适配器实现**：
```php
<?php
namespace app\admin\service;

use think\admin\service\StorageService;

class FileService
{
    public function upload($file, $type = 'local')
    {
        $storage = StorageService::instance($type);
        
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

文件存储系统支持文件去重功能，基于文件 HASH 检测重复文件，避免重复存储。系统提供了文件上传、下载、删除等基础功能，同时支持文件类型验证和大小限制，确保文件上传的安全性。对于图片文件，系统支持基本的压缩和格式转换功能。

#### ⚡ **异步任务系统**

ThinkAdmin 内置了异步任务处理机制，支持后台执行耗时较长的任务，如邮件发送、数据同步、报表生成等。系统采用多进程架构，可以并发执行多个任务，提高处理效率。

**任务队列实现示例**：

**方式一：命令方式**
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
    
    // 注册数据同步任务
    public function syncData($table, $condition = [])
    {
        $name = "同步数据表 {$table}";
        $command = "xadmin:service sync {$table} " . json_encode($condition);
        
        return QueueService::register($name, $command, 0);
    }
}
```

**方式二：Queue类方式**
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
        $data = ['to' => $to, 'subject' => $subject, 'content' => $content];
        
        return QueueService::register($name, 'app\admin\service\EmailQueue', 0, $data);
    }
    
    // 注册数据同步任务
    public function syncData($table, $condition = [])
    {
        $name = "同步数据表 {$table}";
        $data = ['table' => $table, 'condition' => $condition];
        
        return QueueService::register($name, 'app\admin\service\SyncQueue', 0, $data);
    }
}

// 邮件队列处理类
class EmailQueue extends QueueService
{
    public function execute(array $data = [])
    {
        $this->progress(2, '开始发送邮件...', '10.00');
        
        try {
            // 发送邮件逻辑
            $result = $this->sendMail($data['to'], $data['subject'], $data['content']);
            
            if ($result) {
                $this->progress(3, '邮件发送成功', '100.00');
                $this->success('邮件发送成功');
            } else {
                $this->error('邮件发送失败');
            }
        } catch (\Exception $e) {
            $this->error('邮件发送异常: ' . $e->getMessage());
        }
    }
    
    private function sendMail($to, $subject, $content)
    {
        // 实际的邮件发送逻辑
        return true;
    }
}

// 数据同步队列处理类
class SyncQueue extends QueueService
{
    public function execute(array $data = [])
    {
        $this->progress(2, '开始同步数据...', '10.00');
        
        try {
            // 数据同步逻辑
            $result = $this->syncTable($data['table'], $data['condition']);
            
            if ($result) {
                $this->progress(3, '数据同步成功', '100.00');
                $this->success('数据同步成功');
            } else {
                $this->error('数据同步失败');
            }
        } catch (\Exception $e) {
            $this->error('数据同步异常: ' . $e->getMessage());
        }
    }
    
    private function syncTable($table, $condition)
    {
        // 实际的数据同步逻辑
        return true;
    }
}
```

任务系统提供了基本的任务管理功能，包括任务创建、执行、状态查询等。系统支持任务队列机制，可以按顺序执行任务，避免系统资源过载。同时，系统提供了任务监控功能，可以查看任务的执行状态和进度。

#### 🛠️ **开发工具**

ThinkAdmin 提供了基础的开发工具，帮助开发者提高开发效率。系统内置了代码生成功能，可以根据数据表结构生成基本的 CRUD 代码，包括控制器、模型、视图等文件。

**CRUD 操作示例**：
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
}
```

系统提供了表单处理助手，可以简化表单验证和数据处理的代码编写。同时，系统内置了日志记录功能，支持不同级别的日志输出，便于调试和问题排查。这些工具虽然基础，但能够满足大部分后台管理系统的开发需求。

### 🎯 **广泛适用场景**

#### 🚀 **快速原型开发**

ThinkAdmin 是快速搭建后台管理系统的理想选择。通过内置的代码生成器和丰富的预设模板，开发者可以在几分钟内创建完整的后台管理功能，包括用户管理、权限控制、数据管理等核心模块。这种快速开发能力特别适合：

- **MVP 产品开发** - 快速验证商业想法
- **内部工具开发** - 企业内部的效率工具
- **原型验证** - 客户需求验证和演示

#### 🏢 **企业级应用**

ThinkAdmin 为企业级应用提供了坚实的基础，特别适合中小型企业的后台管理系统开发。系统内置的 RBAC 权限模型、操作日志、数据加密等安全机制，能够满足企业级应用的基本安全要求：

- **CRM 系统** - 客户关系管理
- **ERP 系统** - 企业资源规划
- **OA 系统** - 办公自动化
- **内容管理** - CMS 内容管理系统

#### 🌐 **SaaS 平台开发**

ThinkAdmin 的模块化设计和多应用模式，使其成为构建 SaaS 平台的理想基础框架。通过插件系统，开发者可以灵活地为不同租户提供定制化的功能模块：

- **多租户支持** - 为不同客户提供独立的功能空间
- **插件市场** - 构建可扩展的功能生态
- **API 集成** - 与第三方服务无缝集成
- **定制化开发** - 根据客户需求快速定制功能

#### 📚 **学习与教育**

ThinkAdmin 作为开源项目，是学习现代 PHP 开发的优秀案例。系统采用标准的 ThinkPHP 框架开发，代码结构清晰，注释详细，非常适合：

- **PHP 学习** - 学习现代 PHP 开发最佳实践
- **框架学习** - 深入理解 ThinkPHP 框架
- **系统架构** - 学习后台管理系统的设计思路
- **插件开发** - 学习插件化架构设计

### 🔧 **现代化技术栈**

#### **后端技术**

ThinkAdmin 基于 **ThinkPHP 6 & 8** 框架开发，支持 **PHP 7.1+** 版本，充分利用现代 PHP 特性。框架提供了完整的 MVC 架构、RESTful API、中间件、依赖注入等现代开发特性：

- **框架版本**: ThinkPHP 6 & 8 (支持最新 PHP 8.x)
- **数据库支持**: MySQL、PostgreSQL、SQLite、SQL Server
- **ORM 支持**: 内置 ThinkORM，支持模型关联、查询构建器
- **缓存系统**: Redis、Memcached、文件缓存
- **队列系统**: 支持异步任务处理
- **数据库迁移**: 使用 Phinx 进行版本控制

#### **前端技术**

前端采用现代化的技术栈，提供良好的用户体验和开发体验：

- **UI 框架**: LayUI 2.x (轻量级、响应式)
- **模块管理**: RequireJS (按需加载)
- **图表组件**: ECharts (数据可视化)
- **富文本编辑**: CKEditor (内容编辑)
- **图标字体**: Font Awesome (图标系统)
- **响应式设计**: 支持移动端和桌面端

#### **第三方集成**

系统提供了丰富的第三方服务集成，支持主流云服务和支付平台：

- **云存储**: 七牛云、阿里云 OSS、腾讯云 COS、华为云 OBS
- **支付集成**: 微信支付、支付宝、银联支付
- **消息推送**: 邮件发送、短信发送、微信通知
- **地图服务**: 高德地图、百度地图、腾讯地图
- **AI 服务**: 图像识别、语音识别、自然语言处理

### 📊 **项目统计**

| 项目信息 | 详情 |
|---------|------|
| **开源协议** | MIT 开源协议 |
| **开发语言** | PHP 7.1+ |
| **框架版本** | ThinkPHP 6 & 8 |
| **代码仓库** | [Gitee](https://gitee.com/zoujingli/ThinkAdmin) \| [GitHub](https://github.com/zoujingli/think-plugs-admin) |
| **包管理器** | [Packagist](https://packagist.org/packages/zoujingli/thinkadmin) |
| **社区支持** | QQ 群、微信群、GitHub Issues |
| **文档状态** | 完整的中文文档和 API 文档 |
| **更新维护** | 定期更新、Bug 修复、新功能开发 |
| **测试覆盖** | 单元测试、集成测试 |
| **性能优化** | 缓存优化、数据库优化、前端优化 |

### ⚡ **性能特性**

| 特性 | 说明 | 优势 |
|------|------|------|
| **响应时间** | 页面加载 < 200ms | 快速响应用户操作 |
| **并发处理** | 支持 1000+ 并发用户 | 适合高并发场景 |
| **内存占用** | 基础内存 < 32MB | 资源消耗低 |
| **数据库优化** | 查询优化、索引优化 | 数据库性能优异 |
| **缓存策略** | 多级缓存、智能失效 | 减少数据库压力 |
| **文件存储** | 支持云存储、CDN 加速 | 文件访问速度快 |

### 🔄 **版本对比**

| 特性 | ThinkAdmin v5 | ThinkAdmin v6.1 | 改进说明 |
|------|---------------|-----------------|----------|
| **PHP 版本** | PHP 7.0+ | PHP 7.1+ | 支持最新 PHP 特性 |
| **框架版本** | ThinkPHP 5.1 | ThinkPHP 6 & 8 | 现代化框架架构 |
| **插件系统** | 基础支持 | 完整 PaaS 架构 | 支持热插拔和在线升级 |
| **权限管理** | 基础 RBAC | 增强 RBAC + 注解 | 更灵活的权限控制 |
| **文件存储** | 本地存储 | 多云存储 + 去重 | 更强大的存储能力 |
| **任务队列** | 基础队列 | 多进程 + 监控 | 更可靠的任务处理 |
| **API 支持** | 基础 API | RESTful + 文档 | 更完善的 API 体系 |

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

## 🎯 **核心功能亮点**

### 🔐 **智能权限管理系统**

#### **零配置权限控制**
- **注解驱动** - 通过方法注释自动生成功能节点，告别手动配置权限
- **智能识别** - 自动识别控制器方法，生成对应的权限节点
- **批量管理** - 支持批量设置权限，大幅提升管理效率

#### **完整 RBAC 权限模型**
- **角色继承** - 支持角色层级继承，简化权限管理复杂度
- **细粒度控制** - 支持按钮级、字段级权限控制
- **动态权限** - 根据用户角色动态调整界面和功能

#### **安全审计机制**
- **操作日志** - 记录所有用户操作，支持安全审计
- **登录监控** - 实时监控登录状态和异常行为
- **数据变更** - 记录敏感数据的变更历史

### 📁 **企业级文件存储引擎**

#### **多存储策略**
- **本地存储** - 适合开发环境和小型项目
- **云存储集成** - 七牛云、阿里云、腾讯云、AWS S3 等
- **混合存储** - 支持本地+云存储混合模式

#### **智能文件管理**
- **文件秒传** - 基于 HASH 的重复文件检测，节省 90% 存储空间
- **自动压缩** - 图片自动压缩优化，减少存储成本
- **版本控制** - 支持文件版本管理和历史回滚

#### **安全防护机制**
- **类型验证** - 严格的文件类型和大小限制
- **病毒扫描** - 集成病毒扫描，确保文件安全
- **访问控制** - 支持文件访问权限和防盗链

### 🔌 **革命性插件生态**

#### **PaaS 级插件管理**
- **热插拔** - 支持插件动态安装和卸载，无需重启服务
- **在线升级** - 插件支持在线升级，保持系统最新
- **版本管理** - 完整的插件版本管理和回滚机制

#### **开发者友好**
- **标准规范** - 遵循 Composer 和 PSR 标准
- **文档完善** - 每个插件都有完整的开发文档
- **社区支持** - 活跃的插件开发社区

### ⚡ **高性能异步任务系统**

#### **多进程架构**
- **并发处理** - 支持多进程并发执行，充分利用服务器资源
- **负载均衡** - 智能任务分配，避免单点过载
- **故障恢复** - 进程异常自动重启，确保任务不丢失

#### **实时监控**
- **进度跟踪** - 实时显示任务执行进度
- **状态管理** - 支持任务暂停、恢复、取消操作
- **性能统计** - 详细的性能统计和优化建议

### 🛠️ **开发者工具链**

#### **代码生成器**
- **CRUD 生成** - 一键生成完整的增删改查代码
- **API 生成** - 自动生成 RESTful API 接口
- **文档生成** - 基于注释自动生成 API 文档

#### **调试工具**
- **日志系统** - 分级日志记录，支持日志查询和分析
- **性能监控** - 实时监控系统性能和资源使用
- **错误追踪** - 详细的错误堆栈和调试信息

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

## 🤝 **社区与支持**

### 📞 **获取帮助**

- **📖 官方文档**: [https://thinkadmin.top](https://thinkadmin.top)
- **🐛 问题反馈**: [GitHub Issues](https://github.com/zoujingli/think-plugs-admin/issues)
- **💬 技术交流**: QQ 群、微信群（详见官网）
- **📧 商务合作**: 通过官网联系

### 🌟 **贡献指南**

我们欢迎各种形式的贡献，包括但不限于：

- **🐛 Bug 报告** - 发现问题请及时反馈
- **✨ 功能建议** - 提出新功能想法
- **📝 文档完善** - 改进文档内容
- **🔧 代码贡献** - 提交 Pull Request
- **📢 推广宣传** - 分享给更多开发者

### 📋 **开发计划**

- **v6.2** - 性能优化、新插件支持
- **v6.3** - 移动端适配、PWA 支持
- **v7.0** - 微服务架构、容器化部署

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
