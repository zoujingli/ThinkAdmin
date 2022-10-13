<?php

use think\migration\Migrator;

/**
 * 用户数据
 */
class InstallUser extends Migrator
{
    public function change()
    {
        $this->_user();
        $this->_token();
        $this->_rebate();
        $this->_address();
        $this->_balance();
        $this->_payment();
        $this->_message();
        $this->_upgrade();
        $this->_transfer();
    }

    private function _user()
    {
        // 当前操作
        $table = "data_user";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户',
        ])
            ->addColumn('pid0', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '临时推荐人UID'])
            ->addColumn('pid1', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '推荐人一级UID'])
            ->addColumn('pid2', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '推荐人二级UID'])
            ->addColumn('pids', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '推荐人绑定状态'])
            ->addColumn('path', 'string', ['limit' => 999, 'default' => '-', 'comment' => '推荐关系路径'])
            ->addColumn('layer', 'integer', ['limit' => 20, 'default' => 1, 'comment' => '推荐关系层级'])
            ->addColumn('openid1', 'string', ['limit' => 50, 'default' => '', 'comment' => '小程序OPENID'])
            ->addColumn('openid2', 'string', ['limit' => 50, 'default' => '', 'comment' => '服务号OPENID'])
            ->addColumn('unionid', 'string', ['limit' => 50, 'default' => '', 'comment' => '公众号UnionID'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户手机'])
            ->addColumn('headimg', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户头像'])
            ->addColumn('username', 'string', ['limit' => 50, 'default' => '', 'comment' => '用户姓名'])
            ->addColumn('nickname', 'string', ['limit' => 99, 'default' => '', 'comment' => '用户昵称'])
            ->addColumn('password', 'string', ['limit' => 32, 'default' => '', 'comment' => '登录密码'])
            ->addColumn('region_province', 'string', ['limit' => 30, 'default' => '', 'comment' => '所在省份'])
            ->addColumn('region_city', 'string', ['limit' => 30, 'default' => '', 'comment' => '所在城市'])
            ->addColumn('region_area', 'string', ['limit' => 30, 'default' => '', 'comment' => '所在区域'])
            ->addColumn('base_age', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户年龄'])
            ->addColumn('base_sex', 'string', ['limit' => 10, 'default' => '', 'comment' => '用户性别'])
            ->addColumn('base_height', 'string', ['limit' => 10, 'default' => '', 'comment' => '用户身高'])
            ->addColumn('base_weight', 'string', ['limit' => 10, 'default' => '', 'comment' => '用户体重'])
            ->addColumn('base_birthday', 'string', ['limit' => 20, 'default' => '', 'comment' => '用户生日'])
            ->addColumn('vip_code', 'integer', ['limit' => 20, 'default' => 0, 'comment' => 'VIP等级编号'])
            ->addColumn('vip_name', 'string', ['limit' => 30, 'default' => '普通用户', 'comment' => 'VIP等级名称'])
            ->addColumn('vip_order', 'string', ['limit' => 20, 'default' => '', 'comment' => 'VIP升级订单'])
            ->addColumn('vip_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => 'VIP等级时间'])
            ->addColumn('buy_vip_entry', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '是否入会礼包'])
            ->addColumn('buy_last_date', 'string', ['limit' => 20, 'default' => '', 'comment' => '最后支付时间'])
            ->addColumn('rebate_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '返利金额统计'])
            ->addColumn('rebate_used', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '返利提现统计'])
            ->addColumn('rebate_lock', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '返利锁定统计'])
            ->addColumn('balance_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '累计充值统计'])
            ->addColumn('balance_used', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '已经使用统计'])
            ->addColumn('teams_users_total', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '团队人数统计'])
            ->addColumn('teams_users_direct', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '直属人数团队'])
            ->addColumn('teams_users_indirect', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '间接人数团队'])
            ->addColumn('order_amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单交易统计'])
            ->addColumn('teams_amount_total', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '二级团队业绩'])
            ->addColumn('teams_amount_direct', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '直属团队业绩'])
            ->addColumn('teams_amount_indirect', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '间接团队业绩'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户备注描述'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '用户状态(1正常,0已黑)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删,1已删)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '注册时间'])
            ->save();
    }

    private function _upgrade()
    {
        // 当前操作
        $table = "base_user_upgrade";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-等级',
        ])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '用户级别名称'])
            ->addColumn('number', 'integer', ['limit' => 2, 'default' => 0, 'comment' => '用户级别序号'])
            ->addColumn('rebate_rule', 'string', ['limit' => 255, 'default' => '', 'comment' => '用户奖利规则'])
            ->addColumn('upgrade_type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '会员升级规则(0单个,1同时)'])
            ->addColumn('upgrade_team', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '团队人数统计(0不计,1累计)'])
            ->addColumn('goods_vip_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '入会礼包状态'])
            ->addColumn('order_amount_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '订单金额状态'])
            ->addColumn('order_amount_number', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单金额累计'])
            ->addColumn('teams_users_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '团队人数状态'])
            ->addColumn('teams_users_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '团队人数累计'])
            ->addColumn('teams_direct_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '直推人数状态'])
            ->addColumn('teams_direct_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '直推人数累计'])
            ->addColumn('teams_indirect_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '间推人数状态'])
            ->addColumn('teams_indirect_number', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '间推人数累计'])
            ->addColumn('remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '用户级别描述'])
            ->addColumn('utime', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '等级更新时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '用户等级状态(1使用,0禁用)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '等级创建时间'])
            ->save();
    }

    private function _transfer()
    {
        $table = "data_user_transfer";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-提现',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('type', 'string', ['limit' => 30, 'default' => '', 'comment' => '提现方式'])
            ->addColumn('date', 'string', ['limit' => 20, 'default' => '', 'comment' => '提现日期'])
            ->addColumn('code', 'string', ['limit' => 100, 'default' => '', 'comment' => '提现单号'])
            ->addColumn('appid', 'string', ['limit' => 100, 'default' => '', 'comment' => '公众号APPID'])
            ->addColumn('openid', 'string', ['limit' => 100, 'default' => '', 'comment' => '公众号OPENID'])
            ->addColumn('charge_rate', 'decimal', ['precision' => 20, 'scale' => 4, 'default' => '0.0000', 'comment' => '提现手续费比例'])
            ->addColumn('charge_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '提现手续费金额'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '提现转账金额'])
            ->addColumn('qrcode', 'string', ['limit' => 999, 'default' => '', 'comment' => '收款码图片地址'])
            ->addColumn('bank_wseq', 'string', ['limit' => 20, 'default' => '', 'comment' => '微信银行编号'])
            ->addColumn('bank_name', 'string', ['limit' => 100, 'default' => '', 'comment' => '开户银行名称'])
            ->addColumn('bank_bran', 'string', ['limit' => 100, 'default' => '', 'comment' => '开户分行名称'])
            ->addColumn('bank_user', 'string', ['limit' => 100, 'default' => '', 'comment' => '开户账号姓名'])
            ->addColumn('bank_code', 'string', ['limit' => 100, 'default' => '', 'comment' => '开户银行卡号'])
            ->addColumn('alipay_user', 'string', ['limit' => 100, 'default' => '', 'comment' => '支付宝姓名'])
            ->addColumn('alipay_code', 'string', ['limit' => 100, 'default' => '', 'comment' => '支付宝账号'])
            ->addColumn('remark', 'string', ['limit' => 200, 'default' => '', 'comment' => '提现描述'])
            ->addColumn('trade_no', 'string', ['limit' => 100, 'default' => '', 'comment' => '交易单号'])
            ->addColumn('trade_time', 'string', ['limit' => 20, 'default' => '', 'comment' => '打款时间'])
            ->addColumn('change_time', 'string', ['limit' => 20, 'default' => '', 'comment' => '处理时间'])
            ->addColumn('change_desc', 'string', ['limit' => 500, 'default' => '', 'comment' => '处理描述'])
            ->addColumn('audit_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '审核状态'])
            ->addColumn('audit_remark', 'string', ['limit' => 500, 'default' => '', 'comment' => '审核描述'])
            ->addColumn('audit_datetime', 'string', ['limit' => 20, 'default' => '', 'comment' => '审核时间'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '提现状态(0失败,1待审核,2已审核,3打款中,4已打款,5已收款)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _token()
    {
        // 当前操作
        $table = "data_user_token";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-认证',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '授权类型'])
            ->addColumn('time', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '有效时间'])
            ->addColumn('token', 'string', ['limit' => 32, 'default' => '', 'comment' => '授权令牌'])
            ->addColumn('tokenv', 'string', ['limit' => 32, 'default' => '', 'comment' => '授权验证'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _rebate()
    {
        // 当前操作
        $table = "data_user_rebate";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-返利',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('date', 'string', ['limit' => 20, 'default' => '', 'comment' => '奖励日期'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '奖励编号'])
            ->addColumn('type', 'string', ['limit' => 20, 'default' => '', 'comment' => '奖励类型'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '奖励名称'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '奖励数量'])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '订单单号'])
            ->addColumn('order_uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '订单用户'])
            ->addColumn('order_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单金额'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '生效状态(0未生效,1已生效)'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态(0未删除,1已删除)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _payment()
    {
        // 当前操作
        $table = "data_user_payment";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-支付',
        ])
            ->addColumn('order_no', 'string', ['limit' => 20, 'default' => '', 'comment' => '订单单号'])
            ->addColumn('order_name', 'string', ['limit' => 255, 'default' => '', 'comment' => '订单描述'])
            ->addColumn('order_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '订单金额'])
            ->addColumn('payment_code', 'string', ['limit' => 20, 'default' => '', 'comment' => '支付编号'])
            ->addColumn('payment_type', 'string', ['limit' => 50, 'default' => '', 'comment' => '支付通道'])
            ->addColumn('payment_trade', 'string', ['limit' => 100, 'default' => '', 'comment' => '支付单号'])
            ->addColumn('payment_status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '支付状态'])
            ->addColumn('payment_amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '支付金额'])
            ->addColumn('payment_datatime', 'string', ['limit' => 20, 'default' => '', 'comment' => '支付时间'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _message()
    {
        // 当前操作
        $table = "data_user_message";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-短信',
        ])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 1, 'comment' => '短信类型'])
            ->addColumn('msgid', 'string', ['limit' => 50, 'default' => '', 'comment' => '消息编号'])
            ->addColumn('phone', 'string', ['limit' => 100, 'default' => '', 'comment' => '目标手机'])
            ->addColumn('region', 'string', ['limit' => 100, 'default' => '', 'comment' => '国家编号'])
            ->addColumn('result', 'string', ['limit' => 100, 'default' => '', 'comment' => '返回结果'])
            ->addColumn('content', 'string', ['limit' => 512, 'default' => '', 'comment' => '短信内容'])
            ->addColumn('status', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '短信状态(0失败,1成功)'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _balance()
    {
        // 当前操作
        $table = "data_user_balance";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-余额',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '充值编号'])
            ->addColumn('name', 'string', ['limit' => 200, 'default' => '', 'comment' => '充值名称'])
            ->addColumn('remark', 'string', ['limit' => 999, 'default' => '', 'comment' => '充值备注'])
            ->addColumn('amount', 'decimal', ['precision' => 20, 'scale' => 2, 'default' => '0.00', 'comment' => '充值金额'])
            ->addColumn('upgrade', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '强制升级'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_by', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '系统用户'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }

    private function _address()
    {
        // 当前操作
        $table = "data_user_address";

        // 创建数据表，存在则跳过
        $this->hasTable($table) || $this->table($table, [
            'engine' => 'InnoDB', 'collation' => 'utf8mb4_general_ci', 'comment' => '数据-用户-收货地址',
        ])
            ->addColumn('uuid', 'integer', ['limit' => 20, 'default' => 0, 'comment' => '用户UID'])
            ->addColumn('type', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '地址类型(0普通,1默认)'])
            ->addColumn('code', 'string', ['limit' => 20, 'default' => '', 'comment' => '地址编号'])
            ->addColumn('name', 'string', ['limit' => 100, 'default' => '', 'comment' => '收货姓名'])
            ->addColumn('phone', 'string', ['limit' => 20, 'default' => '', 'comment' => '收货手机'])
            ->addColumn('idcode', 'string', ['limit' => 255, 'default' => '', 'comment' => '身体证号'])
            ->addColumn('idimg1', 'string', ['limit' => 500, 'default' => '', 'comment' => '身份证正面'])
            ->addColumn('idimg2', 'string', ['limit' => 500, 'default' => '', 'comment' => '身份证反面'])
            ->addColumn('province', 'string', ['limit' => 100, 'default' => '', 'comment' => '地址-省份'])
            ->addColumn('city', 'string', ['limit' => 100, 'default' => '', 'comment' => '地址-城市'])
            ->addColumn('area', 'string', ['limit' => 100, 'default' => '', 'comment' => '地址-区域'])
            ->addColumn('address', 'string', ['limit' => 255, 'default' => '', 'comment' => '地址-详情'])
            ->addColumn('deleted', 'integer', ['limit' => 1, 'default' => 0, 'comment' => '删除状态'])
            ->addColumn('create_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'comment' => '创建时间'])
            ->save();
    }
}
