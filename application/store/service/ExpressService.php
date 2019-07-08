<?php

// +----------------------------------------------------------------------
// | ThinkAdmin
// +----------------------------------------------------------------------
// | 版权所有 2014~2019 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://demo.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | gitee 代码仓库：https://gitee.com/zoujingli/ThinkAdmin
// | github 代码仓库：https://github.com/zoujingli/ThinkAdmin
// +----------------------------------------------------------------------

namespace app\store\service;

use think\Db;

/**
 * 商城邮费服务
 * Class ExpressService
 * @package app\store\service
 */
class ExpressService
{

    /**
     * 订单邮费计算
     * @param string $province 配送省份
     * @param string $number 计费数量
     * @param string $amount 订单金额
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function price($province, $number, $amount)
    {
        // 读取对应的模板规则
        $map = [['is_default', 'eq', '0'], ['rule', 'like', "%{$province}%"]];
        $rule = Db::name('StoreExpressTemplate')->where($map)->find();
        if (!empty($rule)) return self::buildData($rule, '普通模板', $number, $amount);
        $rule = Db::name('StoreExpressTemplate')->where(['is_default' => '1'])->find();
        return self::buildData($rule, '默认模板', $number, $amount);
    }

    /**
     * 生成邮费数据
     * @param array $rule 模板规则
     * @param string $type 模板类型
     * @param integer $number 计费件数
     * @param double $amount 订单金额
     * @return array
     */
    protected static function buildData($rule, $type, $number, $amount)
    {
        // 异常规则
        if (empty($rule)) return [
            'express_price' => 0.00, 'express_type' => '未知模板', 'express_desc' => '未匹配到邮费模板',
        ];
        // 满减免邮
        if ($rule['order_reduction_state'] && $amount >= $rule['order_reduction_price']) {
            return [
                'express_price' => 0.00, 'express_type' => $type,
                'express_desc'  => "订单总金额满{$rule['order_reduction_price']}元减免全部邮费",
            ];
        }
        // 首重计费
        if ($number <= $rule['first_number']) return [
            'express_price' => $rule['first_price'], 'express_type' => $type,
            'express_desc'  => "首件计费，{$rule['first_number']}件及{$rule['first_number']}以内计费{$rule['first_price']}元",
        ];
        // 续重计费
        list($price1, $price2) = [$rule['first_price'], 0];
        if ($rule['next_number'] > 0 && $rule['next_price'] > 0) {
            $price2 = $rule['next_price'] * ceil(($number - $rule['first_number']) / $rule['next_number']);
        }
        return [
            'express_price' => $price1 + $price2, 'express_type' => $type,
            'express_desc'  => "续件计费，超出{$rule['first_number']}件，首件费用{$rule['first_price']}元 + 续件费用{$price2}元",
        ];
    }
}
