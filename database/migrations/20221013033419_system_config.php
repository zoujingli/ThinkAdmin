<?php

use think\migration\Migrator;

/**
 * 系统配置数据
 */
class SystemConfig extends Migrator
{
    public function change()
    {
        // 当前操作
        $table = 'system_config';
        // 创建数据表，存在则跳过
        if (!$this->hasTable($table)) {
            $this->table($table, [
                'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-配置',
            ])
                ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '配置分类'])
                ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '配置名称'])
                ->addColumn('value', 'string', ['limit' => 2048, 'default' => '', 'comment' => '配置内容'])
                ->addIndex('type', ['name' => 'idx_system_config_type'])
                ->addIndex('name', ['name' => 'idx_system_config_name'])
                ->save();

            // 初始化配置信息
            $this->execute(<<<SQL
INSERT INTO {$table} VALUES (1, 'base', 'app_name', 'ThinkAdmin');
INSERT INTO {$table} VALUES (2, 'base', 'app_version', 'v6');
INSERT INTO {$table} VALUES (3, 'base', 'beian', '');
INSERT INTO {$table} VALUES (4, 'base', 'editor', 'ckeditor5');
INSERT INTO {$table} VALUES (5, 'base', 'login_image', '');
INSERT INTO {$table} VALUES (6, 'base', 'login_name', '系统管理');
INSERT INTO {$table} VALUES (7, 'base', 'miitbeian', '');
INSERT INTO {$table} VALUES (8, 'base', 'site_copy', '©版权所有 2014-2022 楚才科技');
INSERT INTO {$table} VALUES (9, 'base', 'site_host', '');
INSERT INTO {$table} VALUES (10, 'base', 'site_icon', 'https://v6.thinkadmin.top/upload/4b/5a423974e447d5502023f553ed370f.png');
INSERT INTO {$table} VALUES (11, 'base', 'site_name', 'ThinkAdmin');
INSERT INTO {$table} VALUES (12, 'base', 'site_theme', 'default');
INSERT INTO {$table} VALUES (13, 'base', 'xpath', 'admin');
INSERT INTO {$table} VALUES (14, 'storage', 'alioss_http_protocol', 'http');
INSERT INTO {$table} VALUES (15, 'storage', 'allow_exts', 'doc,gif,ico,jpg,mp3,mp4,p12,pem,png,zip,rar,xls,xlsx');
INSERT INTO {$table} VALUES (16, 'storage', 'link_type', 'none');
INSERT INTO {$table} VALUES (17, 'storage', 'local_http_domain', '');
INSERT INTO {$table} VALUES (18, 'storage', 'local_http_protocol', 'follow');
INSERT INTO {$table} VALUES (19, 'storage', 'name_type', 'xmd5');
INSERT INTO {$table} VALUES (20, 'storage', 'type', 'local');
INSERT INTO {$table} VALUES (21, 'wechat', 'type', 'api');
INSERT INTO {$table} VALUES (22, 'storage', 'qiniu_http_protocol', 'http');
SQL
            );
        }
    }
}
