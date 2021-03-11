<?php

namespace app\data\controller\api\auth;

use app\data\controller\api\Auth;
use app\data\service\PaymentService;

/**
 * 接口数据配置
 * Class Config
 * @package app\data\controller\api\auth
 */
class Config extends Auth
{
    /**
     * 获取支付参数数据
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function getPayment()
    {
        $types = [];
        foreach (PaymentService::TYPES as $type => $arr) if (in_array($this->type, $arr['bind'])) $types[] = $type;
        $query = $this->app->db->name('ShopPayment')->where(['status' => 1, 'deleted' => 0])->whereIn('type', $types);
        $this->success('获取支付参数数据', $query->order('sort desc,id desc')->field('type,code,name')->select()->toArray());
    }
}