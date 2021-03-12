<?php

namespace app\data\controller;

use app\data\service\UserUpgradeService;
use think\admin\Controller;

/**
 * 用户返利管理
 * Class UserRebate
 * @package app\data\controller
 */
class UserRebate extends Controller
{

    /**
     * 返利奖励配置
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function config()
    {
        $this->skey = 'RebateRule';
        $this->title = '返利奖励配置';
        if ($this->request->isGet()) {
            $this->data = sysdata($this->skey);
            $this->levels = UserUpgradeService::instance()->levels();
            $this->fetch();
        } else {
            sysdata($this->skey, $this->request->post());
            $this->success('奖励修改成功');
        }
    }

}