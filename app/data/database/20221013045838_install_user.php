<?php

// +----------------------------------------------------------------------
// | Shop-Demo for ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2022~2023 Anyon <zoujingli@qq.com>
// +----------------------------------------------------------------------
// | 官方网站: https://thinkadmin.top
// +----------------------------------------------------------------------
// | 免责声明 ( https://thinkadmin.top/disclaimer )
// | 会员免费 ( https://thinkadmin.top/vip-introduce )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', -1);

/**
 * 用户数据
 */
class InstallUser extends Migrator
{
    /**
     * 创建数据库
     */
    public function change()
    {
        $this->_create_base_postage_company();
        $this->_create_base_postage_template();
        $this->_create_base_user_discount();
        $this->_create_base_user_message();
        $this->_create_base_user_payment();
        $this->_create_base_user_upgrade();
        $this->_create_data_news_item();
        $this->_create_data_news_mark();
        $this->_create_data_news_x_collect();
        $this->_create_data_user();
        $this->_create_data_user_address();
        $this->_create_data_user_balance();
        $this->_create_data_user_logger();
        $this->_create_data_user_message();
        $this->_create_data_user_payment();
        $this->_create_data_user_rebate();
        $this->_create_data_user_token();
        $this->_create_data_user_transfer();
        $this->_create_shop_goods();
        $this->_create_shop_goods_cate();
        $this->_create_shop_goods_item();
        $this->_create_shop_goods_mark();
        $this->_create_shop_goods_stock();
        $this->_create_shop_order();
        $this->_create_shop_order_item();
        $this->_create_shop_order_send();
    }

