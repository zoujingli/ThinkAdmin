<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 门店核销管理
 * Class StoreItem
 * @package app\data\controller
 */
class StoreUsed extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'DataStoreUsed';

    /**
     * 门店店员管理
     * @auth true
     * @menu true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '门店核销管理';
        $query = $this->_query($this->table);
        $query->order('id desc')->equal('status')->dateBetween('create_at')->page();
    }

    /**
     * 修改核销状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table, $this->_vali([
            'status.in:0,1'  => '状态值范围异常！',
            'status.require' => '状态值不能为空！',
        ]));
    }

}