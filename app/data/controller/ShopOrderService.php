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
        $query = $this->_query($this->table);
        $query->page();
    }

}