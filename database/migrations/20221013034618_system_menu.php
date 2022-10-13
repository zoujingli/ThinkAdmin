<?php

use think\migration\Migrator;

/**
 * 系统菜单数据
 */
class SystemMenu extends Migrator
{
    private $name = 'system_menu';

    public function change()
    {
        // 存在则跳过
        if ($this->hasTable($this->name)) {
            return;
        }
        // 创建数据表
        $this->table($this->name, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '系统-菜单',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '上级编号'])
            ->addColumn('title', 'string', ['limit' => 100, 'default' => '', 'comment' => '菜单名称'])
            ->addColumn('icon', 'string', ['limit' => 100, 'default' => '', 'comment' => '菜单图标'])
            ->addColumn('node', 'string', ['limit' => 100, 'default' => '', 'comment' => '节点代码'])
            ->addColumn('url', 'string', ['limit' => 500, 'default' => '', 'comment' => '链接节点'])
            ->addColumn('params', 'string', ['limit' => 500, 'default' => '', 'comment' => '链接参数'])
            ->addColumn('target', 'string', ['limit' => 20, 'default' => '_self', 'comment' => '打开方式'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '状态(0禁用,1启用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->addIndex('pid', ['name' => 'idx_system_menu_pid'])
            ->addIndex('sort', ['name' => 'idx_system_menu_sort'])
            ->addIndex('status', ['name' => 'idx_system_menu_status'])
            ->save();

        // 初始化菜单数据
        $this->execute(<<<SQL
INSERT INTO {$this->name} VALUES (1, 0, '控制台', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (2, 1, '数据管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (3, 2, '数据统计报表', 'layui-icon layui-icon-theme', 'data/total.portal/index', 'data/total.portal/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (4, 2, '轮播图片管理', 'layui-icon layui-icon-carousel', 'data/base.slider/index', 'data/base.slider/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (5, 2, '页面内容管理', 'layui-icon layui-icon-read', 'data/base.pager/index', 'data/base.pager/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (6, 2, '文章内容管理', 'layui-icon layui-icon-template', 'data/news.item/index', 'data/news.item/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (7, 2, '支付参数管理', 'layui-icon layui-icon-rmb', 'data/base.payment/index', 'data/base.payment/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (8, 2, '系统通知管理', 'layui-icon layui-icon-notice', 'data/base.message/index', 'data/base.message/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (9, 2, '微信小程序配置', 'layui-icon layui-icon-set', 'data/base.config/wxapp', 'data/base.config/wxapp', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (10, 2, '邀请二维码设置', 'layui-icon layui-icon-cols', 'data/base.config/cropper', 'data/base.config/cropper', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (11, 1, '用户管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (12, 11, '会员用户管理', 'layui-icon layui-icon-user', 'data/user.admin/index', 'data/user.admin/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (13, 11, '余额充值管理', 'layui-icon layui-icon-rmb', 'data/user.balance/index', 'data/user.balance/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (14, 11, '用户返利管理', 'layui-icon layui-icon-transfer', 'data/user.rebate/index', 'data/user.rebate/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (15, 11, '用户提现管理', 'layui-icon layui-icon-component', 'data/user.transfer/index', 'data/user.transfer/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (16, 11, '用户等级管理', 'layui-icon layui-icon-senior', 'data/base.upgrade/index', 'data/base.upgrade/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (17, 11, '用户折扣方案', 'layui-icon layui-icon-set', 'data/base.discount/index', 'data/base.discount/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (18, 1, '商城管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (19, 18, '商品数据管理', 'layui-icon layui-icon-star', 'data/shop.goods/index', 'data/shop.goods/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (20, 18, '商品分类管理', 'layui-icon layui-icon-tabs', 'data/shop.cate/index', 'data/shop.cate/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (21, 18, '订单数据管理', 'layui-icon layui-icon-template', 'data/shop.order/index', 'data/shop.order/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (22, 18, '订单发货管理', 'layui-icon layui-icon-transfer', 'data/shop.send/index', 'data/shop.send/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (23, 18, '快递公司管理', 'layui-icon layui-icon-website', 'data/base.postage.company/index', 'data/base.postage.company/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (24, 18, '邮费模板管理', 'layui-icon layui-icon-template-1', 'data/base.postage.template/index', 'data/base.postage.template/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (25, 0, '微信管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (26, 25, '微信管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (27, 26, '微信接口配置', 'layui-icon layui-icon-set', '', 'wechat/config/options', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (28, 26, '微信支付配置', 'layui-icon layui-icon-rmb', '', 'wechat/config/payment', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (29, 25, '微信定制', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (30, 29, '微信粉丝管理', 'layui-icon layui-icon-username', '', 'wechat/fans/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (31, 29, '微信菜单配置', 'layui-icon layui-icon-cellphone', '', 'wechat/menu/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (32, 29, '微信图文管理', 'layui-icon layui-icon-template-1', '', 'wechat/news/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (33, 29, '回复规则管理', 'layui-icon layui-icon-engine', '', 'wechat/keys/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (34, 29, '关注自动回复', 'layui-icon layui-icon-release', 'wechat/auto/index', 'wechat/auto/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (35, 0, '系统管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (36, 35, '系统配置', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (37, 36, '系统参数配置', 'layui-icon layui-icon-set', '', 'admin/config/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (38, 36, '系统任务管理', 'layui-icon layui-icon-log', '', 'admin/queue/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (39, 36, '系统日志管理', 'layui-icon layui-icon-form', '', 'admin/oplog/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (40, 36, '数据字典管理', 'layui-icon layui-icon-code-circle', 'admin/base/index', 'admin/base/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (41, 36, '系统文件管理', 'layui-icon layui-icon-carousel', 'admin/file/index', 'admin/file/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (42, 36, '系统菜单管理', 'layui-icon layui-icon-layouts', '', 'admin/menu/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (43, 35, '权限管理', '', '', '#', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (44, 43, '访问权限管理', 'layui-icon layui-icon-vercode', '', 'admin/auth/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
INSERT INTO {$this->name} VALUES (45, 43, '系统用户管理', 'layui-icon layui-icon-username', '', 'admin/user/index', '', '_self', 0, 1, '2022-10-13 12:19:45');
SQL
        );
    }
}
