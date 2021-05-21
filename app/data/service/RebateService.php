<?php

namespace app\data\service;

use think\admin\Exception;
use think\admin\extend\CodeExtend;
use think\admin\Service;

/**
 * 系统实时返利服务
 * Class RebateService
 * @package app\data\service
 */
class RebateService extends Service
{
    const PRIZE_01 = 'PRIZE01';
    const PRIZE_02 = 'PRIZE02';
    const PRIZE_03 = 'PRIZE03';
    const PRIZE_04 = 'PRIZE04';
    const PRIZE_05 = 'PRIZE05';
    const PRIZE_06 = 'PRIZE06';
    const PRIZE_07 = 'PRIZE07';

    const PRIZES = [
        self::PRIZE_01 => ['code' => self::PRIZE_01, 'name' => '首推奖励', 'func' => '_prize01'],
        self::PRIZE_02 => ['code' => self::PRIZE_02, 'name' => '复购奖励', 'func' => '_prize02'],
        self::PRIZE_03 => ['code' => self::PRIZE_03, 'name' => '直属团队', 'func' => '_prize03'],
        self::PRIZE_04 => ['code' => self::PRIZE_04, 'name' => '间接团队', 'func' => '_prize04'],
        self::PRIZE_05 => ['code' => self::PRIZE_05, 'name' => '差额奖励', 'func' => '_prize05'],
        self::PRIZE_06 => ['code' => self::PRIZE_06, 'name' => '管理奖励', 'func' => '_prize06'],
        self::PRIZE_07 => ['code' => self::PRIZE_07, 'name' => '升级奖励', 'func' => '_prize07'],
    ];

    /**
     * 用户数据
     * @var array
     */
    protected $user;

    /**
     * 订单数据
     * @var array
     */
    protected $order;

    /**
     * 奖励到账时机
     * @var integer
     */
    protected $status;

    /**
     * 推荐用户
     * @var array
     */
    protected $from1;
    protected $from2;

    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserRebate';

