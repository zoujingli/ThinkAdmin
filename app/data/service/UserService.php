<?php

namespace app\data\service;

use think\admin\Service;

/**
 * 用户数据接口服务
 * Class UserService
 * @package app\store\service
 */
class UserService extends Service
{
    const APITYPE_WAP = 'wap';
    const APITYPE_WEB = 'web';
    const APITYPE_WXAPP = 'wxapp';
    const APITYPE_WECHAT = 'wechat';
    const APITYPE_IOSAPP = 'iosapp';
    const APITYPE_ANDROID = 'android';

    const TYPES = [
        // 接口通道配置（不需要的直接注释）
        UserService::APITYPE_WAP     => [
            'name' => '手机浏览器',
            'auth' => 'phone',
        ],
        UserService::APITYPE_WEB     => [
            'name' => '电脑浏览器',
            'auth' => 'phone',
        ],
        UserService::APITYPE_IOSAPP  => [
            'name' => '苹果应用',
            'auth' => 'phone',
        ],
        UserService::APITYPE_ANDROID => [
            'name' => '安卓应用',
            'auth' => 'phone',
        ],
        UserService::APITYPE_WXAPP   => [
            'name' => '微信小程序',
            'auth' => 'openid1',
        ],
        UserService::APITYPE_WECHAT  => [
            'name' => '微信服务号',
            'auth' => 'openid2',
        ],
    ];

    /**
     * 认证有效时间
     * @var integer
     */
    private $expire = 7200;

