<?php

use think\migration\Migrator;

/**
 * 系统用户数据
 */
class SystemUser extends Migrator
{
    protected $name = 'system_user';

    public function change()
    {
        // 创建数据表
        $table = $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-用户',
        ]);
        $table
            ->addColumn('usertype', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户类型'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户账号'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'comment' => '用户密码'])
            ->addColumn('nickname', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户昵称'])
            ->addColumn('headimg', 'string', ['limit' => 500, 'default' => '', 'comment' => '头像地址'])
            ->addColumn('authorize', 'string', ['limit' => 500, 'default' => '', 'comment' => '权限授权'])
            ->addColumn('contact_qq', 'string', ['limit' => 20, 'default' => '', 'comment' => '联系QQ'])
            ->addColumn('contact_mail', 'string', ['limit' => 20, 'default' => '', 'comment' => '联系邮箱'])
            ->addColumn('contact_phone', 'string', ['limit' => 20, 'default' => '', 'comment' => '联系手机'])
            ->addColumn('login_ip', 'string', ['limit' => 20, 'default' => '', 'comment' => '登录地址'])
            ->addColumn('login_at', 'string', ['limit' => 20, 'default' => '', 'comment' => '登录时间'])
            ->addColumn('login_num', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '登录次数'])
            ->addColumn('describe', 'string', ['limit' => 500, 'default' => '', 'comment' => '备注说明'])
            ->addColumn('status', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('is_deleted', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '删除(1删除,0未删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_system_user_status'])
            ->addIndex('username', ['name' => 'idx_system_user_username'])
            ->addIndex('is_deleted', ['name' => 'idx_system_user_deleted'])
            ->save();

        // 初始化默认数据
        $data = [
            'id'       => 10000,
            'username' => 'admin',
            'nickname' => '超级管理员',
            'password' => '21232f297a57a5a743894a0e4a801fc3',
            'headimg'  => 'https://thinkadmin.top/static/img/icon.png',
        ];
        $table->insert($data)->saveData();
    }
}
