<?php

namespace app\data\service;

use think\admin\Exception;
use think\admin\Service;

/**
 * 季度返利服务
 * Class RebateQuarterService
 * @package app\data\service
 */
class RebateQuarterService extends Service
{
    /** @var string */
    protected $quarter;

    /** @var string */
    protected $dateAfter;

    /** @var string */
    protected $dateStart;

    /**
     * 发放季度奖励
     * @param string $year 年份
     * @param string $month 月份
     * @return RebateQuarterService
     */
    public function build(string $year = '', string $month = ''): RebateQuarterService
    {
        $year = $year ?: date('Y', '-3 month');
        $month = $month ?: date('m', '-3 month');
        $this->quarter = ceil(date('n', mktime(0, 0, 0, $month, 1, $year)) / 3);
        $this->dateAfter = date('Y-m-t 23:59:59', mktime(0, 0, 0, ($this->quarter - 1) * 3 + 0, 1, date('Y')));
        $this->dateStart = date('Y-m-01 00:00:00', mktime(0, 0, 0, ($this->quarter - 2) * 3 + 1, 1, date('Y')));
        return $this;
    }

    /**
     * 指定用户发放奖励
     * @param mixed $uid
     * @param array $user
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function execute($uid, $user = [])
    {
        if (empty($user)) $user = $this->app->db->name('DataUser')->where(['id' => $uid])->find();
        if (empty($user)) throw new Exception("指定用户[{$uid}]不存在");
        $this->app->log->notice("开始处理用户[{$user['id']}]季度[{$this->dateStart} - {$this->dateAfter}]返利");
        // $this->_prize_05($user);
    }
}