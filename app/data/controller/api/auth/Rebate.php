<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\RebateService;

/**
 * 用户返利管理
 * Class Rebate
 * @package app\data\controller\api\auth
 */
class Rebate extends Auth
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserRebate';

    /**
     * 获取用户返利记录
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function get()
    {
        $date = trim(input('date', date('Y-m')), '-');
        [$map, $year] = [['uid' => $this->uuid], substr($date, 0, 4)];
        $query = $this->_query($this->table)->where($map)->equal('type,status')->whereLike('date', "{$date}%");
        $this->success('获取返利统计', array_merge($query->order('id desc')->page(true, false, false, 10), [
            'total' => [
                '年度' => $this->_query($this->table)->where($map)->equal('type,status')->whereLike('date', "{$year}%")->db()->sum('amount'),
                '月度' => $this->_query($this->table)->where($map)->equal('type,status')->whereLike('date', "{$date}%")->db()->sum('amount'),
            ],
        ]));
    }

    /**
     * 获取我的奖励
     */
    public function prize()
    {
        [$map, $data] = [['number' => $this->user['vip_code']], []];
        $prizes = $this->app->db->name($this->table)->group('name')->column('name');
        $rebate = $this->app->db->name('BaseUserUpgrade')->where($map)->value('rebate_rule', '');
        $codemap = array_merge($prizes, str2arr($rebate));
        foreach (RebateService::PRIZES as $prize) {
            if (in_array($prize['code'], $codemap)) $data[] = $prize;
        }
        $this->success('获取我的奖励', $data);
    }

    /**
     * 获取奖励配置
     */
    public function prizes()
    {
        $this->success('获取系统奖励', array_values(RebateService::PRIZES));
    }
}