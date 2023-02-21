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

use app\data\model\BaseUserDiscount;
use app\data\model\BaseUserUpgrade;
use app\data\model\DataUser;
use app\data\model\DataUserRebate;
use app\data\model\ShopOrder;
use app\data\model\ShopOrderItem;
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
    const PRIZE_08 = 'PRIZE08';

    const PRIZES = [
        self::PRIZE_01 => ['code' => self::PRIZE_01, 'name' => '首推奖励', 'func' => '_prize01'],
        self::PRIZE_02 => ['code' => self::PRIZE_02, 'name' => '复购奖励', 'func' => '_prize02'],
        self::PRIZE_03 => ['code' => self::PRIZE_03, 'name' => '直属团队', 'func' => '_prize03'],
        self::PRIZE_04 => ['code' => self::PRIZE_04, 'name' => '间接团队', 'func' => '_prize04'],
        self::PRIZE_05 => ['code' => self::PRIZE_05, 'name' => '差额奖励', 'func' => '_prize05'],
        self::PRIZE_06 => ['code' => self::PRIZE_06, 'name' => '管理奖励', 'func' => '_prize06'],
        self::PRIZE_07 => ['code' => self::PRIZE_07, 'name' => '升级奖励', 'func' => '_prize07'],
        self::PRIZE_08 => ['code' => self::PRIZE_08, 'name' => '平推返利', 'func' => '_prize08'],
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
     * 执行订单返利处理
     * @param string $orderNo
     * @throws \think\admin\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function execute(string $orderNo)
    {
        // 获取订单数据
        $map = ['order_no' => $orderNo, 'payment_status' => 1];
        $this->order = ShopOrder::mk()->where($map)->findOrEmpty();
        if ($this->order->isEmpty()) throw new Exception('订单不存在');
        if ($this->order['payment_type'] === 'balance') return;
        if ($this->order['amount_total'] <= 0) throw new Exception('订单金额为零');
        if ($this->order['rebate_amount'] <= 0) throw new Exception('订单返利为零');
        // 获取用户数据
        $map = ['id' => $this->order['uuid'], 'deleted' => 0];
        $this->user = DataUser::mk()->where($map)->findOrEmpty();
        if ($this->user->isEmpty()) throw new Exception('用户不存在');
        // 获取直接代理数据
        if ($this->order['puid1'] > 0) {
            $this->from1 = DataUser::mk()->find($this->order['puid1']);
            if (empty($this->from1)) throw new Exception('直接代理不存在');
        }
        // 获取间接代理数据
        if ($this->order['puid2'] > 0) {
            $this->from2 = DataUser::mk()->find($this->order['puid2']);
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
        $map = ['order_uuid' => $this->user['id']];
        if (DataUserRebate::mk()->where($map)->count() > 0) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_01, $this->from1['vip_code'])) return false;
        // 创建返利奖励记录
        $key = "{$this->from1['vip_code']}_{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_01, 'order_no' => $this->order['order_no'], 'order_uuid' => $this->order['uuid']];
        if ($this->config("frist_state_vip_{$key}") && DataUserRebate::mk()->where($map)->count() < 1) {
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
     * 用户复购奖励
     * @return boolean
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    protected function _prize02(): bool
    {
        $map = [];
        $map[] = ['order_uuid', '=', $this->user['id']];
        $map[] = ['order_no', '<>', $this->order['order_no']];
        if (DataUserRebate::mk()->where($map)->count() < 1) return false;
        // 检查上级可否奖励
        if (empty($this->from1) || empty($this->from1['vip_code'])) return false;
        if (!$this->checkPrizeStatus(self::PRIZE_02, $this->from1['vip_code'])) return false;
        // 创建返利奖励记录
        $key = "vip_{$this->from1['vip_code']}_{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_02, 'order_no' => $this->order['order_no'], 'order_uuid' => $this->order['uuid']];
        if ($this->config("repeat_state_{$key}") && DataUserRebate::mk()->where($map)->count() < 1) {
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
        $map = ['type' => self::PRIZE_03, 'order_no' => $this->order['order_no'], 'order_uuid' => $this->order['uuid']];
        if ($this->config("direct_state_vip_{$key}") && DataUserRebate::mk()->where($map)->count() < 1) {
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
        $map = ['type' => self::PRIZE_04, 'order_no' => $this->order['order_no'], 'order_uuid' => $this->order['uuid']];
        if ($this->config("indirect_state_vip_{$key}") && DataUserRebate::mk()->where($map)->count() < 1) {
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
        $vips = BaseUserUpgrade::mk()->whereLike('rebate_rule', '%,' . self::PRIZE_05 . ',%')->column('number');
        $users = DataUser::mk()->whereIn('vip_code', $vips)->whereIn('id', $puids)->orderField('id', $puids)->select()->toArray();
        if (empty($vips) || empty($users)) return true;
        // 查询需要计算奖励的商品
        foreach (ShopOrderItem::mk()->where(['order_no' => $this->order['order_no']])->cursor() as $item) {
            if ($item['discount_id'] > 0 && $item['rebate_type'] === 1) {
                [$tVip, $tRate] = [$item['vip_code'], $item['discount_rate']];
                $map = ['id' => $item['discount_id'], 'status' => 1, 'deleted' => 0];
                $rules = json_decode(BaseUserDiscount::mk()->where($map)->value('items', '[]'), true);
                foreach ($users as $user) if (isset($rules[$user['vip_code']]) && $user['vip_code'] > $tVip) {
                    if (($rule = $rules[$user['vip_code']]) && $tRate > $rule['discount']) {
                        $map = ['uuid' => $user['id'], 'type' => self::PRIZE_05, 'order_no' => $this->order['order_no']];
                        if (DataUserRebate::mk()->where($map)->count() < 1) {
                            $dRate = ($rate = $tRate - $rule['discount']) / 100;
                            $name = "等级差额奖励{$tVip}#{$user['vip_code']}商品原价{$item['total_selling']}元的{$rate}%";
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
        // 记录用户原始等级
        $prevLevel = $this->user['vip_code'];
        // 获取参与奖励的代理
        $vips = BaseUserUpgrade::mk()->whereLike('rebate_rule', '%,' . self::PRIZE_06 . ',%')->column('number');
        foreach (DataUser::mk()->whereIn('vip_code', $vips)->whereIn('id', $puids)->orderField('id', $puids)->cursor() as $user) {
            if ($user['vip_code'] > $prevLevel) {
                if (($amount = $this->_prize06amount($prevLevel + 1, $user['vip_code'])) > 0.00) {
                    $map = ['uuid' => $user['id'], 'type' => self::PRIZE_06, 'order_no' => $this->order['order_no']];
                    if (DataUserRebate::mk()->where($map)->count() < 1) {
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
     * @param integer $prevLevel 上个等级
     * @param integer $nextLevel 下个等级
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
        } elseif ($this->config("manage_state_vip_{$nextLevel}")) {
            return floatval($this->config("manage_value_vip_{$nextLevel}"));
        } else {
            return floatval(0);
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
        $vip = "{$this->user['vip_code']}";
        $map = ['type' => self::PRIZE_07, 'order_no' => $this->order['order_no'], 'order_uuid' => $this->order['uuid']];
        if ($this->config("upgrade_state_vip_{$vip}") && DataUserRebate::mk()->where($map)->count() < 1) {
            $value = $this->config("upgrade_value_vip_{$vip}");
            if ($this->config("upgrade_type_vip_{$vip}") == 1) {
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

    /**
     * 用户平推奖励发放
     * @return boolean
     */
    private function _prize08(): bool
    {
        if (empty($this->from1)) return false;
        $map = ['vip_code' => $this->user['vip_code']];
        $uuids = array_reverse(str2arr(trim($this->user['path'], '-'), '-'));
        $puids = DataUser::mk()->whereIn('id', $uuids)->orderField('id', $uuids)->where($map)->column('id');
        if (count($puids) < 2) return false;

        $this->app->db->transaction(function () use ($puids, $map) {
            foreach ($puids as $key => $puid) {
                // 最多两层
                if (($layer = $key + 1) > 2) break;
                // 检查重复
                $map = ['uuid' => $puid, 'type' => self::PRIZE_08, 'order_no' => $this->order['order_no']];
                if (DataUserRebate::mk()->where($map)->count() < 1) {
                    // 返利比例
                    $rate = $this->config("equal_value_vip_{$layer}_{$this->user['vip_code']}");
                    // 返利金额
                    $money = floatval($rate * $this->order['rebate_amount'] / 100);
                    $name = "{$this->name(self::PRIZE_08)}, 返回订单的 {$rate}%";
                    // 写入返利
                    $this->writeRabate($puid, $map, $name, $money);
                }
            }
        });
        return true;
    }

    /**
     * 获取奖励名称
     * @param string $prize
     * @return string
     */
    public static function name(string $prize): string
    {
        return self::PRIZES[$prize]['name'] ?? $prize;
    }

    /**
     * 检查等级是否有奖励
     * @param string $prize 奖励规则
     * @param integer $level 用户等级
     * @return boolean
     */
    private function checkPrizeStatus(string $prize, int $level): bool
    {
        $query = BaseUserUpgrade::mk()->where(['number' => $level]);
        return $query->whereLike('rebate_rule', "%,{$prize},%")->count() > 0;
    }

    /**
     * 写返利记录
     * @param int $uuid 奖励用户
     * @param array $map 查询条件
     * @param string $name 奖励名称
     * @param float $amount 奖励金额
     */
    private function writeRabate(int $uuid, array $map, string $name, float $amount)
    {
        DataUserRebate::mk()->insert(array_merge($map, [
            'uuid'         => $uuid,
            'date'         => date('Y-m-d'),
            'code'         => CodeExtend::uniqidDate(20, 'R'),
            'name'         => $name,
            'amount'       => $amount,
            'status'       => $this->status,
            'order_no'     => $this->order['order_no'],
            'order_uuid'   => $this->order['uuid'],
            'order_amount' => $this->order['amount_total'],
        ]));
        // 刷新用户返利统计
        UserRebateService::amount($uuid);
    }
}