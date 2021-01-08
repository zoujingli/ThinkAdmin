<?php

namespace app\data\controller;

use think\admin\Controller;

/**
 * 商品标签管理
 * Class ShopGoodsMark
 * @package app\data\controller
 */
class ShopGoodsMark extends Controller
{
    /**
     * 绑定数据表
     * @var string
     */
    private $table = 'ShopGoodsMark';

    /**
     * 商品标签管理
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function index()
    {
        $this->title = '商品标签管理';
        $query = $this->_query($this->table);
        $query->like('name')->dateBetween('create_at');
        $query->equal('status')->order('sort desc,id desc')->page();
    }

    /**
     * 商品标签选择
     * @login true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function select()
    {
        $this->_query($this->table)->order('sort desc,id desc')->page();
    }

    /**
     * 添加商品标签
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function add()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 编辑商品标签
     * @auth true
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function edit()
    {
        $this->_form($this->table, 'form');
    }

    /**
     * 修改商品标签状态
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function state()
    {
        $this->_save($this->table);
    }

    /**
     * 删除商品标签
     * @auth true
     * @throws \think\db\exception\DbException
     */
    public function remove()
    {
        $this->_delete($this->table);
    }

}