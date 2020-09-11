<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 订单发货管理
 * Class ShopOrderSend
 * @package app\data\controller
 */
class ShopOrderSend extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopOrder';

    /**
     * 订单发货管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '订单发货管理';
        $query = $this->_query($this->table);
        if (is_numeric($this->type = input('type', 'all'))) {
            $query->equal('status#type');
        }
        $query->order('id desc')->page();
    }

}