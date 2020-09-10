<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 售后申请管理
 * Class ShopOrderService
 * @package app\data\controller
 */
class ShopOrderService extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopOrderService';

    /**
     * 售后申请管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '售后申请管理';
        $this->type = input('type', 'all');

        $query = $this->_query($this->table);
        if (is_numeric($this->type = input('type', 'all'))) {
            $query->equal('status#type');
        }
        $query->order('id desc')->page();
    }

}