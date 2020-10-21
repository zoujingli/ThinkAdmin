[![Latest Stable Version](https://poser.pugx.org/zoujingli/think-library/v/stable)](https://packagist.org/packages/zoujingli/think-library) [![Total Downloads](https://poser.pugx.org/zoujingli/think-library/downloads)](https://packagist.org/packages/zoujingli/think-library) [![Latest Unstable Version](https://poser.pugx.org/zoujingli/think-library/v/unstable)](https://packagist.org/packages/zoujingli/think-library) [![License](https://poser.pugx.org/zoujingli/think-library/license)](https://packagist.org/packages/zoujingli/think-library)

# ThinkLibrary 6.0 for ThinkPHP 6.0
ThinkLibrary 6.0 是针对 ThinkPHP 6.0 版本封装的一套工具类库，方便快速构建 WEB 应用。

## 包含组件
* 数据列表展示（可带高级搜索器）
* FORM表单处理器（表单展示及数据入库）
* 数据状态快速处理（数据指定字段更新，支持多字段同时）
* 数据安全删除处理（硬删除 + 软删除，is_deleted 字段存在则自动软删除）
* 文件存储通用组件（本地服务存储 + 七牛云存储 + 阿里云OSS存储  + 腾讯云COS存储）
* 通用数据保存更新（通过 key 值及 where 判定是否存在，存在则更新，不存在则新增）
* 通用网络请求 （支持 get 及 post，可配置请求证书等）
* 系统参数通用 g-k-v 配置（快速参数长久化配置） 
* UTF8加密算法支持（安全URL参数传参数）
* 接口 CORS 跨域默认支持（输出 JSON 标准化）
* 支持表单CSRF安全验证（自动化 FORM 标签替换）
* 更新功能等待您来发现哦....

## 参考项目

#### ThinkAdmin - V6.0
* Gitee 仓库 https://gitee.com/zoujingli/ThinkAdmin/tree/v6
* Github 仓库 https://github.com/zoujingli/ThinkAdmin/tree/v6
* 体验地址（账号密码都是admin）https://v6.thinkadmin.top

## 代码仓库
 ThinkLibrary 为 MIT 协议开源项目，安装使用或二次开发不受约束，欢迎 fork 项目。
 
 部分代码来自互联网，若有异议可以联系作者进行删除。
 
 * 在线体验地址：https://v6.thinkadmin.top （账号和密码都是 admin ）
 * Gitee仓库地址：https://gitee.com/zoujingli/ThinkLibrary
 * Github仓库地址：https://github.com/zoujingli/ThinkLibrary

## 使用说明
* ThinkLibrary 需要 Composer 支持
* 安装命令 ` composer require zoujingli/think-library 6.0.x-dev`
* 案例代码：
控制器需要继承 `think\admin\Controller`，然后`$this`就可能使用全部功能
```php
// 定义 MyController 控制器
class MyController extend \think\admin\Controller {

    // 指定当前数据表名
    protected $dbQuery = '数据表名';
    
    // 显示数据列表
    public function index(){
        $this->_page($this->dbQuery);
    }
    
    // 当前列表数据处理
    protected function _index_page_filter(&$data){
         foreach($data as &$vo){
            // @todo 修改原列表
         }
    }
    
}
```

* 必要数据库表SQL（sysdata 函数需要用这个表）
```sql
CREATE TABLE `system_data` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(100) DEFAULT NULL COMMENT '配置名',
  `value` longtext COMMENT '配置值',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_data_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统-数据';
```

* 必要数据库表SQl（sysoplog 函数需要用的这个表）
```sql
CREATE TABLE `system_oplog` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `node` varchar(200) NOT NULL DEFAULT '' COMMENT '当前操作节点',
  `geoip` varchar(15) NOT NULL DEFAULT '' COMMENT '操作者IP地址',
  `action` varchar(200) NOT NULL DEFAULT '' COMMENT '操作行为名称',
  `content` varchar(1024) NOT NULL DEFAULT '' COMMENT '操作内容描述',
  `username` varchar(50) NOT NULL DEFAULT '' COMMENT '操作人用户名',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统-日志';
```
* 必要数据库表SQL（sysconf 函数需要用到这个表）
```sql
CREATE TABLE `system_config` (
  `type` varchar(20) DEFAULT '' COMMENT '分类',
  `name` varchar(100) DEFAULT '' COMMENT '配置名',
  `value` varchar(500) DEFAULT '' COMMENT '配置值',
  KEY `idx_system_config_type` (`type`),
  KEY `idx_system_config_name` (`name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统-配置';
```
* 系统任务列队支持需要的数据表
```sql
CREATE TABLE `system_queue` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `code` varchar(20) DEFAULT '' COMMENT '任务编号',
  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '任务名称',
  `command` varchar(500) DEFAULT '' COMMENT '执行指令',
  `exec_data` longtext COMMENT '执行参数',
  `exec_time` bigint(20) unsigned DEFAULT '0' COMMENT '执行时间',
  `exec_desc` varchar(500) DEFAULT '' COMMENT '状态描述',
  `enter_time` bigint(20) DEFAULT '0' COMMENT '开始时间',
  `outer_time` bigint(20) DEFAULT '0' COMMENT '结束时间',
  `attempts` bigint(20) DEFAULT '0' COMMENT '执行次数',
  `rscript` tinyint(1) DEFAULT '1' COMMENT '单例模式',
  `status` tinyint(1) DEFAULT '1' COMMENT '任务状态(1新任务,2处理中,3成功,4失败)',
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `idx_system_queue_code` (`code`),
  KEY `idx_system_queue_title` (`title`) USING BTREE,
  KEY `idx_system_queue_status` (`status`) USING BTREE,
  KEY `idx_system_queue_rscript` (`rscript`) USING BTREE,
  KEY `idx_system_queue_create_at` (`create_at`) USING BTREE,
  KEY `idx_system_queue_exec_time` (`exec_time`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COMMENT='系统-任务';
```

#### 列表处理
```php
// 列表展示
$this->_page($dbQuery, $isPage, $isDisplay, $total);

// 列表展示搜索器（按 name、title 模糊搜索；按 status 精确搜索）
$this->_query($dbQuery)->like('name,title')->equal('status')->page();

// 对列表查询器进行二次处理
$query = $this->_query($dbQuery)->like('name, title')->equal('status');
$db = $query->db(); // @todo 这里可以对db进行操作
$this->_page($db); // 显示列表分页
```

#### 表单处理
```php
// 表单显示及数据更新
$this->_form($dbQuery, $tplFile, $pkField , $where, $data);
```

#### 删除处理
```php
// 数据删除处理
$this->_deleted($dbQuery);
```

#### 禁用启用处理
```php
// 数据禁用处理
$this->_save($dbQuery, ['status'=>'0']);

// 数据启用处理
$this->_save($dbQuery, ['status'=>'1']);
```

#### 文件存储组件（ oss 及 qiniu 需要配置参数）
```php

// 配置默认存储方式    
sysconf('storage.type','文件存储类型');

// 七牛云存储配置
sysconf('storage.qiniu_region', '文件存储节点');
sysconf('storage.qiniu_domain', '文件访问域名');
sysconf('storage.qiniu_bucket', '文件存储空间名称');
sysconf('storage.qiniu_is_https', '文件HTTP访问协议');
sysconf('storage.qiniu_access_key', '接口授权AccessKey');
sysconf('storage.qiniu_secret_key', '接口授权SecretKey');


// 生成文件名称(链接url或文件md5)
$filename = \think\admin\Storage::name($url, $ext, $prv, $fun);

// 获取文件内容（自动存储方式）
$result = \think\admin\Storage::get($filename)

// 保存内容到文件（自动存储方式）
boolean \think\admin\Storage::save($filename, $content);

// 判断文件是否存在
boolean \think\admin\Storage::has($filename);

// 获取文件信息
$result = \think\admin\Storage::info($filename);

//指定存储类型（调用方法）
boolean \think\admin\Storage::instance('local')->save($filename, $content);
boolean \think\admin\Storage::instance('qiniu')->save($filename, $content);

$result = \think\admin\Storage::instance('local')->get($filename);
$result = \think\admin\Storage::instance('qiniu')->get($filename);

boolean \think\admin\Storage::instance('local')->has($filename);
boolean \think\admin\Storage::instance('qiniu')->has($filename);

$resutl = \think\admin\Storage::instance('local')->info($filename);
$resutl = \think\admin\Storage::instance('qiniu')->info($filename);
```

#### 通用数据保存
```php
// 指定关键列更新（$where 为扩展条件）
boolean data_save($dbQuery, $data, 'pkname', $where);
```

#### 通用网络请求
```php
// 发起get请求
$result = http_get($url, $query, $options);

// 发起post请求
$result = http_post($url, $data, $options);
```

#### 系统参数配置（基于 system_config 数据表）
```php
// 设置参数
sysconf($keyname, $keyvalue);

// 获取参数
$keyvalue = sysconf($kename);
```

#### UTF8加密算法
```php
// 字符串加密操作
$string = encode($content);

// 加密字符串解密
$content = decode($string);
```

## 赞助打赏

![赞助](http://static.thinkadmin.top/pay.png)
