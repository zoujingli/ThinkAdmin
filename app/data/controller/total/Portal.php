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

namespace app\data\controller\total;

use app\data\model\BaseUserUpgrade;
use app\data\model\DataUser;
use app\data\model\DataUserBalance;
use app\data\model\DataUserRebate;
use app\data\model\ShopGoods;
use app\data\model\ShopOrder;
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
        $this->usersTotal = DataUser::mk()->cache(true, 60)->count();
        $this->goodsTotal = ShopGoods::mk()->cache(true, 60)->where(['deleted' => 0])->count();
        $this->orderTotal = ShopOrder::mk()->cache(true, 60)->whereRaw('status >= 4')->count();
        $this->amountTotal = ShopOrder::mk()->cache(true, 60)->whereRaw('status >= 4')->sum('amount_total');
        // 近十天的用户及交易趋势
        $this->days = $this->app->cache->get('portals', []);
        if (empty($this->days)) {
            for ($i = 15; $i >= 0; $i--) {
                $date = date('Y-m-d', strtotime("-{$i}days"));
                $this->days[] = [
                    '当天日期' => date('m-d', strtotime("-{$i}days")),
                    '增加用户' => DataUser::mk()->whereLike('create_at', "{$date}%")->count(),
                    '订单数量' => ShopOrder::mk()->whereLike('create_at', "{$date}%")->whereRaw('status>=4')->count(),
                    '订单金额' => ShopOrder::mk()->whereLike('create_at', "{$date}%")->whereRaw('status>=4')->sum('amount_total'),
                    '返利金额' => DataUserRebate::mk()->whereLike('create_at', "{$date}%")->sum('amount'),
                    '剩余余额' => DataUserBalance::mk()->whereRaw("create_at<='{$date} 23:59:59' and deleted=0")->sum('amount'),
                    '充值余额' => DataUserBalance::mk()->whereLike('create_at', "{$date}%")->whereRaw('amount>0 and deleted=0')->sum('amount'),
                    '消费余额' => DataUserBalance::mk()->whereLike('create_at', "{$date}%")->whereRaw('amount<0 and deleted=0')->sum('amount'),
                ];
            }
            $this->app->cache->set('portals', $this->days, 60);
        }
        // 会员级别分布统计
        $levels = BaseUserUpgrade::mk()->where(['status' => 1])->order('number asc')->column('number code,name,0 count', 'number');
        foreach (DataUser::mk()->field('count(1) count,vip_code level')->group('vip_code')->cursor() as $vo) {
            $levels[$vo['level']]['count'] = isset($levels[$vo['level']]) ? $vo['count'] : 0;
        }
        $this->levels = array_values($levels);
        $this->fetch();
    }
}