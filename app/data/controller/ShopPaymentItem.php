<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 支付行为记录
 * Class ShopPaymentItem
 * @package app\data\controller
 */
class ShopPaymentItem extends Controller
{
    /**
     * 绑定数据
     * @var string
     */
    private $table = 'ShopPaymentItem';

    /**
     * 支付行为记录
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '支付行为记录';
        $query = $this->_query($this->table);
        $query->like('order_no')->order('id desc')->page();
    }

}