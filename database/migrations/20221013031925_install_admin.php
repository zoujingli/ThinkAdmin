<?php

use think\migration\Migrator;

/**
 * 系统模块数据
 */
class InstallAdmin extends Migrator
{
    public function change()
    {
        $this->_auth();
        $this->_base();
        $this->_conf();
        $this->_data();
        $this->_file();
        $this->_menu();
        $this->_node();
        $this->_oplog();
        $this->_queue();
        $this->_user();
    }

    private function _auth()
    {
        // 当前操作
        $table = 'system_auth';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-权限',
        ])
            ->addColumn('title', 'string', ['limit' => 80, 'default' => '', 'comment' => '权限名称'])
            ->addColumn('utype', 'string', ['limit' => 50, 'default' => '', 'comment' => '身份权限'])
            ->addColumn('desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '备注说明'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_system_auth_sort'])
            ->addIndex('title', ['name' => 'idx_system_auth_title'])
            ->addIndex('status', ['name' => 'idx_system_auth_status'])
            ->save();
    }

    private function _base()
    {
        // 当前操作
        $table = 'system_base';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-字典',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '数据类型'])
            ->addColumn('code', 'string', ['limit' => 100, 'default' => '', 'comment' => '数据代码'])
            ->addColumn('name', 'string', ['limit' => 500, 'default' => '', 'comment' => '数据名称'])
            ->addColumn('content', 'text', ['default' => '', 'comment' => '数据内容'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除(0正常,1已删)'])
            ->addColumn('deleted_at', 'string', ['limit' => 20, 'default' => '', 'comment' => '删除时间'])
            ->addColumn('deleted_by', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '删除用户'])
            ->addIndex('type', ['name' => 'idx_system_base_type'])
            ->addIndex('code', ['name' => 'idx_system_base_code'])
            ->addIndex('name', ['name' => 'idx_system_base_name'])
            ->addIndex('sort', ['name' => 'idx_system_base_sort'])
            ->addIndex('status', ['name' => 'idx_system_base_status'])
            ->addIndex('deleted', ['name' => 'idx_system_base_deleted'])
            ->save();
    }

    private function _conf()
    {
        // 当前操作
        $table = 'system_config';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-配置',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '配置分类'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '配置名称'])
            ->addColumn('value', 'string', ['limit' => 2048, 'default' => '', 'comment' => '配置内容'])
            ->addIndex('type', ['name' => 'idx_system_config_type'])
            ->addIndex('name', ['name' => 'idx_system_config_name'])
            ->save();
    }

    private function _data()
    {
        // 当前数据表
        $table = 'system_data';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-数据',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '配置名'])
            ->addColumn('value', 'text', ['default' => null, 'comment' => '配置值'])
            ->addIndex('name', ['name' => 'idx_system_data_name'])
            ->save();
    }

    private function _file()
    {
        // 当前数据表
        $table = 'system_file';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-文件',
        ])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '上传类型'])
            ->addColumn('hash', 'string', ['limit' => 32, 'default' => '', 'comment' => '文件哈希'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '文件名称'])
            ->addColumn('xext', 'string', ['limit' => 100, 'default' => '', 'comment' => '文件后缀'])
            ->addColumn('xurl', 'string', ['limit' => 500, 'default' => '', 'comment' => '访问链接'])
            ->addColumn('xkey', 'string', ['limit' => 500, 'default' => '', 'comment' => '文件路径'])
            ->addColumn('mime', 'string', ['limit' => 100, 'default' => '', 'comment' => '文件类型'])
            ->addColumn('size', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '文件大小'])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户编号'])
            ->addColumn('isfast', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '是否秒传'])
            ->addColumn('issafe', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '安全模式'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '上传状态(1悬空,2落地)'])
            ->addColumn('create_at', 'datetime', ['default' => null, 'comment' => '创建时间'])
            ->addColumn('update_at', 'datetime', ['default' => null, 'comment' => '更新时间'])
            ->addIndex('type', ['name' => 'idx_system_file_type'])
            ->addIndex('hash', ['name' => 'idx_system_file_hash'])
            ->addIndex('uuid', ['name' => 'idx_system_file_uuid'])
            ->addIndex('xext', ['name' => 'idx_system_file_xext'])
            ->addIndex('status', ['name' => 'idx_system_file_status'])
            ->addIndex('issafe', ['name' => 'idx_system_file_issafe'])
            ->addIndex('isfast', ['name' => 'idx_system_file_isfast'])
            ->save();
    }

    private function _menu()
    {
        // 当前数据表
        $table = 'system_menu';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-菜单',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '上级ID'])
            ->addColumn('title', 'string', ['limit' => 100, 'default' => '', 'comment' => '菜单名称'])
            ->addColumn('icon', 'string', ['limit' => 100, 'default' => '', 'comment' => '菜单图标'])
            ->addColumn('node', 'string', ['limit' => 100, 'default' => '', 'comment' => '节点代码'])
            ->addColumn('url', 'string', ['limit' => 400, 'default' => '', 'comment' => '链接节点'])
            ->addColumn('params', 'string', ['limit' => 500, 'default' => '', 'comment' => '链接参数'])
            ->addColumn('target', 'string', ['limit' => 20, 'default' => '_self', 'comment' => '打开方式'])
            ->addColumn('sort', 'integer', ['limit' => 11, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('pid', ['name' => 'idx_system_menu_pid'])
            ->addIndex('sort', ['name' => 'idx_system_menu_sort'])
            ->addIndex('status', ['name' => 'idx_system_menu_status'])
            ->save();
    }

    private function _node()
    {
        // 当前操作
        $table = 'system_auth_node';

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-授权',
        ])
            ->addColumn('auth', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '角色编号'])
            ->addColumn('node', 'string', ['limit' => 200, 'default' => '', 'comment' => '节点路径'])
            ->addIndex('auth', ['name' => 'idx_system_auth_node_auth'])
            ->addIndex('node', ['name' => 'idx_system_auth_node_node'])
            ->save();
    }

    private function _oplog()
    {
        // 当前数据表
        $table = 'system_oplog';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-日志',
        ])
            ->addColumn('node', 'string', ['limit' => 200, 'default' => '', 'comment' => '当前操作节点'])
            ->addColumn('geoip', 'string', ['limit' => 15, 'default' => '', 'comment' => '操作者IP地址'])
            ->addColumn('action', 'string', ['limit' => 200, 'default' => '', 'comment' => '操作行为名称'])
            ->addColumn('content', 'string', ['limit' => 1024, 'default' => '', 'comment' => '操作内容描述'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '操作人用户名'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _queue()
    {
        // 当前数据表
        $table = 'system_queue';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-任务',
        ])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '任务编号'])
            ->addColumn('title', 'string', ['limit' => 100, 'default' => '', 'comment' => '任务名称'])
            ->addColumn('command', 'string', ['limit' => 500, 'default' => '', 'comment' => '执行指令'])
            ->addColumn('exec_pid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '执行进程'])
            ->addColumn('exec_data', 'text', ['default' => null, 'comment' => '执行参数'])
            ->addColumn('exec_time', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '执行时间'])
            ->addColumn('exec_desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '执行描述'])
            ->addColumn('enter_time', 'decimal', ['precision' => 20, 'scale' => 4, 'default' => '0.0000', 'comment' => '开始时间'])
            ->addColumn('outer_time', 'decimal', ['precision' => 20, 'scale' => 4, 'default' => '0.0000', 'comment' => '结束时间'])
            ->addColumn('loops_time', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '循环时间'])
            ->addColumn('attempts', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '执行次数'])
            ->addColumn('rscript', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '任务类型(0单例,1多例)'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '任务状态(1新任务,2处理中,3成功,4失败)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_system_queue_code'])
            ->addIndex('title', ['name' => 'idx_system_queue_title'])
            ->addIndex('status', ['name' => 'idx_system_queue_status'])
            ->addIndex('rscript', ['name' => 'idx_system_queue_rscript'])
            ->addIndex('exec_time', ['name' => 'idx_system_queue_exec_time'])
            ->addIndex('create_at', ['name' => 'idx_system_queue_create_at'])
            ->save();
    }

    private function _user()
    {
        // 当前数据表
        $table = 'system_user';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-用户',
        ])
            ->addColumn('usertype', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户类型'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户账号'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'comment' => '用户密码'])
            ->addColumn('nickname', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户昵称'])
            ->addColumn('headimg', 'string', ['limit' => 255, 'default' => '', 'comment' => '头像地址'])
            ->addColumn('authorize', 'string', ['limit' => 255, 'default' => '', 'comment' => '权限授权'])
            ->addColumn('contact_qq', 'string', ['limit' => 20, 'default' => '', 'comment' => '联系QQ'])
            ->addColumn('contact_mail', 'string', ['limit' => 50, 'default' => '', 'comment' => '联系邮箱'])
            ->addColumn('contact_phone', 'string', ['limit' => 50, 'default' => '', 'comment' => '联系手机'])
            ->addColumn('login_ip', 'string', ['limit' => 255, 'default' => '', 'comment' => '登录地址'])
            ->addColumn('login_at', 'string', ['limit' => 20, 'default' => '', 'comment' => '登录时间'])
            ->addColumn('login_num', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '登录次数'])
            ->addColumn('describe', 'string', ['limit' => 255, 'default' => '', 'comment' => '备注说明'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('is_deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除(1删除,0未删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_system_user_status'])
            ->addIndex('username', ['name' => 'idx_system_user_username'])
            ->addIndex('is_deleted', ['name' => 'idx_system_user_is_deleted'])
            ->save();
    }
}
