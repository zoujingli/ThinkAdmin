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

use think\admin\extend\PhinxExtend;
use think\migration\Migrator;

@set_time_limit(0);
@ini_set('memory_limit', -1);

/**
 * 数据库初始化
 */
class InstallUserData extends Migrator
{
    /**
     * @return void
     */
    public function change()
    {
        $this->insertMenu();
    }

    /**
     * 创建菜单
     * @return void
     */
    protected function insertMenu()
    {
        PhinxExtend::write2menu([
            [
                'name' => '控制台',
                'sort' => '300',
                'subs' => [
                    [
                        'name' => '数据管理',
                        'subs' => [
                            ['name' => '数据统计报表', 'icon' => 'layui-icon layui-icon-theme', 'node' => 'data/total.portal/index'],
                            ['name' => '轮播图片管理', 'icon' => 'layui-icon layui-icon-carousel', 'node' => 'data/base.slider/index'],
                            ['name' => '页面内容管理', 'icon' => 'layui-icon layui-icon-read', 'node' => 'data/base.pager/index'],
                            ['name' => '文章内容管理', 'icon' => 'layui-icon layui-icon-template', 'node' => 'data/news.item/index'],
                            ['name' => '支付参数管理', 'icon' => 'layui-icon layui-icon-rmb', 'node' => 'data/base.payment/index'],
                            ['name' => '系统通知管理', 'icon' => 'layui-icon layui-icon-notice', 'node' => 'data/base.message/index'],
                            ['name' => '微信小程序配置', 'icon' => 'layui-icon layui-icon-set', 'node' => 'data/base.config/wxapp'],
                            ['name' => '邀请二维码设置', 'icon' => 'layui-icon layui-icon-cols', 'node' => 'data/base.config/cropper'],
                        ],
                    ],
                    [
                        'name' => '用户管理',
                        'subs' => [
                            ['name' => '会员用户管理', 'icon' => 'layui-icon layui-icon-user', 'node' => 'data/user.admin/index'],
                            ['name' => '余额充值管理', 'icon' => 'layui-icon layui-icon-rmb', 'node' => 'data/user.balance/index'],
                            ['name' => '用户返利管理', 'icon' => 'layui-icon layui-icon-transfer', 'node' => 'data/user.rebate/index'],
                            ['name' => '用户提现管理', 'icon' => 'layui-icon layui-icon-component', 'node' => 'data/user.transfer/index'],
                            ['name' => '用户等级管理', 'icon' => 'layui-icon layui-icon-senior', 'node' => 'data/base.upgrade/index'],
                            ['name' => '用户折扣方案', 'icon' => 'layui-icon layui-icon-set', 'node' => 'data/base.discount/index'],
                        ],
                    ],
                    [
                        'name' => '商城管理',
                        'subs' => [
                            ['name' => '商品数据管理', 'icon' => 'layui-icon layui-icon-star', 'node' => 'data/shop.goods/index'],
                            ['name' => '商品分类管理', 'icon' => 'layui-icon layui-icon-tabs', 'node' => 'data/shop.cate/index'],
                            ['name' => '订单数据管理', 'icon' => 'layui-icon layui-icon-template', 'node' => 'data/shop.order/index'],
                            ['name' => '订单发货管理', 'icon' => 'layui-icon layui-icon-transfer', 'node' => 'data/shop.send/index'],
                            ['name' => '快递公司管理', 'icon' => 'layui-icon layui-icon-website', 'node' => 'data/base.postage.company/index'],
                            ['name' => '邮费模板管理', 'icon' => 'layui-icon layui-icon-template-1', 'node' => 'data/base.postage.template/index'],
                        ],
                    ],
                ],
            ],
        ], ['node' => 'data/user.admin/index']);
    }
}