    /**
     * 获取用户数据
     * @param string $type 接口类型
     * @param integer $uuid 用户UID
     * @return array
     */
    public function get(string $type, int $uuid): array
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uuid, 'deleted' => 0])->findOrEmpty();
        $data = $this->app->db->name('DataUserToken')->where(['uid' => $uuid, 'type' => $type])->where(function ($query) {
            $query->where(['tokenv' => ''])->whereOr(['tokenv' => $this->_buildTokenVerify()]);
        })->findOrEmpty();
        $user['token'] = ['token' => $data['token'], 'expire' => $data['time']];
        unset($user['deleted'], $user['password']);
        return $user;
    }

    /**
     * 更新用户用户参数
     * @param array $map 查询条件
     * @param array $data 更新数据
     * @param string $type 接口类型
     * @param boolean $force 强刷令牌
     * @return array
     * @throws \think\db\exception\DbException
     */
    public function set(array $map, array $data, string $type, bool $force = false): array
    {
        unset($data['id'], $data['deleted'], $data['create_at']);
        if ($uuid = $this->app->db->name('DataUser')->where($map)->where(['deleted' => 0])->value('id')) {
            if (!empty($data)) {
                $map = ['id' => $uuid, 'deleted' => 0];
                $this->app->db->name('DataUser')->strict(false)->where($map)->update($data);
            }
        } else {
            $uuid = $this->app->db->name('DataUser')->strict(false)->insertGetId($data);
        }
        if ($force) $this->token(intval($uuid), $type);
        return $this->get($type, $uuid);
    }

    /**
     * 同步刷新用户余额
     * @param int $uuid 用户UID
     * @param array $nots 排除的订单
     * @return array [total,count]
     * @throws \think\db\exception\DbException
     */
    public function balance(int $uuid, array $nots = []): array
    {
        $total = $this->app->db->name('DataUserBalance')->where(['uid' => $uuid, 'deleted' => 0])->sum('amount');
        $total += $this->app->db->name('DataUserBalanceTransfer')->where(['uid' => $uuid, 'deleted' => 0])->sum('amount');
        $count = $this->app->db->name('DataUserBalanceTransfer')->where(['from' => $uuid, 'deleted' => 0])->sum('amount');
        if (empty($nots)) {
            $count += $this->app->db->name('ShopOrder')->whereRaw("uid={$uuid} and status>1")->sum('amount_balance');
            $this->app->db->name('DataUser')->where(['id' => $uuid])->update(['balance_total' => $total, 'balance_used' => $count]);
        } else {
            $count += $this->app->db->name('ShopOrder')->whereRaw("uid={$uuid} and status>1")->whereNotIn('order_no', $nots)->sum('amount_balance');
        }
        return [$total, $count];
    }

    /**
     * 检查 TOKEN 是否有效
     * @param string $type 接口类型
     * @param string $token 认证令牌
     * @param array $data 认证数据
     * @return array [ 检查状态，状态描述，用户UID, 有效时间 ]
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function check(string $type, string $token, array $data = []): array
    {
        if (empty($data)) {
            $map = ['type' => $type, 'token' => $token];
            $data = $this->app->db->name('DataUserToken')->where($map)->find();
        }
        if (empty($data) || empty($data['uid'])) {
            return [0, '请重新登录，登录认证无效', 0, 0];
        } elseif ($data['time'] < time()) {
            return [0, '请重新登录，登录认证失效', 0, 0];
        } elseif ($token !== 'token' && $data['tokenv'] !== $this->_buildTokenVerify()) {
            return [0, '请重新登录，客户端已更换', 0, 0];
        } else {
            $this->expire($type, $token);
            return [1, '登录验证成功', $data['uid'], $data['time']];
        }
    }

    /**
     * 延期 TOKEN 有效时间
     * @param string $type 接口类型
     * @param string $token 授权令牌
     * @throws \think\db\exception\DbException
     */
    public function expire(string $type, string $token)
    {
        $map = ['type' => $type, 'token' => $token];
        $this->app->db->name('DataUserToken')->where($map)->update([
            'time' => time() + $this->expire,
        ]);
    }

    /**
     * 列表绑定用户数据
     * @param array $list 原数据列表
     * @param string $keys 用户UID字段
     * @param string $bind 绑定字段名称
     * @param string $cols 返回用户字段
     * @return array
     */
    public function buildByUid(array &$list, string $keys = 'uid', string $bind = 'user', string $cols = '*'): array
    {
        if (count($list) < 1) return $list;
        $uids = array_unique(array_column($list, $keys));
        $users = $this->app->db->name('DataUser')->whereIn('id', $uids)->column($cols, 'id');
        foreach ($list as &$vo) $vo[$bind] = $users[$vo[$keys]] ?? [];
        return $list;
    }

    /**
     * 获取用户数据统计
     * @param int $uuid 用户UID
     * @return array
     */
    public function total(int $uuid): array
    {
        $query = $this->app->db->name('DataUser');
        return ['my_invite' => $query->where(['pid1' => $uuid])->count()];
    }

    /**
     * 生成新的用户令牌
     * @param int $uuid 授权用户
     * @param string $type 接口类型
     * @return array [创建状态, 状态描述, 令牌数据]
     * @throws \think\db\exception\DbException
     */
    public function token(int $uuid, string $type): array
    {
        // 清理无效认证数据
        $map1 = [['time', '<', $time = time()]];
        $map2 = [['uid', '=', $uuid], ['type', '=', $type]];
        $this->app->db->name('DataUserToken')->whereOr([$map1, $map2])->delete();
        // 创建新的认证数据
        do $map = ['type' => $type, 'token' => md5(uniqid() . rand(100, 999))];
        while ($this->app->db->name('DataUserToken')->where($map)->count() > 0);
        // 写入用户认证数据
        $data = array_merge($map, ['uid' => $uuid, 'time' => $time + $this->expire, 'tokenv' => $this->_buildTokenVerify()]);
        if ($this->app->db->name('DataUserToken')->insert($data) !== false) {
            return [1, '刷新认证成功', $data];
        } else {
            return [0, '刷新认证失败', []];
        }
    }

    /**
     * 同步计算用户级别
     * @param integer $uid 指定用户uid
     * @param boolean $parent 同步计算上级
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function syncLevel(int $uid, bool $parent = true): bool
    {
        $user = $this->app->db->name('DataUser')->where(['id' => $uid])->find();
        if (empty($user)) return true;
        [$vipName, $vipNumber] = ['普通用户', 0];
        // 统计历史数据
        $teamsDirect = $this->app->db->name('DataUser')->where(['pid1' => $uid])->count();
        $teamsIndirect = $this->app->db->name('DataUser')->where(['pid2' => $uid])->count();
        $teamsUsers = $this->app->db->name('DataUser')->whereLike('path', "%-{$uid}-%")->count();
        $orderAmount = $this->app->db->name('ShopOrder')->where(['uid' => $uid])->whereIn('status', [3, 4, 5])->sum('amount_total');
        // 计算用户级别
        foreach ($this->app->db->name('DataUserLevel')->where(['status' => 1])->order('number desc')->cursor() as $item) {
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
                [$vipName, $vipNumber] = [$item['name'], $item['number']];
                break;
            }
        }
        // 购买商品升级
        $query = $this->app->db->name('ShopOrderItem')->alias('b')->join('shop_order a', 'b.order_no=a.order_no');
        $tmpNumber = $query->whereRaw("a.uid={$uid} and a.payment_status=1 and a.status in (3,4,5) and b.vip_entry=1")->max('b.vip_number');
        if ($tmpNumber > $vipNumber) {
            $map = ['number' => $tmpNumber, 'status' => 1];
            $levelInfo = $this->app->db->name('DataUserLevel')->where($map)->find();
            if (!empty($levelInfo)) [$vipNumber, $vipName] = [$levelInfo['number'], $levelInfo['name']];
        }
        // 统计订单统计
        $orderAmountTotal = $this->app->db->name('ShopOrder')->whereRaw("uid={$uid} and status in (3,4,5)")->sum('amount_goods');
        // 统计团队业绩
        $usql = $this->app->db->name('DataUser')->field('id')->whereRaw("`pid1`={$uid}")->buildSql();
        $teamsAmountDirect = $this->app->db->name('ShopOrder')->whereRaw("`from`={$uid} and status in (3,4,5)")->sum('amount_goods');
        $teamsAmountIndirect = $this->app->db->name('ShopOrder')->whereRaw("`from` in {$usql} and status in (3,4,5)")->sum('amount_goods');
        // 更新用户数据
        $data = [
            'vip_name'              => $vipName,
            'vip_number'            => $vipNumber,
            'teams_users_total'     => $teamsUsers,
            'teams_users_direct'    => $teamsDirect,
            'teams_users_indirect'  => $teamsIndirect,
            'teams_amount_total'    => $teamsAmountDirect + $teamsAmountIndirect,
            'teams_amount_direct'   => $teamsAmountDirect,
            'teams_amount_indirect' => $teamsAmountIndirect,
            'order_amount_total'    => $orderAmountTotal,
        ];
        if ($data['vip_number'] !== $user['vip_number']) {
            $data['vip_datetime'] = date('Y-m-d H:i:s');
        }
        $this->app->db->name('DataUser')->where(['id' => $uid])->update($data);
        return ($parent && $user['pid2'] > 0) ? $this->syncLevel($user['pid2'], false) : true;
    }

    /**
     * 获取令牌的认证值
     * @return string
     */
    private function _buildTokenVerify(): string
    {
        return md5($this->app->request->server('HTTP_USER_AGENT', '-'));
    }
}