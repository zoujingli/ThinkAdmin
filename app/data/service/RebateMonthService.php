<?php

namespace app\data\service;

use think\admin\Exception;
use think\admin\Service;

/**
 * 月度返利服务
 * Class RebateMonthService
 * @package app\agent\service
 */
class RebateMonthService extends Service
{
    /** @var string */
    protected $date;

    /** @var array */
    protected $user;

    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataUserRebate';

    /**
     * 指定用户发放奖励
     * @param mixed $uid
     * @param array $user
     * @throws Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function execute($uid, array $user)
    {
        if (empty($user)) $user = $this->app->db->name('DataUser')->where(['id' => $uid])->find();
        if (empty($user)) throw new Exception("指定用户[{$uid}]不存在");
        $this->app->log->notice("开始处理用户[{$user['id']}]月度[{$this->date}]返利");
        $this->user = $user;
        // $this->_prize_02();
    }

}