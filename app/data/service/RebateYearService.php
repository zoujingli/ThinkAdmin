<?php

namespace app\data\service;

use think\admin\Exception;
use think\admin\Service;

/**
 * 年度返利服务
 * Class RebateYearService
 * @package app\data\service
 */
class RebateYearService extends Service
{
    /** @var array */
    protected $user;

    /** @var string */
    protected $year;

    /**
     * 发放年度奖励
     * @param string $year 年份
     * @return RebateYearService
     */
    public function build(string $year = ''): RebateYearService
    {
        $this->year = $year ?: date('Y', strtotime('-1 year'));
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
        $this->app->log->notice("开始处理用户[{$user['id']}]年度[{$this->year}]返利");
        $this->user = $user;
        // $this->_prize_06();
    }

}