    /**
     * 执行订单返利处理
     * @param string $orderNo
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function execute(string $orderNo)
    {
        // 获取订单数据
        $map = ['order_no' => $orderNo, 'payment_status' => 1];
        $this->order = $this->app->db->name('ShopOrder')->where($map)->find();
        if (empty($this->order)) throw new Exception('订单不存在');
        if ($this->order['payment_type'] === 'balance') return;
        // throw new Exception('余额支付不反利');
        // 检查订单参与返利
        if ($this->order['amount_total'] <= 0) throw new Exception('订单金额为零');
        if ($this->order['rebate_amount'] <= 0) throw new Exception('订单返利为零');
        // 获取用户数据
        $map = ['id' => $this->order['uid'], 'deleted' => 0];
        $this->user = $this->app->db->name('DataUser')->where($map)->find();
        if (empty($this->user)) throw new Exception('用户不存在');
        // 获取直接代理数据
        if ($this->order['puid1'] > 0) {
            $map = ['id' => $this->order['puid1']];
            $this->from1 = $this->app->db->name('DataUser')->where($map)->find();
            if (empty($this->from1)) throw new Exception('直接代理不存在');
        }
        // 获取间接代理数据
        if ($this->order['puid2'] > 0) {
            $map = ['id' => $this->order['puid2']];
            $this->from2 = $this->app->db->name('DataUser')->where($map)->find();
            if (empty($this->from2)) throw new Exception('间接代理不存在');
        }
        // 批量发放配置奖励
        foreach (self::PRIZES as $vo) if (method_exists($this, $vo['func'])) {
            $this->app->log->notice("订单 {$orderNo} 开始发放 [{$vo['func']}] {$vo['name']}");
            $this->{$vo['func']}();
            $this->app->log->notice("订单 {$orderNo} 完成发放 [{$vo['func']}] {$vo['name']}");
        }
    }

    /**
     * 返利服务初始化
     * @return void
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function initialize()
    {
        // 返利奖励到账时机
        // settl_type 为 1 支付后立即到账
        // settl_type 为 2 确认后立即到账
        $this->status = $this->config('settl_type') > 1 ? 0 : 1;
    }

    /**
     * 获取配置数据
     * @param ?string $name 配置名称
     * @return array|string
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config(?string $name = null)
    {
        static $data = [];
        if (empty($data)) $data = sysdata('RebateRule');
        return is_null($name) ? $data : ($data[$name] ?? '');
    }

    /**
     * 用户首推奖励
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _prize01(): bool
    {
        if (empty($this->from1)) return false;
        $map = ['order_uid' => $this->user['id']];
        if ($this->app->db->name($this->table)->where($map)->count() > 0) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_01, $this->from1['vip_code'])) return false;
        // 创建返利奖励记录
        $key = "{$this->from1['vip_code']}_{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_01, 'order_no' => $this->order['order_no'], 'order_uid' => $this->order['uid']];
        if ($this->config("frist_state_vip_{$key}") && $this->app->db->name($this->table)->where($map)->count() < 1) {
            $value = $this->config("frist_value_vip_{$key}");
            if ($this->config("frist_type_vip_{$key}") == 1) {
                $val = floatval($value ?: '0.00');
                $name = "{$this->name(self::PRIZE_01)}，每单 {$val} 元";
            } else {
                $val = floatval($value * $this->order['rebate_amount'] / 100);
                $name = "{$this->name(self::PRIZE_01)}，订单 {$value}%";
            }
            // 写入返利记录
            $this->writeRabate($this->from1['id'], $map, $name, $val);
        }
        return true;
    }

    /**
     * 检查等级是否有奖励
     * @param string $prize 奖励规则
     * @param integer $level 用户等级
     * @return boolean
     */
    private function checkPrizeStatus(string $prize, int $level): bool
    {
        $map = [['number', '=', $level], ['rebate_rule', 'like', "%,{$prize},%"]];
        return $this->app->db->name('BaseUserUpgrade')->where($map)->count() > 0;
    }

    /**
     * 获取奖励名称
     * @param string $prize
     * @return string
     */
    public function name(string $prize): string
    {
        return self::PRIZES[$prize]['name'] ?? $prize;
    }

    /**
     * 写返利记录
     * @param int $uid
     * @param array $map
     * @param string $name
     * @param float $amount
     * @throws \think\db\exception\DbException
     */
    private function writeRabate(int $uid, array $map, string $name, float $amount)
    {
        $this->app->db->name($this->table)->insert(array_merge($map, [
            'uid'          => $uid,
            'date'         => date('Y-m-d'),
            'code'         => CodeExtend::uniqidDate(20, 'R'),
            'name'         => $name,
            'amount'       => $amount,
            'status'       => $this->status,
            'order_no'     => $this->order['order_no'],
            'order_uid'    => $this->order['uid'],
            'order_amount' => $this->order['amount_total'],
        ]));
        // 刷新用户返利统计
        UserRebateService::instance()->amount($uid);
    }

