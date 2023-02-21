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

namespace app\data\service;

use app\data\model\BaseUserUpgrade;
use app\data\model\DataUser;
use app\data\model\DataUserBalance;
use app\data\model\ShopOrder;
use app\data\model\ShopOrderItem;
use think\admin\Library;
use think\admin\Service;

/**
 * 用户等级升级服务
 * Class UserUpgradeService
 * @package app\data\service
 */
class UserUpgradeService extends Service
{

    /**
     * 尝试绑定上级代理
     * @param integer $uuid 用户UID
     * @param integer $pid0 代理UID
     * @param integer $mode 操作类型（0临时绑定, 1永久绑定, 2强行绑定）
     * @return array
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function bindAgent(int $uuid, int $pid0 = 0, int $mode = 1): array
    {
        $user = DataUser::mk()->where(['id' => $uuid])->find();
        if (empty($user)) return [0, '查询用户资料失败'];
        if ($user['pids'] && in_array($mode, [0, 1])) return [1, '已经绑定代理'];
        // 检查代理用户
        if (empty($pid0)) $pid0 = $user['pid0'];
        if (empty($pid0)) return [0, '绑定的代理不存在'];
        if ($uuid == $pid0) return [0, '不能绑定自己为代理'];
        // 检查代理资格
        $agent = DataUser::mk()->where(['id' => $pid0])->find();
        if (empty($agent['vip_code'])) return [0, '代理无推荐资格'];
        if (strpos($agent['path'], "-{$uuid}-") !== false) return [0, '不能绑定下属'];
        try {
            Library::$sapp->db->transaction(function () use ($user, $agent, $mode) {
                // 更新用户代理
                $path1 = rtrim($agent['path'] ?: '-', '-') . "-{$agent['id']}-";
                $user->save(['pid0' => $agent['id'], 'pid1' => $agent['id'], 'pid2' => $agent['pid1'], 'pids' => $mode > 0 ? 1 : 0, 'path' => $path1, 'layer' => substr_count($path1, '-')]);
                // 更新下级代理
                $path2 = "{$user['path']}{$user['id']}-";
                if (DataUser::mk()->whereLike('path', "{$path2}%")->count() > 0) {
                    foreach (DataUser::mk()->whereLike('path', "{$path2}%")->order('layer desc')->select() as $item) {
                        $attr = array_reverse(str2arr($path3 = preg_replace("#^{$path2}#", "{$path1}{$user['id']}-", $item['path']), '-'));
                        $item->save(['pid0' => $attr[0] ?? 0, 'pid1' => $attr[0] ?? 0, 'pid2' => $attr[1] ?? 0, 'path' => $path3, 'layer' => substr_count($path3, '-')]);
                    }
                }
            });
            static::upgrade($user['id']);
            return [1, '绑定代理成功'];
        } catch (\Exception $exception) {
            return [0, "绑定代理失败, {$exception->getMessage()}"];
        }
    }

    /**
     * 同步计算用户等级
     * @param integer $uuid 指定用户UID
     * @param boolean $parent 同步计算上级
     * @param ?string $orderNo 升级触发订单
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public static function upgrade(int $uuid, bool $parent = true, ?string $orderNo = null): bool
    {
        $user = DataUser::mk()->where(['id' => $uuid])->find();
        if (empty($user)) return true;
        // 初始化等级参数
        $levels = BaseUserUpgrade::items();
        [$vipName, $vipCode, $vipTeam] = [$levels[0]['name'] ?? '普通用户', 0, []];
        // 统计用户数据
        foreach ($levels as $key => $level) if ($level['upgrade_team'] === 1) $vipTeam[] = $key;
        $orderAmount = ShopOrder::mk()->where("uuid={$uuid} and status>=4")->sum('amount_total');
        $teamsDirect = DataUser::mk()->where(['pid1' => $uuid])->whereIn('vip_code', $vipTeam)->count();
        $teamsIndirect = DataUser::mk()->where(['pid2' => $uuid])->whereIn('vip_code', $vipTeam)->count();
        $teamsUsers = $teamsDirect + $teamsIndirect;
        // 动态计算用户等级
        foreach (array_reverse($levels) as $item) {
            $l1 = empty($item['goods_vip_status']) || $user['buy_vip_entry'] > 0;
            $l2 = empty($item['teams_users_status']) || $item['teams_users_number'] <= $teamsUsers;
            $l3 = empty($item['order_amount_status']) || $item['order_amount_number'] <= $orderAmount;
            $l4 = empty($item['teams_direct_status']) || $item['teams_direct_number'] <= $teamsDirect;
            $l5 = empty($item['teams_indirect_status']) || $item['teams_indirect_number'] <= $teamsIndirect;
            if (
                ($item['upgrade_type'] == 0 && ($l1 || $l2 || $l3 || $l4 || $l5)) /* 满足任何条件可以等级 */
                ||
                ($item['upgrade_type'] == 1 && ($l1 && $l2 && $l3 && $l4 && $l5)) /* 满足所有条件可以等级 */
            ) {
                [$vipName, $vipCode] = [$item['name'], $item['number']];
                break;
            }
        }
        // 购买入会商品升级
        $query = ShopOrderItem::mk()->alias('b')->join('shop_order a', 'b.order_no=a.order_no');
        $tmpCode = $query->whereRaw("a.uuid={$uuid} and a.payment_status=1 and a.status>=4 and b.vip_entry=1")->max('b.vip_upgrade');
        if ($tmpCode > $vipCode && isset($levels[$tmpCode])) {
            [$vipName, $vipCode] = [$levels[$tmpCode]['name'], $levels[$tmpCode]['number']];
        } else {
            $orderNo = null;
        }
        // 后台余额充值升级
        $tmpCode = DataUserBalance::mk()->where(['uuid' => $uuid, 'deleted' => 0])->max('upgrade');
        if ($tmpCode > $vipCode && isset($levels[$tmpCode])) {
            [$vipName, $vipCode] = [$levels[$tmpCode]['name'], $levels[$tmpCode]['number']];
        }
        // 统计用户订单金额
        $orderAmountTotal = ShopOrder::mk()->whereRaw("uuid={$uuid} and status>=4")->sum('amount_goods');
        $teamsAmountDirect = ShopOrder::mk()->whereRaw("puid1={$uuid} and status>=4")->sum('amount_goods');
        $teamsAmountIndirect = ShopOrder::mk()->whereRaw("puid2={$uuid} and status>=4")->sum('amount_goods');
        // 更新用户团队数据
        $data = [
            'vip_name'              => $vipName,
            'vip_code'              => $vipCode,
            'teams_users_total'     => $teamsUsers,
            'teams_users_direct'    => $teamsDirect,
            'teams_users_indirect'  => $teamsIndirect,
            'teams_amount_total'    => $teamsAmountDirect + $teamsAmountIndirect,
            'teams_amount_direct'   => $teamsAmountDirect,
            'teams_amount_indirect' => $teamsAmountIndirect,
            'order_amount_total'    => $orderAmountTotal,
        ];
        if (!empty($orderNo)) $data['vip_order'] = $orderNo;
        if ($data['vip_code'] !== $user['vip_code']) $data['vip_datetime'] = date('Y-m-d H:i:s');
        DataUser::mk()->where(['id' => $uuid])->update($data);
        // 用户升级事件
        if ($user['vip_code'] < $vipCode) Library::$sapp->event->trigger('UserUpgradeLevel', [
            'uuid' => $user['id'], 'order_no' => $orderNo, 'vip_code_old' => $user['vip_code'], 'vip_code_new' => $vipCode,
        ]);
        return !($parent && $user['pid1'] > 0) || static::upgrade($user['pid1'], false);
    }
}