    /**
     * 创建数据对象
     * @class BasePostageCompany
     * @table base_postage_company
     * @return void
     */
    private function _create_base_postage_company()
    {

        // 当前数据表
        $table = 'base_postage_company';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-快递-公司',
        ])
            ->addColumn('name', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '快递公司名称'])
            ->addColumn('code_1', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '快递公司代码'])
            ->addColumn('code_2', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '百度快递100代码'])
            ->addColumn('code_3', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '官方快递100代码'])
            ->addColumn('remark', 'string', ['limit' => 512, 'default' => '', 'null' => true, 'comment' => '快递公司描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '状态(0.无效,1.有效)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(1已删除,0未删除)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code_1', ['name' => 'idx_base_postage_company_code_1'])
            ->addIndex('code_2', ['name' => 'idx_base_postage_company_code_2'])
            ->addIndex('code_3', ['name' => 'idx_base_postage_company_code_3'])
            ->addIndex('status', ['name' => 'idx_base_postage_company_status'])
            ->addIndex('deleted', ['name' => 'idx_base_postage_company_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class BasePostageTemplate
     * @table base_postage_template
     * @return void
     */
    private function _create_base_postage_template()
    {

        // 当前数据表
        $table = 'base_postage_template';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-快递-模板',
        ])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '模板编号'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '模板名称'])
            ->addColumn('normal', 'text', ['default' => null, 'null' => true, 'comment' => '默认规则'])
            ->addColumn('content', 'text', ['default' => null, 'null' => true, 'comment' => '模板规则'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '模板状态'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_base_postage_template_code'])
            ->addIndex('status', ['name' => 'idx_base_postage_template_status'])
            ->addIndex('deleted', ['name' => 'idx_base_postage_template_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class BaseUserDiscount
     * @table base_user_discount
     * @return void
     */
    private function _create_base_user_discount()
    {

        // 当前数据表
        $table = 'base_user_discount';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-基础-折扣',
        ])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '方案名称'])
            ->addColumn('items', 'text', ['default' => null, 'null' => true, 'comment' => '方案规则'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '方案描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '方案状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_base_user_discount_status'])
            ->addIndex('deleted', ['name' => 'idx_base_user_discount_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class BaseUserMessage
     * @table base_user_message
     * @return void
     */
    private function _create_base_user_message()
    {

        // 当前数据表
        $table = 'base_user_message';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-基础-通知',
        ])
            ->addColumn('type', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '消息类型'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '消息名称'])
            ->addColumn('content', 'text', ['default' => null, 'null' => true, 'comment' => '消息内容'])
            ->addColumn('num_read', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '阅读次数'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '消息状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'idx_base_user_message_type'])
            ->addIndex('status', ['name' => 'idx_base_user_message_status'])
            ->addIndex('deleted', ['name' => 'idx_base_user_message_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class BaseUserPayment
     * @table base_user_payment
     * @return void
     */
    private function _create_base_user_payment()
    {

        // 当前数据表
        $table = 'base_user_payment';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-基础-支付',
        ])
            ->addColumn('type', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '支付类型'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '通道编号'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '支付名称'])
            ->addColumn('cover', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '支付图标'])
            ->addColumn('content', 'text', ['default' => null, 'null' => true, 'comment' => '支付参数'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '支付说明'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '支付状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'idx_base_user_payment_type'])
            ->addIndex('code', ['name' => 'idx_base_user_payment_code'])
            ->addIndex('status', ['name' => 'idx_base_user_payment_status'])
            ->addIndex('deleted', ['name' => 'idx_base_user_payment_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class BaseUserUpgrade
     * @table base_user_upgrade
     * @return void
     */
    private function _create_base_user_upgrade()
    {

        // 当前数据表
        $table = 'base_user_upgrade';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-等级',
        ])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '用户级别名称'])
            ->addColumn('number', 'integer', ['limit' => 2, 'default' => 0, 'null' => true, 'comment' => '用户级别序号'])
            ->addColumn('rebate_rule', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '用户奖利规则'])
            ->addColumn('upgrade_type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '会员升级规则(0单个,1同时)'])
            ->addColumn('upgrade_team', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '团队人数统计(0不计,1累计)'])
            ->addColumn('goods_vip_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '入会礼包状态'])
            ->addColumn('order_amount_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '订单金额状态'])
            ->addColumn('order_amount_number', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '订单金额累计'])
            ->addColumn('teams_users_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '团队人数状态'])
            ->addColumn('teams_users_number', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '团队人数累计'])
            ->addColumn('teams_direct_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '直推人数状态'])
            ->addColumn('teams_direct_number', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '直推人数累计'])
            ->addColumn('teams_indirect_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '间推人数状态'])
            ->addColumn('teams_indirect_number', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '间推人数累计'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '用户级别描述'])
            ->addColumn('utime', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '等级更新时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '用户等级状态(1使用,0禁用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '等级创建时间'])
            ->addIndex('status', ['name' => 'idx_base_user_upgrade_status'])
            ->addIndex('number', ['name' => 'idx_base_user_upgrade_number'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataNewsItem
     * @table data_news_item
     * @return void
     */
    private function _create_data_news_item()
    {

        // 当前数据表
        $table = 'data_news_item';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-文章-内容',
        ])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '文章编号'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '文章标题'])
            ->addColumn('mark', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '文章标签'])
            ->addColumn('cover', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '文章封面'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '备注说明'])
            ->addColumn('content', 'text', ['default' => null, 'null' => true, 'comment' => '文章内容'])
            ->addColumn('num_like', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '文章点赞数'])
            ->addColumn('num_read', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '文章阅读数'])
            ->addColumn('num_collect', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '文章收藏数'])
            ->addColumn('num_comment', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '文章评论数'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '文章状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_data_news_item_code'])
            ->addIndex('status', ['name' => 'idx_data_news_item_status'])
            ->addIndex('deleted', ['name' => 'idx_data_news_item_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataNewsMark
     * @table data_news_mark
     * @return void
     */
    private function _create_data_news_mark()
    {

        // 当前数据表
        $table = 'data_news_mark';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-文章-标签',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '标签名称'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '标签说明'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '标签状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_data_news_mark_status'])
            ->addIndex('deleted', ['name' => 'idx_data_news_mark_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataNewsXCollect
     * @table data_news_x_collect
     * @return void
     */
    private function _create_data_news_x_collect()
    {

        // 当前数据表
        $table = 'data_news_x_collect';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-文章-标记',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UID'])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '记录类型(1收藏,2点赞,3历史,4评论)'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '文章编号'])
            ->addColumn('reply', 'text', ['default' => null, 'null' => true, 'comment' => '评论内容'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '记录状态(0无效,1待审核,2已审核)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'idx_data_news_x_collect_type'])
            ->addIndex('code', ['name' => 'idx_data_news_x_collect_code'])
            ->addIndex('status', ['name' => 'idx_data_news_x_collect_status'])
            ->addIndex('uuid', ['name' => 'idx_data_news_x_collect_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUser
     * @table data_user
     * @return void
     */
    private function _create_data_user()
    {

        // 当前数据表
        $table = 'data_user';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-会员',
        ])
            ->addColumn('pid0', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '临时推荐人UID'])
            ->addColumn('pid1', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '推荐人一级UID'])
            ->addColumn('pid2', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '推荐人二级UID'])
            ->addColumn('pids', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '推荐人绑定状态'])
            ->addColumn('path', 'string', ['limit' => 999, 'default' => '-', 'null' => true, 'comment' => '推荐关系路径'])
            ->addColumn('layer', 'integer', ['limit' => 20, 'default' => 1, 'null' => true, 'comment' => '推荐关系层级'])
            ->addColumn('openid1', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '小程序OPENID'])
            ->addColumn('openid2', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '服务号OPENID'])
            ->addColumn('unionid', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '公众号UnionID'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '用户手机'])
            ->addColumn('headimg', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '用户头像'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '用户姓名'])
            ->addColumn('nickname', 'string', ['limit' => 99, 'default' => '', 'null' => true, 'comment' => '用户昵称'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'null' => true, 'comment' => '登录密码'])
            ->addColumn('region_province', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '所在省份'])
            ->addColumn('region_city', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '所在城市'])
            ->addColumn('region_area', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '所在区域'])
            ->addColumn('base_age', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户年龄'])
            ->addColumn('base_sex', 'string', ['limit' => 10, 'default' => '', 'null' => true, 'comment' => '用户性别'])
            ->addColumn('base_height', 'string', ['limit' => 10, 'default' => '', 'null' => true, 'comment' => '用户身高'])
            ->addColumn('base_weight', 'string', ['limit' => 10, 'default' => '', 'null' => true, 'comment' => '用户体重'])
            ->addColumn('base_birthday', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '用户生日'])
            ->addColumn('vip_code', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => 'VIP等级编号'])
            ->addColumn('vip_name', 'string', ['limit' => 30, 'default' => '普通用户', 'null' => true, 'comment' => 'VIP等级名称'])
            ->addColumn('vip_order', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => 'VIP升级订单'])
            ->addColumn('vip_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => 'VIP等级时间'])
            ->addColumn('buy_vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '是否入会礼包'])
            ->addColumn('buy_last_date', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '最后支付时间'])
            ->addColumn('rebate_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '返利金额统计'])
            ->addColumn('rebate_used', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '返利提现统计'])
            ->addColumn('rebate_lock', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '返利锁定统计'])
            ->addColumn('balance_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '累计充值统计'])
            ->addColumn('balance_used', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '已经使用统计'])
            ->addColumn('teams_users_total', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '团队人数统计'])
            ->addColumn('teams_users_direct', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '直属人数团队'])
            ->addColumn('teams_users_indirect', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '间接人数团队'])
            ->addColumn('order_amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '订单交易统计'])
            ->addColumn('teams_amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '二级团队业绩'])
            ->addColumn('teams_amount_direct', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '直属团队业绩'])
            ->addColumn('teams_amount_indirect', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '间接团队业绩'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '用户备注描述'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '用户状态(1正常,0已黑)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '注册时间'])
            ->addIndex('status', ['name' => 'idx_data_user_status'])
            ->addIndex('deleted', ['name' => 'idx_data_user_deleted'])
            ->addIndex('openid1', ['name' => 'idx_data_user_openid1'])
            ->addIndex('openid2', ['name' => 'idx_data_user_openid2'])
            ->addIndex('unionid', ['name' => 'idx_data_user_unionid'])
            ->addIndex('pid1', ['name' => 'idx_data_user_pid1'])
            ->addIndex('pid2', ['name' => 'idx_data_user_pid2'])
            ->addIndex('pid0', ['name' => 'idx_data_user_pid0'])
            ->addIndex('pids', ['name' => 'idx_data_user_pids'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserAddress
     * @table data_user_address
     * @return void
     */
    private function _create_data_user_address()
    {

        // 当前数据表
        $table = 'data_user_address';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-地址',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UID'])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '地址类型(0普通,1默认)'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '地址编号'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '收货姓名'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '收货手机'])
            ->addColumn('idcode', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '身体证号'])
            ->addColumn('idimg1', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '身份证正面'])
            ->addColumn('idimg2', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '身份证反面'])
            ->addColumn('province', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '地址-省份'])
            ->addColumn('city', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '地址-城市'])
            ->addColumn('area', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '地址-区域'])
            ->addColumn('address', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '地址-详情'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'idx_data_user_address_type'])
            ->addIndex('code', ['name' => 'idx_data_user_address_code'])
            ->addIndex('deleted', ['name' => 'idx_data_user_address_deleted'])
            ->addIndex('uuid', ['name' => 'idx_data_user_address_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserBalance
     * @table data_user_balance
     * @return void
     */
    private function _create_data_user_balance()
    {

        // 当前数据表
        $table = 'data_user_balance';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-余额',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UID'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '充值编号'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '充值名称'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '充值备注'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '充值金额'])
            ->addColumn('upgrade', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '强制升级'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_by', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '系统用户'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_data_user_balance_code'])
            ->addIndex('deleted', ['name' => 'idx_data_user_balance_deleted'])
            ->addIndex('uuid', ['name' => 'idx_data_user_balance_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserLogger
     * @table data_user_logger
     * @return void
     */
    private function _create_data_user_logger()
    {

        // 当前数据表
        $table = 'data_user_logger';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-会员',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '登录用户'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '用户手机'])
            ->addColumn('regon_ip', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '登录地址'])
            ->addColumn('region_prov', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '所有省份'])
            ->addColumn('region_city', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '所在城市'])
            ->addColumn('region_area', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '所在区间'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '注册时间'])
            ->addIndex('uuid', ['name' => 'idx_data_user_logger_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserMessage
     * @table data_user_message
     * @return void
     */
    private function _create_data_user_message()
    {

        // 当前数据表
        $table = 'data_user_message';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-短信',
        ])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '短信类型'])
            ->addColumn('msgid', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '消息编号'])
            ->addColumn('phone', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '目标手机'])
            ->addColumn('region', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '国家编号'])
            ->addColumn('result', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '返回结果'])
            ->addColumn('content', 'string', ['limit' => 512, 'default' => '', 'null' => true, 'comment' => '短信内容'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '短信状态(0失败,1成功)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'idx_data_user_message_type'])
            ->addIndex('status', ['name' => 'idx_data_user_message_status'])
            ->addIndex('phone', ['name' => 'idx_data_user_message_phone'])
            ->addIndex('msgid', ['name' => 'idx_data_user_message_msgid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserPayment
     * @table data_user_payment
     * @return void
     */
    private function _create_data_user_payment()
    {

        // 当前数据表
        $table = 'data_user_payment';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-支付',
        ])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '订单单号'])
            ->addColumn('order_name', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '订单描述'])
            ->addColumn('order_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '订单金额'])
            ->addColumn('payment_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '支付编号'])
            ->addColumn('payment_type', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '支付通道'])
            ->addColumn('payment_trade', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '支付单号'])
            ->addColumn('payment_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '支付状态'])
            ->addColumn('payment_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '支付金额'])
            ->addColumn('payment_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '支付时间'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('order_no', ['name' => 'idx_data_user_payment_order_no'])
            ->addIndex('payment_code', ['name' => 'idx_data_user_payment_payment_code'])
            ->addIndex('payment_type', ['name' => 'idx_data_user_payment_payment_type'])
            ->addIndex('payment_trade', ['name' => 'idx_data_user_payment_payment_trade'])
            ->addIndex('payment_status', ['name' => 'idx_data_user_payment_payment_status'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserRebate
     * @table data_user_rebate
     * @return void
     */
    private function _create_data_user_rebate()
    {

        // 当前数据表
        $table = 'data_user_rebate';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-返利',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UID'])
            ->addColumn('date', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '奖励日期'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '奖励编号'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '奖励类型'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '奖励名称'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '奖励数量'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '订单单号'])
            ->addColumn('order_uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '订单用户'])
            ->addColumn('order_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '订单金额'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '生效状态(0未生效,1已生效)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删除,1已删除)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('type', ['name' => 'idx_data_user_rebate_type'])
            ->addIndex('date', ['name' => 'idx_data_user_rebate_date'])
            ->addIndex('code', ['name' => 'idx_data_user_rebate_code'])
            ->addIndex('name', ['name' => 'idx_data_user_rebate_name'])
            ->addIndex('status', ['name' => 'idx_data_user_rebate_status'])
            ->addIndex('uuid', ['name' => 'idx_data_user_rebate_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserToken
     * @table data_user_token
     * @return void
     */
    private function _create_data_user_token()
    {

        // 当前数据表
        $table = 'data_user_token';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-认证',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UID'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '授权类型'])
            ->addColumn('time', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '有效时间'])
            ->addColumn('token', 'string', ['limit' => 32, 'default' => '', 'null' => true, 'comment' => '授权令牌'])
            ->addColumn('tokenv', 'string', ['limit' => 32, 'default' => '', 'null' => true, 'comment' => '授权验证'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('uuid', ['name' => 'idx_data_user_token_uuid'])
            ->addIndex('type', ['name' => 'idx_data_user_token_type'])
            ->addIndex('time', ['name' => 'idx_data_user_token_time'])
            ->addIndex('token', ['name' => 'idx_data_user_token_token'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class DataUserTransfer
     * @table data_user_transfer
     * @return void
     */
    private function _create_data_user_transfer()
    {

        // 当前数据表
        $table = 'data_user_transfer';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-提现',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户UID'])
            ->addColumn('type', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '提现方式'])
            ->addColumn('date', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '提现日期'])
            ->addColumn('code', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '提现单号'])
            ->addColumn('appid', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '公众号APPID'])
            ->addColumn('openid', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '公众号OPENID'])
            ->addColumn('charge_rate', 'decimal', ['precision' => 20, 'scale' => 4, 'default' => '0.0000', 'null' => true, 'comment' => '提现手续费比例'])
            ->addColumn('charge_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '提现手续费金额'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '提现转账金额'])
            ->addColumn('qrcode', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '收款码图片地址'])
            ->addColumn('bank_wseq', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '微信银行编号'])
            ->addColumn('bank_name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '开户银行名称'])
            ->addColumn('bank_bran', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '开户分行名称'])
            ->addColumn('bank_user', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '开户账号姓名'])
            ->addColumn('bank_code', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '开户银行卡号'])
            ->addColumn('alipay_user', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '支付宝姓名'])
            ->addColumn('alipay_code', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '支付宝账号'])
            ->addColumn('remark', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '提现描述'])
            ->addColumn('trade_no', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '交易单号'])
            ->addColumn('trade_time', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '打款时间'])
            ->addColumn('change_time', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '处理时间'])
            ->addColumn('change_desc', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '处理描述'])
            ->addColumn('audit_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '审核状态'])
            ->addColumn('audit_remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '审核描述'])
            ->addColumn('audit_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '审核时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '提现状态(0失败,1待审核,2已审核,3打款中,4已打款,5已收款)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_data_user_transfer_code'])
            ->addIndex('status', ['name' => 'idx_data_user_transfer_status'])
            ->addIndex('date', ['name' => 'idx_data_user_transfer_date'])
            ->addIndex('type', ['name' => 'idx_data_user_transfer_type'])
            ->addIndex('audit_status', ['name' => 'idx_data_user_transfer_audit_status'])
            ->addIndex('appid', ['name' => 'idx_data_user_transfer_appid'])
            ->addIndex('openid', ['name' => 'idx_data_user_transfer_openid'])
            ->addIndex('uuid', ['name' => 'idx_data_user_transfer_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopGoods
     * @table shop_goods
     * @return void
     */
    private function _create_shop_goods()
    {

        // 当前数据表
        $table = 'shop_goods';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-内容',
        ])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商品编号'])
            ->addColumn('name', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '商品名称'])
            ->addColumn('marks', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '商品标签'])
            ->addColumn('cateids', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '分类编号'])
            ->addColumn('cover', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '商品封面'])
            ->addColumn('slider', 'text', ['default' => null, 'null' => true, 'comment' => '轮播图片'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '商品描述'])
            ->addColumn('content', 'text', ['default' => null, 'null' => true, 'comment' => '商品详情'])
            ->addColumn('payment', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '支付方式'])
            ->addColumn('data_specs', 'text', ['default' => null, 'null' => true, 'comment' => '商品规格(JSON)'])
            ->addColumn('data_items', 'text', ['default' => null, 'null' => true, 'comment' => '商品规格(JSON)'])
            ->addColumn('stock_total', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '商品库存统计'])
            ->addColumn('stock_sales', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '商品销售统计'])
            ->addColumn('stock_virtual', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '商品虚拟销量'])
            ->addColumn('price_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '最低销售价格'])
            ->addColumn('price_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '最低市场价格'])
            ->addColumn('discount_id', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '折扣方案编号'])
            ->addColumn('truck_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '物流运费模板'])
            ->addColumn('truck_type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '物流配送(0无需配送,1需要配送)'])
            ->addColumn('rebate_type', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '参与返利(0无需返利,1需要返利)'])
            ->addColumn('vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '入会礼包(0非入会礼包,1是入会礼包)'])
            ->addColumn('vip_upgrade', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '购买升级等级(0不升级,其他升级)'])
            ->addColumn('limit_low_vip', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '限制最低等级(0不限制,其他限制)'])
            ->addColumn('limit_max_num', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '最大购买数量(0不限制,其他限制)'])
            ->addColumn('num_read', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '访问阅读统计'])
            ->addColumn('state_hot', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '设置热度标签'])
            ->addColumn('state_home', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '设置首页推荐'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '列表排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '商品状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('code', ['name' => 'idx_shop_goods_code'])
            ->addIndex('status', ['name' => 'idx_shop_goods_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_goods_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopGoodsCate
     * @table shop_goods_cate
     * @return void
     */
    private function _create_shop_goods_cate()
    {

        // 当前数据表
        $table = 'shop_goods_cate';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-分类',
        ])
            ->addColumn('pid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '上级分类'])
            ->addColumn('name', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '分类名称'])
            ->addColumn('cover', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '分类图标'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '分类描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '使用状态'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_shop_goods_cate_sort'])
            ->addIndex('status', ['name' => 'idx_shop_goods_cate_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_goods_cate_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopGoodsItem
     * @table shop_goods_item
     * @return void
     */
    private function _create_shop_goods_item()
    {

        // 当前数据表
        $table = 'shop_goods_item';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-规格',
        ])
            ->addColumn('goods_sku', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商品SKU'])
            ->addColumn('goods_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商品编号'])
            ->addColumn('goods_spec', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '商品规格'])
            ->addColumn('stock_sales', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '销售数量'])
            ->addColumn('stock_total', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '商品库存'])
            ->addColumn('price_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '销售价格'])
            ->addColumn('price_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '市场价格'])
            ->addColumn('number_virtual', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '虚拟销量'])
            ->addColumn('number_express', 'integer', ['limit' => 20, 'default' => 1, 'null' => true, 'comment' => '配送计件'])
            ->addColumn('reward_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '奖励余额'])
            ->addColumn('reward_integral', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '奖励积分'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '商品状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('goods_code', ['name' => 'idx_shop_goods_item_goods_code'])
            ->addIndex('goods_spec', ['name' => 'idx_shop_goods_item_goods_spec'])
            ->addIndex('status', ['name' => 'idx_shop_goods_item_status'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopGoodsMark
     * @table shop_goods_mark
     * @return void
     */
    private function _create_shop_goods_mark()
    {

        // 当前数据表
        $table = 'shop_goods_mark';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-标签',
        ])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '标签名称'])
            ->addColumn('remark', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '标签描述'])
            ->addColumn('sort', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '排序权重'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '标签状态(1使用,0禁用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('sort', ['name' => 'idx_shop_goods_mark_sort'])
            ->addIndex('status', ['name' => 'idx_shop_goods_mark_status'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopGoodsStock
     * @table shop_goods_stock
     * @return void
     */
    private function _create_shop_goods_stock()
    {

        // 当前数据表
        $table = 'shop_goods_stock';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-商品-库存',
        ])
            ->addColumn('batch_no', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '操作批量'])
            ->addColumn('goods_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商品编号'])
            ->addColumn('goods_spec', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '商品规格'])
            ->addColumn('goods_stock', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '入库数量'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '数据状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_shop_goods_stock_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_goods_stock_deleted'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopOrder
     * @table shop_order
     * @return void
     */
    private function _create_shop_order()
    {

        // 当前数据表
        $table = 'shop_order';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-内容',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '下单用户编号'])
            ->addColumn('puid1', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '推荐一层用户'])
            ->addColumn('puid2', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '推荐二层用户'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商品订单单号'])
            ->addColumn('amount_real', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '订单实际金额'])
            ->addColumn('amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '订单统计金额'])
            ->addColumn('amount_goods', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品统计金额'])
            ->addColumn('amount_reduct', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '随机减免金额'])
            ->addColumn('amount_express', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '快递费用金额'])
            ->addColumn('amount_discount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '折扣后的金额'])
            ->addColumn('payment_type', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '实际支付平台'])
            ->addColumn('payment_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '实际通道编号'])
            ->addColumn('payment_allow', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '允许支付通道'])
            ->addColumn('payment_trade', 'string', ['limit' => 80, 'default' => '', 'null' => true, 'comment' => '实际支付单号'])
            ->addColumn('payment_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '实际支付状态'])
            ->addColumn('payment_image', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '支付凭证图片'])
            ->addColumn('payment_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '实际支付金额'])
            ->addColumn('payment_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '余额抵扣金额'])
            ->addColumn('payment_remark', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '支付结果描述'])
            ->addColumn('payment_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '支付到账时间'])
            ->addColumn('number_goods', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '订单商品数量'])
            ->addColumn('number_express', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '订单快递计数'])
            ->addColumn('truck_type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '物流配送类型(0无需配送,1需要配送)'])
            ->addColumn('rebate_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '参与返利金额'])
            ->addColumn('reward_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '奖励账户余额'])
            ->addColumn('order_remark', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '订单用户备注'])
            ->addColumn('cancel_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '订单取消状态'])
            ->addColumn('cancel_remark', 'string', ['limit' => 200, 'default' => '', 'null' => true, 'comment' => '订单取消描述'])
            ->addColumn('cancel_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '订单取消时间'])
            ->addColumn('deleted_status', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '订单删除状态(0未删,1已删)'])
            ->addColumn('deleted_remark', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '订单删除描述'])
            ->addColumn('deleted_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '订单删除时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '订单流程状态(0已取消,1预订单,2待支付,3支付中,4已支付,5已发货,6已完成)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '订单创建时间'])
            ->addIndex('status', ['name' => 'idx_shop_order_status'])
            ->addIndex('order_no', ['name' => 'idx_shop_order_order_no'])
            ->addIndex('cancel_status', ['name' => 'idx_shop_order_cancel_status'])
            ->addIndex('payment_status', ['name' => 'idx_shop_order_payment_status'])
            ->addIndex('puid1', ['name' => 'idx_shop_order_puid1'])
            ->addIndex('deleted_status', ['name' => 'idx_shop_order_deleted_status'])
            ->addIndex('uuid', ['name' => 'idx_shop_order_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopOrderItem
     * @table shop_order_item
     * @return void
     */
    private function _create_shop_order_item()
    {

        // 当前数据表
        $table = 'shop_order_item';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-商品',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '商城用户编号'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商城订单单号'])
            ->addColumn('goods_sku', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商城商品SKU'])
            ->addColumn('goods_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商城商品编号'])
            ->addColumn('goods_spec', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '商城商品规格'])
            ->addColumn('goods_name', 'string', ['limit' => 250, 'default' => '', 'null' => true, 'comment' => '商城商品名称'])
            ->addColumn('goods_cover', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '商品封面图片'])
            ->addColumn('goods_payment', 'string', ['limit' => 999, 'default' => '', 'null' => true, 'comment' => '指定支付通道'])
            ->addColumn('price_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品市场单价'])
            ->addColumn('price_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品销售单价'])
            ->addColumn('total_market', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品市场总价'])
            ->addColumn('total_selling', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品销售总价'])
            ->addColumn('reward_balance', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品奖励余额'])
            ->addColumn('reward_integral', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品奖励积分'])
            ->addColumn('stock_sales', 'integer', ['limit' => 20, 'default' => 1, 'null' => true, 'comment' => '包含商品数量'])
            ->addColumn('vip_name', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '用户等级名称'])
            ->addColumn('vip_code', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '用户等级序号'])
            ->addColumn('vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '是否入会礼包(0非礼包,1是礼包)'])
            ->addColumn('vip_upgrade', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '升级用户等级'])
            ->addColumn('truck_type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '物流配送类型(0虚物,1实物)'])
            ->addColumn('truck_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '快递邮费模板'])
            ->addColumn('truck_number', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '快递计费基数'])
            ->addColumn('rebate_type', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '参与返利状态(0不返,1返利)'])
            ->addColumn('rebate_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '参与返利金额'])
            ->addColumn('discount_id', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '优惠方案编号'])
            ->addColumn('discount_rate', 'decimal', ['precision' => 20, 'scale' => 6, 'default' => '100.000000', 'null' => true, 'comment' => '销售价格折扣'])
            ->addColumn('discount_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '商品优惠金额'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '商品状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '订单创建时间'])
            ->addIndex('status', ['name' => 'idx_shop_order_item_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_order_item_deleted'])
            ->addIndex('order_no', ['name' => 'idx_shop_order_item_order_no'])
            ->addIndex('goods_sku', ['name' => 'idx_shop_order_item_goods_sku'])
            ->addIndex('goods_code', ['name' => 'idx_shop_order_item_goods_code'])
            ->addIndex('goods_spec', ['name' => 'idx_shop_order_item_goods_spec'])
            ->addIndex('rebate_type', ['name' => 'idx_shop_order_item_rebate_type'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

    /**
     * 创建数据对象
     * @class ShopOrderSend
     * @table shop_order_send
     * @return void
     */
    private function _create_shop_order_send()
    {

        // 当前数据表
        $table = 'shop_order_send';

        // 存在则跳过
        if ($this->hasTable($table)) return;

        // 创建数据表
        $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '商城-订单-配送',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '商城用户编号'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '商城订单单号'])
            ->addColumn('address_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '配送地址编号'])
            ->addColumn('address_name', 'string', ['limit' => 50, 'default' => '', 'null' => true, 'comment' => '配送收货人姓名'])
            ->addColumn('address_phone', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '配送收货人手机'])
            ->addColumn('address_idcode', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '配送收货人证件号码'])
            ->addColumn('address_idimg1', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '配送收货人证件正面'])
            ->addColumn('address_idimg2', 'string', ['limit' => 500, 'default' => '', 'null' => true, 'comment' => '配送收货人证件反面'])
            ->addColumn('address_province', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '配送地址的省份'])
            ->addColumn('address_city', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '配送地址的城市'])
            ->addColumn('address_area', 'string', ['limit' => 30, 'default' => '', 'null' => true, 'comment' => '配送地址的区域'])
            ->addColumn('address_content', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '配送的详细地址'])
            ->addColumn('address_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '地址确认时间'])
            ->addColumn('template_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '配送模板编号'])
            ->addColumn('template_count', 'integer', ['limit' => 20, 'default' => 0, 'null' => true, 'comment' => '快递计费基数'])
            ->addColumn('template_remark', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '配送计算描述'])
            ->addColumn('template_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'null' => true, 'comment' => '配送计算金额'])
            ->addColumn('company_code', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '快递公司编码'])
            ->addColumn('company_name', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '快递公司名称'])
            ->addColumn('send_number', 'string', ['limit' => 100, 'default' => '', 'null' => true, 'comment' => '快递运送单号'])
            ->addColumn('send_remark', 'string', ['limit' => 255, 'default' => '', 'null' => true, 'comment' => '快递发送备注'])
            ->addColumn('send_datetime', 'string', ['limit' => 20, 'default' => '', 'null' => true, 'comment' => '快递发送时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'null' => true, 'comment' => '发货商品状态(1使用,0禁用)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'null' => true, 'comment' => '发货删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => true, 'comment' => '创建时间'])
            ->addIndex('status', ['name' => 'idx_shop_order_send_status'])
            ->addIndex('deleted', ['name' => 'idx_shop_order_send_deleted'])
            ->addIndex('order_no', ['name' => 'idx_shop_order_send_order_no'])
            ->addIndex('uuid', ['name' => 'idx_shop_order_send_uuid'])
            ->save();

        // 修改主键长度
        $this->table($table)->changeColumn('id', 'integer', ['limit' => 20, 'identity' => true]);
    }

}