    /**
     * 用户复购奖励
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _prize02(): bool
    {
        $map = [];
        $map[] = ['order_uid', '=', $this->user['id']];
        $map[] = ['order_no', '<>', $this->order['order_no']];
        if ($this->app->db->name($this->table)->where($map)->count() < 1) return false;
        // 检查上级可否奖励
        if (empty($this->from1) || empty($this->from1['vip_code'])) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_02, $this->from1['vip_code'])) return false;
        // 创建返利奖励记录
        $key = "vip_{$this->from1['vip_code']}_{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_02, 'order_no' => $this->order['order_no'], 'order_uid' => $this->order['uid']];
        if ($this->config("repeat_state_{$key}") && $this->app->db->name($this->table)->where($map)->count() < 1) {
            $value = $this->config("repeat_value_{$key}");
            if ($this->config("repeat_type_{$key}") == 1) {
                $val = floatval($value ?: '0.00');
                $name = "{$this->name(self::PRIZE_02)}，每人 {$val} 元";
            } else {
                $val = floatval($value * $this->order['rebate_amount'] / 100);
                $name = "{$this->name(self::PRIZE_02)}，订单 {$value}%";
            }
            // 写入返利记录
            $this->writeRabate($this->from1['id'], $map, $name, $val);
        }
        return true;
    }

    /**
     * 用户直属团队
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _prize03(): bool
    {
        if (empty($this->from1)) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_03, $this->from1['vip_code'])) return false;
        // 创建返利奖励记录
        $key = "{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_03, 'order_no' => $this->order['order_no'], 'order_uid' => $this->order['uid']];
        if ($this->config("direct_state_vip_{$key}") && $this->app->db->name($this->table)->where($map)->count() < 1) {
            $value = $this->config("direct_value_vip_{$key}");
            if ($this->config("direct_type_vip_{$key}") == 1) {
                $val = floatval($value ?: '0.00');
                $name = "{$this->name(self::PRIZE_03)}，每人 {$val} 元";
            } else {
                $val = floatval($value * $this->order['rebate_amount'] / 100);
                $name = "{$this->name(self::PRIZE_03)}，订单 {$value}%";
            }
            // 写入返利记录
            $this->writeRabate($this->from1['id'], $map, $name, $val);
        }
        return true;
    }

    /**
     * 用户间接团队
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _prize04(): bool
    {
        if (empty($this->from2)) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_04, $this->from2['vip_code'])) return false;
        $key = "{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_04, 'order_no' => $this->order['order_no'], 'order_uid' => $this->order['uid']];
        if ($this->config("indirect_state_vip_{$key}") && $this->app->db->name($this->table)->where($map)->count() < 1) {
            $value = $this->config("indirect_value_vip_{$key}");
            if ($this->config("indirect_type_vip_{$key}") == 1) {
                $val = floatval($value ?: '0.00');
                $name = "{$this->name(self::PRIZE_03)}，每人 {$val} 元";
            } else {
                $val = floatval($value * $this->order['rebate_amount'] / 100);
                $name = "{$this->name(self::PRIZE_03)}，订单 {$value}%";
            }
            // 写入返利记录
            $this->writeRabate($this->from2['id'], $map, $name, $val);
        }
        return true;
    }

    /**
     * 用户差额奖励
     * @return false
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _prize05(): bool
    {
        $puids = array_reverse(str2arr($this->user['path'], '-'));
        if (empty($puids) || $this->order['amount_total'] <= 0) return false;
        // 获取可以参与奖励的代理
        $vips = $this->app->db->name('BaseUserUpgrade')->whereLike('rebate_rule', '%,' . self::PRIZE_05 . ',%')->column('number');
        $users = $this->app->db->name('DataUser')->whereIn('vip_code', $vips)->whereIn('id', $puids)->orderField('id', $puids)->select()->toArray();
        // 查询需要计算奖励的商品
        foreach ($this->app->db->name('ShopOrderItem')->where(['order_no' => $this->order['order_no']])->cursor() as $item) {
            $itemJson = $this->app->db->name('BaseUserDiscount')->where(['status' => 1, 'deleted' => 0])->value('items');
            if (!empty($itemJson) && is_array($rules = json_decode($itemJson, true))) {
                [$tVip, $tRate] = [$item['vip_code'], $item['discount_rate']];
                foreach ($rules as $rule) if ($rule['level'] > $tVip) foreach ($users as $user) if ($user['vip_code'] > $tVip) {
                    if ($tRate > $rule['discount'] && $tRate < 100) {
                        $map = ['uid' => $user['id'], 'type' => self::PRIZE_05];
                        $map['code'] = "{$this->order['order_no']}#{$item['id']}#{$tVip}.{$user['vip_code']}";
                        if ($this->app->db->name($this->table)->where($map)->count() < 1) {
                            $dRate = ($tRate - $rule['discount']) / 100;
                            $name = "等级差额奖励{$tVip}#{$user['vip_code']}商品的{$dRate}%";
                            $amount = $dRate * $item['total_selling'];
                            // 写入用户返利记录
                            $this->writeRabate($user['id'], $map, $name, $amount);
                        }
                        [$tVip, $tRate] = [$user['vip_code'], $rule['discount']];
                    }
                }
            }
        }
        return true;
    }

    /**
     * 用户管理奖励发放
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _prize06(): bool
    {
        $puids = array_reverse(str2arr($this->user['path'], '-'));
        if (empty($puids) || $this->order['amount_total'] <= 0) return false;
        // 记录原始等级
        $prevLevel = $this->user['vip_code'];
        // 获取可以参与奖励的代理
        $vips = $this->app->db->name('BaseUserUpgrade')->whereLike('rebate_rule', '%,' . self::PRIZE_06 . ',%')->column('number');
        foreach ($this->app->db->name('DataUser')->whereIn('vip_code', $vips)->whereIn('id', $puids)->orderField('id', $puids)->cursor() as $user) {
            if ($user['vip_code'] > $prevLevel) {
                if (($amount = $this->_prize06amount($prevLevel + 1, $user['vip_code'])) > 0.00) {
                    $map = ['uid' => $user['id'], 'type' => self::PRIZE_06, 'order_no' => $this->order['order_no'], 'order_uid' => $this->order['uid']];
                    if ($this->app->db->name($this->table)->where($map)->count() < 1) {
                        $name = "{$this->name(self::PRIZE_06)}，[ VIP{$prevLevel} > VIP{$user['vip_code']} ] 每单 {$amount} 元";
                        $this->writeRabate($user['id'], $map, $name, $amount);
                    }
                }
                $prevLevel = $user['vip_code'];
            }
        }
        return true;
    }

    /**
     * 计算两等级之间的管理奖差异
     * @param integer $prevLevel
     * @param integer $nextLevel
     * @return float
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _prize06amount(int $prevLevel, int $nextLevel): float
    {
        if ($this->config("manage_type_vip_{$nextLevel}") == 2) {
            $amount = 0.00;
            foreach (range($prevLevel, $nextLevel) as $level) {
                [$state, $value] = [$this->config("manage_state_vip_{$level}"), $this->config("manage_value_vip_{$level}")];
                if ($state && $value > 0) $amount += $value;
            }
            return floatval($amount);
        } else {
            if ($this->config("manage_state_vip_{$nextLevel}")) {
                return floatval($this->config("manage_value_vip_{$nextLevel}"));
            } else {
                return floatval(0);
            }
        }
    }

    /**
     * 用户升级奖励发放
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    private function _prize07(): bool
    {
        if (empty($this->from1)) return false;
        if ($this->order['order_no'] !== $this->user['vip_order']) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_07, $this->from1['vip_code'])) return false;
        // 创建返利奖励记录
        $key = "{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_07, 'order_no' => $this->order['order_no'], 'order_uid' => $this->order['uid']];
        if ($this->config("upgrade_state_vip_{$key}") && $this->app->db->name($this->table)->where($map)->count() < 1) {
            $value = $this->config("upgrade_value_vip_{$key}");
            if ($this->config("upgrade_type_vip_{$key}") == 1) {
                $val = floatval($value ?: '0.00');
                $name = "{$this->name(self::PRIZE_07)}，每人 {$val} 元";
            } else {
                $val = floatval($value * $this->order['rebate_amount'] / 100);
                $name = "{$this->name(self::PRIZE_07)}，订单 {$value}%";
            }
            // 写入返利记录
            $this->writeRabate($this->from1['id'], $map, $name, $val);
        }
        return true;
    }
}