<?php

namespace app\data\controller\total;

use think\admin\Controller;

/**
 * 商城数据报表
 * Class Portal
 * @package app\data\controller\total
 */
class Portal extends Controller
{
    /**
     * 商城数据报表
     * @auth true
     * @menu true
     */
    public function index()
    {
        $this->usersTotal = $this->app->db->name('DataUser')->cache(true, 60)->count();
        $this->goodsTotal = $this->app->db->name('ShopGoods')->cache(true, 60)->where(['deleted' => 0])->count();
        $this->orderTotal = $this->app->db->name('ShopOrder')->cache(true, 60)->whereRaw('status >= 4')->count();
        $this->amountTotal = $this->app->db->name('ShopOrder')->cache(true, 60)->whereRaw('status >= 4')->sum('amount_total');
        // 近七天用户及交易趋势
        $this->days = [];
        for ($i = 15; $i >= 0; $i--) {
            $date = date('Y-m-d', strtotime("-{$i}days"));
            $this->days[] = [
                date('m-d', strtotime("-{$i}days")),
                $this->app->db->name('DataUser')->cache(true, 60)->whereLike('create_at', "{$date}%")->count(),
                $this->app->db->name('ShopOrder')->cache(true, 60)->whereLike('create_at', "{$date}%")->whereRaw('status>=4')->count(),
                $this->app->db->name('ShopOrder')->cache(true, 60)->whereLike('create_at', "{$date}%")->whereRaw('status>=4')->sum('amount_total'),
                $this->app->db->name('DataUserRebate')->cache(true, 60)->whereLike('create_at', "{$date}%")->sum('amount'),
            ];
        }
        // 会员级别分布统计
        $levels = $this->app->db->name('BaseUserUpgrade')->where(['status' => 1])->order('number asc')->column('number code,name,0 count', 'number');
        foreach ($this->app->db->name('DataUser')->field('count(1) count,vip_code level')->group('vip_code')->cursor() as $vo) {
            $levels[$vo['level']]['count'] = isset($levels[$vo['level']]) ? $vo['count'] : 0;
        }
        $this->levels = array_values($levels);
        $this->fetch();
    }

}