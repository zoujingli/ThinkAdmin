<?php

use think\migration\Migrator;
use think\migration\db\Column;

class SystemUser extends Migrator
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        $table = $this->table('system_user1', ['comment' => '系统-用户', 'collation' => 'utf8mb4_general_ci']);
        $table
            ->addColumn('usertype', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户类型'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户账号'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'comment' => '用户密码'])
            ->addColumn('nickname', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户昵称'])
            ->addColumn('headimg', 'string', ['limit' => 255, 'default' => '', 'comment' => '头像地址'])
            ->addColumn('authorize', 'string', ['limit' => 255, 'default' => '', 'comment' => '权限授权'])
            ->addColumn('contact_qq', 'string', ['limit' => 20, 'default' => '', 'comment' => '联系QQ'])
            ->addColumn('contact_mail', 'string', ['limit' => 20, 'default' => '', 'comment' => '联系邮箱'])
            ->addColumn('contact_phone', 'string', ['limit' => 20, 'default' => '', 'comtent' => '联系手机'])
            ->addColumn('login_ip', 'string', ['limit' => 20, 'default' => '', 'comment' => '登录地址'])
            ->addColumn('login_at', 'string', ['limit' => 20, 'default' => '', 'comment' => '登录时间'])
            ->addColumn('login_num', 'bigint', ['limit' => 20, 'default' => 0, 'comment' => '登录次数'])
            ->addColumn('describe', 'string', ['limit' => 255, 'default' => '', 'comment' => '备注说明'])
            ->addColumn('status', 'bigint', ['limit' => 20, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('sort', 'bigint', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('is_deleted', 'bigint', ['limit' => 20, 'default' => 0, 'comment' => '删除(1删除,0未删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_system_user_status'])
            ->addIndex('username', ['name' => 'idx_system_user_username'])
            ->addIndex('is_deleted', ['name' => 'idx_system_user_deleted'])
            ->save();
    }
}
