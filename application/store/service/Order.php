<?php

// +----------------------------------------------------------------------
// | framework
// +----------------------------------------------------------------------
// | 版权所有 2014~2018 广州楚才信息科技有限公司 [ http://www.cuci.cc ]
// +----------------------------------------------------------------------
// | 官方网站: http://framework.thinkadmin.top
// +----------------------------------------------------------------------
// | 开源协议 ( https://mit-license.org )
// +----------------------------------------------------------------------
// | github开源项目：https://github.com/zoujingli/framework
// +----------------------------------------------------------------------

namespace app\store\service;

use think\Db;

/**
 * 订单服务管理器
 * Class Order
 * @package app\store\service
 */
class Order
{
    /**
     * 根据订单号升级会员等级
     * @param string $order_no 订单单号
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public static function update($order_no)
    {
        // @todo 更新订单状态
    }

    /**
     * 根据订单同步库存销量
     * @param string $order_no
     * @return boolean
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public static function syncStock($order_no)
    {
        $map = ['order_no' => $order_no];
        $goodsIds = Db::name('StoreOrderList')->where($map)->column('goods_id');
        foreach (array_unique($goodsIds) as $goodsId) if (!Goods::syncStock($goodsId)) return false;
        return true;
    }

    /**
     * 订单利润计算
     * @param string $order_no
     * @return boolean
     */
    public static function profit($order_no = '')
    {
        // @todo 计算订单返佣
    }
}